<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "db_penjadwalan";

// Koneksi ke database
$conn = mysqli_connect($server, $user, $pass, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$jadwal_output = '';

if (isset($_POST['submit'])) {
    // Ambil data perawat
    $sql = "SELECT id_perawat, nama, status FROM perawat WHERE unit = 'Nusa Indah' AND jabatan != 'POS'";
    $result = $conn->query($sql);
    $perawat = [];
    $perawat_hamil = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $perawat[] = $row['nama'];
            $perawat_hamil[] = $row['status']; // Menyimpan status kehamilan perawat
        }
    } else {
        die("Tidak ada perawat yang ditemukan");
    }

    // Ambil data permohonan jadwal
    $sql = "SELECT id_perawat, hari, waktu_shift FROM permohonan_jadwal";
    $result = $conn->query($sql);
    $permohonan_jadwal = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $permohonan_jadwal[$row['id_perawat']][$row['hari']] = $row['waktu_shift'];
        }
    }

    // Inisialisasi variabel cuti
    $cuti = []; // Jika Anda memiliki data cuti, Anda bisa mengambilnya di sini dengan query ke database

    // Konstanta
    $hari = $_POST["jhari"];
    $shift = ['P', 'S', 'M']; // Pagi (P), Siang (S), Malam (M)
    $ukuran_populasi = $_POST["populasi"];
    $generasi = $_POST["generasi"];
    $ratemutasi = $_POST["ratemutasi"];
    $mutasi_rate = $ratemutasi/100;

    // Inisialisasi Populasi
// Inisialisasi Populasi
function inisialisasi_populasi($ukuran_populasi, $perawat, $hari, $shift) {
    $populasi = [];
    $jumlah_perawat = count($perawat);

    // Tentukan distribusi shift per hari
    $distribusi_shift = [
        'P' => 7, // Pagi
        'S' => 6, // Siang
        'M' => 5, // Malam
        'L' => 3  // Libur
    ];

    for ($i = 0; $i < $ukuran_populasi; $i++) {
        $individu = [];
        for ($j = 0; $j < $hari; $j++) {
            $jadwal_hari = array_fill(0, $jumlah_perawat, ''); // Isi jadwal harian dengan placeholder kosong
            $perawat_tersedia = range(0, $jumlah_perawat - 1); // Daftar perawat yang tersedia untuk penjadwalan

            // Alokasi shift secara acak sesuai dengan distribusi yang diinginkan
            foreach ($distribusi_shift as $shift_type => $jumlah) {
                for ($k = 0; $k < $jumlah; $k++) {
                    // Pilih perawat secara acak dari daftar perawat yang tersedia
                    $random_key = array_rand($perawat_tersedia);
                    $perawat_terpilih = $perawat_tersedia[$random_key];
                    
                    // Tetapkan shift ke perawat tersebut
                    $jadwal_hari[$perawat_terpilih] = $shift_type;

                    // Hapus perawat tersebut dari daftar perawat yang tersedia
                    unset($perawat_tersedia[$random_key]);
                }
            }

            $individu[] = $jadwal_hari;
        }
        $populasi[] = $individu;
    }
    return $populasi;
}



    // Evaluasi Fitness
    function evaluasi_fitness($individu, $permohonan_jadwal, $cuti, $perawat_hamil) {
        $fitness = 1000; // Memulai dengan nilai fitness tinggi
        global $hari, $shift;

        $perawat_shift_count = array_fill(0, count($individu[0]), array_fill(0, count($shift), 0)); // Track shift count for each nurse
        $perawat_libur_count = array_fill(0, count($individu[0]), 0);

        for ($d = 0; $d < $hari; $d++) {
            $jadwal_hari = $individu[$d];
            $shift_malam = 0;
            for ($i = 0; $i < count($jadwal_hari); $i++) {
                $current_shift = $jadwal_hari[$i];
                if ($current_shift != 'L') {
                    $shift_index = array_search($current_shift, $shift);
                    $perawat_shift_count[$i][$shift_index]++;
                } else {
                    $perawat_libur_count[$i]++;
                }

                // P1: Penalti jika perawat tidak mendapatkan libur atau shift malam setelah shift malam
                if ($current_shift == 'M' && isset($individu[$d + 1][$i]) && $individu[$d + 1][$i] != 'L' && $individu[$d + 1][$i] != 'M') {
                    $fitness -= 15;
                }

                // P2: Penalti jika perawat mendapatkan lebih dari 2 shift malam berturut-turut
                if ($current_shift == 'M') {
                    $shift_malam++;
                    if ($shift_malam > 2) {
                        $fitness -= 15;
                    }
                } else {
                    $shift_malam = 0;
                }

                // P3: Penalti jika permohonan jadwal tidak terpenuhi
                if (isset($permohonan_jadwal[$i][$d]) && $permohonan_jadwal[$i][$d] != $current_shift) {
                    $fitness -= 15;
                }

                // P4: Penalti jika perawat hamil mendapatkan lebih dari 2 shift malam di periode ini
                if ($perawat_hamil[$i] && $current_shift == 'M' && $perawat_shift_count[$i][2] > 2) {
                    $fitness -= 15;
                }

                // P5: Penalti besar jika perawat mendapatkan shift ketika sedang cuti (Hard Constraint)
                if (isset($cuti[$i]) && in_array($d, $cuti[$i]) && $current_shift != 'L') {
                    $fitness -= 40;
                }
            }
        }

       

        return $fitness;
    }

    // Seleksi
    function seleksi($populasi, $fitness_scores) {
        $terpilih = [];
        $total_fitness = array_sum($fitness_scores);
        if ($total_fitness <= 0) {
            $total_fitness = 1; // Hindari pembagian dengan nol
        }
        for ($i = 0; $i < count($populasi); $i++) {
            $random = mt_rand(0, $total_fitness);
            $kumulatif = 0;
            foreach ($populasi as $key => $individu) {
                $kumulatif += $fitness_scores[$key];
                if ($kumulatif > $random) {
                    $terpilih[] = $individu;
                    break;
                }
            }
        }
        return $terpilih;
    }

    // Crossover
    function crossover($induk1, $induk2) {
        $titik_crossover = rand(1, count($induk1) - 1);
        $anak1 = array_merge(array_slice($induk1, 0, $titik_crossover), array_slice($induk2, $titik_crossover));
        $anak2 = array_merge(array_slice($induk2, 0, $titik_crossover), array_slice($induk1, $titik_crossover));
        return [$anak1, $anak2];
    }

    // Mutasi
    function mutasi($individu, $mutasi_rate) {
        if (rand(0, 100) < $mutasi_rate * 100) {
            $hari = rand(0, count($individu) - 1);
            $pos1 = rand(0, count($individu[$hari]) - 1);
            $pos2 = rand(0, count($individu[$hari]) - 1);
            $temp = $individu[$hari][$pos1];
            $individu[$hari][$pos1] = $individu[$hari][$pos2];
            $individu[$hari][$pos2] = $temp;
        }
        return $individu;
    }

    // Inisialisasi Populasi
    $populasi = inisialisasi_populasi($ukuran_populasi, $perawat, $hari, $shift);

    // Jalankan Algoritma Genetika
    for ($g = 0; $g < $generasi; $g++) {
        $fitness_scores = array_map(function($individu) use ($permohonan_jadwal, $cuti, $perawat_hamil) {
            return evaluasi_fitness($individu, $permohonan_jadwal, $cuti, $perawat_hamil);
        }, $populasi);
        $populasi_terpilih = seleksi($populasi, $fitness_scores);
        $populasi_baru = [];
        $jumlah_populasi_terpilih = count($populasi_terpilih);
        for ($i = 0; $i < $jumlah_populasi_terpilih - 1; $i += 2) {
            if (isset($populasi_terpilih[$i + 1])) {
                list($anak1, $anak2) = crossover($populasi_terpilih[$i], $populasi_terpilih[$i + 1]);
                $populasi_baru[] = mutasi($anak1, $mutasi_rate);
                $populasi_baru[] = mutasi($anak2, $mutasi_rate);
            }
        }
        // Tambahkan beberapa individu dari populasi lama untuk mempertahankan keragaman
        while (count($populasi_baru) < $ukuran_populasi) {
            $populasi_baru[] = $populasi[array_rand($populasi)];
        }
        $populasi = $populasi_baru;
    }

    // Tampilkan jadwal terbaik
    $fitness_scores = array_map(function($individu) use ($permohonan_jadwal, $cuti, $perawat_hamil) {
        return evaluasi_fitness($individu, $permohonan_jadwal, $cuti, $perawat_hamil);
    }, $populasi);
    $individu_terbaik = $populasi[array_search(max($fitness_scores), $fitness_scores)];

    // Output jadwal
    $jadwal_output .= "<h2>Jadwal Perawat</h2>";
    $jadwal_output .= "<table class='table table-bordered'>";
    $jadwal_output .= "<tr><th>No</th><th>Nama</th>";
    for ($d = 1; $d <= $hari; $d++) {
        $jadwal_output .= "<th>Hari $d</th>";
    }
    $jadwal_output .= "</tr>";

    for ($i = 0; $i < count($perawat); $i++) {
        $jadwal_output .= "<tr>";
        $jadwal_output .= "<td>" . ($i + 1) . "</td>";
        $jadwal_output .= "<td>" . $perawat[$i] . "</td>";
        for ($d = 0; $d < $hari; $d++) {
            if (isset($individu_terbaik[$d][$i]) && $individu_terbaik[$d][$i] != 'L') {
                $jadwal_output .= "<td>" . $individu_terbaik[$d][$i] . "</td>";
            } else {
                $jadwal_output .= "<td>L</td>"; // Set sebagai libur
            }
        }
        $jadwal_output .= "</tr>";
    }
    $jadwal_output .= "</table>";
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembuatan Jadwal Perawat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Masukkan Konstanta Untuk Jadwal</h2>
    <form method="POST" action="">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="hari" class="form-label">Jumlah Hari:</label>
                <input type="number" class="form-control" id="hari" name="jhari" >
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="mutasi_rate" class="form-label">Laju Mutasi (dalam persen):</label>
                <input type="number" class="form-control" id="mutasi_rate" name="ratemutasi" >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="ukuran_populasi" class="form-label">Ukuran Populasi:</label>
                <input type="number" class="form-control" id="ukuran_populasi" name="populasi" >
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="generasi" class="form-label">Jumlah Generasi:</label>
                <input type="number" class="form-control" id="generasi" name="generasi" >
            </div>
        </div>
    </div>
        <button type="submit" class="btn btn-primary" name="submit">Buat Jadwal</button>
    </form>
    
    <!-- Cetak jadwal di bawah form -->
    <div class="mt-5">
        <?php echo $jadwal_output; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

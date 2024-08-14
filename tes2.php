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
if (isset($_POST['submit'])) {
    // $jhari = $_POST["jhari"];
    // $ratemutasi = $_POST["ratemutasi"];
    // $populasi = $_POST["populasi"];
    // $generasi = $_POST["generasi"];

    // var_dump($jhari);
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

// // Ambil data cuti perawat
// $sql = "SELECT id_perawat, hari FROM cuti";
// $result = $conn->query($sql);
// $cuti = [];
// if ($result->num_rows > 0) {
//     while($row = $result->fetch_assoc()) {
//         $cuti[$row['id_perawat']][] = $row['hari'];
//     }
// }

// Konstanta
$hari = $_POST["jhari"];
$shift = ['P', 'S', 'M']; // Pagi (P), Siang (S), Malam (M)
$ukuran_populasi = $_POST["populasi"];
$generasi = $_POST["generasi"];
$ratemutasi = $_POST["ratemutasi"];
$mutasi_rate = $ratemutasi/100;

// Inisialisasi Populasi
function inisialisasi_populasi($ukuran_populasi, $perawat, $hari, $shift) {
    $populasi = [];
    $jumlah_perawat = count($perawat);
    $jumlah_shift = count($shift);

    for ($i = 0; $i < $ukuran_populasi; $i++) {
        $individu = [];
        for ($j = 0; $j < $hari; $j++) {
            $jadwal_hari = [];
            $shift_count = array_fill(0, $jumlah_shift, 0); // Track shift assignment per nurse

            for ($k = 0; $k < $jumlah_perawat; $k++) {
                $available_shifts = array_filter($shift, function($s) use ($shift_count, $shift) {
                    $shift_index = array_search($s, $shift);
                    return $shift_count[$shift_index] < floor(count($shift) / count($shift)); // Ensure fair distribution
                });

                if (!empty($available_shifts)) {
                    $random_shift_key = array_rand($available_shifts);
                    $random_shift = $available_shifts[$random_shift_key];
                } else {
                    $random_shift_key = array_rand($shift);
                    $random_shift = $shift[$random_shift_key];
                }

                $shift_index = array_search($random_shift, $shift);
                $jadwal_hari[] = $random_shift;
                $shift_count[$shift_index]++;
            }

            $individu[] = $jadwal_hari;
        }
        $populasi[] = $individu;
    }
    return $populasi;
}

// Evaluasi Fitness
function evaluasi_fitness($individu, $constraints, $permohonan_jadwal, $cuti, $perawat_hamil) {
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

    // Penalti jika perawat tidak mendapatkan cukup shift secara merata
    foreach ($perawat_shift_count as $shift_count) {
        $mean_shift = array_sum($shift_count) / count($shift);
        foreach ($shift_count as $count) {
            if (abs($count - $mean_shift) > 1) {
                $fitness -= 10; // Penalti jika perawat tidak mendapatkan distribusi shift yang merata
            }
        }
    }

    // Penalti jika perawat tidak mendapatkan cukup libur
    foreach ($perawat_libur_count as $count) {
        if ($count == 0) {
            $fitness -= 10; // Penalti jika tidak mendapatkan libur sama sekali
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
    for ($i = 0; i < count($populasi); $i++) {
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
for ($generasi = 0; $generasi < $generasi; $generasi++) {
    $fitness_scores = array_map(function($individu) use ($constraints, $permohonan_jadwal, $cuti, $perawat_hamil) {
        return evaluasi_fitness($individu, $constraints, $permohonan_jadwal, $cuti, $perawat_hamil);
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
$fitness_scores = array_map(function($individu) use ($constraints, $permohonan_jadwal, $cuti, $perawat_hamil) {
    return evaluasi_fitness($individu, $constraints, $permohonan_jadwal, $cuti, $perawat_hamil);
}, $populasi);
$individu_terbaik = $populasi[array_search(max($fitness_scores), $fitness_scores)];

// Output jadwal
echo "<table border='1'>";
echo "<tr><th>No</th><th>Nama</th>";
for ($d = 1; $d <= $hari; $d++) {
    echo "<th>Hari $d</th>";
}
echo "</tr>";

for ($i = 0; $i < count($perawat); $i++) {
    echo "<tr>";
    echo "<td>" . ($i + 1) . "</td>";
    echo "<td>" . $perawat[$i] . "</td>";
    for ($d = 0; $d < $hari; $d++) {
        if (isset($individu_terbaik[$d][$i]) && $individu_terbaik[$d][$i] != 'L') {
            echo "<td>" . $individu_terbaik[$d][$i] . "</td>";
        } else {
            echo "<td>Libur</td>"; // Set sebagai libur
        }
    }
    echo "</tr>";
}
echo "</table>";

// Tutup koneksi
$conn->close();



}


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
    <h2>tolong cetak jadwal di bawah sini</h2>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

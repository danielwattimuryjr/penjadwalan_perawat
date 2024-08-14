<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "db_penjadwalan";


// Koneksi ke database
$conn = mysqli_connect($server, $user, $pass, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$id_perawat= $_SESSION['id'];


// Memeriksa apakah form tambah data telah dikirim
if (isset($_POST['tambah_cuti'])) { 
    $tanggal_mulai = mysqli_real_escape_string($conn, $_POST["tanggal_mulai"]);
    $tanggal_selesai = mysqli_real_escape_string($conn, $_POST["tanggal_selesai"]);
    $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
    $perawat_pengganti = mysqli_real_escape_string($conn, $_POST["perawat_pengganti"]);


    // Memasukkan data ke database
    $queryInsert = "INSERT INTO cuti (id_perawat, tanggal_mulai, tanggal_selesai, keterangan, perawat_pengganti) VALUES ('$id_perawat', '$tanggal_mulai', '$tanggal_selesai', '$keterangan', '$perawat_pengganti')";
    if (mysqli_query($conn, $queryInsert)) {
        echo "<script>alert('Simpan data berhasil'); window.location.href = 'index4.php?halaman=cuti';</script>";
    } else {
        echo "<script>alert('Simpan data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index4.php?halaman=cuti';</script>";
    }
}

// Menutup koneksi

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Perawat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Data Perawat</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Cuti</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Keterangan</th>
                <th>Perawat Pengganti</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Koneksi ke database
            $conn = new mysqli('localhost', 'root', '', 'db_penjadwalan');

            // Cek koneksi
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Query untuk mengambil data perawat
            $sql = "SELECT 
                        perawat.nama, 
                        perawat.jabatan, 
                        cuti.tanggal_mulai,
                        cuti.tanggal_selesai,
                        cuti.keterangan,
                        cuti.perawat_pengganti
                    FROM 
                        perawat
                    JOIN 
                        cuti 
                    ON 
                        perawat.id_perawat = cuti.id_perawat
                          WHERE 
                        perawat.id_perawat = $id_perawat";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['jabatan']}</td>
                            <td>{$row['tanggal_mulai']}</td>
                            <td>{$row['tanggal_selesai']}</td>
                            <td>{$row['keterangan']}</td>
                            <td>{$row['perawat_pengganti']}</td>
                          </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Cuti -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="id_perawat" class="form-label">ID Perawat</label>
                        <input type="text" class="form-control" id="id_perawat" name="id_perawat" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                    </div>
                    <div class="mb-3">
                        <label for="perawat_pengganti" class="form-label">Perawat Pengganti</label>
                        <input type="text" class="form-control" id="perawat_pengganti" name="perawat_pengganti" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="tambah_cuti">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

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

// Pilih unit
if (isset($_POST["pilihUnit"])) {

    $_SESSION['unitTerpilih'] = $_POST['pilihUnit'];
    $_SESSION['showData'] = true;
    $showData = true;
    header('Location: index.php?halaman=perawat');
    exit();
}
$unitTerpilih = isset($_SESSION['unitTerpilih']) ? $_SESSION['unitTerpilih'] : 'null';

// Memeriksa apakah form tambah data telah dikirim
if (isset($_POST['tambah_perawat'])) {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $jabatan = mysqli_real_escape_string($conn, $_POST["jabatan"]);
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST["jenis_kelamin"]);
    $alamat = mysqli_real_escape_string($conn, $_POST["alamat"]);
    $unit = mysqli_real_escape_string($conn, $_POST["unit"]);
    $password = $username;

    // Memasukkan data ke database
    $queryInsert = "INSERT INTO perawat (username, password, jabatan, nama, jenis_kelamin, alamat, unit) VALUES ('$username', '$password', '$jabatan', '$nama', '$jenis_kelamin', '$alamat', '$unit')";
    if (mysqli_query($conn, $queryInsert)) {
        echo "<script>alert('Simpan data berhasil'); window.location.href = 'index.php?halaman=perawat';</script>";
    } else {
        echo "<script>alert('Simpan data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index.php?halaman=perawat';</script>";
    }
}

// Memeriksa apakah form hapus data telah dikirim
if (isset($_POST['hapus_perawat'])) {
    $id_perawat = mysqli_real_escape_string($conn, $_POST["id_perawat"]);

    // Menghapus data dari database
    $queryDelete = "DELETE FROM perawat WHERE id_perawat = '$id_perawat'";
    if (mysqli_query($conn, $queryDelete)) {
        echo "<script>alert('Hapus data berhasil'); window.location.href = 'index.php?halaman=perawat';</script>";
    } else {
        echo "<script>alert('Hapus data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index.php?halaman=perawat';</script>";
    }
}

// Memeriksa apakah form edit data telah dikirim
if (isset($_POST['edit_perawat'])) {
    $id_perawat = mysqli_real_escape_string($conn, $_POST["id_perawat"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $jabatan = mysqli_real_escape_string($conn, $_POST["jabatan"]);
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST["jenis_kelamin"]);
    $alamat = mysqli_real_escape_string($conn, $_POST["alamat"]);
    $unit = mysqli_real_escape_string($conn, $_POST["unit"]);

    // Mengupdate data di database
    $queryUpdate = "UPDATE perawat SET username = '$username', jabatan = '$jabatan', nama = '$nama', jenis_kelamin = '$jenis_kelamin', alamat = '$alamat', unit = '$unit' WHERE id_perawat = '$id_perawat'";
    if (mysqli_query($conn, $queryUpdate)) {
        echo "<script>alert('Edit data berhasil'); window.location.href = 'index.php?halaman=perawat';</script>";
    } else {
        echo "<script>alert('Edit data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index.php?halaman=perawat';</script>";
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
    <form method="POST" action="">
        <div class="row mb-3">
            <div class="col-md-4">
                <select class='form-select' name="pilihUnit" onchange="this.form.submit()">
                    <option value='null' <?php if ($unitTerpilih == 'null') echo "selected"; ?>>Pilih Unit</option>
                    <option value='rekam medis' <?php if ($unitTerpilih == 'rekam medis') echo "selected"; ?>>Rekam Medis</option>
                    <option value='icu' <?php if ($unitTerpilih == 'icu') echo "selected"; ?>>ICU</option>
                    <option value='nusa indah' <?php if ($unitTerpilih == 'nusa indah') echo "selected"; ?>>Nusa Indah</option>
                </select>
            </div>
            <div class="col-md-8 text-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Perawat</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Jabatan</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Unit</th>
                <th>Aksi</th>
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

            // Query untuk mengambil data perawat berdasarkan unit yang dipilih
            $sql = "SELECT * FROM perawat WHERE unit = '$unitTerpilih'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $no = 0;
                while ($row = $result->fetch_assoc()) {
                    $no++;
                    echo "<tr>
                            <td>$no</td>
                            <td>{$row['username']}</td>
                            <td>{$row['jabatan']}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['jenis_kelamin']}</td>
                            <td>{$row['alamat']}</td>
                            <td>{$row['unit']}</td>
                            <td>
                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' data-id='{$row['id_perawat']}' data-username='{$row['username']}' data-jabatan='{$row['jabatan']}' data-nama='{$row['nama']}' data-jenis_kelamin='{$row['jenis_kelamin']}' data-alamat='{$row['alamat']}' data-unit='{$row['unit']}'>Edit</button>
                                <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#hapusModal' data-id='{$row['id_perawat']}'>Hapus</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Perawat -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Perawat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <select class="form-select" id="unit" name="unit" required>
                            <option value="rekam medis">Rekam Medis</option>
                            <option value="icu">ICU</option>
                            <option value="nusa indah">Nusa Indah</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="tambah_perawat">Tambah</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Perawat -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Perawat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" id="id_perawat" name="id_perawat">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="edit_jabatan" name="jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <select class="form-select" id="edit_unit" name="unit" required>
                            <option value="rekam medis">Rekam Medis</option>
                            <option value="icu">ICU</option>
                            <option value="nusa indah">Nusa Indah</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="edit_perawat">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Perawat -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Hapus Perawat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" id="hapus_id_perawat" name="id_perawat">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" name="hapus_perawat">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id_perawat = button.data('id')
        var username = button.data('username')
        var jabatan = button.data('jabatan')
        var nama = button.data('nama')
        var jenis_kelamin = button.data('jenis_kelamin')
        var alamat = button.data('alamat')
        var unit = button.data('unit')

        var modal = $(this)
        modal.find('.modal-body #id_perawat').val(id_perawat)
        modal.find('.modal-body #edit_username').val(username)
        modal.find('.modal-body #edit_jabatan').val(jabatan)
        modal.find('.modal-body #edit_nama').val(nama)
        modal.find('.modal-body #edit_jenis_kelamin').val(jenis_kelamin)
        modal.find('.modal-body #edit_alamat').val(alamat)
        modal.find('.modal-body #edit_unit').val(unit)
    })

    $('#hapusModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id_perawat = button.data('id')

        var modal = $(this)
        modal.find('.modal-body #hapus_id_perawat').val(id_perawat)
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

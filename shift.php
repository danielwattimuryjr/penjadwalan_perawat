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

$id_perawat = $_SESSION['id'];

// Menangani penambahan data permohonan
if (isset($_POST['tambah_permohonan'])) {
    $hari = mysqli_real_escape_string($conn, $_POST["hari"]);
    $tanggal = mysqli_real_escape_string($conn, $_POST["tanggal"]);
    $waktu_shift = mysqli_real_escape_string($conn, $_POST["waktu_shift"]);
    $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);

    $queryInsert = "INSERT INTO permohonan_jadwal (id_perawat, hari, tanggal, waktu_shift, keterangan) VALUES ('$id_perawat', '$hari', '$tanggal', '$waktu_shift', '$keterangan')";
    if (mysqli_query($conn, $queryInsert)) {
        echo "<script>alert('Simpan data berhasil'); window.location.href = 'index4.php?halaman=permohonan_jadwal';</script>";
    } else {
        echo "<script>alert('Simpan data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index4.php?halaman=permohonan_jadwal';</script>";
    }
}

// Menangani penghapusan data permohonan
if (isset($_POST['delete_permohonan'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id_permohonan']);
    $sql = "DELETE FROM permohonan_jadwal WHERE id_permohonan = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Hapus data berhasil'); window.location.href = 'index4.php?halaman=permohonan_jadwal';</script>";
    } else {
        echo "<script>alert('Hapus data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index4.php?halaman=permohonan_jadwal';</script>";
    }
}

// Menangani pembaruan data permohonan
if (isset($_POST['update_permohonan'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id_permohonan']);
    $hari = mysqli_real_escape_string($conn, $_POST['hari']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $waktu_shift = mysqli_real_escape_string($conn, $_POST['waktu_shift']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "UPDATE permohonan_jadwal SET hari='$hari', tanggal='$tanggal', waktu_shift='$waktu_shift', keterangan='$keterangan' WHERE id_permohonan='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Update data berhasil'); window.location.href = 'index4.php?halaman=permohonan_jadwal';</script>";
    } else {
        echo "<script>alert('Update data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index4.php?halaman=permohonan_jadwal';</script>";
    }
}

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
    <h1 class="mb-4">Data Permohonan Jadwal</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Permohonan Jadwal</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Waktu Shift</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT 
                        perawat.nama, 
                        perawat.jabatan, 
                        permohonan_jadwal.hari,
                        permohonan_jadwal.tanggal,
                        permohonan_jadwal.waktu_shift,
                        permohonan_jadwal.keterangan,
                        permohonan_jadwal.id_permohonan
                    FROM 
                        perawat
                    JOIN 
                        permohonan_jadwal 
                    ON 
                        perawat.id_perawat = permohonan_jadwal.id_perawat
                    WHERE 
                        perawat.id_perawat = $id_perawat";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['jabatan']}</td>
                            <td>{$row['hari']}</td>
                            <td>{$row['tanggal']}</td>
                            <td>{$row['waktu_shift']}</td>
                            <td>{$row['keterangan']}</td>
                            <td>
                                <button class='btn btn-warning btn-sm edit-btn' data-bs-toggle='modal' data-bs-target='#editModal' data-id='{$row['id_permohonan']}'>Edit</button>
                                <button class='btn btn-danger btn-sm delete-btn' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='{$row['id_permohonan']}'>Delete</button>
                            </td>
                          </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Permohonan Jadwal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Permohonan Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="hari" class="form-label">Hari</label>
                        <input type="text" class="form-control" id="hari" name="hari" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_shift" class="form-label">Waktu Shift</label>
                        <input type="text" class="form-control" id="waktu_shift" name="waktu_shift" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="tambah_permohonan">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Permohonan Jadwal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Permohonan Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" id="edit_id_permohonan" name="id_permohonan">
                    <div class="mb-3">
                        <label for="edit_hari" class="form-label">Hari</label>
                        <input type="text" class="form-control" id="edit_hari" name="hari" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_waktu_shift" class="form-label">Waktu Shift</label>
                        <input type="text" class="form-control" id="edit_waktu_shift" name="waktu_shift" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="edit_keterangan" name="keterangan" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_permohonan">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Permohonan Jadwal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Permohonan Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" id="delete_id_permohonan" name="id_permohonan">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                    <button type="submit" class="btn btn-danger" name="delete_permohonan">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.edit-btn').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'get_permohonan.php',
            type: 'post',
            data: { id: id },
            success: function(response) {
                var data = JSON.parse(response);
                $('#edit_id_permohonan').val(data.id_permohonan);
                $('#edit_hari').val(data.hari);
                $('#edit_tanggal').val(data.tanggal);
                $('#edit_waktu_shift').val(data.waktu_shift);
                $('#edit_keterangan').val(data.keterangan);
            }
        });
    });

    $('.delete-btn').on('click', function() {
        var id = $(this).data('id');
        $('#delete_id_permohonan').val(id);
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>

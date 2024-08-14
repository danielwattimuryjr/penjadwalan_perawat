<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "penjadwalan";

// Koneksi ke database
$conn = mysqli_connect($server, $user, $pass, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data dari tabel unit
$query = "SELECT * FROM unit";
$result = mysqli_query($conn, $query);

// Memeriksa apakah form tambah data telah dikirim
if (isset($_POST['tunit'])) { 
    $namaunit = mysqli_real_escape_string($conn, $_POST["namaunit"]);

    // Memasukkan data ke database
    $queryInsert = "INSERT INTO unit (nama_unit) VALUES ('$namaunit')";
    if (mysqli_query($conn, $queryInsert)) {
        echo "<script>alert('Simpan data berhasil'); window.location.href = 'index.php?halaman=unit';</script>";
    } else {
        echo "<script>alert('Simpan data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index.php?halaman=unit';</script>";
    }
}

// Memeriksa apakah form hapus data telah dikirim
if (isset($_POST['hapus_unit'])) { 
    $id_unit = mysqli_real_escape_string($conn, $_POST["id_unit"]);

    // Menghapus data dari database
    $queryDelete = "DELETE FROM unit WHERE id_unit = '$id_unit'";
    if (mysqli_query($conn, $queryDelete)) {
        echo "<script>alert('Hapus data berhasil'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Hapus data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index.php';</script>";
    }
}

// Memeriksa apakah form edit data telah dikirim
if (isset($_POST['eunit'])) { 
    $id_unit = mysqli_real_escape_string($conn, $_POST["id_unit"]);
    $namaunit = mysqli_real_escape_string($conn, $_POST["namaunit"]);

    // Mengupdate data di database
    $queryUpdate = "UPDATE unit SET nama_unit = '$namaunit' WHERE id_unit = '$id_unit'";
    if (mysqli_query($conn, $queryUpdate)) {
        echo "<script>alert('Edit data berhasil'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Edit data gagal: " . mysqli_error($conn) . "'); window.location.href = 'index.php';</script>";
    }
}

// Menutup koneksi
mysqli_close($conn);
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css1.css">
    <title>Data Unit</title>
</head>
<body>
<div class="jumbotron">
    <h2>Unit</h2>
    <hr>
    <div class="container1">
        <div class="satu">
            <h4></h4>
        </div>
        <div class="dua">
            <form action="" method="post" id="pilihan">
                <select class='selectterminal' name="pilihArea" onchange="this.form.submit()">
                    <option value='IDJKT-T2D'>Nusa Indah</option>
                    <option value='IDJKT-T3D'>ICU</option>
                    <option value='IDJKT-T2D'>Rawat Jalan</option>
                </select>
            </form>
        </div>
        <div class="tiga">
            <form action="" method="post">
                <div class="input-group teer mt-1">
                    <input name="keyword" autofocus autocomplete="off" class="form-control" type="text" placeholder="Cari Perawat" value="<?php echo isset($_SESSION['keyword']) ? $_SESSION['keyword'] : ''; ?>">
                    <button id="cari" type="submit" name="cari" class="cari btn btn-secondary">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container mtcontent" id="margin">
        <table class="table table-hover table-bordered mb-3 table-striped mt-1">
            <thead>
                <tr>
                    <th scope="col" style="width: 20px;">No</th>
                    <th scope="col" style="width: 80px;">Unit</th>
                    <th scope="col" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                while($tampil = mysqli_fetch_array($result)){
                ?>
                <tr>
                    <th scope="row"><?php echo $no++; ?></th>
                    <td><?php echo $tampil['nama_unit']; ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?php echo $tampil['id_unit']; ?>" data-name="<?php echo $tampil['nama_unit']; ?>">Edit</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal" data-id="<?php echo $tampil['id_unit']; ?>" data-name="<?php echo $tampil['nama_unit']; ?>">Hapus</button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Tambah</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Unit -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="namaunit" class="form-label">Nama Unit</label>
                        <input type="text" class="form-control" id="namaunit" name="namaunit" placeholder="Masukan nama unit" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary" name="tunit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Unit -->
<div class="modal fade" id="hapusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusModalLabel">Hapus Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="hidden" id="id_unit" name="id_unit">
                    <p>Apakah anda yakin ingin menghapus unit <strong id="unit_name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" name="hapus_unit">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Unit -->
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_id_unit" name="id_unit">
                    <div class="mb-3">
                        <label for="edit_namaunit" class="form-label">Nama Unit</label>
                        <input type="text" class="form-control" id="edit_namaunit" name="namaunit" placeholder="Masukan nama unit" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary" name="eunit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Script untuk mengisi data ke dalam modal hapus
    var hapusModal = document.getElementById('hapusModal')
    hapusModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var name = button.getAttribute('data-name')

        var modalTitle = hapusModal.querySelector('.modal-title')
        var modalBodyInput = hapusModal.querySelector('.modal-body input#id_unit')
        var modalBodyText = hapusModal.querySelector('.modal-body #unit_name')

        modalTitle.textContent = 'Hapus Unit: ' + name
        modalBodyInput.value = id
        modalBodyText.textContent = name
    })

    // Script untuk mengisi data ke dalam modal edit
    var editModal = document.getElementById('editModal')
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var name = button.getAttribute('data-name')

        var modalTitle = editModal.querySelector('.modal-title')
        var modalBodyInputId = editModal.querySelector('.modal-body input#edit_id_unit')
        var modalBodyInputName = editModal.querySelector('.modal-body input#edit_namaunit')

        modalTitle.textContent = 'Edit Unit: ' + name
        modalBodyInputId.value = id
        modalBodyInputName.value = name
    })
</script>
</body>
</html>

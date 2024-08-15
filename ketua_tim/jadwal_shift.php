<?php
include '../db/koneksi.php';

$fetch_unit_query = "
    SELECT id, nama_unit from units ORDER BY nama_unit ASC
";
$fetch_unit_stmt = $conn->prepare($fetch_unit_query);
$fetch_unit_stmt->execute();
$fetch_unit_results = $fetch_unit_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSU Bhakti Asih Tangerang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #CDE8E5;
        }
        .content {
            padding: 20px;
        }
        .sidebar a {
            text-decoration: none;
            color: #000;
        }
        .sidebar a:hover {
            background-color: #7E8EF1;
            color: #000;
        }
        .table-wrapper {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include '../components/sidebaradmin.php'; ?>

        <!-- Konten utama -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
            <div class="row">
              <div class="col">
                <select name="unit_option" id="" class="form-control" required>
                <option value="" selected disabled>-- UNIT --</option>
                <?php foreach ($fetch_unit_results as $unit) { ?>
                  <option value="<?= $unit['id'] ?>"><?= $unit['nama_unit'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col">
                <a href="create_shift.php" class="btn btn-primary">Tambah Data</a>
              </div>
            </div>

            <div class="row mt-3">
                <div class="card">
                    <div class="card-body">
                        <table id="data-table">
                          <thead>
    <tr>
        <th>ID Perawat</th>
        <th>Nama</th>
        <th>Shift</th>
        <th>Unit</th>
        <th>Tanggal</th>
        <th>Hari</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>001</td>
        <td>Jane Doe</td>
        <td>Pagi</td>
        <td>ICU</td>
        <td>2024-08-15</td>
        <td>Kam</td>
        <td>
            <a href="edit_shift.php?id=1" class="btn btn-warning">Update</a>
            <button class="btn btn-danger">Delete</button>
        </td>
    </tr>
    <tr>
        <td>002</td>
        <td>John Smith</td>
        <td>Siang</td>
        <td>ER</td>
        <td>2024-08-15</td>
        <td>Kam</td>
        <td>
            <a href="edit_shift.php?id=1" class="btn btn-warning">Update</a>
            <button class="btn btn-danger">Delete</button>
        </td>
    </tr>
    <tr>
        <td>003</td>
        <td>Emily Johnson</td>
        <td>Malam</td>
        <td>Geriatri</td>
        <td>2024-08-15</td>
        <td>Kam</td>
        <td>
            <a href="edit_shift.php?id=1" class="btn btn-warning">Update</a>
            <button class="btn btn-danger">Delete</button>
        </td>
    </tr>
</tbody>


                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script> 
<script src="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.js"></script>
<script>
    $(document).ready(function(){
        new DataTable('#data-table');
    });
</script>
</body>
</html>

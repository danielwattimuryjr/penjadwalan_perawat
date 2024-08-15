<?php
include '../db/koneksi.php';
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
                <select name="periode_option" id="" class="form-control" required>
                  <option value="" selected disabled>-- PERIODE --</option>
                </div>
                <div class="col">
                  &nbsp;
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
    </tr>
</thead>
<tbody>
    <tr>
        <td>101</td>
        <td>Jane Doe</td>
        <td>Pagi</td>
        <td>ICU</td>
        <td>2024-08-15</td>
        <td>Kam</td>
    </tr>
    <tr>
        <td>102</td>
        <td>John Smith</td>
        <td>Siang</td>
        <td>ER</td>
        <td>2024-08-15</td>
        <td>Kam</td>
    </tr>
    <tr>
        <td>103</td>
        <td>Emily Johnson</td>
        <td>Malam</td>
        <td>Geriatri</td>
        <td>2024-08-15</td>
        <td>Kam</td>
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

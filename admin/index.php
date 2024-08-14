<?php
include 'db/koneksi.php'

$perawat_query = "
    SELECT u.username, u.nama, un.nama_unit,
        IF(u.jenis_kelamin='l', 'Laki-laki', 'Perempuan') AS jenis_kelamin,
        u.alamat 
    FROM users u
    JOIN roles r ON u.role_id = r.id
    JOIN unit_user uu ON uu.user_id = u.id
    JOIN units un ON uu.unit_id = un.id 
    WHERE r.role_name = 'perawat'
";
$perawat_stmt = $conn->prepare($perawat_query);
$perawat_stmt->execute();
$perawat_results = $perawat_stmt->fetchAll(PDO::FETCH_ASSOC);

$unit_count_query = "SELECT COUNT(*) AS total_unit FROM units";
$unit_count_stmt = $conn->prepare($unit_count_query);
$unit_count_stmt->execute();
$unit_count_result = $unit_count_stmt->fetch(PDO::FETCH_NUM);

$perawat_query = "
    SELECT COUNT(*) AS total_perawat FROM users
    JOIN roles ON users.role_id=roles.id
    WHERE roles.role_name='perawat'
";
$perawat_count_stmt = $conn->prepare($perawat_count_query);
$perawat_count_stmt->execute();
$perawat_count_result = $perawat_count_stmt->fetch(PDO::FETCH_NUM);

$user_query = "SELECT COUNT(*) AS total_users FROM users";
$user_count_stmt = $conn->prepare($user_count_query);
$user_count_stmt->execute();
$user_count_result = $user_count_stmt->fetch(PDO::FETCH_NUM);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSU Bhakti Asih Tangerang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
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
        <?php include 'sidebar/sidebaradmin.php'; ?>

        <!-- Konten utama -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
            <?php 
                if (isset($_GET['halaman'])) {
                    $halaman = $_GET['halaman'];
                    if ($halaman == 'unit') {
                        include 'unit.php';
                    } elseif ($halaman == 'dokter') {
                        include 'konten_dokter.php';
                    } elseif ($halaman == 'perawat') {
                        include 'perawat.php';
                    } elseif ($halaman == 'jadwal'){
                        include 'jadwal.php';
                    }elseif ($halaman == 'user'){
                        include 'user.php';
                    }elseif ($halaman == 'logout'){
                        include 'logout.php';
                    }else {
                        include 'dashboard.php';
                    }
                } else {
                    include 'dashboard.php';
                }
            ?>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
</body>
</html>

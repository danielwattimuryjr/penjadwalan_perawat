<?php
session_start();
if(!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSU Bhakti Asih Tangerang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
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
        <?php include 'sidebar/sidebarperawat.php'; ?>

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
                    } elseif ($halaman == 'user'){
                        include 'user.php';
                    } elseif ($halaman == 'cuti'){
                        include 'cuti.php';
                    } elseif ($halaman == 'shift'){
                        include 'shift.php';
                    } elseif ($halaman == 'logout'){
                        include 'logout.php';
                    } else {
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
<script>
    document.getElementById('toggleScheduleRequest').addEventListener('click', function () {
        var submenu = document.getElementById('scheduleRequestSubmenu');
        var icon = this.querySelector('.bi');

        if (submenu.style.display === 'none' || submenu.style.display === '') {
            submenu.style.display = 'block';
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        } else {
            submenu.style.display = 'none';
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        }
    });

    // Tetap menampilkan sub-menu saat item di dalamnya diklik
    var submenuItems = document.querySelectorAll('#scheduleRequestSubmenu .nav-link');
    submenuItems.forEach(function(item) {
        item.addEventListener('click', function() {
            var submenu = document.getElementById('scheduleRequestSubmenu');
            submenu.style.display = 'block';
            var icon = document.querySelector('#toggleScheduleRequest .bi');
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        });
    });
</script>

</body>
</html>

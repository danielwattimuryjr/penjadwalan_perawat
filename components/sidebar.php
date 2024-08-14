<?php
include './db/conn.php';
$role = $_SESSION['user']['role_name'];
?>

<nav class="col-md-3 col-lg-2 d-md-block  sidebar">
  <div class="position-sticky">
    <div class="text-center py-4">
      <img src="img/logo.png" alt="Logo" class="img-fluid">
      <h4>RSU Bhakti Asih Tangerang</h4>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="?halaman=dashboard">Beranda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?halaman=perawat">Unit</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?halaman=perawat">Perawat</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?halaman=perawat">Jadwal Dokter</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?halaman=perawat">Jadwal Shift</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?halaman=perawat">Kebutuhan Shift</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?halaman=perawat">Constraint</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?halaman=perawat">Pengguna</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?halaman=logout">Logout</a>
      </li>
    </ul>
  </div>
</nav>
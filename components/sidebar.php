<?php
include './db/conn.php';
$role = $_SESSION['user']['role_name'];

$menus = [
  "admin" => [
    "Unit" => "?halaman=unit",
    "User" => "?halaman=user",
    "Perawat" => "?halaman=perawat",
    "Jadwal Dokter" => "?halaman=jadwal_dokter",
    "Jadwal Shift" => "?halaman=jadwal_shift",
  ],
  "kepala_unit" => [
    "Kebutuhan Shift" => "?halaman=kebutuhan_shift",
    "Constraint" => "?halaman=constraint",
    "Permohonan Jadwal" => "?halaman=permohonan_jadwal",
    "Perawat" => "?halaman=perawat",
    "Jadwal Dokter" => "?halaman=jadwal_dokter",
    "Jadwal Shift" => "?halaman=jadwal_shift",
  ],
  "ketua_tim" => [
    "Kebutuhan Shift" => "?halaman=kebutuhan_shift",
    "Constraint" => "?halaman=constraint",
    "Permohonan Jadwal" => "?halaman=permohonan_jadwal",
    "Jadwal Dokter" => "?halaman=jadwal_dokter",
    "Perawat" => "?halaman=perawat",
    "Jadwal Shift" => "?halaman=jadwal_shift",
  ],
  "perawat" => [
    "Permohonan Jadwal" => "?halaman=permohonan_jadwal",
    "Jadwal Dokter" => "?halaman=jadwal_dokter",
    "Perawat" => "?halaman=perawat",
    "Jadwal Shift" => "?halaman=jadwal_shift",
  ]
];

$common_menus = [
  "Logout" => "?halaman=logout"
];

if (isset($menus[$role])) {
  $menus_to_show = array_merge($menus[$role], $common_menus);
} else {
  $menus_to_show = $common_menus;
}
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

      <?php
      foreach ($menus_to_show as $menu_name => $menu_link) {
        echo "<li class='nav-item'><a class='nav-link' href='$menu_link'>$menu_name</a></li>";
      }
      ?>
    </ul>
  </div>
</nav>
<?php
include '../db/koneksi.php';

$fetch_perawat_query = "
  SELECT u.id, u.nama, un.nama_unit FROM users u 
  JOIN roles r ON u.role_id=r.id 
  JOIN unit_user uu ON uu.user_id=u.id
  JOIN units un ON uu.unit_id=un.id
  WHERE r.role_name='perawat'
";
$fetch_perawat_stmt = $conn->prepare($fetch_perawat_query);
$fetch_perawat_stmt->execute();
$fetch_perawat_results = $fetch_perawat_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
            <div class="row mt-3">
                <div class="card">
                    <form>
                      <div class="mb-3">
                        <label  class="form-label">Perawat</label>
                        <select name="user_id" id="" class="form-control" required>
                          <option value="" selected disabled>-- PILIH PERAWAT --</option>
                          <?php foreach ($fetch_perawat_results as $perawat) { ?>
                            <option value="<?= $perawat['id'] ?>" selected disabled>
                              <?= $perawat['nama'] . ' - ' . $perawat['nama_unit'] ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label  class="form-label">Shift</label>
                        <select name="shift" id="" class="form-control" required>
                          <option value="" selected disabled>-- PILIH SHIFT --</option>
                          <option value="p" >Pagi</option>
                          <option value="s" >Siang</option>
                          <option value="m" >Malam</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label  class="form-label">Hari dan Tanggal</label>
                        <input type="date" name="hari_tanggal" id="" class="form-control">
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
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

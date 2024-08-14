<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css1.css">
    <title>Hello, world!</title>
  </head>
  <body>
      <div class="container mt-5">
        <h2>Unit</h2>
        <hr>
      </div>
    <div class="jumbotron">
    <div class="container1">
        <div class="satu">
            <h4> </h4>
        </div>
        <div class="dua">
            <h4> </h4>
        </div>
        <div class="tiga">
            <form action="" method="post">
                <div class="input-group teer mt-1">
                    <input name="keyword" autofocus autocomplete="off" class="form-control" type="text" placeholder="Cari Unit" value="<?php echo isset($_SESSION['keyword']) ? $_SESSION['keyword'] : ''; ?>">
                    <button  id="cari"type="submit" name="cari" class="cari btn btn-secondary">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container mtcontent" id="margin">
    <button  style="margin-left: 650px;"type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        +tambah
        </button>
        <table class="table table-hover table-bordered mb-3 table-striped mt-1">
            <thead>
                <tr>
                    <th scope="col" style="width: 20px;">No</th>
                    <th scope="col" style="width: 80px;">Unit</th>
                    <th scope="col" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="width: 20px;">1</th>
                    <td style="width: 80px;">Rekam Medis</td>
                    <td style="width: 100px;">
                        <button type="button" class="btn btn-primary">Edit</button>
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="width: 20px;">2</th>
                    <td style="width: 80px;">Nusa Indah</td>
                    <td style="width: 100px;">
                        <button type="button" class="btn btn-primary">Edit</button>
                        <button type="button" class="btn btn-danger">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

  <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form action="" method="post">
                    <div class="container">
                        <div class="mb-3">
                            <label style="font-size:18px"><i class="fa fa-user text-info"></i> Nama Unit </label>
                            <input type="text" class="form-control" name="nama_pemesan" id="nama_pemesan" aria-describedby="emailHelp" placeholder="masukan nama unit" required>
                        </div>
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>
<!-- tutup modal  -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
<!doctype html>
<html lang="en">
  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>user rsu bhakti asih</title>
  </head>
  <body>
<div class="jumbotron">
            <h2>User</h2>
            <hr>
            <div class="container1 ">
                    <div class="satu">  
                        <h4> </h4>
                    </div>
                    <div class="dua">
                        <form action="" method="post" id="pilihan">    
                            <select class='selectterminal' name="pilihArea" onchange="this.form.submit()"  >
                            <option value='IDJKT-T2D' >Nusa Indah </option>
                            <option value='IDJKT-T3D' >ICU</option>
                            <option value='IDJKT-T2D' >Rawat Jalan </option>
                            </select>
                        </form>
                    </div>
                    <div class="tiga">
                        <form action="" method ="post"   >
                            <div class="input-group teer mt-1">
                            <input  name="keyword" autofocus autocomplete="off"  class="form-control" type="text"    placeholder ="Cari Perawat"  value="<?php echo isset($_SESSION['keyword']) ? $_SESSION['keyword'] : ''; ?>" >
                            <button id="cari" type="submit"  name="cari" class="cari">cari</button>   
                            </div>
                        </form>
                    </div>      
            </div>
            <div class="container1 mtcontent " id="margin">
                    <table class="table table table-hover table-bordered mb-3 table-striped mt-1">
                            <thead>
                                <tr>
                                <th scope="col">No</th>
                                <th scope="col">Username</th>
                                <th scope="col">Nama </th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Status</th>
                                <th scope="col">Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">1</th>
                                <td>tombuuul</td>
                                <td>admin tombul</td>
                                <td>manajer</td>
                                <td>laki-laki</td>
                                <td>studi</td>
                                <td>Jl. Baru </td>
                                </tr>
                                <tr>
                                <th scope="row">2</th>
                                <td>tombuuul</td>
                                <td>admin tombul</td>
                                <td>manajer</td>
                                <td>laki-laki</td>
                                <td>studi</td>
                                <td>Jl. Baru </td>
                                </tr>
                                <tr>
                                <th scope="row">3</th>
                                <td>tombuuul</td>
                                <td>admin tombul</td>
                                <td>manajer</td>
                                <td>laki-laki</td>
                                <td>studi</td>
                                <td>Jl. Baru </td>
                                </tr>
                            </tbody>
                    </table>
            </div>
            
 <!-- jumbotron tutup -->
</div>
 
  </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* styles.css */
h1 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.input-group {
    width: 50%;
}

.table th, .table td {
    text-align: center;
    vertical-align: middle;
}

#add-button {
    background-color: #28a745; /* Hijau */
}

.btn-warning {
    background-color: #ffc107; /* Kuning */
}

.btn-danger {
    background-color: #dc3545; /* Merah */
}

.pagination .page-link {
    color: black;
}

.pagination .page-link:hover {
    background-color: #f8f9fa;
    color: black;
}

    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>Cari Unit</h1>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Unit" aria-label="Cari Unit" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Cari</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-end mb-3">
                <button class="btn btn-success" id="add-button">+ Tambah</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Unit</th>
                            <th>Unit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>----</td>
                            <td>----</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Ubah</button>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>----</td>
                            <td>----</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Ubah</button>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td>----</td>
                            <td>----</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Ubah</button>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

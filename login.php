<?php
include './proses/login.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- Custom CSS -->
    <style>
        .container-fluid {
            height: 100vh;
        }

        .left-side {
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .right-side {
            background-color: #006989;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 20px;
        }

        .right-side .card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 10px;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-primary {
            background-color: blue;
            border: none;
            border-radius: 30px;
        }

        h5 {
            color: black;
        }

        .input-group-text {
            border-radius: 0 20px 20px 0;
            cursor: pointer;
        }

        .input-group .form-control:first-child {
            border-radius: 20px 0 0 20px;
        }
    </style>

    <title>Login Penjadwalan</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-8 left-side">
                <div class="text-center">
                    <div class="logo-container">
                        <!-- Ganti src dengan URL atau path logo Anda -->
                        <img src="img/logo.png" alt="Logo RSU Bhakti Asih Tangerang" class="logo">
                    </div>
                    <h2>Sistem Penjadwalan Perawat RSU Bhakti Asih Tangerang</h2>
                </div>
            </div>
            <div class="col-md-4 right-side">
                <div class="card p-4">
                    <div class="card-body">
                        <h5 class="card-title text-center">LOGIN</h5>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                    <span class="input-group-text" id="togglePassword">
                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">LOGIN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <!-- Custom JavaScript -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const password = document.getElementById('password');
            const passwordIcon = document.getElementById('togglePasswordIcon');
            if (password.type === 'password') {
                password.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
            }
        });
    </script>
</body>

</html>
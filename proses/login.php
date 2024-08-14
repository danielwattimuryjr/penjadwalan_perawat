<?php

include './db/conn.php';

if (isset($_POST['submit'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);

  if (!$username || !$password) {
    echo "<script>alert('Username atau Password tidak boleh kosong')</script>";
  } else {
    $login_query = "SELECT u.id, u.nama, u.username, u.email, u.alamat, u.jenis_kelamin, r.role_name, r.display_name FROM users u JOIN roles r ON u.role_id = r.id WHERE username=? AND password=?";
    $stmt = $conn->prepare($login_query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($result->num_rows == 1) {
      $_SESSION['user'] = $user;

      switch ($user['role_name']) {
        case 'admin':
          # code...
          break;
        case 'kepala_unit':
          # code...
          break;
        case 'ketua_tim':
          # code...
          break;
        case 'admin':
          # code...
          break;
        default:
          echo "<script>alert('Role user tidak valid. Login dengan akun yang berbeda!')</script>";
          unset($_SESSION['user']);
          break;
      }
    } else {
      echo "<script>alert('Username atau Password salah2'); window.location.href='login.php';</script>";
    }

    $stmt->close();
    $conn->close();
  }
}
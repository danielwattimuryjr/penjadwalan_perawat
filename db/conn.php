<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'db_penjadwalan';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
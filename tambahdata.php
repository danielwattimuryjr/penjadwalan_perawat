<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "penjadwalan";

// Koneksi ke database
$conn = mysqli_connect($server, $user, $pass, $database);

// Periksa koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Memeriksa apakah form telah disubmit
if (isset($_POST['tunit'])) { 
    // Mengambil data dari form
    $namaunit = mysqli_real_escape_string($conn, $_POST['namaunit']);

    // Query untuk menambahkan data
    $query = "INSERT INTO unit (nama_unit) VALUES ('$namaunit')";
    
    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Jika berhasil simpan, tampilkan pesan berhasil
        echo "<script>
                alert('Simpan data berhasil');
                window.location.href = 'index.php';
              </script>";
    } else {
        // Jika gagal simpan, tampilkan pesan gagal
        echo "<script>
                alert('Simpan data gagal: " . mysqli_error($conn) . "');
                window.location.href = 'index.php';
              </script>";
    }
}

// Menutup koneksi
mysqli_close($conn);
?>

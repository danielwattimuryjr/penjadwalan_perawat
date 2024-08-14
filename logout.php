<?php
session_start();
session_destroy();
echo "<script>
alert('Selamat, Logout Berhasil') ;
document.location.href = 'login.php' ;   

</script>";
?>
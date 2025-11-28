<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>SIMBS</title></head>
<body>
    <nav style="background: #eee; padding: 10px;">
        <a href="kategori.php">Kategori Buku</a> | <a href="buku.php">Halaman Buku</a> | <span style="float:right">Halo, <b><?= $_SESSION['username']; ?></b> | <a href="logout.php">Logout</a></span>
    </nav>

    <h1>Selamat Datang di SIMBS</h1>
    <p>Silakan pilih menu di atas.</p>
</body>
</html>
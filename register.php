<?php
include 'koneksi.php';

$pesan_error = "";

if (isset($_POST['register'])) {
    $username = $_POST['username']; // [cite: 37]
    $email    = $_POST['email'];    // [cite: 38]
    $password = $_POST['password']; // [cite: 39]

    // Validasi Panjang Password minimal 8 karakter 
    if (strlen($password) < 8) {
        // [cite: 43] Contoh implementasi strlen sesuai gambar referensi
        $pesan_error = "Password harus mengandung minimal 8 karakter";
    } else {
        // Cek apakah username atau email sudah ada 
        $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' OR email = '$email'");
        
        if (mysqli_num_rows($cek) > 0) {
            $pesan_error = "Username atau email sudah terdaftar, gunakan yang lain"; // 
        } else {
            // Jika aman, simpan data
            // Disarankan menggunakan password_hash untuk keamanan, tapi untuk uji kompetensi sederhana kadang plain text atau md5
            $query = mysqli_query($koneksi, "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')");
            if ($query) {
                echo "<script>alert('Register Berhasil'); window.location='login.php';</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register SIMBS</title></head>
<body>
    <h2>Register</h2>
    <?php if($pesan_error != ""): ?>
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
            <?= $pesan_error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit" name="register">Daftar</button>
    </form>
</body>
</html>
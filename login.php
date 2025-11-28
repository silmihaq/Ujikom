<?php
session_start();
// Pastikan file koneksi.php sudah ada dan berisi konfigurasi koneksi database
include 'koneksi.php'; 

$pesan_error = "";

// Cek apakah tombol 'login' telah ditekan
if (isset($_POST['login'])) {
    // Ambil data dari formulir
    $username = $_POST['username'];
    // PERHATIAN: Ini adalah kode yang RENTAN terhadap SQL Injection.
    // Untuk pengembangan nyata, Anda HARUS menggunakan prepared statements.
    $password = $_POST['password']; 

    // Lakukan query untuk memverifikasi user
    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    
    // Cek jumlah baris yang ditemukan
    if (mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_assoc($cek);
        
        // Atur session jika login berhasil
        $_SESSION['username'] = $data['username'];
        $_SESSION['status'] = "login";
        // Redirect ke halaman index.php
        header("Location: index.php");
        exit(); // Penting untuk menghentikan eksekusi setelah header
    } else {
        // Pesan error jika gagal
        $pesan_error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login SIMBS</title>
    <style>
        /* CSS dasar untuk membuat tampilan lebih rapi */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 50px;
        }
        .login-box {
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
            width: 300px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 8px 0;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 style="text-align: center;">Login</h2>
        
        <?php if($pesan_error != ""): ?>
            <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px; background-color: #fdd;">
                <?= $pesan_error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <table border="0">
                <tr>
                    <td style="width: 100px;">Username</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="username" required>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>:</td>
                    <td>
                        <input type="password" name="password" required>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <button type="submit" name="login">Login</button>
                    </td>
                </tr>
            </table>
        </form>
        <p style="text-align: center; margin-top: 15px;">
            <a href="register.php">Belum punya akun? Register</a>
        </p>
    </div>
</body>
</html>
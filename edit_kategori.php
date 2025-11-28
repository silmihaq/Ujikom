<?php
// Hubungkan ke database
include 'koneksi.php';

// Pastikan ada ID kategori yang dikirim melalui parameter URL
if (!isset($_GET['id'])) {
    header("Location: kategori.php"); // Ganti dengan halaman daftar kategori Anda
    exit();
}

$id_kategori = $_GET['id'];

// --- BAGIAN 1: Mengambil Data Kategori Saat Ini ---
// Ambil data kategori berdasarkan ID
$query_ambil = "SELECT * FROM kategori WHERE id_kategori = $id_kategori";
$result = mysqli_query($koneksi, $query_ambil);

if (mysqli_num_rows($result) === 0) {
    echo "Kategori tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);

// --- BAGIAN 2: Memproses Data yang Dikirim dari Form (UPDATE) ---
if (isset($_POST['edit'])) {
    $nama_kategori_baru = $_POST['nama_kategori'];
    
    // Query UPDATE
    $query_update = "UPDATE kategori SET nama_kategori = '$nama_kategori_baru' WHERE id_kategori = $id_kategori";
    
    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Kategori berhasil diperbarui!'); window.location.href='kategori.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
</head>
<body>

    <h2>Edit Kategori: <?php echo $data['nama_kategori']; ?></h2>
    
    <form action="" method="POST" autocomplete="off">
        <label for="nama_kategori">Nama Kategori Baru:</label><br>
        <input type="text" id="nama_kategori" name="nama_kategori" value="<?php echo htmlspecialchars($data['nama_kategori']); ?>" required><br><br>
        
        <button type="submit" name="edit">Simpan Perubahan</button>
        <a href="list_kategori.php">Batal</a>
    </form>

</body>
</html>
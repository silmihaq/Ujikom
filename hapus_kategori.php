<?php
// Hubungkan ke database
include 'koneksi.php';

// Pastikan ada ID kategori yang dikirim melalui parameter URL
if (!isset($_GET['id'])) {
    header("Location: kategori.php"); // Ganti dengan halaman daftar kategori Anda
    exit();
}

$id_kategori = $_GET['id'];

// Query DELETE
$query_delete = "DELETE FROM kategori WHERE id_kategori = $id_kategori";

if (mysqli_query($koneksi, $query_delete)) {
    // Redirect setelah penghapusan berhasil
    echo "<script>alert('Kategori berhasil dihapus!'); window.location.href='kategori.php';</script>";
} else {
    // Error handling, misalnya jika kategori sedang digunakan oleh data buku (Foreign Key Constraint)
    echo "Error menghapus kategori: " . mysqli_error($koneksi);
}

// Tutup koneksi database (opsional, tergantung cara koneksi Anda)
mysqli_close($koneksi);
?>
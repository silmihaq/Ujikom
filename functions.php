<?php
// File: functions.php

/**
 * Membersihkan dan Melindungi Input dari SQL Injection dan XSS
 */
function sanitize_input($koneksi, $data) {
    $data = trim($data);
    $data = mysqli_real_escape_string($koneksi, $data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Melakukan Pengalihan Halaman (Redirect)
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Menampilkan Pesan Flash (Alert) Sesuai Spesifikasi (Warna Merah/Hijau)
 */
function display_alert($message, $type = 'error') {
    $color = ($type == 'success') ? 'green' : 'red';
    $style = "color: {$color}; border: 1px solid {$color}; padding: 10px; background-color: " . (($type == 'success') ? '#eafaea' : '#ffeaea') . ";";
    
    return "<p style='{$style}'>
                {$message}
            </p>";
}

/**
 * Mengecek Status Login Pengguna
 */
function is_logged_in() {
    return (isset($_SESSION['status']) && $_SESSION['status'] === "login");
}


// ------------------------------------------------------------------
// FUNGSI SPESIFIK APLIKASI (CRUD)
// ------------------------------------------------------------------

/**
 * Menyimpan data buku baru ke database.
 */
// File: functions.php - Ganti fungsi insert_buku dengan yang ini

function insert_buku($koneksi, $data) {

    $judul = mysqli_real_escape_string($koneksi, $data['judul']);
    $id_kategori = intval($data['id_kategori']);
    $penulis = mysqli_real_escape_string($koneksi, $data['penulis']);
    $penerbit = mysqli_real_escape_string($koneksi, $data['penerbit']);
    $gambar = mysqli_real_escape_string($koneksi, $data['gambar']);
    $tanggal_input = mysqli_real_escape_string($koneksi, $data['tanggal_input']);

    $query_sql = "INSERT INTO buku (judul, id_kategori, penulis, penerbit, gambar, tanggal_input) VALUES ('$judul', $id_kategori, '$penulis', '$penerbit', '$nama_gambar_db', '$tanggal_input')";

    $simpan = mysqli_query($koneksi, $query_sql);

    if ($simpan) {
        return true;
    } else {
        return "Error: " . mysqli_error($koneksi);
    }
}
?>
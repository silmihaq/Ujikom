<?php
// =========================
// KONEKSI DATABASE
// =========================
$koneksi = mysqli_connect("localhost", "root", "", "simbs"); 
// GANTI "silmi" jika database kamu bukan itu

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// =========================
// JIKA TOMBOL SIMPAN DITEKAN
// =========================
if (isset($_POST['simpan'])) {

    $judul      = $_POST['judul'];
    $penulis    = $_POST['penulis'];
    $penerbit   = $_POST['penerbit'];
    $id_kategori = $_POST['id_kategori'];

    // =========================
    // upload gambar
    // =========================

    $nama_gambar = ""; // default jika tidak upload

    if (!empty($_FILES['gambar']['name'])) {

        $allowed = ['jpg','jpeg','png'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die("Ekstensi tidak diperbolehkan!");
        }

        if ($_FILES['gambar']['size'] > 5044070) {
            die("Ukuran gambar max 5MB!");
        }

        // buat folder jika belum ada
        if (!is_dir(__DIR__ . "/gambar")) {
            mkdir(_DIR_ . "/gambar", 0777, true);
        }

        // rename file → random + time
        $nama_gambar = rand() . "_" . time() . "." . $ext;
        $target = __DIR__ . "/gambar/" . $nama_gambar;

        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            die("Gagal upload gambar!");
        }
    }

    // =========================
    // INSERT DATA KE DATABASE
    // =========================

    $query = "
        INSERT INTO buku (judul, id_kategori, penulis, penerbit, gambar)
        VALUES ('$judul', '$id_kategori', '$penulis', '$penerbit', '$nama_gambar')
    ";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data berhasil disimpan!');
                window.location = 'buku.php';
              </script>";
        exit;
    } else {
        die("Error Query: " . mysqli_error($koneksi));
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
</head>
<body>

<h2>Tambah Buku</h2>

<form method="POST" enctype="multipart/form-data" autocomplete="off">

    <label>Judul Buku</label><br>
    <input type="text" name="judul" required><br><br>

    <label>Penulis</label><br>
    <input type="text" name="penulis" required><br><br>

    <label>Penerbit</label><br>
    <input type="text" name="penerbit" required><br><br>

    <label>Kategori</label><br>
    <select name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>

        <?php
        $kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
        while ($k = mysqli_fetch_assoc($kategori)) {
            echo "<option value='".$k['id_kategori']."'>".$k['nama_kategori']."</option>";
        }
        ?>
    </select>
    <br><br>

    <label>Cover Buku</label><br>
    <input type="file" name="gambar"><br><br>

    <button type="submit" name="simpan">Simpan</button>
    <a href="buku.php">Kembali</a>

</form>

</body>
</html>
<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = '$id'");
$data  = mysqli_fetch_array($query);

if (isset($_POST['update'])) {
    $judul       = $_POST['judul'];
    $id_kategori = $_POST['id_kategori'];

    $update = mysqli_query($koneksi, "UPDATE buku SET judul='$judul', id_kategori='$id_kategori' WHERE id_buku='$id'");
    
    if ($update) {
        header("Location: buku.php");
    } else {
        echo "Gagal update data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Buku</title></head>
<body>
    <h3>Ubah Data Buku</h3>
    <form method="POST" autocomplete="off">
        <label>Judul Buku:</label><br>
        <input type="text" name="judul" value="<?= $data['judul']; ?>" required style="width: 300px;"><br><br>

        <label>Kategori:</label><br>
        <select name="id_kategori" required>
            <?php
            $sql_kat = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
            while($k = mysqli_fetch_array($sql_kat)): 
                // Logic agar kategori lama terpilih otomatis
                $selected = ($k['id_kategori'] == $data['id_kategori']) ? "selected" : "";
            ?>
                <option value="<?= $k['id_kategori']; ?>" <?= $selected; ?>><?= $k['nama_kategori']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="update">Ubah Data</button>
        <a href="buku.php">Kembali</a>
    </form>
</body>
</html>
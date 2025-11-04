<?php
session_start();
include 'koneksi.php';

// Ambil semua kategori
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori1");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
</head>
<body>
    <h2>Tambah Barang</h2>
    
    <form action="proses_tambah_barang.php" method="POST" enctype="multipart/form-data">
        <label>Nama Barang:</label><br>
        <input type="text" name="nama_barang" required><br>

        <label>Foto:</label><br>
        <input type="file" name="foto" accept="image/*" required><br>

        <label>Kategori:</label><br>
        <select name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php while ($row = mysqli_fetch_assoc($queryKategori)) : ?>
            <option value="<?= $row['id_kategori']; ?>">
                <?= $row['nama_kategori']; ?>
            </option>
        <?php endwhile; ?>
        </select><br>

        <label>Satuan:</label><br>
        <input type="text" name="satuan" required><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" required><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" required><br>

        <button type="submit">Tambah Barang</button>
        <a href="barang.php">Batal</a>
    </form>

    
</body>
</html>
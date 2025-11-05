<?php
session_start();
include '../koneksi.php';

// Ambil semua kategori
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori1");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>

    <link rel="stylesheet" href="../css/crud_barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
<div class="form-container">
    <h2>Tambah Barang</h2>
    
    <form action="proses_tambah_barang.php" method="POST" enctype="multipart/form-data">
        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" required>

        <label>Foto:</label>
        <input type="file" name="foto" accept="image/*" required>

        <label>Kategori:</label>
        <select name="id_kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php while ($row = mysqli_fetch_assoc($queryKategori)) : ?>
            <option value="<?= $row['id_kategori']; ?>">
                <?= $row['nama_kategori']; ?>
            </option>
        <?php endwhile; ?>
        </select>

        <label>Satuan:</label>
        <input type="text" name="satuan" required>

        <label>Harga:</label>
        <input type="number" name="harga" required>

        <label>Stok:</label>
        <input type="number" name="stok" required>

        <button type="submit" class="btn-update">Simpan</button>
        <a href="barang.php" class="btn-back">Batal</a>
    </form>
</div>
    
</body>
</html>
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
    <?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Barang</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="../beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="main-content">
    <div class="form-container">
    <h2>Tambah Barang</h2>
    
    <form action="proses_tambah_barang.php" method="POST" enctype="multipart/form-data" novalidate>
        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" >
        <?php if(isset($_GET['error']) && $_GET['error'] == "nama_barang"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
            <?php endif; ?>

        <label>Foto:</label>
        <input type="file" name="foto" accept="image/*" >

        <label>Kategori:</label>
        <select name="id_kategori" >
        <option value="">-- Pilih Kategori --</option>
        <?php while ($row = mysqli_fetch_assoc($queryKategori)) : ?>
            <option value="<?= $row['id_kategori']; ?>">
                <?= $row['nama_kategori']; ?>
            </option>
        <?php endwhile; ?>
        </select>
        <?php if(isset($_GET['error']) && $_GET['error'] == "id_kategori"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
            <?php endif; ?>

        <label>Satuan:</label>
        <input type="text" name="satuan" >
        <?php if(isset($_GET['error']) && $_GET['error'] == "satuan"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
            <?php endif; ?>

        <label>Harga:</label>
        <input type="number" name="harga">
        <?php if(isset($_GET['error']) && $_GET['error'] == "harga"): ?>
            <div class="text-danger small">Harga jual harus lebih dari 0!</div>
            <?php endif; ?>

        <label>Stok:</label>
        <input type="number" name="stok">
        <?php if(isset($_GET['error']) && $_GET['error'] == "stok"): ?>
            <div class="text-danger small">Stok harus lebih dari 0!</div>
            <?php endif; ?>

        <button type="submit" class="btn-update">Simpan</button>
        <a href="barang.php" class="btn-back">Batal</a>
    </form>
    </div>
    </div>
    
    <?php include '../include/footer.php'; ?>

</body>
</html>
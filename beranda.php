<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>

    <link rel="stylesheet" href="beranda.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
    
<nav class="navbar-home">
    <div class="logo-area">
        <img src="logo.jpg" alt="" class="logo">
        <h1>Sinar Abadi</h1>
    </div>

    <ul>
        <li><a href="#hero">Beranda</a></li>
        <li><a href="#about">Tentang Kami</a></li>
        <li><a href="#layanan">Layanan</a></li>
        <li><a href="login.php" class="login-btn">Login</a></li>
    </ul>
</nav>

<section id="hero" class="hero">
    <div class="hero-content">
        <h2>Selamat Datang di Sistem Manajemen Toko Bangunan <span>Sinar Abadi</span></h2>
        <p>MUdahkan pengelolaan tugas dan data toko</p>
        <a href="login.php" class="button">Login Sekarang</a>
    </div>
    <div class="hero-img">
        <img src="logo.jpg" alt="">
    </div>
</section>

<section id="about" class="about">
     <h2>Tentang Kami</h2>
     <p>Website ini dibuat untuk mendukung karyawan dan admin dalam mengelola data internal, termasuk manajemen karyawan, penjualan, pembelian, dan stok barang. Semua akses terbatas hanya untuk internal toko. 
     </p>
</section>

<section id="layanan" class="layanan">
    <h2>Layanan Kami</h2>
    <div class="cards">
        <div class="card">
            <h3>Manajemen Karyawan</h3>
            <p>Tambah, edit, dan pantau data karyawan dengan mudah</p>
        </div>
        <div class="card">
            <h3>Data Penjualan</h3>
            <p>Input dan pantau penjualan harian</p>
        </div>
        <div class="card">
            <h3>Stok Barang</h3>
            <p>Cek stok barang yang tersedia ditoko kami</p>
        </div>
        <div class="card">
            <h3>Data Pembelian dan Supplier</h3>
            <p>Input dan pantau data pemeblian barang dari supplier</p>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>

<?php
    session_start();
    include 'koneksi.php';

    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }

    //ambil data ringkasan dari database
    $karyawan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM karyawan"));
    $penjualan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM penjualan"));
    $stok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM barang"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="dashboard.css">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="sidebar">
        <img src="logo.jpg" class="logo">
        <h2>Sinar Abadi</h2> 

        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="karyawan.php">Karyawan</a></li>
            <li><a href="penjualan.php">Penjualan</a></li>
            <li><a href="pembelian.php">Pembelian</a></li>
            <li><a href="barang.php">Barang</a></li>
        </ul>

    </div>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Dashboard</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="content">
        <h1>Selamat Datang di Halaman Dashboard</h1>

        <div class="cards">
            <div class="card karyawan">
                <h3>Total Karyawan</h3>
                <p><?=$karyawan['total'] ?></p>
            </div>
            <div class="card penjualan">
                <h3>Total Penjualan</h3>
                <p><?=$penjualan['total'] ?></p>
            </div>
            <div class="card stok">
                <h3>Total Stok Barang</h3>
                <p><?=$stok['total'] ?></p>
            </div>
        </div>
    </div>
    
</body>
</html>
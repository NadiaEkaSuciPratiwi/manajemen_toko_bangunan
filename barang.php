<?php
    session_start();
    include 'koneksi.php';

    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>

    <link rel="stylesheet" href="barang.css">
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
            <h3>Data Barang</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>
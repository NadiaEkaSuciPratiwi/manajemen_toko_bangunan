<?php
session_start();
include '../koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil data
$supplier = $_POST['id_supplier'];
$barang = $_POST['id_barang'];
$jumlah = $_POST['jumlah'];
$harga_beli = $_POST['harga_beli'];
$total_harga = $_POST['total_harga'];
$tanggal = $_POST['tanggal_pembelian'];

// Query simpan
$query = "INSERT INTO pembelian (id_supplier, id_barang, jumlah, harga_beli, total_harga, tanggal_pembelian) 
          VALUES ('$supplier', '$barang', '$jumlah', '$harga_beli', '$total_harga', '$tanggal')";

if($insert){
    echo "<script>alert('Data pembelian berhasil ditambahkan');window.location='pembelian.php';</script>";
    } else {
    echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }

?>
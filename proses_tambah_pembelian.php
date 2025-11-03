<?php
session_start();
include 'koneksi.php';

// Ambil data
$supplier = $_POST['supplier'];
$jumlah = $_POST['jumlah'];
$harga_beli = $_POST['harga_beli'];
$total_harga = $_POST['total_harga'];
$tanggal = $_POST['tgl'];

// Query simpan
$query = "INSERT INTO pembelian (supplier, jumlah, harga_beli, total_harga, tanggal) 
          VALUES ('$supplier', '$jumlah', '$harga_beli', '$total_harga', '$tanggal')";

if(mysqli_query($conn, $query)){
    header("Location: pembelian.php?pesan=berhasil");
    exit;
} else {
    header("Location: tambah_pembelian.php?pesan=gagal");
    exit;
}
?>
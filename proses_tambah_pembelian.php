<?php
session_start();
include 'koneksi.php';

// Ambil data
$supplier = $_POST['id_supplier'];
$barang = $_POST['id_barang'];
$jumlah = $_POST['jumlah'];
$harga_beli = $_POST['harga_beli'];
$total_harga = $_POST['total_harga'];
$tanggal = $_POST['tanggal_pembelian'];

// Query simpan
$query = "INSERT INTO pembelian1 (id_supplier, id_barang, jumlah, harga_beli, total_harga, tanggal_pembelian) 
          VALUES ('$supplier', '$barang', '$jumlah', '$harga_beli', '$total_harga', '$tanggal')";

if(mysqli_query($koneksi, $query)){
    header("Location: pembelian.php?pesan=berhasil");
    exit;
} else {
    header("Location: create_pembelian.php?pesan=gagal");
    exit;
}
?>
<?php
include 'koneksi.php';

if(!isset($_GET['id'])){
    header("Location: penjualan.php");
    exit;
}

$id_penjualan = $_GET['id'];

//ambil jumlah & id_barang
$data = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT * FROM penjualan WHERE id_penjualan=$id_penjualan"));

$id_barang = $data['id_barang'];
$jumlah = $data['jumlah'];

//kembalikan stok
mysqli_query($koneksi,
    "UPDATE barang SET stok = stok + $jumlah WHERE id_barang = $id_barang");

//hapus penjualan
mysqli_query($koneksi,
    "DELETE FROM penjualan WHERE id_penjualan = $id_penjualan");

header("Location: penjualan.php?status=deleted");
exit;
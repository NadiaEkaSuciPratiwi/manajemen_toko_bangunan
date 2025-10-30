<?php
session_start();
include 'koneksi.php';

//Cek apakah user sudah login
if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit;
}

$query = mysqli_query($koneksi, "SELECT pembelian.id_pembelian, supplier.nama_supplier, barang.nama_barang,
           pembelian.jumlah, pembelian.harga_beli,
           (pembelian.jumlah * pembelian.harga_beli) AS total_harga,
           pembelian.tanggal_pembelian
    FROM pembelian
    JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
    JOIN barang ON pembelian.id_barang = barang.id_barang
    ORDER BY pembelian.id_pembelian DESC");

$pembelian = [];
while($row = mysqli_fetch_assoc($query)){
    $pembelian[] = $row;
}
?>
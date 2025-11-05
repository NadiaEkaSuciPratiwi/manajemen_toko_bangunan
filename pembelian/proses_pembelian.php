<?php
session_start();
include '../koneksi.php';

//Cek apakah user sudah login
if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

// Fungsi format tanggal
    function formatTanggal($tanggal_pembelian){

    return date('d-m-Y', strtotime($tanggal_pembelian));
    
    }

$query = mysqli_query($koneksi, "SELECT pembelian.id_pembelian, supplier.nama_supplier, barang.nama_barang,
           pembelian.jumlah, pembelian.harga_beli,
           (pembelian.jumlah * pembelian.harga_beli) AS total_harga,
           pembelian.tanggal_pembelian
    FROM pembelian
    JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
    JOIN barang ON pembelian.id_barang = barang.id_barang
    ORDER BY pembelian.id_pembelian DESC");

    if(!$query){
        die("Query Error: " . mysqli_error($koneksi));
    }

$pembelian = [];
while($row = mysqli_fetch_assoc($query)){
    $pembelian[] = $row;
}
?>
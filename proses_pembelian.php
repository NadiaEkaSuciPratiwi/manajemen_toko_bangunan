<?php
session_start();
include 'koneksi.php';

//Cek apakah user sudah login
if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit;
}

// Fungsi format tanggal
    function formatTanggal($tanggal){

    return date('d-m-Y', strtotime($tanggal));
    
    }

$query = mysqli_query($koneksi, "SELECT pembelian1.id_pembelian, supplier.nama_supplier, barang.nama_barang,
           pembelian1.jumlah, pembelian1.harga_beli,
           (pembelian1.jumlah * pembelian1.harga_beli) AS total_harga,
           pembelian1.tanggal_pembelian
    FROM pembelian1
    JOIN supplier ON pembelian1.id_supplier = supplier.id_supplier
    JOIN barang ON pembelian1.id_barang = barang.id_barang
    ORDER BY pembelian1.id_pembelian DESC");

    if(!$query){
        die("Query Error: " . mysqli_error($koneksi));
    }

$pembelian = [];
while($row = mysqli_fetch_assoc($query)){
    $pembelian[] = $row;
}
?>
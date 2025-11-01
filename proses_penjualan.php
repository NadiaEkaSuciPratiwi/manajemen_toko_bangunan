<?php
    session_start();
    include 'koneksi.php';

    //cek login
    if(!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    // Fungsi format tanggal
    function formatTanggal($tanggal_penjualan){

    return date('d-m-Y', strtotime($tanggal_penjualan));

    }

    //ambil data penjualan
    $query = mysqli_query($koneksi, "SELECT penjualan.id_penjualan, barang.nama_barang,
           penjualan.jumlah, penjualan.total_harga,
           penjualan.tanggal_penjualan
    FROM penjualan
    JOIN barang ON penjualan.id_barang = barang.id_barang
    ORDER BY penjualan.id_penjualan ASC");

    $penjualan = [];
    while($row = mysqli_fetch_assoc($query)) {
        $penjualan[] = $row;
    }
?>
<?php
session_start();
include '../koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// pastikan request dari form edit
if(!isset($_POST['id_penjualan'])){
    header("Location: penjualan.php");
    exit;
}

$id_penjualan = $_POST['id_penjualan'];
$id_barang_baru = $_POST['id_barang'];
$jumlah_baru = intval($_POST['jumlah']);
$total_harga = $_POST['total_harga'];
$tanggal_penjualan = $_POST['tanggal_penjualan'];

// ambil data penjualan lama
$qOld = mysqli_query($koneksi, "SELECT * FROM penjualan WHERE id_penjualan=$id_penjualan");
$old = mysqli_fetch_assoc($qOld);

$id_barang_lama = $old['id_barang'];
$jumlah_lama = $old['jumlah'];

// ambil stok lama & baru
$bLama = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT stok FROM barang WHERE id_barang=$id_barang_lama"));

$bBaru = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT stok FROM barang WHERE id_barang=$id_barang_baru"));

if($id_barang_lama == $id_barang_baru){
    //barang sama → hitung selisih jumlah
    $selisih = $jumlah_lama - $jumlah_baru;
    $stok_baru = $bBaru['stok'] + $selisih;

    if($stok_baru < 0){
        echo "<script>alert('Jumlah melebihi stok!'); history.back();</script>";
        exit;
    }

    mysqli_query($koneksi, 
        "UPDATE barang SET stok=$stok_baru WHERE id_barang=$id_barang_baru");

} else {
    //barang diganti → kembalikan stok barang lama
    mysqli_query($koneksi, 
        "UPDATE barang SET stok = stok + $jumlah_lama WHERE id_barang=$id_barang_lama");

    //potong stok barang baru
    $stok_baru = $bBaru['stok'] - $jumlah_baru;

    if($stok_baru < 0){
        echo "<script>alert('Stok barang tidak cukup!'); history.back();</script>";
        exit;
    }

    mysqli_query($koneksi, 
        "UPDATE barang SET stok=$stok_baru WHERE id_barang=$id_barang_baru");
}

// update data penjualan
mysqli_query($koneksi,
    "UPDATE penjualan 
    SET id_barang='$id_barang_baru', jumlah='$jumlah_baru', total_harga='$total_harga', tanggal_penjualan='$tanggal_penjualan'
    WHERE id_penjualan=$id_penjualan"
);

header("Location: penjualan.php?status=updated");
exit;
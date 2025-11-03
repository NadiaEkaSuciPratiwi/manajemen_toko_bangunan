<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];

// Ambil data lama untuk rollback stok
$cek = mysqli_query($conn, "SELECT id_barang, jumlah FROM pembelian WHERE id_pembelian='$id'");
$data = mysqli_fetch_assoc($cek);
$id_barang = $data['id_barang'];
$jumlah = $data['jumlah'];

// Hapus
if(mysqli_query($conn, "DELETE FROM pembelian WHERE id_pembelian='$id'")) {
    mysqli_query($conn, "UPDATE barang SET stok = stok - $jumlah WHERE id_barang='$id_barang'");
    header("Location: pembelian.php?pesan=hapus_berhasil");
    exit;
} else {
    header("Location: pembelian.php?pesan=hapus_gagal");
    exit;
}
?>
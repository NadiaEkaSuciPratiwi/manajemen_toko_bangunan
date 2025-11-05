<?php
session_start();
include '../koneksi.php';

$id = $_POST['id_pembelian'];
$id_barang = $_POST['id_barang'];
$id_supplier = $_POST['id_supplier'];
$jumlah = $_POST['jumlah'];
$harga_beli = $_POST['harga_beli'];
$total_harga = $jumlah * $harga_beli;
$tanggal_pembelian = $_POST['tanggal_pembelian'];

$query = mysqli_query($koneksi, "UPDATE pembelian SET 
    id_barang='$id_barang',
    id_supplier='$id_supplier',
    jumlah='$jumlah',
    harga_beli='$harga_beli',
    total_harga='$total_harga',
    tanggal_pembelian='$tanggal_pembelian'
    WHERE id_pembelian='$id'
");

if ($query) {
    echo "<script>alert('Data berhasil diupdate');window.location='pembelian.php';</script>";
} else {
    echo "<script>alert('Gagal update data');window.location='pembelian.php';</script>";
}
?>

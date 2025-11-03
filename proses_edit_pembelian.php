<?php
session_start();
include 'koneksi.php';

$id = $_POST['id_pembelian'];
$id_barang = $_POST['id_barang'];
$supplier = $_POST['supplier'];
$jumlah = $_POST['jumlah'];
$jumlah_lama = $_POST['jumlah_lama'];
$harga_beli = $_POST['harga_beli'];
$total_harga = $_POST['total_harga'];
$tanggal = $_POST['tanggal'];

// Selisih stok
$selisih = $jumlah - $jumlah_lama;

// Update pembelian
$query = "UPDATE pembelian SET 
            id_barang='$id_barang',
            supplier='$supplier',
            jumlah='$jumlah',
            harga_beli='$harga_beli',
            total_harga='$total_harga',
            tanggal='$tanggal'
          WHERE id_pembelian='$id'";

if(mysqli_query($conn, $query)){

    // Update stok sesuai selisih
    $updateStok = "UPDATE barang SET stok = stok + $selisih WHERE id_barang='$id_barang'";
    mysqli_query($conn, $updateStok);

    header("Location: pembelian.php?pesan=edit_berhasil");
    exit;
} else {
    header("Location: edit_pembelian.php?id=$id&pesan=gagal");
    exit;
}
?>
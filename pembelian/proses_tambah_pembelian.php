<?php
session_start();
include '../koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil data
$supplier = $_POST['id_supplier'];
$barang = $_POST['id_barang'];
$jumlah = $_POST['jumlah'];
$harga_beli = $_POST['harga_beli'];
$total_harga = $_POST['total_harga'];
$tanggal = $_POST['tanggal_pembelian'];

$error = "";

    if ($supplier == "") {
        $error = "id_supplier";
    }
    if ($barang == "") {
        $error = "id_barang";
    } elseif ($jumlah <= 0) {
        $error = "jumlah";
    } elseif ($harga_beli <= 0) {
        $error = "harga_beli";
    } elseif ($total_harga <= 0) {
        $error = "total harga";
    } elseif ($tanggal == "") {
        $error = "tanggal_pembelian";
    }

if($error != ""){
    header("Location: create_pembelian.php?error=$error");
    exit;
}

// Query simpan
$query = "INSERT INTO pembelian (id_supplier, id_barang, jumlah, harga_beli, total_harga, tanggal_pembelian) 
          VALUES ('$supplier', '$barang', '$jumlah', '$harga_beli', '$total_harga', '$tanggal')";
          
mysqli_query($koneksi, $query);

if($query){
    echo "<script>alert('Data pembelian berhasil ditambahkan');window.location='pembelian.php';</script>";
    } else {
    echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }

?>
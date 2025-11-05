<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: barang.php");
    exit;
}
$id = intval($_GET['id']);

// ambil nama file dulu
$res = mysqli_query($koneksi, "SELECT foto FROM barang WHERE id_barang = $id");
if(mysqli_num_rows($res) == 0){
    header("Location: barang.php");
    exit;
}
$row = mysqli_fetch_assoc($res);
$foto = $row['foto'];

if(mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang = $id")){
    // hapus file fisik jika ada
    if($foto && file_exists('produk/'.$foto)){
        @unlink('produk/'.$foto);
    }
    echo "<script>alert('Data barang berhasil dihapus');window.location='barang.php';</script>";
} else {
    echo "Gagal menghapus: " . mysqli_error($koneksi) . " <a href='barang.php'>Kembali</a>";
    exit;
}
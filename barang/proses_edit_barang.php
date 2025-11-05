<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: barang.php");
    exit;
}

// ambil dan sanitize
$id_barang = intval($_POST['id_barang']);
$nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
$id_kategori = intval($_POST['id_kategori']);
$satuan = mysqli_real_escape_string($koneksi, $_POST['satuan']);
$harga = $_POST['harga']; // numeric, bisa val di DB
$stok = $_POST['stok'];
$foto_lama = isset($_POST['foto_lama']) ? $_POST['foto_lama'] : null;

$upload_dir = "produk/";
$new_file_name = $foto_lama; // default tetap foto lama

// jika ada file upload baru
if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
    $tmp = $_FILES['foto']['tmp_name'];
    $orig_name = basename($_FILES['foto']['name']);
    $ext = pathinfo($orig_name, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if(!in_array(strtolower($ext), $allowed)){
        echo "Format file tidak didukung. <a href='edit_barang.php?id=$id_barang'>Kembali</a>";
        exit;
    }

    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $new_file_name = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $orig_name);
    if(move_uploaded_file($tmp, $upload_dir . $new_file_name)){
        // hapus file lama kalau ada dan berbeda
        if($foto_lama && file_exists($upload_dir . $foto_lama)){
            @unlink($upload_dir . $foto_lama);
        }
    } else {
        echo "Gagal upload foto. <a href='edit_barang.php?id=$id_barang'>Kembali</a>";
        exit;
    }
}

// update query
$sql = "UPDATE barang SET 
            nama_barang = '$nama_barang',
            foto = " . ($new_file_name !== null ? "'$new_file_name'" : "NULL") . ",
            id_kategori = $id_kategori,
            satuan = '$satuan',
            harga = '$harga',
            stok = '$stok'
        WHERE id_barang = $id_barang";

if(mysqli_query($koneksi, $sql)){
    echo "<script>alert('Data barang berhasil diubah');window.location='barang.php';</script>";
} else {
    echo "Error update: " . mysqli_error($koneksi) . " <a href='edit_barang.php?id=$id_barang'>Kembali</a>";
    exit;
}
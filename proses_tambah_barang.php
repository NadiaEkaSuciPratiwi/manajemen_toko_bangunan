<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}


$nama_barang = $_POST['nama_barang'];
$id_kategori = $_POST['id_kategori'];
$satuan = $_POST['satuan'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

// Proses upload foto
if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
    $file_tmp = $_FILES['foto']['tmp_name'];
    $file_name = time().'_'.basename($_FILES['foto']['name']); 
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];

    if(in_array(strtolower($file_ext), $allowed)){
        $upload_dir = "produk/";
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
            // buat folder jika belum ada
        }
        move_uploaded_file($file_tmp, $upload_dir.$file_name);
    } else {
        echo "<div class='alert error'>Format file tidak didukung! <a href='tambah_barang.php'>Kembali</a></div>";
        exit;
    }
} else {
    $file_name = null;
}

// Simpan ke database
$query = "INSERT INTO barang (nama_barang, foto, id_kategori, satuan, harga, stok) 
          VALUES ('$nama_barang', '$file_name', '$id_kategori', '$satuan', '$harga', '$stok' )";

if(mysqli_query($koneksi, $query)){
    echo "<div class='alert success'>Barang berhasil ditambahkan! <a href='barang.php'>Lihat Daftar Barang</a></div>";
} else {
    echo "<div class='alert error'>Error: ".mysqli_error($koneksi)." <a href='tambah_barang.php'>Kembali</a></div>";
}
?>
<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

// Ambil kata kunci pencarian (kalau ada)
$search = isset($_GET['cari']) ? $_GET['cari'] : '';

// Query dengan kondisi search
if($search != "") {
    $query = "SELECT barang.*, kategori1.nama_kategori 
              FROM barang 
              LEFT JOIN kategori1 ON barang.id_kategori = kategori1.id_kategori
              WHERE barang.nama_barang LIKE '%$search%'
              OR kategori1.nama_kategori LIKE '%$search%'";


} else {
    $query = "SELECT barang.*, kategori1.nama_kategori 
              FROM barang 
              LEFT JOIN kategori1 ON barang.id_kategori = kategori1.id_kategori";
}

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$query = "SELECT barang.*, kategori1.nama_kategori 
          FROM barang 
          LEFT JOIN kategori1 ON barang.id_kategori = kategori1.id_kategori
          WHERE 1=1";

if($search != ""){
    $query .= " AND (barang.nama_barang LIKE '%$search%' 
        OR kategori1.nama_kategori LIKE '%$search%')";
}

if($kategori != ""){
    $query .= " AND barang.id_kategori = '$kategori'";
}


$result = mysqli_query($koneksi, $query);

$barang_list = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $barang_list[] = $row;
    }
}
;
?>

<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Pagination
$limit = 2; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Filter Pencarian & Kategori
$search   = isset($_GET['cari']) ? $_GET['cari'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Query dasar
$where = "WHERE 1=1";

// Jika ada pencarian
if ($search != "") {
    $where .= " AND (barang.nama_barang LIKE '%$search%' 
               OR kategori1.nama_kategori LIKE '%$search%')";
}

// Jika pilih kategori
if ($kategori != "") {
    $where .= " AND barang.id_kategori = '$kategori'";
}

// Hitung total data untuk pagination
$countQuery = "SELECT COUNT(*) AS total FROM barang 
               LEFT JOIN kategori1 ON barang.id_kategori = kategori1.id_kategori
               $where";
$countResult = mysqli_query($koneksi, $countQuery);
$total_data = mysqli_fetch_assoc($countResult)['total'];
$total_page = ceil($total_data / $limit);

// Query data sesuai halaman
$query = "SELECT barang.*, kategori1.nama_kategori 
          FROM barang 
          LEFT JOIN kategori1 ON barang.id_kategori = kategori1.id_kategori
          $where
          LIMIT $offset, $limit";
$result = mysqli_query($koneksi, $query);

// Simpan hasil ke dalam array
$barang_list = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $barang_list[] = $row;
    }
}
?>

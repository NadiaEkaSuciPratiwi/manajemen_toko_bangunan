<?php
session_start();
include '../koneksi.php';

//Cek apakah user sudah login
if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

//  Pagination
$limit = 2; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil search (jika ada)
$search = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : "";

//  Query hitung total data
$query_count = "SELECT COUNT(*) AS total FROM supplier
                WHERE supplier.nama_supplier LIKE '%$search%'";
$result_count = mysqli_query($koneksi, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_data = $row_count['total'];
$total_page = ceil($total_data / $limit);

$query = "SELECT  * FROM supplier
            WHERE supplier.nama_supplier LIKE '%$search%'
            ORDER BY id_supplier DESC
            LIMIT $start, $limit";

$result = mysqli_query($koneksi, $query);

$supplier =[];
if($result){
    while($row =mysqli_fetch_assoc($result)){
        $supplier[] = $row;
    }
}
?>
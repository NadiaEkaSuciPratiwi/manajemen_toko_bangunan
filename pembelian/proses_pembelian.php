<?php
session_start();
include '../koneksi.php';

//Cek apakah user sudah login
if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

// Fungsi format tanggal
    function formatTanggal($tanggal_pembelian){

    return date('d-m-Y', strtotime($tanggal_pembelian));
    
    }

//  Pagination
$limit = 2; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil search (jika ada)
$search = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : "";

//  Query hitung total data
$query_count = "SELECT COUNT(*) AS total FROM pembelian
                LEFT JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
                LEFT JOIN barang ON pembelian.id_barang = barang.id_barang
                WHERE barang.nama_barang LIKE '%$search%'
                OR supplier.nama_supplier LIKE '%$search%'";
$result_count = mysqli_query($koneksi, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_data = $row_count['total'];
$total_page = ceil($total_data / $limit);


$query = "SELECT pembelian.*, supplier.nama_supplier, barang.nama_barang
            FROM pembelian
            LEFT JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
            LEFT JOIN  barang ON pembelian.id_pembelian = barang.id_barang
            WHERE barang.nama_barang LIKE '%$search%'
            OR supplier.nama_supplier LIKE '%$search%'
            ORDER BY id_pembelian ASC
            LIMIT $start, $limit";
$result = mysqli_query($koneksi, $query);


// Masukkan ke array
$pembelian = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $pembelian[] = $row;
    }
}

?>
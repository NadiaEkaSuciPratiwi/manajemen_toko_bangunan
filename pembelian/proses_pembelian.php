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

$search = isset($_GET['cari']) ? $_GET['cari'] : '';

if($search != "") {
    $query = "SELECT pembelian.*, supplier.nama_supplier, barang.nama_barang
          FROM pembelian
          LEFT JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
          LEFT JOIN barang ON pembelian.id_barang = barang.id_barang
          WHERE supplier.nama_supplier LIKE '%$search%'
             OR pembelian.tanggal_pembelian LIKE '%$search%'
             OR pembelian.total_harga LIKE '%$search%'
             OR pembelian.jumlah LIKE '%$search%'
             OR barang.nama_barang LIKE '%$search%'
          ORDER BY id_pembelian ASC";

} else {
    $query = "SELECT pembelian.*, supplier.nama_supplier, barang.nama_barang
            FROM pembelian
            LEFT JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
            LEFT JOIN  barang ON pembelian.id_pembelian = barang.id_barang
            ORDER BY id_pembelian ASC";
}

$result = mysqli_query($koneksi, $query);

// Masukkan ke array
$pembelian = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $pembelian[] = $row;
    }
}

?>
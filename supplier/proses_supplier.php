<?php
session_start();
include '../koneksi.php';

//Cek apakah user sudah login
if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

//Ambil data supplier 
$search = isset($_GET['cari']) ? $_GET['cari'] : '';

if($search != "") {
    $query = "SELECT  * FROM supplier
            WHERE supplier.nama_supplier LIKE '%$search%'
            ORDER BY id_supplier DESC";
} else {
    $query = "SELECT * FROM supplier ORDER BY id_supplier DESC";
}

$result = mysqli_query($koneksi, $query);

$supplier =[];
if($result){
    while($row =mysqli_fetch_assoc($result)){
        $supplier[] = $row;
    }
}
?>
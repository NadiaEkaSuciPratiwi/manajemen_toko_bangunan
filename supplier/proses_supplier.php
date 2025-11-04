<?php
session_start();
include '../koneksi.php';

//Cek apakah user sudah login
if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

//Ambil data supplier dari database
$query = mysqli_query($koneksi,"SELECT * FROM supplier ORDER BY id_supplier DESC");

$supplier =[];
while($row =mysqli_fetch_assoc($query)){
    $supplier[] = $row;
}

?>
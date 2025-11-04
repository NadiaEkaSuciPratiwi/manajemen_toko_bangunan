<?php
include '../koneksi.php';

session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

$nama = $_POST['nama_supplier'];
$alamat = $_POST['alamat'];
$no = $_POST['no_telpon'];

$query = "INSERT INTO supplier (nama_supplier, alamat, no_telpon) 
          VALUES ('$nama','$alamat','$no')";
mysqli_query($koneksi, $query);

header("Location: supplier.php");
exit;
?>
<?php
include '../koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$id   = $_POST['id_supplier'];
$nama = $_POST['nama_supplier'];
$alamat = $_POST['alamat'];
$no = $_POST['no_telpon'];

$query = "UPDATE supplier SET 
            nama_supplier='$nama', 
            alamat='$alamat', 
            no_telpon='$no'
          WHERE id_supplier=$id";
mysqli_query($koneksi, $query);

header("Location: supplier.php");
exit;
?>
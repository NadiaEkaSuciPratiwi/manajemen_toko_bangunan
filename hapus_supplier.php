<?php
include 'koneksi.php';

$id = intval($_GET['id']);
mysqli_query($koneksi, "DELETE FROM supplier WHERE id_supplier=$id");

header("Location: supplier.php");
exit;
?>
<?php
include '../koneksi.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $hapus = mysqli_query($koneksi, "DELETE FROM pembelian WHERE id_pembelian='$id'");

    if ($hapus) {
        echo "<script>alert('Data berhasil dihapus!');window.location='pembelian.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!');window.location='pembelian.php';</script>";
    }
} else {
    header("Location: pembelian.php");
}
?>
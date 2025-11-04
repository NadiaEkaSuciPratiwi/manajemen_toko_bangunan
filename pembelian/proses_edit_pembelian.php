<?php
include '../koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: .../login.php");
    exit;
}

// Ambil data pembelian berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM pembelian1 WHERE id_pembelian='$id'");
    $data = mysqli_fetch_assoc($query);
}

//ambil data supplier
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier");

// Jika form disubmit
if (isset($_POST['update'])) {
    $id_supplier = $_POST['id_supplier'];
    $jumlah = $_POST['jumlah'];
    $harga_beli = $_POST['harga_beli'];
    $total_harga = $jumlah * $harga_beli;
    $tanggal_pembelian = $_POST['tanggal_pembelian'];

    $update = mysqli_query($koneksi, "UPDATE pembelian1 SET 
                id_supplier='$id_supplier', 
                jumlah='$jumlah', 
                harga_beli='$harga_beli', 
                total_harga='$total_harga', 
                tanggal_pembelian='$tanggal_pembelian'
              WHERE id_pembelian='$id'");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui!');window.location='pembelian.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>
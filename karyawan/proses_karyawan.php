<?php
session_start();
include '../koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Fungsi format tanggal
    function formatTanggal($tanggal_join){

    return date('d-m-Y', strtotime($tanggal_join));
    
    }

// cek role hanya admin yang bisa akses
if (!isset($_SESSION['peran']) || $_SESSION['peran'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin'); window.location='dashboard.php';</script>";
    exit;
}

// ambil data karyawan
$query = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY id_karyawan ASC");

$karyawan = [];
while ($row = mysqli_fetch_assoc($query)) {
    $karyawan[] = $row;
}
?>

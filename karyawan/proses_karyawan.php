<?php
session_start();
include '../koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
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

// Search Karyawan
$search = isset($_GET['cari']) ? $_GET['cari'] : '';

if($search != "") {
    $query = "SELECT karyawan.*, users.username 
            FROM karyawan 
            JOIN users ON karyawan.id = users.id
            WHERE karyawan.nama LIKE '%$search%' 
               OR users.username LIKE '%$search%'
               OR karyawan.no_telp LIKE '%$search%'
            ORDER BY id_karyawan DESC";
} else {
    $query = "SELECT karyawan.*, users.username 
            FROM karyawan 
            JOIN users ON karyawan.id = users.id
            ORDER BY id_karyawan DESC";
}

$result = mysqli_query($koneksi, $query);

// Masukkan ke array
$karyawan = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $karyawan[] = $row;
    }
}

?>

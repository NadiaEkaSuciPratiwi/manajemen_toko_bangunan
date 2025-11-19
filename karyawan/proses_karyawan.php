<?php
session_start();
include '../koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil foto profil dari tabel karyawan
    $id_user = $_SESSION['user_id'];

    $ambilFoto = mysqli_query($koneksi, "
                SELECT foto 
                FROM karyawan
                WHERE id = '$id_user'
    ");

    $dataUser = mysqli_fetch_assoc($ambilFoto);

    // Path foto profil
    $foto = (!empty($dataUser['foto'])) 
        ? "profil/" . $dataUser['foto']  
        : "";

// Fungsi format tanggal
    function formatTanggal($tanggal_join){

    return date('d-m-Y', strtotime($tanggal_join));
    
    }

// cek role hanya admin yang bisa akses
if (!isset($_SESSION['peran']) || $_SESSION['peran'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin'); window.location='dashboard.php';</script>";
    exit;
}

//  Pagination
$limit = 10; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil search (jika ada)
$search = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : "";

//  Query hitung total data
$query_count = "SELECT COUNT(*) AS total FROM karyawan
                JOIN users ON karyawan.id = users.id
                WHERE karyawan.nama LIKE '%$search%' 
                OR users.username LIKE '%$search%'
                OR karyawan.no_telp LIKE '%$search%'";
$result_count = mysqli_query($koneksi, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_data = $row_count['total'];
$total_page = ceil($total_data / $limit);

    $query = "SELECT karyawan.*, users.username 
            FROM karyawan 
            JOIN users ON karyawan.id = users.id
            WHERE karyawan.nama LIKE '%$search%' 
               OR users.username LIKE '%$search%'
               OR karyawan.no_telp LIKE '%$search%'
            ORDER BY id_karyawan ASC
            LIMIT $start, $limit";

$result = mysqli_query($koneksi, $query);

// Masukkan ke array
$karyawan = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $karyawan[] = $row;
    }
}

?>

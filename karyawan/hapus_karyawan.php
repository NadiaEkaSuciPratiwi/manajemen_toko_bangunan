<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['id'])) {
    die("ID karyawan tidak ditemukan");
}

$id_karyawan = $_GET['id'];

// ambil id user terkait
$query = mysqli_query($koneksi, "SELECT id FROM karyawan WHERE id_karyawan='$id_karyawan'");
if (mysqli_num_rows($query) == 0) {
    die("ID karyawan tidak ditemukan dalam database");
}
$data = mysqli_fetch_assoc($query);
$id_user = $data['id'];

// cek apakah user dipakai karyawan lain
$cek_user = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id='$id_user' AND id_karyawan!='$id_karyawan'");

if (mysqli_num_rows($cek_user) == 0) {
    mysqli_query($koneksi, "DELETE FROM users WHERE id='$id_user'");
}

// hapus karyawan
$hapus = mysqli_query($koneksi, "DELETE FROM karyawan WHERE id_karyawan='$id_karyawan'");

if ($hapus) {
    echo "<script>alert('Karyawan berhasil dihapus'); window.location='karyawan.php';</script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>

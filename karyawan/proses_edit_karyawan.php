<?php
session_start();
include '../koneksi.php';

// Cek role admin
if ($_SESSION['peran'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin'); window.location='../beranda.php';</script>";
    exit;
}

$id = $_POST['id_karyawan'];
$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];
$no_telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];
$tanggal_join = $_POST['tanggal_join'];
$id_user = $_POST['id'];

$query = "UPDATE karyawan SET 
            nama='$nama',
            jabatan='$jabatan',
            no_telp='$no_telp',
            alamat='$alamat',
            tanggal_join='$tanggal_join',
            id='$id_user'
          WHERE id_karyawan='$id'";

mysqli_query($koneksi, $query);

if($query){
    echo "<script>alert('Data karyawan berhasil diubah');window.location='karyawan.php';</script>";
    } else {
    echo "Gagal megubah data: " . mysqli_error($koneksi);
    }
?>

<?php
session_start();
include '../koneksi.php';

$id_user = $_POST['id'];
$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];
$no_telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];
$tanggal_join = $_POST['tanggal_join'];

$query = "INSERT INTO karyawan (id, nama, jabatan, no_telp, alamat, tanggal_join) 
          VALUES ('$id_user', '$nama', '$jabatan', '$no_telp', '$alamat', '$tanggal_join')";

mysqli_query($koneksi, $query);

if($query){
    echo "<script>alert('Data karyawan berhasil ditambahkan');window.location='karyawan.php';</script>";
    } else {
    echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
?>

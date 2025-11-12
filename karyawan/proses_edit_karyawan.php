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
$foto_lama = $_POST['foto_lama'] ?? null;
$id_user = $_POST['id'];

$upload_dir = "profil/";
$new_file_name = $foto_lama;

// Jika ada file baru
if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
    $tmp = $_FILES['foto']['tmp_name'];
    $orig_name = basename($_FILES['foto']['name']);
    $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif'];

    if(!in_array($ext, $allowed)){
        echo "Format file tidak didukung. <a href='edit_karyawan.php?id=$id'>Kembali</a>";
        exit;
    }

    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $new_file_name = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $orig_name);
    if(move_uploaded_file($tmp, $upload_dir . $new_file_name)){
        if($foto_lama && file_exists($upload_dir . $foto_lama)){
            @unlink($upload_dir . $foto_lama);
        }
    } else {
        echo "Gagal upload foto. <a href='edit_karyawan.php?id=$id'>Kembali</a>";
        exit;
    }
}

// Simpan ke database
$query = "UPDATE karyawan SET 
            nama='$nama',
            jabatan='$jabatan',
            no_telp='$no_telp',
            alamat='$alamat',
            tanggal_join='$tanggal_join',
            foto='$new_file_name',
            id='$id_user'
          WHERE id_karyawan='$id'";

$result = mysqli_query($koneksi, $query);

if($result){
    echo "<script>alert('Data karyawan berhasil diubah');window.location='karyawan.php';</script>";
} else {
    echo "Gagal mengubah data: " . mysqli_error($koneksi);
}
?>

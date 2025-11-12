<?php
session_start();
include '../koneksi.php';

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$peran = $_POST['peran'];  
$nama = $_POST['nama'];
$no_telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];
$tanggal_join = $_POST['tanggal_join'];

// Ambil foto lama dari tabel karyawan
$qOld = mysqli_query($koneksi, "SELECT foto FROM karyawan WHERE id='$id'");
if (!$qOld) {
    die("Query error: " . mysqli_error($koneksi));
}
$dOld = mysqli_fetch_assoc($qOld);
$fotoLama = $dOld['foto'] ?? null;

// Upload foto baru (jika ada)
$fotoBaru = $fotoLama;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $tmp = $_FILES['foto']['tmp_name'];
    $nama_file = time() . '_' . $_FILES['foto']['name'];
    $lokasi = "../karyawan/profil/" . $nama_file;

    if (move_uploaded_file($tmp, $lokasi)) {
        // Hapus foto lama
        if (!empty($fotoLama) && file_exists("../karyawan/profil/" . $fotoLama)) {
            unlink("../karyawan/profil/" . $fotoLama);
        }
        $fotoBaru = $nama_file;
    }
}

// Update tabel users
mysqli_query($koneksi, "
    UPDATE users 
    SET username='$username', password='$password', peran='$peran'
    WHERE id='$id'
");

// Update tabel karyawan
mysqli_query($koneksi, "
    UPDATE karyawan 
    SET nama='$nama', no_telp='$no_telp', alamat='$alamat', foto='$fotoBaru', tanggal_join='$tanggal_join'
    WHERE id='$id'
");

echo "<script>alert('Profil berhasil diperbarui!');window.location='detail_users.php';</script>";
?>

<?php
session_start();
include '../koneksi.php';

$id_user = $_POST['id'];
$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];
$no_telp = $_POST['no_telp'];
$alamat = $_POST['alamat'];
$tanggal_join = $_POST['tanggal_join'];

$error = "";

// Validasi
if ($id_user == "") {
    $error = "id";
} elseif ($nama == "") {
    $error = "nama";
} elseif ($jabatan == "") {
    $error = "jabatan";
} elseif (strlen($no_telp) > 13) {
    $error = "no_telp";
} elseif ($alamat == "") {
    $error = "alamat";
} elseif ($tanggal_join == "") {
    $error = "tanggal_join";
}

if ($error != "") {
    header("Location: create_karyawan.php?error=$error");
    exit;
}

// --- Upload foto ---
$foto = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $tmp = $_FILES['foto']['tmp_name'];
    $orig_name = basename($_FILES['foto']['name']);
    $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif'];

    if (!in_array($ext, $allowed)) {
        header("Location: create_karyawan.php?error=foto");
        exit;
    }

    $upload_dir = "profil/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $new_file_name = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $orig_name);
    if (move_uploaded_file($tmp, $upload_dir . $new_file_name)) {
        $foto = $new_file_name;
    }
}

// --- Simpan ke database (termasuk foto) ---
$query = "INSERT INTO karyawan (id, nama, jabatan, no_telp, alamat, tanggal_join, foto) 
          VALUES ('$id_user', '$nama', '$jabatan', '$no_telp', '$alamat', '$tanggal_join', '$foto')";

$result = mysqli_query($koneksi, $query);

if ($result) {
    echo "<script>alert('Data karyawan berhasil ditambahkan');window.location='karyawan.php';</script>";
} else {
    echo "Gagal menambahkan data: " . mysqli_error($koneksi);
}
?>

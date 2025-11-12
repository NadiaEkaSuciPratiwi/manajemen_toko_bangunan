<?php
include '../koneksi.php';

session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

$nama = $_POST['nama_supplier'];
$alamat = $_POST['alamat'];
$no = $_POST['no_telpon'];

$error = "";

    if ($nama == "") {
        $error = "nama_supplier";
    } elseif ($alamat == "") {
        $error = "alamat";
    } elseif ($no < 12) {
        $error = "no_telpon";
    }

    if($error != ""){
        header("Location: create_supplier.php?error=$error");
        exit;
    }

$query = "INSERT INTO supplier (nama_supplier, alamat, no_telpon) 
          VALUES ('$nama','$alamat','$no')";
mysqli_query($koneksi, $query);

if($query){
    echo "<script>alert('Data berhasil ditambahkan');window.location='supplier.php';</script>";
    } else {
    echo "Gagal menambah data: " . mysqli_error($koneksi);
    }
?>
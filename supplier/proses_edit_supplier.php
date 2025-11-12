<?php
include '../koneksi.php';



$id   = $_POST['id_supplier'];
$nama = $_POST['nama_supplier'];
$alamat = $_POST['alamat'];
$no = $_POST['no_telpon'];

$query = "UPDATE supplier SET 
            nama_supplier='$nama', 
            alamat='$alamat', 
            no_telpon='$no'
          WHERE id_supplier=$id";
mysqli_query($koneksi, $query);

if($query){
    echo "<script>alert('Data berhasil diubah');window.location='supplier.php';</script>";
    } else {
    echo "Gagal megubah data: " . mysqli_error($koneksi);
    }

?>
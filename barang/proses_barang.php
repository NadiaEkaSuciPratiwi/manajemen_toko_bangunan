<?php
    session_start();
    include '../koneksi.php';

    if(!isset($_SESSION['user_id'])){
        header("Location: ../login/login.php");
        exit;
    }

    //ambil data barang dan kategori, pakai join biar tampil nama kategori
    function getALLBarang($koneksi){
        $query = "SELECT barang.*, kategori1.nama_kategori From barang LEFT JOIN kategori1 ON barang.id_kategori = kategori1.id_kategori";
        $result = mysqli_query($koneksi, $query);

        $data = [];
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }

        return $data;
    }

    //panggil fungsi
    $barang_list = getALLBarang($koneksi)
?>
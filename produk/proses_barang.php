<?php
    session_start();
    include 'koneksi.php';

    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }

    //ambil data barang dan kategori, pakai join biar tampil nama kategori
    function getALLBarang($koneksi){
        $query = "SELECT barang.*, kategori.nama_kategori From barang LEFT JOIN kategori ON barang.id_kategori = kategori.id_kategori";
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
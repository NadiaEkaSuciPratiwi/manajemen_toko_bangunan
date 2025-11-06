<?php
    session_start();
    include '../koneksi.php';

    //cek login
    if(!isset($_SESSION['user_id'])) {
        header("Location: ../login/login.php");
        exit;
    }

    // Fungsi format tanggal
    function formatTanggal($tanggal_penjualan){

    return date('d-m-Y', strtotime($tanggal_penjualan));

    }

    // Ambil data penjualan
    $search = isset($_GET['cari']) ? $_GET['cari'] : '';

    if($search != "") {
        $query = "SELECT penjualan.id_penjualan, barang.nama_barang,
                        penjualan.jumlah, penjualan.total_harga,
                        penjualan.tanggal_penjualan
                FROM penjualan
                LEFT JOIN barang ON penjualan.id_barang = barang.id_barang
                WHERE penjualan.tanggal_penjualan LIKE '%$search%'
                    OR barang.nama_barang LIKE '%$search%'
                ORDER BY id_penjualan ASC";
    } else {
        $query = "SELECT penjualan.id_penjualan, barang.nama_barang,
                        penjualan.jumlah, penjualan.total_harga,
                        penjualan.tanggal_penjualan
                FROM penjualan
                LEFT JOIN barang ON penjualan.id_barang = barang.id_barang
                ORDER BY id_penjualan ASC";
    }

    $result = mysqli_query($koneksi, $query);

    $penjualan = [];
    if($result){
        while ($row = mysqli_fetch_assoc($result)) {
            $penjualan[] = $row;
        }
    }

?>
<?php
    session_start();
    include 'koneksi.php';

    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }
    
    // ambil data karyawan
    $query = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY id_karyawan ASC");

    $karyawan = [];
    while($row = mysqli_fetch_assoc($query)) {
        $karyawan[] = $row;
    }

?>
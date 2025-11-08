<?php
session_start();
include '../koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Fungsi format tanggal
function formatTanggal($tanggal_penjualan)
{
    return date('d-m-Y', strtotime($tanggal_penjualan));
}

//  Pagination
$limit = 2; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil search (jika ada)
$search = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : "";

//  Query hitung total data
$query_count = "SELECT COUNT(*) AS total FROM penjualan 
                LEFT JOIN barang ON penjualan.id_barang = barang.id_barang
                WHERE barang.nama_barang LIKE '%$search%'";
$result_count = mysqli_query($koneksi, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_data = $row_count['total'];
$total_page = ceil($total_data / $limit);

// Query ambil data sesuai pagination
$query = "SELECT penjualan.id_penjualan, barang.nama_barang,
                    penjualan.jumlah, penjualan.total_harga,
                    penjualan.tanggal_penjualan
          FROM penjualan
          LEFT JOIN barang ON penjualan.id_barang = barang.id_barang
          WHERE barang.nama_barang LIKE '%$search%'
          ORDER BY id_penjualan DESC
          LIMIT $start, $limit";
$result = mysqli_query($koneksi, $query);

// Simpan hasil ke array
$penjualan = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $penjualan[] = $row;
    }
}
?>

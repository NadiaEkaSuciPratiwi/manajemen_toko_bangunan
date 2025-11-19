<?php
session_start();
include '../koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil foto profil
$id_user = $_SESSION['user_id'];
$ambilFoto = mysqli_query($koneksi, "SELECT foto FROM karyawan WHERE id = '$id_user'");
$dataUser = mysqli_fetch_assoc($ambilFoto);
$foto = (!empty($dataUser['foto'])) ? "../karyawan/profil/" . $dataUser['foto'] : "";

// Fungsi format tanggal
function formatTanggal($tanggal_penjualan) {
    return date('d-m-Y', strtotime($tanggal_penjualan));
}

// Ambil filter
$mulai  = $_GET['mulai']  ?? '';
$sampai = $_GET['sampai'] ?? '';
$search = $_GET['cari']   ?? '';

// Pagination setting
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // tidak boleh < 1
$start = ($page - 1) * $limit;

// =========================
//   QUERY DASAR
// =========================
$where = "WHERE 1=1";

// Jika ada search
if (!empty($search)) {
    $search = mysqli_real_escape_string($koneksi, $search);
    $where .= " AND barang.nama_barang LIKE '%$search%'";
}

// Jika ada filter tanggal
if (!empty($mulai) && !empty($sampai)) {
    $where .= " AND penjualan.tanggal_penjualan BETWEEN '$mulai' AND '$sampai'";
}

// =========================
//   HITUNG TOTAL DATA
// =========================
$query_count = "
    SELECT COUNT(*) AS total
    FROM penjualan
    LEFT JOIN barang ON penjualan.id_barang = barang.id_barang
    $where
";

$result_count = mysqli_query($koneksi, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_data = $row_count['total'];
$total_page = ceil($total_data / $limit);

// =========================
//   AMBIL DATA PAGINATION
// =========================
$query = "
    SELECT penjualan.id_penjualan, barang.nama_barang,
           penjualan.jumlah, penjualan.total_harga,
           penjualan.tanggal_penjualan
    FROM penjualan
    LEFT JOIN barang ON penjualan.id_barang = barang.id_barang
    $where
    ORDER BY id_penjualan DESC
    LIMIT $start, $limit
";

$result = mysqli_query($koneksi, $query);

// Simpan hasil
$penjualan = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $penjualan[] = $row;
    }
}
?>

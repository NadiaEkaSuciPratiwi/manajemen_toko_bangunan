<?php
session_start();
include '../koneksi.php';

//Cek login
if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

// Ambil foto profil
$id_user = $_SESSION['user_id'];
$ambilFoto = mysqli_query($koneksi, "SELECT foto FROM karyawan WHERE id = '$id_user'");
$dataUser = mysqli_fetch_assoc($ambilFoto);
$foto = (!empty($dataUser['foto'])) ? "../karyawan/profil/" . $dataUser['foto'] : "";

// Format tanggal
function formatTanggal($tanggal){
    return date('d-m-Y', strtotime($tanggal));
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search
$search = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : "";

// Filter tanggal
$mulai  = isset($_GET['mulai']) ? $_GET['mulai'] : "";
$sampai = isset($_GET['sampai']) ? $_GET['sampai'] : "";

// WHERE Condition
$where = "1";

if (!empty($search)) {
    $where .= " AND (barang.nama_barang LIKE '%$search%' 
                OR supplier.nama_supplier LIKE '%$search%')";
}

if (!empty($mulai) && !empty($sampai)) {
    $where .= " AND pembelian.tanggal_pembelian BETWEEN '$mulai' AND '$sampai'";
}

// Count total
$query_count = "
    SELECT COUNT(*) AS total
    FROM pembelian
    LEFT JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
    LEFT JOIN barang ON pembelian.id_barang = barang.id_barang
    WHERE $where
";
$result_count = mysqli_query($koneksi, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_data = $row_count['total'];
$total_page = ceil($total_data / $limit);

// Query data
$query = "
    SELECT pembelian.*, supplier.nama_supplier, barang.nama_barang
    FROM pembelian
    LEFT JOIN supplier ON pembelian.id_supplier = supplier.id_supplier
    LEFT JOIN barang ON pembelian.id_barang = barang.id_barang
    WHERE $where
    ORDER BY pembelian.id_pembelian DESC
    LIMIT $start, $limit
";
$result = mysqli_query($koneksi, $query);

// Data array
$pembelian = [];
if($result){
    while($row = mysqli_fetch_assoc($result)){
        $pembelian[] = $row;
    }
}
?>

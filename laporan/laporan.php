<?php
session_start();
include '../koneksi.php';

// Cek login + role admin
if (!isset($_SESSION['user_id']) || $_SESSION['peran'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location='../dashboard/dashboard.php';</script>";
    exit;
}

$hasil = [];
$totalHarga = 0;

// Jika tombol filter ditekan
if (isset($_GET['filter'])) {
    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];

    $sql = "SELECT penjualan.*, barang.nama_barang
            FROM penjualan
            LEFT JOIN barang ON penjualan.id_barang = barang.id_barang
            WHERE penjualan.tanggal_penjualan BETWEEN '$dari' AND '$sampai'
            ORDER BY penjualan.tanggal_penjualan ASC";
    
    $query = mysqli_query($koneksi, $sql);

    while($row = mysqli_fetch_assoc($query)){
        $hasil[] = $row;
        $totalHarga += $row['total_harga'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="../css/barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include '../include/sidebar.php'; ?>
    <div class="navbar">
        <div class="navbar_left">
            <h3>Laporan</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="../beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>

<div class="content">
    <h2>Laporan Penjualan</h2>

    <form method="GET" class="filter-box">
        <label>Dari Tanggal:</label>
        <input type="date" name="dari" required>

        <label>Sampai:</label>
        <input type="date" name="sampai" required>

        <button type="submit" name="filter">Tampilkan</button>
    </form>

    <?php if(count($hasil) > 0) { ?>
        <a href="export_excel.php">Unduh Laporan</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($hasil as $row) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tanggal_penjualan'])) ?></td>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td>Rp <?= number_format($row['total_harga'],0,',','.') ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="total-box">
            <strong>Total Penjualan: </strong>
            Rp <?= number_format($totalHarga,0,',','.') ?>
        </div>

    <?php } ?>
</div>

<?php include '../include/footer.php'; ?>
</body>
</html>

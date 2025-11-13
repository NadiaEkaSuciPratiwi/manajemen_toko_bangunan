<?php
session_start();
include '../koneksi.php';

// Ambil foto profil dari tabel karyawan
    $id_user = $_SESSION['user_id'];

    $ambilFoto = mysqli_query($koneksi, "
                SELECT foto 
                FROM karyawan
                WHERE id = '$id_user'
    ");

    $dataUser = mysqli_fetch_assoc($ambilFoto);

    // Path foto profil
    $foto = (!empty($dataUser['foto'])) 
        ? "../karyawan/profil/" . $dataUser['foto']  
        : "";
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
            <span>Hello, <?php echo $_SESSION['username']; ?></span>

        <div class="profile-dropdown">
        <img src="<?php echo $foto; ?>" class="profile-photo" onclick="toggleDropdown()">

        <ul id="dropdownMenu" class="dropdown-content">
            <li><a href="../beranda.php" class="dropdown-logout">Logout</a></li>
        </ul>
        </div>

    </div>

    <script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const dd = document.querySelector('.profile-dropdown');
        if (!dd.contains(e.target)) {
            document.getElementById('dropdownMenu').style.display = 'none';
        }
    });
    </script>
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
        <a href="export_excel.php" class="unduh">Unduh Laporan</a>

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

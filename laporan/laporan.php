<?php
session_start();
include '../koneksi.php';

// Ambil foto profil
$id_user = $_SESSION['user_id'];
$ambilFoto = mysqli_query($koneksi, "
    SELECT foto FROM karyawan WHERE id = '$id_user'
");
$dataUser = mysqli_fetch_assoc($ambilFoto);
$foto = (!empty($dataUser['foto'])) 
        ? "../karyawan/profil/" . $dataUser['foto']  
        : "";

// Pagination setup
$limit = 10; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$hasil = [];
$totalHarga = 0;

// HITUNG TOTAL DATA UNTUK PAGINATION

// Jika filter digunakan
if (isset($_GET['filter'])) {
    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];

    // Hitung total data berdasarkan filter
    $sqlCount = "SELECT COUNT(*) AS total 
                 FROM penjualan 
                 WHERE tanggal_penjualan BETWEEN '$dari' AND '$sampai'";
} else {
    // Hitung total semua data
    $sqlCount = "SELECT COUNT(*) AS total FROM penjualan";
}

$countResult = mysqli_fetch_assoc(mysqli_query($koneksi, $sqlCount));
$totalData = $countResult['total'];
$totalPages = ceil($totalData / $limit);

// QUERY DATA PENJUALAN + LIMIT

if (isset($_GET['filter'])) {
    $sql = "SELECT penjualan.*, barang.nama_barang
            FROM penjualan
            LEFT JOIN barang ON penjualan.id_barang = barang.id_barang
            WHERE penjualan.tanggal_penjualan BETWEEN '$dari' AND '$sampai'
            ORDER BY penjualan.tanggal_penjualan ASC
            LIMIT $start, $limit";
} else {
    $sql = "SELECT penjualan.*, barang.nama_barang
            FROM penjualan
            LEFT JOIN barang ON penjualan.id_barang = barang.id_barang
            ORDER BY penjualan.tanggal_penjualan ASC
            LIMIT $start, $limit";
}

$query = mysqli_query($koneksi, $sql);

// Ambil hasil
while($row = mysqli_fetch_assoc($query)){
    $hasil[] = $row;
    $totalHarga += $row['total_harga'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include '../include/sidebar.php'; ?>
    <div class="navbar">
        <div class="navbar_left">
        
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
        <label>Dari:</label>
        <input type="date" name="dari" required>

        <label>Sampai:</label>
        <input type="date" name="sampai" required>

        <button type="submit" name="filter"><i class="fa fa-filter"></i>Filter</button>
        <a href="laporan.php" class="btn-reset"><i class="fa fa-refresh"></i>Reset</a>

    </form>

    <?php if(count($hasil) > 0) { ?>
        <a href="export_excel.php" class="unduh"><i class="fa fa-download" aria-hidden="true"></i>Unduh Laporan</a>

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

    <!-- Pagination -->
<nav aria-label="Page navigation" style="margin-top: 20px;">
<ul class="pagination-custom">

    <?php
    // Jika sedang menggunakan filter tanggal
    if (isset($_GET['filter'])) {
        $extraLink = "&filter=ok&dari=".$_GET['dari']."&sampai=".$_GET['sampai'];
    } else {
        $extraLink = "";
    }
    ?>

    <!-- Tombol Previous -->
    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
        <a class="page-link"
           href="?page=<?= $page - 1 . $extraLink ?>">
            Previous
        </a>
    </li>

    <!-- Nomor Halaman -->
    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
            <a class="page-link"
               href="?page=<?= $i . $extraLink ?>">
                <?= $i ?>
            </a>
        </li>
    <?php } ?>

    <!-- Tombol Next -->
    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
        <a class="page-link"
           href="?page=<?= $page + 1 . $extraLink ?>">
            Next
        </a>
    </li>

</ul>
</nav>


</div>

<?php include '../include/footer.php'; ?>
</body>
</html>

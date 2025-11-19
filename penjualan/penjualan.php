<?php
    include 'proses_penjualan.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>

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
    <h2>Data Penjualan</h2>
    <a href="create_penjualan.php" class="tambah-btn">+ Tambah Penjualan</a>

    <div class="filter-search-container">

    <!-- FILTER TANGGAL -->
    <form method="GET" class="filter-box">
        <label>Dari:</label>
        <input type="date" name="mulai" value="<?= $_GET['mulai'] ?? '' ?>">

        <label>Sampai:</label>
        <input type="date" name="sampai" value="<?= $_GET['sampai'] ?? '' ?>">

        <button type="submit" name="filter"><i class="fa fa-filter"></i>Filter</button>
        <a href="penjualan.php" class="btn-reset"><i class="fa fa-refresh"></i>Reset</a>
    </form>

    <!-- SEARCH -->
    <form method="GET" class="search">
        <input type="text" name="cari" placeholder="Cari penjualan"
               value="<?= $_GET['cari'] ?? '' ?>">
        <button type="submit" class="search-btn"><i class="fa fa-search"></i> Search</button>
    </form>

    </div>

    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal Penjualan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($penjualan as $row) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>               
                <td><?= formatTanggal($row['tanggal_penjualan']) ?></td>               
                <td class="aksi-btn">
                        <a href="edit_penjualan.php?id=<?= $row['id_penjualan'] ?>" class="edit">Edit</a>
                        <a href="hapus_penjualan.php?id=<?= $row['id_penjualan'] ?>" class="hapus" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                </td>               
            </tr>
            <?php } ?>
        </tbody>
    </table>

   <!-- ✅ Pagination Bootstrap -->
    <nav aria-label="Page navigation" style="margin-top: 20px;">
    <ul class="pagination-custom">

    <!-- Tombol Previous -->
    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
        <a class="page-link" 
            href="?page=<?= $page-1 ?>&cari=<?= $_GET['cari'] ?? '' ?>">
            Previous
        </a>
    </li>

    <!-- Nomor Halaman -->
    <?php for($i = 1; $i <= $total_page; $i++) { ?>
        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
            <a class="page-link"
            href="?page=<?= $i ?>&cari=<?= $_GET['cari'] ?? '' ?>">
                <?= $i ?>
            </a>
        </li>
    <?php } ?>

    <!-- Tombol Next -->
    <li class="page-item <?= ($page >= $total_page) ? 'disabled' : '' ?>">
        <a class="page-link"
            href="?page=<?= $page+1 ?>&cari=<?= $_GET['cari'] ?? '' ?>">
            Next
        </a>
    </li>

</ul>
</nav>

</div>

<?php include '../include/footer.php'; ?>

</body>
</html>
<?php
    include 'proses_pembelian.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian</title>

    <link rel="stylesheet" href="../css/barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Pembelian</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="../beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="content">
    <h2>Data Pembelian</h2>

    <a href="create_pembelian.php" class="tambah-btn">+ Tambah Pembelian</a>

    <form action="" method="GET" class="search-box">
        <input type="text" name="cari" placeholder="Cari pembelian"
                value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
    <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Beli</th>
                <th>Total Harga</th>
                <th>Tanggal Pembelian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($pembelian as $row) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_supplier'] ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jumlah'] ?></td>                     
                <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td><?= formatTanggal($row['tanggal_pembelian']) ?></td>
                <td class="aksi-btn">
                        <a href="edit_pembelian.php?id=<?= $row['id_pembelian'] ?>" class="edit">Edit</a>
                        <a href="hapus_pembelian.php?id=<?= $row['id_pembelian'] ?>" class="hapus" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
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
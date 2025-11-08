<?php
    include 'proses_barang.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>

    <link rel="stylesheet" href="../css/barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Barang</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="../beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>

<div class="content">
    <h2>Data Barang</h2>

    <a href="create_barang.php" class="tambah-btn">+ Tambah Barang</a><br>

    <form method="GET" action="" class="search-box">
    <input type="text" name="cari" placeholder="Cari nama barang" 
           value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">

    <select name="kategori">
        <option value="">Semua Kategori</option>
        <?php 
        $kat = mysqli_query($koneksi, "SELECT * FROM kategori1");
        while($k = mysqli_fetch_assoc($kat)) { 
            $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kategori']) ? "selected" : "";
        ?>
            <option value="<?= $k['id_kategori'] ?>" <?= $selected ?>>
                <?= $k['nama_kategori'] ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Filter</button>
    </form>


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Foto</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($barang_list as $row) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?php if ($row['foto']) { ?>
                    <img src="produk/<?=$row['foto']?>" alt="" width="60">
                    <?php } else { ?>
                        <span>-</span>
                    <?php } ?>
                </td>
                <td><?= $row['nama_kategori'] ?></td>
                <td><?= $row['satuan'] ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>               
                <td><?= $row['stok'] ?></td>               
                <td class="aksi-btn">
                        <a href="edit_barang.php?id=<?= $row['id_barang']; ?>" class="edit">Edit</a>
                        <a href="hapus_barang.php?id=<?= $row['id_barang']; ?>" class="hapus" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
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
            href="?page=<?= $page-1 ?>&cari=<?= $_GET['cari'] ?? '' ?>&kategori=<?= $_GET['kategori'] ?? '' ?>">
            Previous
        </a>
    </li>

    <!-- Nomor Halaman -->
    <?php for($i = 1; $i <= $total_page; $i++) { ?>
        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
            <a class="page-link"
            href="?page=<?= $i ?>&cari=<?= $_GET['cari'] ?? '' ?>&kategori=<?= $_GET['kategori'] ?? '' ?>">
                <?= $i ?>
            </a>
        </li>
    <?php } ?>

    <!-- Tombol Next -->
    <li class="page-item <?= ($page >= $total_page) ? 'disabled' : '' ?>">
        <a class="page-link"
            href="?page=<?= $page+1 ?>&cari=<?= $_GET['cari'] ?? '' ?>&kategori=<?= $_GET['kategori'] ?? '' ?>">
            Next
        </a>
    </li>

</ul>
</nav>
</div>

<?php include '../include/footer.php'; ?>
</body>
</html>
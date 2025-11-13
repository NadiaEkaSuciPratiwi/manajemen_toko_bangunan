<?php
include '../koneksi.php';
session_start();

// Pagination
$limit = 4; // jumlah produk per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Filter pencarian & kategori
$search   = isset($_GET['cari']) ? $_GET['cari'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$where = "WHERE 1=1";
if ($search != "") {
    $where .= " AND (barang.nama_barang LIKE '%$search%' OR kategori1.nama_kategori LIKE '%$search%')";
}
if ($kategori != "") {
    $where .= " AND barang.id_kategori = '$kategori'";
}

// Hitung total data
$countQuery = "SELECT COUNT(*) AS total FROM barang 
               LEFT JOIN kategori1 ON barang.id_kategori = kategori1.id_kategori
               $where";
$countResult = mysqli_query($koneksi, $countQuery);
$total_data = mysqli_fetch_assoc($countResult)['total'];
$total_page = ceil($total_data / $limit);

// Ambil data produk
$query = "SELECT barang.*, kategori1.nama_kategori 
          FROM barang 
          LEFT JOIN kategori1 ON barang.id_kategori = kategori1.id_kategori
          $where
          ORDER BY id_barang DESC 
          LIMIT $offset, $limit";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Semua Produk - Sinar Abadi</title>
    <link rel="stylesheet" href="../css/beranda.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<nav class="navbar-home">
    <div class="logo-area">
        <img src="../foto/logo.jpg" alt="" class="logo">
        <h1>Sinar Abadi</h1>
    </div>

    <ul>
        <li><a href="../beranda.php">Beranda</a></li>
        <li><a href="../beranda.php#about">Tentang Kami</a></li>
        <li><a href="../beranda.php#layanan">Layanan</a></li>
        <li><a href="../beranda.php#produk">Produk</a></li>
        <li><a href="../login/login.php" class="login-btn">Login</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Semua Produk</h2>

    <div class="filter-barang">
        <form method="GET" action="">
            <input type="text" name="cari" placeholder="Cari nama barang" value="<?= htmlspecialchars($search) ?>">
            <select name="kategori">
                <option value="">Semua Kategori</option>
                <?php 
                $kat = mysqli_query($koneksi, "SELECT * FROM kategori1");
                while($k = mysqli_fetch_assoc($kat)) { 
                    $selected = ($kategori == $k['id_kategori']) ? "selected" : "";
                ?>
                    <option value="<?= $k['id_kategori'] ?>" <?= $selected ?>>
                        <?= htmlspecialchars($k['nama_kategori']) ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>
    

    <div class="produk-container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($barang = mysqli_fetch_assoc($result)): ?>
                <div class="produk-card">
                    <?php if (!empty($barang['foto']) && file_exists("../barang/produk/" . $barang['foto'])): ?>
                        <img src="../barang/produk/<?= htmlspecialchars($barang['foto']); ?>" alt="<?= htmlspecialchars($barang['nama_barang']); ?>">
                    <?php else: ?>
                        <img src="../barang/produk/default.png" alt="Default">
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($barang['nama_barang']); ?></h3>
                    <p>Rp <?= number_format($barang['harga'], 0, ',', '.'); ?></p>
                    <p><small><?= htmlspecialchars($barang['nama_kategori'] ?? '-') ?></small></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">Tidak ada barang ditemukan.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <ul class="pagination-custom">
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page-1 ?>&cari=<?= $search ?>&kategori=<?= $kategori ?>">Previous</a>
        </li>

        <?php for($i = 1; $i <= $total_page; $i++): ?>
            <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&cari=<?= $search ?>&kategori=<?= $kategori ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <li class="page-item <?= ($page >= $total_page) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page+1 ?>&cari=<?= $search ?>&kategori=<?= $kategori ?>">Next</a>
        </li>
    </ul>
</div>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h4>Navigasi</h4>
            <ul>
                <li><a href="#hero">Beranda</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#layanan">Layanan</a></li>
                <li><a href="#produk">Produk</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Toko Bangunan <span>Sinar Abadi</span></h3>
            <p>Kelola data toko dengan lebih mudah.</p>
            <p><i class="fa-solid fa-location-dot"></i> Purwosari, Jawa Timur</p>
            <p><i class="fa-solid fa-phone"></i> +62 821-3607-4253</p>
        </div>

        <div class="footer-section">
            <h4>Media Sosial</h4>
            <ul class="social-links">
                <li><a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
                <li><a href="#"><i class="fa-brands fa-tiktok"></i> TikTok</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Gheanadia <span>Sinar Abadi</span></p>
    </div>
</footer>

</body>
</html>

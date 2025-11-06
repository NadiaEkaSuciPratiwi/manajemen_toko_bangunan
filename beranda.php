<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>

    <link rel="stylesheet" href="css/beranda.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    
<nav class="navbar-home">
    <div class="logo-area">
        <img src="foto/logo.jpg" alt="" class="logo">
        <h1>Sinar Abadi</h1>
    </div>

    <ul>
        <li><a href="#hero">Beranda</a></li>
        <li><a href="#about">Tentang Kami</a></li>
        <li><a href="#layanan">Layanan</a></li>
        <li><a href="#produk">Produk</a></li>
        <li><a href="login/login.php" class="login-btn">Login</a></li>
    </ul>
</nav>

<section id="hero" class="hero">
    <div class="hero-content">
        <h2>Selamat Datang di Sistem Manajemen Toko Bangunan <span>Sinar Abadi</span></h2>
        <p>Mudahkan pengelolaan tugas dan data toko</p>
        <a href="login/login.php" class="button">Login Sekarang</a>
    </div>
    <div class="hero-img">
        <img src="foto/logo.jpg" alt="">
    </div>
</section>

<section id="about" class="about">
    <div class="about-title">
    <h2>Tentang Kami</h2>
    <div class="about-container">
        <div class="about-text">
            <p>
                Website Sistem Manajemen Toko Bangunan <strong>Sinar Abadi</strong> dirancang 
                untuk membantu proses pengelolaan data internal secara lebih efisien dan 
                terstruktur. Dengan sistem ini, karyawan dapat melakukan pengelolaan terkait:
            </p>
            <ul>
                <li>Data karyawan dan akses pengguna</li>
                <li>Data penjualan dan laporan harian</li>
                <li>Manajemen stok dan informasi barang</li>
                <li>Pencatatan pembelian dari supplier</li>
            </ul>
            <p>
                Sistem ini hanya dapat diakses oleh internal toko untuk menjaga 
                keamanan informasi dan mendukung peningkatan kinerja operasional 
                secara keseluruhan. Dengan tampilan yang user-friendly, Sinar Abadi 
                siap melangkah lebih maju dalam digitalisasi layanan toko bangunan.
            </p>
        </div>
        
        <div class="about-img">
            <img src="foto/logo.jpg">
        </div>
    </div>
</div>
</section>


<section id="layanan" class="layanan">
    <h2>Layanan Kami</h2>
    <div class="cards">
        <div class="card">
            <i class="fa-solid fa-users"></i>
            <h3>Manajemen Karyawan</h3>
            <p>Tambah, edit, dan pantau data karyawan dengan mudah</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-chart-line"></i>
            <h3>Data Penjualan</h3>
            <p>Input dan pantau penjualan harian</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-box"></i>
            <h3>Stok Barang</h3>
            <p>Cek stok barang yang tersedia ditoko kami</p>
        </div>
        <div class="card">
            <i class="fa-solid fa-truck"></i>
            <h3>Data Pembelian dan Supplier</h3>
            <p>Input dan pantau data pemebelian barang dari supplier</p>
        </div>
    </div>
</section>

<section class="produk-terbaru" id="produk">
    <h2>Produk Terbaru</h2>

    <div class="produk-container">
        <?php
        include 'koneksi.php';
        $query = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id_barang DESC LIMIT 5");

        while($data = mysqli_fetch_assoc($query)) {
        ?>
            <div class="produk-card">
                <img src="barang/produk/<?php echo $data['foto']; ?>" alt="<?php echo $data['nama_barang']; ?>">
                <h3><?php echo $data['nama_barang']; ?></h3>
                <p>Rp <?php echo number_format($data['harga'],0,',','.'); ?></p>
            </div>
        <?php } ?>
    </div>
</section>


<script>
    const navLinks = document.querySelectorAll(".navbar-home ul li a");

    // Saat menu di klik → kasih class active
    navLinks.forEach(link => {
        link.addEventListener("click", () => {
            navLinks.forEach(link => link.classList.remove("active"));
            link.classList.add("active");
        });
    });
</script>

<script>
    const sections = document.querySelectorAll("section");

    window.addEventListener("scroll", () => {
        let current = "";

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;

            if (pageYOffset >= sectionTop - sectionHeight / 3) {
                current = section.getAttribute("id");
            }
        });

        navLinks.forEach(link => {
            link.classList.remove("active");
            if (link.getAttribute("href").includes(current)) {
                link.classList.add("active");
            }
        });
    });
</script>

<footer class="footer">
    &copy; <?php echo date('Y') ?> Ghenadi <span>Sinar Abadi</span>
</footer>

</body>
</html>
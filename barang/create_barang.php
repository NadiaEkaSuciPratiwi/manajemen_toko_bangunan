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

// Ambil semua kategori
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori1");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>

    <link rel="stylesheet" href="../css/crud_barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Barang</h3>
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

    <div class="main-content">
    <div class="form-container">
    <h2>Tambah Barang</h2>
    
    <form action="proses_tambah_barang.php" method="POST" enctype="multipart/form-data" novalidate>
        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" >
        <?php if(isset($_GET['error']) && $_GET['error'] == "nama_barang"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
            <?php endif; ?>

        <label>Foto:</label>
        <input type="file" name="foto" accept="image/*" >

        <label>Kategori:</label>
        <select name="id_kategori" >
        <option value="">-- Pilih Kategori --</option>
        <?php while ($row = mysqli_fetch_assoc($queryKategori)) : ?>
            <option value="<?= $row['id_kategori']; ?>">
                <?= $row['nama_kategori']; ?>
            </option>
        <?php endwhile; ?>
        </select>
        <?php if(isset($_GET['error']) && $_GET['error'] == "id_kategori"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
            <?php endif; ?>

        <label>Satuan:</label>
        <input type="text" name="satuan" >
        <?php if(isset($_GET['error']) && $_GET['error'] == "satuan"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
            <?php endif; ?>

        <label>Harga:</label>
        <input type="number" name="harga">
        <?php if(isset($_GET['error']) && $_GET['error'] == "harga"): ?>
            <div class="text-danger small">Harga jual harus lebih dari 0!</div>
            <?php endif; ?>

        <label>Stok:</label>
        <input type="number" name="stok">
        <?php if(isset($_GET['error']) && $_GET['error'] == "stok"): ?>
            <div class="text-danger small">Stok harus lebih dari 0!</div>
            <?php endif; ?>

        <button type="submit" class="btn-update">Simpan</button>
        <a href="barang.php" class="btn-back">Batal</a>
    </form>
    </div>
    </div>


</body>
</html>
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
        
// ambil id dari query string
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: barang.php");
    exit;
}
$id = intval($_GET['id']);

// ambil data barang saat ini
$sql = "SELECT * FROM barang WHERE id_barang = $id";
$res = mysqli_query($koneksi, $sql);
if(mysqli_num_rows($res) == 0){
    header("Location: barang.php");
    exit;
}
$item = mysqli_fetch_assoc($res);

// ambil daftar kategori
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori1 ORDER BY nama_kategori ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Barang</title>
    
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
    <h2>Edit Barang</h2>

    <form action="proses_edit_barang.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_barang" value="<?= htmlspecialchars($item['id_barang']) ?>">
        <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($item['foto']) ?>">

        <label>Nama Barang</label>
        <input type="text" name="nama_barang" required value="<?= htmlspecialchars($item['nama_barang']) ?>">

        <label>Kategori</label>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php while($row = mysqli_fetch_assoc($queryKategori)) { ?>
                <option value="<?= $row['id_kategori'] ?>" <?= ($row['id_kategori'] == $item['id_kategori']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['nama_kategori']) ?>
                </option>
            <?php } ?>
        </select>

        <label>Satuan</label>
        <input type="text" name="satuan" required value="<?= htmlspecialchars($item['satuan']) ?>">

        <label>Harga</label>
        <input type="number" step="0.01" name="harga" required value="<?= htmlspecialchars($item['harga']) ?>">

        <label>Stok</label>
        <input type="number" step="0.01" name="stok" required value="<?= htmlspecialchars($item['stok']) ?>">
        

        <div class="foto-container">
        <div class="foto-saat-ini">
        <label>Foto saat ini:</label>
        <?php if($item['foto'] && file_exists('produk/'.$item['foto'])): ?>
            <img src="produk/<?= htmlspecialchars($item['foto']) ?>" alt="foto barang" class="preview-foto">
        <?php else: ?>
            <div>Tidak ada foto</div>
        <?php endif; ?>
        </div>

        <div class="ganti-foto">
        <label>Ganti Foto (opsional):</label>
        <input type="file" name="foto" class="file-input">
        </div>
        </div>

        <button type="submit" class="btn-update">Simpan</button>
        <a href="barang.php" class="btn-back">Batal</a>
    </form>
    </div>
    </div>


</body>
</html>
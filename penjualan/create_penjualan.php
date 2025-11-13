<?php
session_start();
include '../koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../login/login.php");
    exit;
}

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

// Ambil data barang untuk dropdown
$queryBarang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");

if(isset($_POST['submit'])){
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal_penjualan'];

    $error = "";

    if ($id_barang == "") {
        $error = "id_barang";
    } elseif ($jumlah <= 0) {
        $error = "jumlah";
    } elseif ($harga_satuan <= 0) {
        $error = "harga";
    } elseif ($tanggal == "") {
        $error = "tanggal_penjualan";
    }

if($error != ""){
    header("Location: create_penjualan.php?error=$error");
    exit;
}

    // Ambil harga satuan dari tabel barang
    $barang = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id_barang='$id_barang'");
    $b = mysqli_fetch_assoc($barang);
    $harga_satuan = $b['harga'];

    $total_harga = $harga_satuan * $jumlah;

    // Masukkan ke tabel penjualan
    $insert = mysqli_query($koneksi, "INSERT INTO penjualan (id_barang, jumlah, total_harga, tanggal_penjualan) VALUES ('$id_barang', '$jumlah', '$total_harga', '$tanggal')");

    if($insert){
    echo "<script>alert('Data penjualan berhasil ditambahkan');window.location='penjualan.php';</script>";
    } else {
    echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Penjualan</title>
    <link rel="stylesheet" href="../css/crud_penjualan.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<div>
    <?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Penjualan</h3>
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
    <h2>Tambah Penjualan</h2>
    <form method="POST" action="">
        <label>Nama Barang:</label>
        <select name="id_barang" id="barang">
            <option value="">-- Pilih Barang --</option>
            <?php while($row = mysqli_fetch_assoc($queryBarang)): ?>
                <option value="<?= $row['id_barang']; ?>" data-harga="<?= $row['harga']; ?>"><?= $row['nama_barang']; ?></option>
            <?php endwhile; ?>
        </select>
        <?php if(isset($_GET['error']) && $_GET['error'] == "id_barang"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
            <?php endif; ?><br><br>

        <label>Harga Satuan:</label>
        <input type="text" id="harga_satuan" readonly>
        <?php if(isset($_GET['error']) && $_GET['error'] == "harga_satuan"): ?>
            <div class="text-danger small">Harga harus lebih dari 0!</div>
            <?php endif; ?>
        <br><br>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" id="jumlah" min="1">
        <?php if(isset($_GET['error']) && $_GET['error'] == "jumlah"): ?>
            <div class="text-danger small">Jumlah harus lebih dari 0!</div>
            <?php endif; ?>
        <br><br>

        <label>Total Harga:</label>
        <input type="text" id="total_harga" readonly>
        <?php if(isset($_GET['error']) && $_GET['error'] == "total_harga"): ?>
            <div class="text-danger small">Total harga harus lebih dari 0!</div>
            <?php endif; ?>
        <br><br>

        <label>Tanggal Penjualan:</label>
        <input type="date" name="tanggal_penjualan">
        <?php if(isset($_GET['error']) && $_GET['error'] == "tanggal_penjualan"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
            <?php endif; ?>
        <br><br>

        <button type="submit" name="submit" class="btn-update">Simpan</button>
        <a href="penjualan.php" class="btn-back">Batal</a>
    </form>

    <script>
        const barangSelect = document.getElementById('barang');
        const hargaInput = document.getElementById('harga_satuan');
        const jumlahInput = document.getElementById('jumlah');
        const totalInput = document.getElementById('total_harga');

        barangSelect.addEventListener('change', function(){
            const harga = this.options[this.selectedIndex].dataset.harga || 0;
            hargaInput.value = harga;
            totalInput.value = harga * (jumlahInput.value || 0);
        });

        jumlahInput.addEventListener('input', function(){
            const harga = hargaInput.value || 0;
            totalInput.value = harga * this.value;
        });
    </script>
    </div>
    </div>
    <?php include '../include/footer.php'; ?>
    
</body>
</html>

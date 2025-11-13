<?php
session_start();
include '../koneksi.php';

// Cek login (optional)
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pembelian</title>

    <link rel="stylesheet" href="../css/crud_pembelian.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
  <?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Pembelian</h3>
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

    <h2>Tambah Pembelian</h2>

    <?php
    // Pesan jika gagal
    if(isset($_GET['pesan']) && $_GET['pesan'] == "gagal") {
        echo "<p style='color:red;'>Gagal menambahkan pembelian!</p>";
    }
    ?>

    <form action="proses_tambah_pembelian.php" method="POST">

        <label>Supplier</label>
        <select name="id_supplier">
        <?php
        include '../koneksi.php';
        $data = mysqli_query($koneksi, "SELECT * FROM supplier");
        while ($d = mysqli_fetch_array($data)) {
            echo "<option value='".$d['id_supplier']."'>".$d['nama_supplier']."</option>";
        }
        ?>
        </select>
        <?php if(isset($_GET['error']) && $_GET['error'] == "id_supplier"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>

        <label>Barang</label>
        <select name="id_barang">
        <?php
        include '../koneksi.php';
        $data = mysqli_query($koneksi, "SELECT * FROM barang");
        while ($d = mysqli_fetch_array($data)) {
            echo "<option value='".$d['id_barang']."'>".$d['nama_barang']."</option>";
        }
        ?>
        </select>
        <?php if(isset($_GET['error']) && $_GET['error'] == "id_barang"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>


        <label>Jumlah</label>
        <input type="number" name="jumlah">
        <?php if(isset($_GET['error']) && $_GET['error'] == "jumlah"): ?>
            <div class="text-danger small">Semua field wajib di isi dengan benar!</div>
        <?php endif; ?>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli">
        <?php if(isset($_GET['error']) && $_GET['error'] == "harga_beli"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>

        <label>Total Harga</label>
        <input type="number" name="total_harga" readonly>
        <?php if(isset($_GET['error']) && $_GET['error'] == "total_harga"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>

        <label>Tanggal Pembelian</label>
        <input type="date" name="tanggal_pembelian">
        <?php if(isset($_GET['error']) && $_GET['error'] == "tanggal_pembelian"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>

        <button type="submit" class="btn-update">Simpan</button>
        <a href="pembelian.php" class="btn-back">Batal</a>
    </form>

        <script>
        const jumlahInput = document.querySelector('input[name="jumlah"]');
        const hargaInput = document.querySelector('input[name="harga_beli"]');
        const totalInput = document.querySelector('input[name="total_harga"]');

        function hitungTotal() {
            const jumlah = parseFloat(jumlahInput.value) || 0;
            const harga = parseFloat(hargaInput.value) || 0;
            const total = jumlah * harga;
            totalInput.value = total;
        }

        jumlahInput.addEventListener("input", hitungTotal);
        hargaInput.addEventListener("input", hitungTotal);
        </script>

    </div>
</div>

    <?php include '../include/footer.php'; ?>

</body>
</html>
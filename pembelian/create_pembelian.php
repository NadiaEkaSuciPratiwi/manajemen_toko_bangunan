<?php
session_start();
include '../koneksi.php';

// Cek login (optional)
if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit;
}
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
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="../beranda.php" class="logout-btn">Logout</a>
        </div>
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
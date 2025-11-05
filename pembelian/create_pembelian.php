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
    <select name="id_supplier" required>
    <?php
    include '../koneksi.php';
    $data = mysqli_query($koneksi, "SELECT * FROM supplier");
    while ($d = mysqli_fetch_array($data)) {
        echo "<option value='".$d['id_supplier']."'>".$d['nama_supplier']."</option>";
    }
    ?>
    </select>

    <label>Barang</label>
    <select name="id_barang" required>
    <?php
    include '../koneksi.php';
    $data = mysqli_query($koneksi, "SELECT * FROM barang");
    while ($d = mysqli_fetch_array($data)) {
        echo "<option value='".$d['id_barang']."'>".$d['nama_barang']."</option>";
    }
    ?>
    </select>


    <label>Jumlah</label>
    <input type="number" name="jumlah" required>

    <label>Harga Beli</label>
    <input type="number" name="harga_beli" required>

    <label>Total Harga</label>
    <input type="number" name="total_harga" readonly>

    <label>Tanggal Pembelian</label>
    <input type="date" name="tanggal_pembelian" required>

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
</body>
</html>
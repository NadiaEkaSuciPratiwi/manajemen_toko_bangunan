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

    <link rel="stylesheet" href="../css/crud.css">
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

    <label>Supplier</label><br>
    <select name="id_supplier" required>
    <?php
    include '../koneksi.php';
    $data = mysqli_query($koneksi, "SELECT * FROM supplier");
    while ($d = mysqli_fetch_array($data)) {
        echo "<option value='".$d['id_supplier']."'>".$d['nama_supplier']."</option>";
    }
    ?>
    </select><br>

    <label>Barang</label><br>
    <select name="id_barang" required>
    <?php
    include '../koneksi.php';
    $data = mysqli_query($koneksi, "SELECT * FROM barang");
    while ($d = mysqli_fetch_array($data)) {
        echo "<option value='".$d['id_barang']."'>".$d['nama_barang']."</option>";
    }
    ?>
    </select><br><br>


    <label>Jumlah</label><br>
    <input type="number" name="jumlah" required><br><br>

    <label>Harga Beli</label><br>
    <input type="number" name="harga_beli" required><br><br>

    <label>Total Harga</label><br>
    <input type="number" name="total_harga" required><br><br>

    <label>Tanggal Pembelian</label><br>
    <input type="date" name="tanggal_pembelian" required><br><br>

    <button type="submit" class="btn-update">Simpan</button>
    <button class="btn-back"><a href="pembelian.php"></a>Batal</button>
</form>
</div>
</body>
</html>
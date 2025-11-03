<?php
session_start();
include 'koneksi.php';

// Cek login (optional)
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pembelian</title>
</head>
<body>

<h2>Tambah Pembelian</h2>

<?php
// Pesan jika gagal
if(isset($_GET['pesan']) && $_GET['pesan'] == "gagal") {
    echo "<p style='color:red;'>Gagal menambahkan pembelian!</p>";
}
?>

<form action="proses_tambah_pembelian.php" method="POST">

    <label>Nama Supplier</label><br>
    <input type="text" name="supplier" required><br><br>

    <label>Jumlah</label><br>
    <input type="number" name="jumlah" required><br><br>

    <label>Harga Beli</label><br>
    <input type="number" name="harga_beli" required><br><br>

    <label>Total Harga</label><br>
    <input type="number" name="total_harga" required><br><br>

    <label>Tanggal Pembelian</label><br>
    <input type="date" name="tgl" required><br><br>

    <button type="submit">Simpan</button>

</form>

</body>
</html>
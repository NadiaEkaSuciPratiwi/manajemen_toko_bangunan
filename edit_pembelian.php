<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Data pembelian
$pembelian = mysqli_query($conn, "SELECT * FROM pembelian WHERE id_pembelian='$id'");
$data = mysqli_fetch_assoc($pembelian);

// Data barang untuk dropdown
$barang = mysqli_query($conn, "SELECT id_barang, nama_barang FROM barang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pembelian</title>
</head>
<body>

<h2>Edit Pembelian</h2>

<form action="proses_edit_pembelian.php" method="POST">

    <input type="hidden" name="id_pembelian" value="<?= $data['id_pembelian']; ?>">
    <input type="hidden" name="jumlah_lama" value="<?= $data['jumlah']; ?>">

    <label>Nama Barang</label><br>
    <select name="id_barang" required>
        <?php while($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id_barang']; ?>" 
                <?= $b['id_barang'] == $data['id_barang'] ? 'selected' : ''; ?>>
                <?= $b['nama_barang']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Supplier</label><br>
    <input type="text" name="supplier" value="<?= $data['supplier']; ?>" required><br><br>

    <label>Jumlah</label><br>
    <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" required><br><br>

    <label>Harga Beli</label><br>
    <input type="number" name="harga_beli" value="<?= $data['harga_beli']; ?>" required><br><br>

    <label>Total Harga</label><br>
    <input type="number" name="total_harga" value="<?= $data['total_harga']; ?>" required><br><br>

    <label>Tanggal Pembelian</label><br>
    <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" required><br><br>

    <button type="submit">Simpan Perubahan</button>

</form>

</body>
</html>
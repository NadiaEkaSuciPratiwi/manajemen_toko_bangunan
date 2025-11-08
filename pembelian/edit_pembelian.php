<?php
session_start();
include '../koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Cek apakah ada id
if (!isset($_GET['id'])) {
    echo "<script>alert('ID tidak ditemukan!');window.location='pembelian.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data pembelian berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM pembelian WHERE id_pembelian='$id'");
$data = mysqli_fetch_assoc($query);

// Jika tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!');window.location='pembelian.php';</script>";
    exit;
}

// Ambil data barang dan supplier untuk dropdown
$barang = mysqli_query($koneksi, "SELECT * FROM barang");
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pembelian</title>
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
    <h2>Edit Pembelian</h2>
    
    <form method="POST" action="proses_edit_pembelian.php">
        <input type="hidden" name="id_pembelian" value="<?= $data['id_pembelian'] ?>">

        <label>Nama Barang</label>
        <select name="id_barang" required>
            <option value="">- Pilih Barang -</option>
            <?php while($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id_barang'] ?>" 
                <?= ($b['id_barang'] == $data['id_barang']) ? 'selected' : '' ?>>
                <?= $b['nama_barang'] ?>
            </option>
            <?php } ?>
        </select>

        <label>Supplier</label>
        <select name="id_supplier" required>
            <option value="">- Pilih Supplier -</option>
            <?php while($s = mysqli_fetch_assoc($supplier)) { ?>
            <option value="<?= $s['id_supplier'] ?>" 
                <?= ($s['id_supplier'] == $data['id_supplier']) ? 'selected' : '' ?>>
                <?= $s['nama_supplier'] ?>
            </option>
            <?php } ?>
        </select>

        <label>Jumlah</label>
        <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" required>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli" value="<?= $data['harga_beli'] ?>" required>

        <label>Total Harga</label>
        <input type="number" name="total_harga" value="<?= $data['total_harga'] ?>" readonly>

        <label>Tanggal Pembelian</label>
        <input type="date" name="tanggal_pembelian" value="<?= $data['tanggal_pembelian'] ?>" required>

        <button type="submit" name="update" class="btn-update">Update</button>
        <a href="pembelian.php" class="btn-back">Batal</a>
    </form>

</div>
</div>
<?php include '../include/footer.php'; ?>

</body>
</html>

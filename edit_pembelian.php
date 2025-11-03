<?php
include 'koneksi.php'; // pastikan ini sama dengan file koneksi kamu

// Ambil data pembelian berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM pembelian1 WHERE id_pembelian='$id'");
    $data = mysqli_fetch_assoc($query);
}

//ambil data supplier
$supplier = mysqli_query($koneksi, "SELECT * FROM supplier");

// Jika form disubmit
if (isset($_POST['update'])) {
    $id_supplier = $_POST['id_supplier'];
    $jumlah = $_POST['jumlah'];
    $harga_beli = $_POST['harga_beli'];
    $total_harga = $jumlah * $harga_beli;
    $tanggal_pembelian = $_POST['tanggal_pembelian'];

    $update = mysqli_query($koneksi, "UPDATE pembelian1 SET 
                id_supplier='$id_supplier', 
                jumlah='$jumlah', 
                harga_beli='$harga_beli', 
                total_harga='$total_harga', 
                tanggal_pembelian='$tanggal_pembelian'
              WHERE id_pembelian='$id'");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui!');window.location='pembelian.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pembelian</title>
    
</head>
<body>

    <div class="content">
        <h2>Edit Pembelian</h2>
        <form method="POST">
            <label>Nama Supplier</label><br>
            <select name="id_supplier" required>
                <option value="">-- Pilih Supplier --</option>
                <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
                    <option value="<?= $s['id_supplier'] ?>" <?= ($s['id_supplier'] == $data['id_supplier']) ? 'selected' : '' ?>>
                        <?= $s['nama_supplier'] ?>
                    </option>
                <?php } ?>
            </select> <br>

            <label>Jumlah</label><br>
            <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" required><br>

            <label>Harga Beli</label><br>
            <input type="number" name="harga_beli" value="<?= $data['harga_beli'] ?>" required><br>

            <label>Tanggal Pembelian</label><br>
            <input type="date" name="tanggal_pembelian" value="<?= $data['tanggal_pembelian'] ?>" required><br>

            <button type="submit" name="update" class="tambah-btn">Update</button>
            <a href="pembelian.php" class="batal-btn">Batal</a>
        </form>
    </div>

</body>
</html>
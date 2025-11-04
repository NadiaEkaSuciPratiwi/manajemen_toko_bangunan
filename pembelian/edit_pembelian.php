<?php
include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pembelian</title>
    <link rel="stylesheet" href="../css/crud.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>

    <div class="form-container">
        <h2>Edit Pembelian</h2>
        <form method="POST" action="proses_edit_pembelian.php">
            <label>Nama Supplier</label><br>
            <select name="id_supplier" required>
                <option value="">-- Pilih Supplier --</option>
                <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
                    <option value="<?= $s['id_supplier'] ?>" <?= ($s['id_supplier'] == $data['id_supplier']) ? 'selected' : '' ?>>
                        <?= $s['nama_supplier'] ?>
                    </option>
                <?php } ?>
            </select> <br>

            <label>Nama Barang</label><br>
            <select name="id_barang" id="barangSelect" required>
            <?php foreach($queryBarang as $b) { ?>
                <option 
                    value="<?= $b['id_barang'] ?>"
                    data-harga="<?= $b['harga'] ?>"
                    <?= ($b['id_barang'] == $pembelian['id_barang']) ? "selected" : "" ?>>
                    <?= $b['nama_barang'] ?>
                </option>
            <?php } ?>
            </select><br><br>


            <label>Jumlah</label><br>
            <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" required><br>

            <label>Harga Beli</label><br>
            <input type="number" name="harga_beli" value="<?= $data['harga_beli'] ?>" required><br>

            <label>Tanggal Pembelian</label><br>
            <input type="date" name="tanggal_pembelian" value="<?= $data['tanggal_pembelian'] ?>" required><br>

            <button type="submit" name="update" class="tambah-btn">Update</button>
            <button class="btn-back"><a href="pembelian.php"></a>Batal</button>
        </form>
    </div>

</body>
</html>
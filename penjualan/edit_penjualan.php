<?php
session_start();
include '../koneksi.php';

//ambil id penjualan
$id_penjualan = $_GET['id'] ?? null;
if(!$id_penjualan){
    header("Location: penjualan.php");
    exit;
}

//ambil data penjualan lama
$queryPenj = mysqli_query($koneksi, 
    "SELECT * FROM penjualan WHERE id_penjualan=$id_penjualan");
$penjualan = mysqli_fetch_assoc($queryPenj);

//ambil semua barang untuk dropdown
$queryBarang = mysqli_query($koneksi, "SELECT * FROM barang");

//jika data tidak ditemukan
if(!$penjualan){
    echo "Data tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Penjualan</title>

<link rel="stylesheet" href="../css/crud.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="form-container">
    <h2>Edit Penjualan</h2>
        <form action="proses_edit_penjualan.php" method="POST">

        <!-- ID penjualan untuk identifikasi di proses update -->
        <input type="hidden" name="id_penjualan" value="<?= $penjualan['id_penjualan'] ?>">

        <label>Nama Barang</label><br>
        <select name="id_barang" id="barangSelect" required>
            <?php foreach($queryBarang as $b) { ?>
                <option 
                    value="<?= $b['id_barang'] ?>"
                    data-harga="<?= $b['harga'] ?>"
                    <?= ($b['id_barang'] == $penjualan['id_barang']) ? "selected" : "" ?>>
                    <?= $b['nama_barang'] ?>
                </option>
            <?php } ?>
        </select><br><br>

        <label>Jumlah</label><br>
        <input type="number" name="jumlah" id="jumlah" 
            value="<?= $penjualan['jumlah'] ?>" required><br><br>

        <label>Total Harga</label><br>
        <input type="text" name="total_harga" id="total_harga" 
            value="<?= $penjualan['total_harga'] ?>" readonly><br><br>

        <label>Tanggal Penjualan</label><br>
        <input type="date" name="tanggal_penjualan"
            value="<?= $penjualan['tanggal_penjualan'] ?>" required><br><br>

        <button type="submit" class="btn-update">Simpan</button>
        <button class="btn-back"><a href="penjualan.php"></a>Batal</button>

        </form>

<script>
//Auto calc total harga saat barang/jumlah berubah
function hitungTotal() {
    let select = document.getElementById('barangSelect');
    let harga = select.options[select.selectedIndex].getAttribute('data-harga');
    let jumlah = document.getElementById('jumlah').value;

    document.getElementById('total_harga').value = harga * jumlah;
}

document.getElementById('barangSelect').addEventListener('change', hitungTotal);
document.getElementById('jumlah').addEventListener('keyup', hitungTotal);
</script>
</div>
</body>
</html>
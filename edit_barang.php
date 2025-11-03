<?php
session_start();
include 'koneksi.php';

// ambil id dari query string
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: barang.php");
    exit;
}
$id = intval($_GET['id']);

// ambil data barang saat ini
$sql = "SELECT * FROM barang WHERE id_barang = $id";
$res = mysqli_query($koneksi, $sql);
if(mysqli_num_rows($res) == 0){
    header("Location: barang.php");
    exit;
}
$item = mysqli_fetch_assoc($res);

// ambil daftar kategori
$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori1 ORDER BY nama_kategori ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Barang</title>
    <style>
        /* styling sederhana, sesuaikan jika perlu */
        form { max-width:600px; background:#fff; padding:20px; border-radius:8px; }
        label { display:block; margin-top:10px; font-weight:600; }
        input, select { width:100%; padding:8px; margin-top:6px; }
        img { max-width:120px; display:block; margin-top:8px; border-radius:6px; }
        button{ margin-top:12px; padding:10px 14px; }
    </style>
</head>
<body>
    <h2>Edit Barang</h2>

    <form action="proses_edit_barang.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_barang" value="<?= htmlspecialchars($item['id_barang']) ?>">
        <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($item['foto']) ?>">

        <label>Nama Barang</label>
        <input type="text" name="nama_barang" required value="<?= htmlspecialchars($item['nama_barang']) ?>">

        <label>Kategori</label>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php while($row = mysqli_fetch_assoc($queryKategori)) { ?>
                <option value="<?= $row['id_kategori'] ?>" <?= ($row['id_kategori'] == $item['id_kategori']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['nama_kategori']) ?>
                </option>
            <?php } ?>
        </select>

        <label>Satuan</label>
        <input type="text" name="satuan" required value="<?= htmlspecialchars($item['satuan']) ?>">

        <label>Harga</label>
        <input type="number" step="0.01" name="harga" required value="<?= htmlspecialchars($item['harga']) ?>">

        <label>Stok</label>
        <input type="number" step="0.01" name="stok" required value="<?= htmlspecialchars($item['stok']) ?>">

        <label>Foto saat ini</label>
        <?php if($item['foto'] && file_exists('produk/'.$item['foto'])): ?>
            <img src="produk/<?= htmlspecialchars($item['foto']) ?>" alt="foto barang">
        <?php else: ?>
            <div>Tidak ada foto</div>
        <?php endif; ?>

        <label>Ganti Foto (opsional)</label>
        <input type="file" name="foto" accept="image/*">

        <button type="submit">Simpan Perubahan</button>
        <a href="barang.php" style="margin-left:10px;">Batal</a>
    </form>
</body>
</html>
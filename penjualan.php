<?php
    include 'proses_penjualan.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>

    <link rel="stylesheet" href="barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Penjualan</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="content">
    <h2>Table Data Penjualan</h2>

    <a href="create_penjualan.php" class="tambah-btn">+ Tambah Penjualan</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal Penjualan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($penjualan as $row) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>               
                <td><?= $row['tanggal_penjualan'] ?></td>               
                <td class="aksi-btn">
                        <a href="edit_penjualan.php?id=<?$row['id_penjualan'] ?>" class="edit">Edit</a>
                        <a href="hapus_penjualan.php?id=<?$row['id_penjualan'] ?>" class="hapus" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                </td>               
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
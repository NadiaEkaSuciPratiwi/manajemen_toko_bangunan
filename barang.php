<?php
    include 'proses_barang.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>

    <link rel="stylesheet" href="barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<>
    <?php include 'sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Dashboard</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Data Barang</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <h2>Data Barang</h2>

    <a href="create_barang.php">+ Tambah Barang</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Foto</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($barang_list as $row) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?php if ($row['foto']) { ?>
                    <img src="produk/<?=$row['foto']?>" alt="" width="60">
                    <?php } else { ?>
                        <span>-</span>
                    <?php } ?>
                </td>
                <td><?= $row['nama_kategori'] ?></td>
                <td><?= $row['satuan'] ?></td>
                <td><?= $row['harga'] ?></td>               
                <td><?= $row['stok'] ?></td>               
                <td class="aksi-btn">
                        <a href="edit_barang.php?id=<?$row['id_barang'] ?>" class="edit">Edit</a>
                        <a href="hapus_barang.php?id=<?$row['id_barang'] ?>" class="hapus" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                </td>               
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
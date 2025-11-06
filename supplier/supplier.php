<?php
    include 'proses_supplier.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier</title>

    <link rel="stylesheet" href="../css/barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Supplier</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="../beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="content">
    <h2>Data Supplier</h2>

    <a href="create_supplier.php" class="tambah-btn">+ Tambah Supplier</a>

    <form method="GET" action="" class="search-box">
    <input type="text" name="cari" placeholder="Cari supplier" 
           value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
    <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($supplier as $row) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama_supplier'] ?></td>
                <td><?= $row['alamat'] ?></td>             
                <td><?= $row['no_telpon'] ?></td>               
                <td class="aksi-btn">
                        <a href="edit_supplier.php?id=<?= $row['id_supplier'] ?>" class="edit">Edit</a>
                        <a href="hapus_supplier.php?id=<?= $row['id_supplier'] ?>" class="hapus" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                </td>               
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>

    <?php include '../include/footer.php'; ?>
</body>
</html>
<?php
    include 'proses_karyawan.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan</title>
    
    <link rel="stylesheet" href="../css/barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Karyawan</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="../beranda.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="content">
    <h2>Table Data Karyawan</h2>

    <a href="create_karyawan.php" class="tambah-btn">+ Tambah Karyawan</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Alamat</th>
                <th>No Telpon</th>
                <th>Tanggal Join</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($karyawan as $row) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['jabatan'] ?></td>
                <td><?= $row['alamat'] ?></td>              
                <td><?= $row['no_telp'] ?></td>               
                <td><?= formatTanggal($row['tanggal_join']) ?></td>               
                <td class="aksi-btn">
                        <a href="edit_karyawan.php?id=<?$row['id_karyawan'] ?>" class="edit">Edit</a>
                        <a href="hapus_karyawan.php?id=<?$row['id_karyawan'] ?>" class="hapus" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                </td>               
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>
</body>
</html>
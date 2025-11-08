<?php
    session_start();
    include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Supplier</title>

    <link rel="stylesheet" href="../css/crud_supplier.css">
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

<div class="main-content">
<div class="form-container">
<h2>Tambah Supplier</h2>
<form action="proses_create_supplier.php" method="POST">
    <label>Nama Supplier</label><br>
    <input type="text" name="nama_supplier" required><br>

    <label>Alamat</label><br>
    <input type="text" name="alamat" required><br>

    <label>No Telepon</label><br>
    <input type="text" name="no_telpon" required><br>

    <button type="submit" class="btn-update">Simpan</button>
    <a href="supplier.php" class="btn-back">Batal</a>
</form>
</div>
</div>

<?php include '../include/footer.php'; ?>
</body>
</html>
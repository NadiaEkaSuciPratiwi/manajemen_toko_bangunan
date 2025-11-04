<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Supplier</title>
</head>
<body>

<h2>Tambah Supplier</h2>
<form action="proses_create_supplier.php" method="POST">
    <label>Nama Supplier</label><br>
    <input type="text" name="nama_supplier" required><br><br>

    <label>Alamat</label><br>
    <input type="text" name="alamat" required><br><br>

    <label>No Telepon</label><br>
    <input type="text" name="no_telpon" required><br><br>

    <button type="submit">Simpan</button>
    <a href="supplier.php">Batal</a>
</form>

</body>
</html>
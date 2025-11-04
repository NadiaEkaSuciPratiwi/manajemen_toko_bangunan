<?php
session_start();
include '../koneksi.php';

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: supplier.php");
    exit;
}
$id = intval($_GET['id']);

$query = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id_supplier=$id");
$data = mysqli_fetch_assoc($query);

if(!$data){
    echo "Data tidak ditemukan!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier</title>
</head>
<body>
    <h2>Edit Supplier</h2>
    <form action="proses_edit_supplier.php" method="POST">
    <input type="hidden" name="id_supplier" value="<?= $data['id_supplier']; ?>">

    <label>Nama Supplier</label><br>
    <input type="text" name="nama_supplier" value="<?= $data['nama_supplier']; ?>" required><br><br>

    <label>Alamat</label><br>
    <input type="text" name="alamat" value="<?= $data['alamat']; ?>" required><br><br>

    <label>No Telepon</label><br>
    <input type="text" name="no_telpon" value="<?= $data['no_telpon']; ?>" required><br><br>

    <button type="submit">Update</button>
    <a href="supplier.php">Batal</a>
</form>
</body>
</html>

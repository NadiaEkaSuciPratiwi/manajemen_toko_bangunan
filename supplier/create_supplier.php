<?php
    include '../koneksi.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Supplier</title>

    <link rel="stylesheet" href="../crud.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
<div class="form-container">
<h2>Tambah Supplier</h2>
<form action="proses_create_supplier.php" method="POST">
    <label>Nama Supplier</label><br>
    <input type="text" name="nama_supplier" required><br><br>

    <label>Alamat</label><br>
    <input type="text" name="alamat" required><br><br>

    <label>No Telepon</label><br>
    <input type="text" name="no_telpon" required><br><br>

    <button type="submit" class="btn-update">Simpan</button>
    <button class="btn-back"><a href="supplier.php"></a>Batal</button>
</form>
</div>
</body>
</html>
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
    <h2>Edit Supplier</h2>
    <form action="proses_edit_supplier.php" method="POST">
    <input type="hidden" name="id_supplier" value="<?= $data['id_supplier']; ?>">

    <label>Nama Supplier</label><br>
    <input type="text" name="nama_supplier" value="<?= $data['nama_supplier']; ?>" required><br>

    <label>Alamat</label><br>
    <input type="text" name="alamat" value="<?= $data['alamat']; ?>" required><br>

    <label>No Telepon</label><br>
    <input type="text" name="no_telpon" value="<?= $data['no_telpon']; ?>" required><br>

    <button type="submit" class="btn-update">Simpan</button>
    <a href="supplier.php" class="btn-back">Batal</a>
</form>
</div>
</div>

<?php include '../include/footer.php'; ?>

</body>
</html>

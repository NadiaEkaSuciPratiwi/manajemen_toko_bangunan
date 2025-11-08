<?php 
session_start();
include '../koneksi.php';

$id = $_GET['id'];

// Ambil data karyawan berdasarkan ID
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan='$id'");
$data = mysqli_fetch_assoc($result);

if(!$data){
    echo "<script>alert('Data tidak ditemukan!'); window.location='karyawan.php';</script>";
}

// Ambil semua user
$users = mysqli_query($koneksi, "SELECT * FROM users ORDER BY username ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Karyawan</title>
    <link rel="stylesheet" href="../css/crud_karyawan.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
<?php include '../include/sidebar.php'; ?>

<div class="navbar">
        <div class="navbar_left">
            <h3>Karyawan</h3>
        </div>
        <div class="navbar-right">
            <span> Hello, <?=$_SESSION['username'] ?> </span>
            <a href="../beranda.php" class="logout-btn">Logout</a>
        </div>
</div>

<div class="main-content">
<div class="form-container">
    <h2>Edit Karyawan</h2>

    <form action="proses_edit_karyawan.php" method="POST">

        <input type="hidden" name="id_karyawan" value="<?= $data['id_karyawan'] ?>">

        <label>User Login</label>
        <select name="id" required>
            <?php while($u = mysqli_fetch_assoc($users)): ?>
                <option value="<?= $u['id']; ?>" 
                    <?= ($u['id'] == $data['id']) ? 'selected' : ''; ?>>
                    <?= $u['username']; ?> (<?= $u['peran']; ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <label>Nama Karyawan</label>
        <input type="text" name="nama" value="<?= $data['nama'] ?>" required>

        <label>Jabatan</label>
        <input type="text" name="jabatan" value="<?= $data['jabatan'] ?>" required>

        <label>No Telpon</label>
        <input type="text" name="no_telp" value="<?= $data['no_telp'] ?>" required>

        <label>Alamat</label>
        <textarea name="alamat" required><?= $data['alamat'] ?></textarea>

        <label>Tanggal Join</label>
        <input type="date" name="tanggal_join" value="<?= $data['tanggal_join']; ?>" required>


        <button type="submit" class="btn-update">Simpan</button>
        <a href="karyawan.php" class="btn-back">Batal</a>

    </form>
</div>
</div>

<?php include '../include/footer.php'; ?>

</body>
</html>

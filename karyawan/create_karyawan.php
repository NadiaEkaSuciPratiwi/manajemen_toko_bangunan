<?php 
session_start();
include '../koneksi.php';

// Ambil data user
$userQuery = mysqli_query($koneksi, "SELECT * FROM users ORDER BY username ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Karyawan</title>
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
    <h2>Tambah Karyawan</h2>

    <form action="proses_tambah_karyawan.php" method="POST">

        <label for="id">Pilih User</label>
        <select name="id" required>
            <option value="">-- Pilih User --</option>
            <?php while($u = mysqli_fetch_assoc($userQuery)) : ?>
                <option value="<?= $u['id'] ?>">
                    <?= $u['username'] ?> (<?= $u['peran'] ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <br><br>
        <a href="../users/tambah_users.php" class="btn-user" style="margin-bottom: 15px;">
            + Tambah User Baru
        </a>

        <br><br>
        <label>Nama Karyawan</label>
        <input type="text" name="nama" required>

        <label>Jabatan</label>
        <input type="text" name="jabatan" required>

        <label>No Telpon</label>
        <input type="text" name="no_telp" required>

        <label>Alamat</label>
        <textarea name="alamat" required></textarea>

        
        <label>Tanggal Join</label>
        <input type="date" name="tanggal_join" required>


        <button type="submit" class="btn-update">Simpan</button>
        <a href="karyawan.php" class="btn-back">Batal</a>
    </form>

</div>
</div>

<?php include '../include/footer.php'; ?>
</body>
</html>

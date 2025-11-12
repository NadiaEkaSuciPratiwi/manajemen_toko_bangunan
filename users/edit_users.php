<?php
session_start();
include '../koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$id = $_GET['id'];

// Ambil data user dan karyawan
$query = mysqli_query($koneksi, "
    SELECT users.id, users.username, users.password, users.peran, 
           karyawan.nama, karyawan.jabatan, karyawan.no_telp, 
           karyawan.alamat, karyawan.foto, karyawan.tanggal_join
    FROM users
    LEFT JOIN karyawan ON users.id = karyawan.id
    WHERE users.id = '$id'
");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data user tidak ditemukan!');window.location='../dashboard/dashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil User</title>
    <link rel="stylesheet" href="../css/crud_karyawan.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include '../include/sidebar.php'; ?>

<div class="navbar">
    <div class="navbar_left">
        <h3>Edit Profil</h3>
    </div>
    <div class="navbar-right">
        <span>Hello, <?= $_SESSION['username']; ?></span>
        <a href="../beranda.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="form-container">
        <h2>Edit Profil User</h2>

        <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $data['id']; ?>">

            <label>Foto Profil</label>
            <?php if (!empty($data['foto']) && file_exists("../karyawan/profil/" . $data['foto'])): ?>
                <img src="../karyawan/profil/<?= htmlspecialchars($data['foto']); ?>" width="80" style="border-radius:10px;display:block;margin-bottom:10px;">
            <?php else: ?>
                <img src="../karyawan/profil/default.png" width="80" style="border-radius:10px;display:block;margin-bottom:10px;">
            <?php endif; ?>
            <input type="file" name="foto" accept=".jpg,.jpeg,.png">

            <label>Nama Karyawan</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>">

            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($data['username']); ?>" required>

            <label>Password</label>
            <input type="password" name="password" value="<?= htmlspecialchars($data['password']); ?>" required>

            <label>Peran</label>
            <select name="peran" required>
                <option value="admin" <?= $data['peran'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="karyawan" <?= $data['peran'] == 'karyawan' ? 'selected' : ''; ?>>Karyawan</option>
            </select>

            <label>No. Telepon</label>
            <input type="text" name="no_telp" value="<?= htmlspecialchars($data['no_telp']); ?>">

            <label>Alamat</label>
            <textarea name="alamat"><?= htmlspecialchars($data['alamat']); ?></textarea>

             <label>Tanggal Bergabung</label>
            <input type="date" name="tanggal_join" value="<?= htmlspecialchars($data['tanggal_join']); ?>">

            <button type="submit" class="btn-update">Simpan</button>
            <a href="detail_users.php" class="btn-back">Batal</a>
        </form>
    </div>
</div>

<?php include '../include/footer.php'; ?>
</body>
</html>

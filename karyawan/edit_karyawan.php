<?php 
session_start();
include '../koneksi.php';

// Ambil foto profil dari tabel karyawan
    $id_user = $_SESSION['user_id'];

    $ambilFoto = mysqli_query($koneksi, "
                SELECT foto 
                FROM karyawan
                WHERE id = '$id_user'
    ");

    $dataUser = mysqli_fetch_assoc($ambilFoto);

    // Path foto profil
    $foto = (!empty($dataUser['foto'])) 
        ? "profil/" . $dataUser['foto']  
        : "";

$id = $_GET['id'];

// Ambil data karyawan berdasarkan ID
$result = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan='$id'");
$data = mysqli_fetch_assoc($result);

if(!$data){
    echo "<script>alert('Data tidak ditemukan!'); window.location='karyawan.php';</script>";
    exit;
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
        <span>Hello, <?php echo $_SESSION['username']; ?></span>

        <div class="profile-dropdown">
        <img src="<?php echo $foto; ?>" class="profile-photo" onclick="toggleDropdown()">

        <ul id="dropdownMenu" class="dropdown-content">
            <li><a href="../beranda.php" class="dropdown-logout">Logout</a></li>
        </ul>
        </div>

    </div>

    <script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const dd = document.querySelector('.profile-dropdown');
        if (!dd.contains(e.target)) {
            document.getElementById('dropdownMenu').style.display = 'none';
        }
    });
    </script>
</div>

<div class="main-content">
<div class="form-container">
    <h2>Edit Karyawan</h2>

    <!-- Tambah enctype biar bisa upload file -->
    <form action="proses_edit_karyawan.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id_karyawan" value="<?= $data['id_karyawan'] ?>">
        <input type="hidden" name="foto_lama" value="<?= htmlspecialchars($data['foto'] ?? '') ?>">

        <label>User Login</label>
        <select name="id" required>
            <?php while($u = mysqli_fetch_assoc($users)): ?>
                <option value="<?= $u['id']; ?>" <?= ($u['id'] == $data['id']) ? 'selected' : ''; ?>>
                    <?= $u['username']; ?> (<?= $u['peran']; ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <label>Nama Karyawan</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

        <label>Jabatan</label>
        <input type="text" name="jabatan" value="<?= htmlspecialchars($data['jabatan']) ?>" required>

        <label>No Telpon</label>
        <input type="text" name="no_telp" value="<?= htmlspecialchars($data['no_telp']) ?>" required>

        <div class="foto-container">
            <div class="foto-saat-ini">
                <label>Foto saat ini:</label>
                <?php if(!empty($data['foto']) && file_exists('profil/'.$data['foto'])): ?>
                    <img src="profil/<?= htmlspecialchars($data['foto']) ?>" alt="foto profil" class="preview-foto">
                <?php else: ?>
                    <div>Tidak ada foto</div>
                <?php endif; ?>
            </div>

            <div class="ganti-foto">
                <label>Ganti Foto (opsional):</label>
                <input type="file" name="foto" class="file-input">
            </div>
        </div>

        <label>Alamat</label>
        <textarea name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea>

        <label>Tanggal Join</label>
        <input type="date" name="tanggal_join" value="<?= htmlspecialchars($data['tanggal_join']); ?>" required>

        <button type="submit" class="btn-update">Simpan</button>
        <a href="karyawan.php" class="btn-back">Batal</a>
    </form>
</div>
</div>

<?php include '../include/footer.php'; ?>
</body>
</html>

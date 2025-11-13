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

// Ambil data user
$userQuery = mysqli_query($koneksi, "SELECT * FROM users ORDER BY username ASC");

// Ambil ID user baru dari URL (kalau baru saja dibuat)
$id_user_terpilih = isset($_GET['id_user_baru']) ? $_GET['id_user_baru'] : '';
?>
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
    <h2>Tambah Karyawan</h2>

    <!-- enctype penting agar bisa upload foto -->
    <form action="proses_tambah_karyawan.php" method="POST" enctype="multipart/form-data">

        <label for="id">Pilih User</label>
        <select name="id" required>
            <option value="">-- Pilih User --</option>
            <?php while($u = mysqli_fetch_assoc($userQuery)) : ?>
                <option value="<?= $u['id'] ?>">
                    <?= $u['username'] ?> (<?= $u['peran'] ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <?php if(isset($_GET['error']) && $_GET['error'] == "id"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>

        <br><br>
        <a href="../users/tambah_users.php" class="btn-user" style="margin-bottom: 15px;">
            + Tambah User Baru
        </a>

        <br><br>

        <label>Nama Karyawan</label>
        <input type="text" name="nama">
        <?php if(isset($_GET['error']) && $_GET['error'] == "nama"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>

        <label>Jabatan</label>
        <input type="text" name="jabatan">
        <?php if(isset($_GET['error']) && $_GET['error'] == "jabatan"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>

        <label>No Telpon</label>
        <input type="text" name="no_telp">
        <?php if(isset($_GET['error']) && $_GET['error'] == "no_telp"): ?>
            <div class="text-danger small">Nomor tidak boleh lebih dari 13 digit!</div>
        <?php endif; ?>

        <label>Alamat</label>
        <textarea name="alamat"></textarea>
        <?php if(isset($_GET['error']) && $_GET['error'] == "alamat"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>

        <label>Tanggal Join</label>
        <input type="date" name="tanggal_join">
        <?php if(isset($_GET['error']) && $_GET['error'] == "tanggal_join"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
        <?php endif; ?>

        <!-- Foto Profil -->
        <label>Foto Profil (opsional)</label>
        <input type="file" name="foto" accept=".jpg,.jpeg,.png,.gif">
        <?php if(isset($_GET['error']) && $_GET['error'] == "foto"): ?>
            <div class="text-danger small">Format file tidak didukung! (Gunakan JPG, PNG, atau GIF)</div>
        <?php endif; ?>

        <button type="submit" class="btn-update">Simpan</button>
        <a href="karyawan.php" class="btn-back">Batal</a>
    </form>

</div>
</div>

<?php include '../include/footer.php'; ?>
</body>
</html>

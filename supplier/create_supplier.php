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
        ? "../karyawan/profil/" . $dataUser['foto']  
        : "";
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
<h2>Tambah Supplier</h2>
<form action="proses_create_supplier.php" method="POST">
    <label>Nama Supplier</label><br>
    <input type="text" name="nama_supplier">
    <?php if(isset($_GET['error']) && $_GET['error'] == "nama_supplier"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
    <?php endif; ?><br>

    <label>Alamat</label><br>
    <input type="text" name="alamat">
    <?php if(isset($_GET['error']) && $_GET['error'] == "alamat"): ?>
            <div class="text-danger small">Semua field wajib diisi!</div>
    <?php endif; ?><br>

    <label>No Telepon</label><br>
    <input type="text" name="no_telpon">
    <?php if(isset($_GET['error']) && $_GET['error'] == "no_telpon"): ?>
            <div class="text-danger small">Nomor tidak boleh lebih dari 12 digit!</div>
    <?php endif; ?><br>

    <button type="submit" class="btn-update">Simpan</button>
    <a href="supplier.php" class="btn-back">Batal</a>
</form>
</div>
</div>

</body>
</html>
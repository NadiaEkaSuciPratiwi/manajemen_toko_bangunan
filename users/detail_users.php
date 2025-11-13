<?php
session_start();
include '../koneksi.php';

function formatTanggal($tanggal_join){

    return date('d-m-Y', strtotime($tanggal_join));
    
    }


// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

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
        
$user_id = $_SESSION['user_id'];

$query = mysqli_query($koneksi, "
    SELECT users.id, users.username, users.peran, users.password, karyawan.nama, karyawan.jabatan, karyawan.no_telp, karyawan.alamat, karyawan.foto, karyawan.tanggal_join
    FROM users
    LEFT JOIN karyawan ON users.id = karyawan.id
    WHERE users.id = '$user_id'
");

$data = mysqli_fetch_assoc($query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail User</title>
    <link rel="stylesheet" href="../css/crud_karyawan.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
</head>
<body>

<?php include '../include/sidebar.php'; ?>

<div class="navbar">
    <div class="navbar_left">
        <h3>Detail User</h3>
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
    <div class="profile-container">
        <div class="profile-header">
            <?php if (!empty($data['foto']) && file_exists("../karyawan/profil/" . $data['foto'])): ?>
                <img src="../karyawan/profil/<?= htmlspecialchars($data['foto']); ?>" alt="Foto Profil">
            <?php else: ?>
                <img src="../karyawan/profil/default.png" alt="Foto Default">
            <?php endif; ?>
            <h2><?= htmlspecialchars($data['nama'] ?? $data['username']); ?></h2>
            <p><?= htmlspecialchars($data['jabatan'] ?? '-'); ?></p>
        </div>

        <div class="profile-info">
            <label>Username:</label>
            <p><?= htmlspecialchars($data['username']); ?></p>

            <label>Peran:</label>
            <p><?= htmlspecialchars($data['peran']); ?></p>

            <label>Password:</label>
            <p><?= htmlspecialchars($data['password']); ?></p>

            <label>No. Telepon:</label>
            <p><?= htmlspecialchars($data['no_telp'] ?? '-'); ?></p>

            <label>Alamat:</label>
            <p><?= htmlspecialchars($data['alamat'] ?? '-'); ?></p>

            <label>Tanggal Bergabung:</label>
            <p><?= formatTanggal($data['tanggal_join']) ?></p>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <a href="edit_users.php?id=<?= $data['id']; ?>" class="btn-edit">Edit Profil</a>
        </div>
    </div>
</div>

<?php include '../include/footer.php'; ?>

</body>
</html>

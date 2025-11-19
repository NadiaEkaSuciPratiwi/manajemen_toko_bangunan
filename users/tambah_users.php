<?php
session_start();
include '../koneksi.php';

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

// Saat tombol submit ditekan
if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $peran = $_POST['peran'];

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

    // Validasi sederhana
    if (empty($username) || empty($password) || empty($peran)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    // Simpan ke database
    $query = "INSERT INTO users (username, password, peran)
              VALUES ('$username', '$password', '$peran')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>
                alert('User berhasil ditambahkan!');
                window.location = '../karyawan/create_karyawan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambah user: " . mysqli_error($koneksi) . "');
                window.history.back();
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <link rel="stylesheet" href="../css/crud_users.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<?php include '../include/sidebar.php'; ?>

<div class="navbar">
    <div class="navbar_left">
        <h3>Users</h3>
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
</div>

<div class="main-content">
<div class="form-container">
    <h2>Tambah User</h2>

    <form action="" method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Peran</label>
        <select name="peran" required>
            <option value="">-- Pilih Peran --</option>
            <option value="admin">Admin</option>
            <option value="karyawan">Karyawan</option>
        </select>

        <button type="submit" name="simpan" class="btn-update">Simpan</button>
        <a href="../karyawan/create_karyawan.php" class="btn-back">Batal</a>
    </form>
</div>
</div>
</body>
</html>

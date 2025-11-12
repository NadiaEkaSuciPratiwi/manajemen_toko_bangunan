<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Saat tombol submit ditekan
if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $peran = $_POST['peran'];

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
</head>
<body>

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

</body>
</html>

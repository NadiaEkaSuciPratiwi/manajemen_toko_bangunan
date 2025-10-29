<?php
    session_start();
    include 'koneksi.php';

    //ambil data di form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //cek data di database
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['peran'] = $data['peran'];

        header("Location: dashboard.php");
        exit;
    } else{
        header("Location: login.php?error=1");
        exit;
    }
?>
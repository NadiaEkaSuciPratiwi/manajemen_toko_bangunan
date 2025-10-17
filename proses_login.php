<?php
    include 'koneksi.php';

    //ambil data di form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //cek data di database
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        header("Location: dashboard.php");
        exit();
    } else{
        echo "Username atau password salah!";
    }
?>
<?php 
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigasi</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    
</head>
<body>
    <div class="sidebar">
        <img src="../foto/logo.jpg" class="logo">
        <h2>Sinar Abadi</h2> 
        <ul>
            <li><a href="../dashboard/dashboard.php"><i class="fa-solid fa-gauge"></i>Dashboard</a></li>
            
            <?php if($_SESSION['peran'] == 'admin') { ?>
                <li><a href="../karyawan/karyawan.php"><i class="fa fa-users"></i>Karyawan</a></li>
                <li><a href="../supplier/supplier.php"><i class="fa-solid fa-truck-loading"></i>Supplier</a></li>
            <?php } ?>

            <li><a href="../penjualan/penjualan.php"><i class="fa-solid fa-cart-shopping"></i>Penjualan</a></li>
            <li><a href="../pembelian/pembelian.php"><i class="fa-solid fa-arrow-down-wide-short"></i>Pembelian</a></li>
            <li><a href="../users/detail_users.php"><i class="fa-solid fa-user-circle"></i>Detail Users</a></li>
            <li><a href="../barang/barang.php"><i class="fa-solid fa-box"></i>Barang</a></li>
            <li><a href="../laporan/laporan.php"><i class="fa-solid fa-chart-column"></i>Laporan</a></li>
        </ul>
    </div>
    
    <script>
        const currentPage = window.location.pathname.split("/").pop();
        const sideLinks = document.querySelectorAll(".sidebar ul li a");

        sideLinks.forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();

        if (linkPage === currentPage) {
            link.classList.add("active");
        }
        });
    </script>
</body>
</html>

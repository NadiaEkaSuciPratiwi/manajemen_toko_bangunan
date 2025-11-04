<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigasi</title>

    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="sidebar">
        <img src="../foto/logo.jpg" class="logo">
        <h2>Sinar Abadi</h2> 
        <ul>
            <li><a href="../dashboard/dashboard.php">Dashboard</a></li>
            <li><a href="../karyawan/karyawan.php">Karyawan</a></li>
            <li><a href="../supplier/supplier.php">Supplier</a></li>
            <li><a href="../penjualan/penjualan.php">Penjualan</a></li>
            <li><a href="../pembelian/pembelian.php">Pembelian</a></li>
            <li><a href="../barang/barang.php">Barang</a></li>
        </ul>
    </div>
    
    <script>
        const currentUrl = window.location.href;
const sideLinks = document.querySelectorAll(".sidebar ul li a");

sideLinks.forEach(link => {
    if (currentUrl.includes(link.getAttribute("href"))) {
        link.classList.add("active");
    }
});

    </script>
</body>
</html>
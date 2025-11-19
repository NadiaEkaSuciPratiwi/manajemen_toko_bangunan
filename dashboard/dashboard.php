
<?php
    session_start();
    include '../koneksi.php';

    if(!isset($_SESSION['user_id'])){
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

    //ambil data ringkasan dari database
    $karyawan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM karyawan"));
    $penjualan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM penjualan"));
    $stok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM barang"));
    $pembelian = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pembelian"));


    // ambil data penjualan per bulan
    $query = "SELECT MONTH(tanggal_penjualan) AS bulan, SUM(total_harga) AS total FROM penjualan GROUP BY MONTH(tanggal_penjualan) ORDER BY bulan";

    $result = mysqli_query($koneksi, $query);

    $bulan = [];
    $total = [];

    $nama_bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    while ($row = mysqli_fetch_assoc($result)) {
    $bulan[] = $nama_bulan[$row['bulan']];
    $total[] = $row['total'];
    }

   // === PENJUALAN PER BULAN ===
$query_penjualan = "
    SELECT MONTH(tanggal_penjualan) AS bulan, COUNT(*) AS total 
    FROM penjualan 
    GROUP BY MONTH(tanggal_penjualan)   
    ORDER BY bulan
";

$result_penjualan = mysqli_query($koneksi, $query_penjualan);

$data_penjualan_perbulan = array_fill(1, 12, 0); // isi default 0

while ($row = mysqli_fetch_assoc($result_penjualan)) {
    $data_penjualan_perbulan[$row['bulan']] = (int)$row['total'];
}


// === PEMBELIAN PER BULAN ===
$query_pembelian = "
    SELECT MONTH(tanggal_pembelian) AS bulan, COUNT(*) AS total 
    FROM pembelian
    GROUP BY MONTH(tanggal_pembelian)
    ORDER BY bulan
";
$result_pembelian = mysqli_query($koneksi, $query_pembelian);

$data_pembelian_perbulan = array_fill(1, 12, 0); // isi default 0

while ($row = mysqli_fetch_assoc($result_pembelian)) {
    $data_pembelian_perbulan[$row['bulan']] = (int)$row['total'];
}


// Nama bulan
$nama_bulan = [
    1=>'Januari','Februari','Maret','April','Mei','Juni',
    'Juli','Agustus','September','Oktober','November','Desember'
];

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../css/dashboard.css">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


</head>
<body>          
    <?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Dashboard</h3>
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

    <div class="content">
        <h1>Selamat Datang di Halaman Dashboard</h1>

        <div class="cards">
            <div class="card karyawan">
                <i class="fa-solid fa-users"></i>
                <h3>Total Karyawan</h3>
                <p><?=$karyawan['total'] ?></p>
                
            </div>
            <div class="card penjualan">
                <i class="fa-solid fa-cart-shopping"></i>
                <h3>Total Penjualan</h3>
                <p><?=$penjualan['total'] ?></p>
            </div>
            <div class="card stok">
                <i class="fa-solid fa-boxes-stacked"></i>
                <h3>Total Stok Barang</h3>
                <p><?=$stok['total'] ?></p>
            </div>
            <div class="card masuk">
                <i class="fa-solid fa-arrow-down"></i>
                <h3>Total Barang Masuk</h3>
                <p><?=$pembelian['total'] ?></p>
            </div>
        </div>

        <div class="chart-container">
    
        <!-- KIRI: Statistik Penjualan (Line Chart yang sudah ada) -->
        <div class="chart-card">
            <h3><i class="fa fa-line-chart"></i> Statistik Penjualan Bulanan</h3>
            <canvas id="chartPenjualan"></canvas>
        </div>

        <!-- KANAN: Diagram Batang Penjualan vs Pembelian -->
        <div class="chart-card">
            <h3><i class="fa fa-bar-chart"></i> Penjualan & Pembelian</h3>
            <canvas id="chartBar"></canvas>
        </div>

    </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('chartPenjualan').getContext('2d');
            const lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($bulan); ?>,
                datasets: [{
                    label: 'Total Penjualan',
                    data: <?php echo json_encode($total); ?>,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#1d4ed8',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
            });

            // GRAFIK BATANG (Penjualan vs Pembelian)
            const ctxBar = document.getElementById('chartBar').getContext('2d');

            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_values($nama_bulan)); ?>,
                    datasets: [
                        {
                            label: 'Penjualan',
                            data: <?= json_encode(array_values($data_penjualan_perbulan)); ?>,
                            backgroundColor: 'rgba(15, 105, 165, 0.7)'
                        },
                        {
                            label: 'Pembelian',
                            data: <?= json_encode(array_values($data_pembelian_perbulan)); ?>,
                            backgroundColor: '#f5c518'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });


        </script>

        
        </div>
    </div>
    <?php include '../include/footer.php'; ?>
    
</body>
</html>
<?php
session_start();
include '../koneksi.php';

//ambil id penjualan
$id_penjualan = $_GET['id'] ?? null;
if(!$id_penjualan){
    header("Location: penjualan.php");
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

//ambil data penjualan lama
$queryPenj = mysqli_query($koneksi, 
    "SELECT * FROM penjualan WHERE id_penjualan=$id_penjualan");
$penjualan = mysqli_fetch_assoc($queryPenj);

//ambil semua barang untuk dropdown
$queryBarang = mysqli_query($koneksi, "SELECT * FROM barang");

//jika data tidak ditemukan
if(!$penjualan){
    echo "Data tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Penjualan</title>

<link rel="stylesheet" href="../css/crud_penjualan.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>
<?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            <h3>Penjualan</h3>
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
    <h2>Edit Penjualan</h2>
        <form action="proses_edit_penjualan.php" method="POST">

        <!-- ID penjualan untuk identifikasi di proses update -->
        <input type="hidden" name="id_penjualan" value="<?= $penjualan['id_penjualan'] ?>">

        <label>Nama Barang</label><br>
        <select name="id_barang" id="barangSelect" required>
            <?php foreach($queryBarang as $b) { ?>
                <option 
                    value="<?= $b['id_barang'] ?>"
                    data-harga="<?= $b['harga'] ?>"
                    <?= ($b['id_barang'] == $penjualan['id_barang']) ? "selected" : "" ?>>
                    <?= $b['nama_barang'] ?>
                </option>
            <?php } ?>
        </select><br><br>

        <label>Jumlah</label><br>
        <input type="number" name="jumlah" id="jumlah" 
            value="<?= $penjualan['jumlah'] ?>" required><br><br>

        <label>Total Harga</label><br>
        <input type="text" name="total_harga" id="total_harga" 
            value="<?= $penjualan['total_harga'] ?>" readonly><br><br>

        <label>Tanggal Penjualan</label><br>
        <input type="date" name="tanggal_penjualan"
            value="<?= $penjualan['tanggal_penjualan'] ?>" required><br><br>

        <button type="submit" class="btn-update">Simpan</button>
        <a href="penjualan.php" class="btn-back">Batal</a>

        </form>

        <script>
        //Auto calc total harga saat barang/jumlah berubah
        function hitungTotal() {
            let select = document.getElementById('barangSelect');
            let harga = select.options[select.selectedIndex].getAttribute('data-harga');
            let jumlah = document.getElementById('jumlah').value;

            document.getElementById('total_harga').value = harga * jumlah;
        }

        document.getElementById('barangSelect').addEventListener('change', hitungTotal);
        document.getElementById('jumlah').addEventListener('keyup', hitungTotal);
        </script>
    </div>
</div>

    <?php include '../include/footer.php'; ?>
</body>
</html>
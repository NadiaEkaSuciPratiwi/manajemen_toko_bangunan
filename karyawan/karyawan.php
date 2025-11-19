<?php
    include 'proses_karyawan.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan</title>
    
    <link rel="stylesheet" href="../css/barang.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php include '../include/sidebar.php'; ?>

    <div class="navbar">
        <div class="navbar_left">
            
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
    <h2>Data Karyawan</h2>

    <a href="create_karyawan.php" class="tambah-btn">+ Tambah Karyawan</a>

    <div class="search-box">
    <form action="" method="GET">
        <input type="text" name="cari" placeholder="Cari karyawan"
                value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
    <button type="submit"><i class="fa fa-search"></i>Search</button>
    <a href="karyawan.php" style="padding: 7px;" class="btn-reset"><i class="fa fa-refresh"></i>Reset</a>
    </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Alamat</th>
                <th>No Telpon</th>
                <th>Foto</th>
                <th>Tanggal Join</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($karyawan as $row) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['jabatan'] ?></td>
                <td><?= $row['alamat'] ?></td>              
                <td><?= $row['no_telp'] ?></td> 
                <td>
                <?php if (!empty($row['foto']) && file_exists("profil/" . $row['foto'])): ?>
                    <img src="profil/<?= htmlspecialchars($row['foto']); ?>" width="100" height="80" style=" border-radius: 10%;">
                <?php else: ?>
                    <img src="profil/" width="100" height="80" style="border-radius: 50%;">
                <?php endif; ?>
                </td>
       
                <td><?= formatTanggal($row['tanggal_join']) ?></td>               
                <td class="aksi-btn">
                        <a href="edit_karyawan.php?id=<?= $row['id_karyawan'] ?>" class="edit">Edit</a>
                        <a href="hapus_karyawan.php?id=<?= $row['id_karyawan'] ?>" class="hapus" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                </td>               
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- ✅ Pagination Bootstrap -->
    <nav aria-label="Page navigation" style="margin-top: 20px;">
    <ul class="pagination-custom">

    <!-- Tombol Previous -->
    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
        <a class="page-link" 
            href="?page=<?= $page-1 ?>&cari=<?= $_GET['cari'] ?? '' ?>">
            Previous
        </a>
    </li>

    <!-- Nomor Halaman -->
    <?php for($i = 1; $i <= $total_page; $i++) { ?>
        <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
            <a class="page-link"
            href="?page=<?= $i ?>&cari=<?= $_GET['cari'] ?? '' ?>">
                <?= $i ?>
            </a>
        </li>
    <?php } ?>

    <!-- Tombol Next -->
    <li class="page-item <?= ($page >= $total_page) ? 'disabled' : '' ?>">
        <a class="page-link"
            href="?page=<?= $page+1 ?>&cari=<?= $_GET['cari'] ?? '' ?>">
            Next
        </a>
    </li>

    </ul>
    </nav>
    
</div>

<?php include '../include/footer.php'; ?>
</body>
</html>
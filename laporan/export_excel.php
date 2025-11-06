<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

include '../koneksi.php';

echo "<h3>Laporan Penjualan</h3>";
echo "<table border='1'>
<tr>
    <th>No</th>
    <th>Barang</th>
    <th>Jumlah</th>
    <th>Total Harga</th>
    <th>Tanggal</th>
</tr>";

$query = mysqli_query($koneksi, 
    "SELECT penjualan.*, barang.nama_barang 
     FROM penjualan
     LEFT JOIN barang ON penjualan.id_barang = barang.id_barang"
);

$no = 1;

while ($row = mysqli_fetch_assoc($query)) {

    $harga = "Rp " . number_format($row['total_harga'], 0, ',', '.');
    $tanggal = date('d-m-Y', strtotime($row['tanggal_penjualan']));

    echo "<tr>
            <td>".$no++."</td>
            <td>".$row['nama_barang']."</td>
            <td>".$row['jumlah']."</td>
            <td>".$harga."</td>
            <td>".$tanggal."</td>
          </tr>";
}

echo "</table>";
?>

<?php
include "../koneksi.php";
include "../class/Transaksi.php";

$transaksi = new Transaksi($mysqli);

// Ambil ID transaksi dari URL
$id_transaksi = $_GET['id_transaksi'];

// Ambil detail transaksi dari database
$query = "SELECT t.tanggal, t.total_harga, p.nama_produk, dt.jumlah, dt.harga 
          FROM transaksi t 
          JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi 
          JOIN produk p ON dt.id_produk = p.id_produk 
          WHERE t.id_transaksi = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id_transaksi);
$stmt->execute();
$result = $stmt->get_result();
$transaksi_data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Detail Transaksi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi_data as $data): ?>
                    <tr>
                        <td><?= $data['tanggal'] ?></td>
                        <td><?= $data['nama_produk'] ?></td>
                        <td><?= $data['jumlah'] ?></td>
                        <td><?= number_format($data['harga'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total Harga: <?= number_format(array_sum(array_column($transaksi_data, 'harga')), 2, ',', '.') ?></h4>
        <button class="btn btn-primary no-print" onclick="window.print()">Cetak</button>
        <a href="tambah_transaksi.php" class="btn btn-secondary no-print">Kembali</a>
    </div>
</body>

</html>
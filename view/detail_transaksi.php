<?php
include "../koneksi.php"; // Include database connection
include "../class/Transaksi.php"; // Include Transaksi class
include "../logic/functions.php"; // Include functions file

$transaksiId = $_GET['id_transaksi'];

try {
    // Ambil detail transaksi
    $transaksiDetails = ambilDetailTransaksi($mysqli, $transaksiId);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function printData() {
            window.print();
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2>Detail Transaksi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $transaksiDetails['id_transaksi'] ?></td>
                    <td><?= $transaksiDetails['tanggal'] ?></td>
                    <td><?= number_format($transaksiDetails['total_harga'], 2, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <h3>Detail Produk</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksiDetails['produk'] as $produk): ?>
                    <tr>
                        <td><?= $produk['nama_produk'] ?></td>
                        <td><?= $produk['jumlah'] ?></td>
                        <td><?= number_format($produk['harga'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button class="btn btn-primary" onclick="printData()">Cetak Detail Transaksi</button>
        <a href="transaksi.php" class="btn btn-primary">Kembali</a>
    </div>
</body>

</html>
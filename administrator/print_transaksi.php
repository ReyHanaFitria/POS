<?php
include "../koneksi.php";
include "../class/Transaksi.php";

$transaksi = new Transaksi($mysqli);

// Get the transaction ID from the URL
$transaksiId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch transaction details
$transaksiDetails = $transaksi->getTransaksiDetails($transaksiId);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi ID: <?= $transaksiId ?></title>
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
        <h2 class="text-center fw-bold">Judul Toko </h2>
        <p class="text-center">Jl. Raya Timur III No.875, Dawuan, Kec. Dawuan, Kabupaten Majalengka, Jawa Barat 45453</p>
        <p>Tanggal: <?= formatTanggal($transaksiDetails['tanggal']) ?></p>
        <p>Pelanggan: <?= ucwords($transaksiDetails['customer_name']) ?></p> <!-- Display customer name -->

        <h4>Detail Produk</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Quantity</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksiDetails['produk'] as $produk): ?>
                    <tr>
                        <td><?= ucwords($produk['nama_produk']) ?></td>
                        <td><?= $produk['jumlah'] ?></td>
                        <td><?= number_format($produk['harga'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" class="text-end"><strong>Total: </strong> </td>

                    <td><?= number_format($transaksiDetails['total_harga'], 2, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <p class="text-center mt-5">"Terimakasih Sudah Berbelanja di Toko Kami"</p>
        <button class="btn btn-primary no-print" onclick="window.print()">Cetak</button>
        <a href=' laporan.php' class="btn btn-primary no-print">Kembali</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
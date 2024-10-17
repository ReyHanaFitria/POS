<?php
include "../koneksi.php";
include "../class/Transaksi.php";
include "header.php";
include "navbar.php";

$transaksi = new Transaksi($mysqli);
$dataTransaksi = $transaksi->getTransaksi();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Data Transaksi</h2>
        <a href="tambah_transaksi.php" class="btn btn-success my-3">Tambah Transaksi</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataTransaksi as $transaksi): ?>
                    <tr>
                        <td><?= $transaksi['id_transaksi'] ?></td>
                        <td><?= $transaksi['tanggal'] ?></td>
                        <td><?= number_format($transaksi['total_harga'], 2, ',', '.') ?></td>
                        <td>
                            <a href="detail_transaksi.php?id_transaksi=<?= $transaksi['id_transaksi'] ?>" class="btn btn-info">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php include "footer.php"; ?>
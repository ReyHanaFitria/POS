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
    <style>
        body {
            background-color: #f8f9fa; /* Latar belakang terang */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font modern */
        }

        .container {
            max-width: 1200px; /* Lebar maksimum kontainer */
            margin-top: 50px; /* Jarak atas kontainer */
        }

        h2 {
            margin-bottom: 20px; /* Jarak bawah judul */
            text-align: center; /* Pusatkan judul */
            color: #343a40; /* Warna judul */
        }

        .card {
            border-radius: 0.5rem; /* Sudut membulat untuk kartu */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Bayangan */
            margin-bottom: 20px; /* Jarak antar kartu */
        }

        .table {
            background-color: white; /* Warna latar tabel */
            border-radius: 0.5rem; /* Sudut tabel membulat */
            overflow: hidden; /* Menghindari elemen keluar dari tabel */
        }

        .table th, .table td {
            vertical-align: middle; /* Penempatan konten di tengah */
            text-align: center; /* Pusatkan teks dalam tabel */
        }

        .btn-success {
            background-color: #28a745; /* Warna tombol tambah */
            border-color: #28a745; /* Warna border tombol */
        }

        .btn-success:hover {
            background-color: #218838; /* Warna latar belakang saat hover */
            border-color: #1e7e34; /* Warna border saat hover */
        }

        .btn-info {
            background-color: #17a2b8; /* Warna tombol detail */
        }

        .btn-info:hover {
            background-color: #138496; /* Warna latar belakang saat hover */
        }

        .alert {
            margin-top: 20px; /* Jarak atas alert */
        }
    </style>
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
                        <td><?= formatTanggal($transaksi['tanggal']) ?></td>
                        <td><?= number_format($transaksi['total_harga'], 2, ',', '.') ?></td>
                        <td>
                            <a href="detail_transaksi.php?id_transaksi=<?= $transaksi['id_transaksi'] ?>" class="btn btn-info">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include "footer.php"; ?>
</body>

</html>

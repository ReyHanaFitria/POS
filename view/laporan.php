<?php
include "../koneksi.php";
include "../class/Transaksi.php";
include "header.php";
include "navbar.php";

$transaksi = new Transaksi($mysqli);

// Ambil semua transaksi
$transaksis = $transaksi->getTransaksi();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Latar belakang terang */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Font modern */
        }

        .container {
            max-width: 1200px; /* Lebar maksimum kontainer */
            margin-top: 50px; /* Jarak atas kontainer */
            background-color: white; /* Latar belakang putih */
            border-radius: 0.5rem; /* Sudut membulat */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Bayangan */
            padding: 30px; /* Padding di dalam kontainer */
        }

        h2 {
            text-align: center; /* Pusatkan judul */
            color: #343a40; /* Warna judul */
            margin-bottom: 30px; /* Jarak bawah judul */
        }

        .table th {
            background-color: #007bff; /* Warna latar tabel */
            color: white; /* Warna teks tabel */
        }

        .btn-info {
            background-color: #17a2b8; /* Warna tombol detail */
        }

        .btn-success {
            background-color: #28a745; /* Warna tombol cetak */
        }

        .modal-header {
            background-color: #007bff; /* Warna header modal */
            color: white; /* Warna teks header modal */
        }
    </style>
</head>

<body>
    <div class="container">
    <h2>Laporan Transaksi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Detail Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksis as $transaksi): ?>
                    <tr>
                        <td><?= $transaksi['id_transaksi'] ?></td>
                        <td><?= formatTanggal($transaksi['tanggal']) ?></td>
                        <td><?= number_format($transaksi['total_harga'], 2, ',', '.') ?></td>
                        <td>
                            <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $transaksi['id_transaksi'] ?>">Lihat Detail</a>

                            <!-- Modal untuk menampilkan detail transaksi -->
                            <div class="modal fade" id="detailModal<?= $transaksi['id_transaksi'] ?>" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel">Detail Transaksi ID: <?= htmlspecialchars($transaksi['id_transaksi']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>ID Produk</th>
                                                        <th>Nama Produk</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Ambil detail transaksi berdasarkan id_transaksi
                                                    $stmt = $mysqli->prepare("SELECT dt.id_produk, p.nama_produk, dt.jumlah, dt.harga FROM detail_transaksi dt JOIN produk p ON dt.id_produk = p.id_produk WHERE dt.id_transaksi = ?");
                                                    $stmt->bind_param("i", $transaksi['id_transaksi']);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();

                                                    while ($row = $result->fetch_assoc()): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($row['id_produk']) ?></td>
                                                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                                            <td><?= htmlspecialchars($row['jumlah']) ?></td>
                                                            <td>Rp. <?= number_format($row['harga'], 2, ',', '.') ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="print_transaksi.php?id=<?= $transaksi['id_transaksi'] ?>" class="btn btn-success">Cetak</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

<?php include 'footer.php'; ?>

</html>

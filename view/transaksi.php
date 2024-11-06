<?php
include "header.php";
include "../koneksi.php";
include "../class/Transaksi.php";

$transaksi = new Transaksi($mysqli);
$dataTransaksi = $transaksi->getTransaksi();
?>
<div id="content">
    <div class="container mt-2">
        <div class="card shadow-lg border-0 mb-4" style="backdrop-filter: blur(10px); --bs-card-bg: none; ">
            <div class="card-body">
                <a href="tambah_transaksi.php" class="btn btn-primary mb-3">Tambah Transaksi</a>
                <table class="table table-hover table-borderless align-middle text-center">
                    <thead class="table-primary">
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
                                <td>Rp. <?= number_format($transaksi['total_harga'], 2, ',', '.') ?></td>
                                <td>
                                    <a href="detail_transaksi.php?id_transaksi=<?= $transaksi['id_transaksi'] ?>" class="btn btn-info btn-sm">Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
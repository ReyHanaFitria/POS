<?php
include "../koneksi.php";
include "../class/Transaksi.php";
include "../logic/functions.php";
include "header.php";
include "navbar.php";

$transaksi = new Transaksi($mysqli);

// Ambil semua transaksi
$transaksis = $transaksi->getTransaksi();

// Ambil bulan dan tahun dari parameter GET
$bulan = isset($_GET['bulan']) ? intval($_GET['bulan']) : date('n');
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y');

// Tambahkan logika untuk filter berdasarkan bulan dan tahun
if (isset($_GET['filter'])) {
    $transaksis = $transaksi->getTransaksiByMonthAndYear($bulan, $tahun);
}
?>

<div class="container mt-4">
    <h2>Laporan Transaksi</h2>
    <form method="get" action="">
        <div class="row mb-3">
            <div class="col">
            <select name="bulan" class="form-select">
                <?php foreach ($namaBulan as $i => $bulanNama): ?>
                    <option value="<?= $i; ?>" <?= ($i == $bulan) ? 'selected' : ''; ?>><?= $bulanNama; ?></option>
                <?php endforeach; ?>
            </select>
            </div>
            <div class="col">
                <input type="number" name="tahun" class="form-control" value="<?= $tahun; ?>" required>
            </div>
            <div class="col">
                <button type="submit" name="filter" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </form>

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
            <?php foreach($transaksis as $transaksi) : ?>
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

                                                while ($row = $result->fetch_assoc()) : ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row['id_produk']) ?></td>
                                                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                                        <td><?= htmlspecialchars($row['jumlah']) ?></td>
                                                        <td>Rp. <?= number_format($row['harga'], 2, ',', '.') ?></td>
                                                    </tr>
                                                <?php endwhile; // Perbaiki di sini ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="print_transaksi.php?id=<?= $transaksi['id_transaksi']; ?>" class="btn btn-success">Cetak</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
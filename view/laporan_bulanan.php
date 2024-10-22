<?php
include "header.php";
include "navbar.php";
include '../koneksi.php'; // Include database connection
include "../logic/functions.php"; // Include functions file

// Ambil bulan dan tahun dari parameter GET
$bulan = isset($_GET['bulan']) ? intval($_GET['bulan']) : date('n'); // Default ke bulan saat ini
$tahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : date('Y'); // Default ke tahun saat ini

try {
    // Fetch monthly detail transactions
    $data = ambilDataDetailTransaksiBulanan($mysqli, $bulan, $tahun);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<div class="container mt-4">
    <h2>Laporan Detail Transaksi Bulanan</h2>
    <form method="get" action="">
        <div class="row mb-3">
            <div class="col">
                <select name="bulan" class="form-select">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i; ?>" <?= ($i == $bulan) ? 'selected' : ''; ?>><?= date('F', mktime(0, 0, 0, $i, 1)); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col">
                <input type="number" name="tahun" class="form-control" value="<?= $tahun; ?>" required>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data transaksi untuk bulan ini.</td>
                </tr>
            <?php else: ?>
                <?php
                $totalPendapatan = 0; // Inisialisasi total pendapatan
                foreach ($data as $transaksi):
                    $pendapatan = $transaksi['total_jumlah'] * $transaksi['harga']; // Hitung pendapatan per produk
                    $totalPendapatan += $pendapatan; // Tambahkan ke total pendapatan
                ?>
                    <tr>
                        <td><?= htmlspecialchars($transaksi['nama_produk']); ?></td>
                        <td><?= $transaksi['total_jumlah']; ?></td>
                        <td>Rp. <?= number_format($transaksi['harga'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($data)): ?>
        <div class="alert alert-info">
            <strong>Total Pendapatan: </strong> Rp. <?= number_format($totalPendapatan, 0, ',', '.'); ?>
        </div>
    <?php endif; ?>
</div>

<?php
include "footer.php";
?>
<?php
include "../koneksi.php";
include "../class/Transaksi.php";
include "../logic/functions.php";
include "header.php";

$transaksi = new Transaksi($mysqli);

// Ambil parameter POST: bulan, tahun, dan tanggal
$bulan = isset($_POST['bulan']) && $_POST['bulan'] !== "" ? intval($_POST['bulan']) : null;
$tahun = isset($_POST['tahun']) ? intval($_POST['tahun']) : date('Y');
$tanggal = isset($_POST['tanggal']) && $_POST['tanggal'] !== "" ? intval($_POST['tanggal']) : null;

// Hitung jumlah hari dalam bulan dan tahun jika bulan dipilih
$jumlahHari = $bulan ? cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun) : 31;

// Ambil transaksi berdasarkan filter
$transaksis = $transaksi->getTransaksi($bulan, $tahun, $tanggal);
?>

<style>
    /* Atur modal agar berada di paling atas */
    .modal {
        z-index: 1055 !important;
        /* Pastikan z-index lebih tinggi dari elemen lain */
    }

    /* Atur backdrop agar tidak menutupi konten */
    .modal-backdrop {
        z-index: 1050 !important;
    }
</style>

<div id="content">
    <div class="container mt-4">
        <div class="card shadow-lg border-0 mb-4" style="backdrop-filter: blur(10px); --bs-card-bg: none; ">
            <div class="card-header">
                <h5 class="text-dark mt-2">Laporan Transaksi</h5>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="row mb-3">
                        <div class="col">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="<?= $tahun; ?>" required onchange="this.form.submit()">
                        </div>
                        <div class="col">
                            <label>Bulan (Opsional)</label>
                            <select name="bulan" class="form-select" onchange="this.form.submit()">
                                <option value="">Pilih Bulan</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i; ?>" <?= ($i == $bulan) ? 'selected' : ''; ?>>
                                        <?= date('F', mktime(0, 0, 0, $i, 1)); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col">
                            <label>Tanggal (Opsional)</label>
                            <select name="tanggal" class="form-select" onchange="this.form.submit()">
                                <option value="">Pilih Tanggal</option>
                                <?php for ($i = 1; $i <= $jumlahHari; $i++): ?>
                                    <option value="<?= $i; ?>" <?= ($i == $tanggal) ? 'selected' : ''; ?>>
                                        <?= $i; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </form>

                <table class="table table-hover table-borderless align-middle">
                    <thead>
                        <tr class="table-primary">
                            <th>ID Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Nama Pelanggan</th>
                            <th>Detail Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksis as $transaksi): ?>
                            <tr>
                                <td><?= $transaksi['id_transaksi'] ?></td>
                                <td><?= formatTanggal($transaksi['tanggal']) ?></td>
                                <td><?= number_format($transaksi['total_harga'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($transaksi['nama_pelanggan']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $transaksi['id_transaksi'] ?>">Lihat Detail</button>
                                    <a href="print_transaksi.php?id=<?= $transaksi['id_transaksi']; ?>" class="btn btn-danger">Cetak</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Deklarasi semua modal di bagian bawah agar berada di paling luar -->
<?php foreach ($transaksis as $transaksi): ?>
    <div class="modal fade" id="detailModal<?= $transaksi['id_transaksi'] ?>" data-bs-backdrop="false" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Tanggal Transaksi: <?= formatTanggal($transaksi['tanggal']) ?></h5>
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
                                    <td><?= ucwords($row['nama_produk']) ?></td>
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
<?php endforeach; ?>

<?php include 'footer.php'; ?>
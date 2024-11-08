<?php
include "header.php";
include '../koneksi.php';
include "../logic/functions.php";

// Ambil parameter POST: bulan, tahun, dan tanggal
$bulan = isset($_POST['bulan']) ? intval($_POST['bulan']) : date('n');
$tahun = isset($_POST['tahun']) ? intval($_POST['tahun']) : date('Y');
$tanggal = isset($_POST['tanggal']) ? intval($_POST['tanggal']) : null;

// Hitung jumlah hari dalam bulan yang dipilih
$jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

try {
    // Cek jika tanggal diisi, ambil data harian. Jika tidak, ambil data bulanan.
    if (!empty($tanggal)) {
        $data = ambilDataDetailTransaksiHarian($mysqli, $tahun, $bulan, $tanggal);
    } else {
        $data = ambilDataDetailTransaksiBulanan($mysqli, $bulan, $tahun);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<div id="content">
    <div class="container mt-2">
        <div class="card shadow-lg border-0 mb-4" style="backdrop-filter: blur(10px); --bs-card-bg: none; ">
            <div class="card-header">
                <h5 class="text-dark mt-2">Laporan Detail Transaksi</h5>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="row mb-3 justify-content-center">
                        <div class="col">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="<?= $tahun; ?>" required onchange="this.form.submit()">
                        </div>
                        <div class="col">
                            <label>Bulan</label>
                            <select name="bulan" class="form-select" onchange="this.form.submit()">
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
                        <div class="col">
                            <br>
                            <button class="btn btn-primary" onclick="printTable()">Print Laporan</button>
                        </div>
                    </div>
                </form>

                <!-- Tombol Print -->

                <!-- Div untuk Tabel Laporan -->
                <div id="printableArea">
                    <!-- Menampilkan informasi filter -->
                    <div class="alert alert-info mb-3">
                        <strong>Laporan Bulanan: </strong>
                        <?php
                        // Menampilkan bulan
                        $bulanNama = date('F', mktime(0, 0, 0, $bulan, 1));
                        echo "$bulanNama, $tahun";
                        // Menampilkan tanggal jika ada
                        if ($tanggal) {
                            echo ", Tanggal: $tanggal";
                        }
                        ?>
                    </div>

                    <!-- Tabel Laporan -->
                    <table class="table table-hover table-borderless align-middle">
                        <thead>
                            <tr class="table-primary">
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($data)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data transaksi untuk periode ini.</td>
                                </tr>
                            <?php else: ?>
                                <?php
                                $totalPendapatan = 0;
                                foreach ($data as $transaksi):
                                    $pendapatan = $transaksi['total_jumlah'] * $transaksi['harga'];
                                    $totalPendapatan += $pendapatan;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars(ucwords($transaksi['nama_produk'])); ?></td>
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
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script>
    function printTable() {
        var printContent = document.getElementById('printableArea');
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>Laporan Detail Transaksi</title>');
        printWindow.document.write('<style>body{font-family: Arial, sans-serif;} table {width: 100%; border-collapse: collapse;} th, td {padding: 8px; text-align: left;} th {background-color: #f2f2f2;} tr:nth-child(even) {background-color: #f9f9f9;} .alert-info {font-weight: bold;} </style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContent.innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
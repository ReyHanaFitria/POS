<?php
include "header.php";
include '../koneksi.php';
include "../logic/functions.php";

$tahun = isset($_POST['tahun']) ? intval($_POST['tahun']) : date('Y');

// Ambil data transaksi bulanan
try {
    $dataBulanan = ambilDataDetailTransaksiPerBulan($mysqli, $tahun);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// Inisialisasi data untuk grafik
$labels = [];
$data = [];

for ($i = 1; $i <= 12; $i++) {
    $labels[] = date('F', mktime(0, 0, 0, $i, 1));
    $data[] = $dataBulanan[$i]['total'] ?? 0; // Jika tidak ada transaksi, set 0
}

?>

<div id="content">
    <div class="container mt-2">
        <div class="card shadow-lg border-0 mb-4" style="backdrop-filter: blur(10px); --bs-card-bg: none; ">
            <div class="card-header">
                <h5 class="text-dark mt-2">Dashboard Transaksi Per Bulan</h5>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="row mb-3">
                        <div class="col">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="<?= $tahun; ?>" required onchange="this.form.submit()">
                        </div>
                    </div>
                </form>

                <canvas id="transaksiChart"></canvas>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<!-- Tambahkan library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk grafik
    const labels = <?= json_encode($labels) ?>;
    const data = <?= json_encode($data) ?>;

    // Inisialisasi grafik menggunakan Chart.js
    const ctx = document.getElementById('transaksiChart').getContext('2d');
    const transaksiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            }
        }
    });
</script>
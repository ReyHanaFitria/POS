<?php
include "../koneksi.php";
include "../class/Transaksi.php";
include "header.php";
include "navbar.php";

$transaksi = new Transaksi($mysqli);

// Ambil data produk dari database
$result_produk = $mysqli->query("SELECT id_produk, nama_produk, harga, stok FROM produk");

// Ambil data pelanggan dari database
$result_pelanggan = $mysqli->query("SELECT PelangganID, NamaPelanggan FROM pelanggan");

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $total_harga = $_POST['total_harga'];
    $uang = $_POST['uang'];
    $kembalian = $_POST['kembalian'];
    $id_customer = $_POST['id_customer'] ?? null; // Jika customer belum dipilih, maka id_customer nya NULL
    $id_transaksi = $transaksi->tambahTransaksi($tanggal, $total_harga, $uang, $kembalian, $id_customer);

    // Loop untuk menambah detail transaksi
    foreach ($_POST['produk'] as $produk) {
        $id_produk = $produk['id_produk'];
        $jumlah = $produk['jumlah'];
        $harga = $produk['harga'];

        // Tambah detail transaksi
        $transaksi->tambahDetailTransaksi($id_transaksi, $id_produk, $jumlah, $harga);

        // Kurangi stok produk menggunakan metode di kelas Transaksi
        try {
            $transaksi->kurangiStok($id_produk, $jumlah);
        } catch (Exception $e) {
            // Alihkan kembali dengan pesan kesalahan
            header("location:tambah_transaksi.php?pesan=gagal&error=" . urlencode($e->getMessage()));
            exit; // Hentikan eksekusi jika terjadi kesalahan
        }
    }

    // Setelah transaksi berhasil ditambahkan
    echo "<script>
        alert('Transaksi berhasil ditambahkan!');
        window.location.href = 'print_transaksi.php?id=' + $id_transaksi;
      </script>";
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
            /* Latar belakang terang */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Font modern */
        }

        .container {
            max-width: 900px;
            /* Lebar maksimum kontainer */
            margin-top: 50px;
            /* Jarak atas kontainer */
            background-color: white;
            /* Latar belakang putih */
            border-radius: 0.5rem;
            /* Sudut membulat */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Bayangan */
            padding: 30px;
            /* Padding di dalam kontainer */
        }

        h2 {
            text-align: center;
            /* Pusatkan judul */
            color: #343a40;
            /* Warna judul */
            margin-bottom: 30px;
            /* Jarak bawah judul */
        }

        .btn-primary {
            background-color: #007bff;
            /* Warna tombol simpan */
            border-color: #007bff;
            /* Warna border tombol */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Warna saat hover */
            border-color: #004085;
            /* Warna border saat hover */
        }

        .alert {
            margin-top: 20px;
            /* Jarak atas alert */
        }

        .detail-item {
            border: 1px solid #dee2e6;
            /* Border detail item */
            border-radius: 0.5rem;
            /* Sudut membulat */
            padding: 15px;
            /* Padding di dalam detail item */
            background-color: #f1f1f1;
            /* Latar belakang detail item */
            margin-bottom: 15px;
            /* Jarak bawah detail item */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Tambah Transaksi</h2>
        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php
                if ($_GET['pesan'] == "gagal") {
                    echo htmlspecialchars($_GET['error']);
                }
                ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="tambah_transaksi.php">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="id_customer" class="form-label">Pelanggan (Opsional)</label>
                <select name="id_customer" class="form-control select-pelanggan">
                    <option value="" disabled selected>Pilih Pelanggan</option>
                    <?php while ($row = $result_pelanggan->fetch_assoc()): ?>
                        <option value="<?= $row['PelangganID'] ?>">
                            <?= $row['NamaPelanggan'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="total_harga" class="form-label">Total Harga</label>
                <input type="number" name="total_harga" id="total_harga" class="form-control" readonly>
            </div>
            <div id="detail-container">
                <h4>Detail Transaksi</h4>
                <div class="detail-item">
                    <select name="produk[0][id_produk]" class="form-control select-produk mb-2" required onchange="setHarga(this, 0)">
                        <option value="" disabled selected>Pilih Produk</option>
                        <?php while ($row = $result_produk->fetch_assoc()): ?>
                            <option value="<?= $row['id_produk'] ?>" data-harga="<?= $row['harga'] ?>" data-stok="<?= $row['stok'] ?>">
                                <?= ucwords($row['nama_produk']) ?> (Stok: <?= $row['stok'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <input type="number" name="produk[0][jumlah]" class="form-control my-3" placeholder="Jumlah" required oninput="hitungSubtotal(0)">
                    <input type="number" name="produk[0][harga]" class="form-control mb-2 harga-produk" placeholder="Harga" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="uang" class="form-label">Uang Pelanggan</label>
                <input type="number" name="uang" id="uang" class="form-control" required oninput="hitungKembalian()">
            </div>
            <div class="mb-3">
                <label for="kembalian" class="form-label">Kembalian</label>
                <input type="number" name="kembalian" id="kembalian" class="form-control" readonly>
            </div>
            <button type="button" class="btn btn-outline-secondary" onclick="tambahDetail()">Tambah Produk</button>
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let detailIndex = 1;

        // Inisialisasi Select2
        $(document).ready(function() {
            $('.select-produk').select2({
                placeholder: "Pilih Produk",
                allowClear: true
            });
            $('.select-pelanggan').select2({
                placeholder: "Pilih Pelanggan",
                allowClear: true
            });
        });

        // Fungsi untuk menambah form detail transaksi
        function tambahDetail() {
            const container = document.getElementById('detail-container');
            const newItem = document.createElement('div');
            newItem.classList.add('detail-item');
            newItem.innerHTML = `
                <select name="produk[${detailIndex}][id_produk]" class="form-control select-produk mb-2" required onchange="setHarga(this, ${detailIndex})">
                    <option value="" disabled selected>Pilih Produk</option>
                    <?php
                    $result_produk = $mysqli->query("SELECT id_produk, nama_produk, harga, stok FROM produk");
                    while ($row = $result_produk->fetch_assoc()): ?>
                        <option value="<?= $row['id_produk'] ?>" data-harga="<?= $row['harga'] ?>" data-stok="<?= $row['stok'] ?>">
                            <?= $row['nama_produk'] ?> (Stok: <?= $row['stok'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
                <input type="number" name="produk[${detailIndex}][jumlah]" class="form-control my-3" placeholder="Jumlah" required oninput="hitungSubtotal(${detailIndex})">
                <input type="number" name="produk[${detailIndex}][harga]" class="form-control mb-2 harga-produk" placeholder="Harga" readonly>
            `;
            container.appendChild(newItem);
            $('.select-produk').select2(); // Re-inisialisasi Select2
            detailIndex++;
        }

        // Set harga produk otomatis saat dipilih
        function setHarga(select, index) {
            const harga = select.options[select.selectedIndex].getAttribute('data-harga');
            document.getElementsByName(`produk[${index}][harga]`)[0].value = harga;
            hitungSubtotal(index);
        }

        // Hitung subtotal dan total harga
        function hitungSubtotal(index) {
            const jumlah = document.getElementsByName(`produk[${index}][jumlah]`)[0].value || 0;
            const harga = document.getElementsByName(`produk[${index}][harga]`)[0].value || 0;
            const subtotal = jumlah * harga;

            // Hitung total harga
            let total = 0;
            document.querySelectorAll('.harga-produk').forEach((input, i) => {
                const qty = document.getElementsByName(`produk[${i}][jumlah]`)[0].value || 0;
                total += qty * input.value;
            });
            document.getElementById('total_harga').value = total;
        }

        function hitungKembalian() {
            const totalHarga = parseFloat(document.getElementById('total_harga').value) || 0;
            const uangCustomer = parseFloat(document.getElementById('uang').value) || 0;
            const kembalian = uangCustomer - totalHarga;
            document.getElementById('kembalian').value = kembalian >= 0 ? kembalian : 0; // Tidak boleh negatif
        }
    </script>
</body>

</html>

<?php include "footer.php"; ?>
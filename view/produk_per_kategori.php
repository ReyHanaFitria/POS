<?php
include "header.php";
include '../koneksi.php'; // Include database connection
include "../logic/functions.php"; // Include functions file

// Ambil id_kategori dari URL
$id_kategori = isset($_GET['id_kategori']) ? intval($_GET['id_kategori']) : 0;

try {
    // Fetch products from the database based on category
    $data = ambilDataProdukByKategori($mysqli, $id_kategori);
} catch (Exception $e) {
    // Handle database error
    echo $e->getMessage(); ?>
    <br><br>
    <a href="data_kategori.php" class="btn btn-primary btn-sm">
        Kembali
    </a>
<?php
    include "footer.php";
    exit();
}
?>

<div id="content">
    <div class="card-body">
        <a href="data_kategori.php" class="btn btn-primary btn-sm">
            Kembali
        </a>
    </div>
    <div class="card mt-2">
        <div class="card-header mt-2">
            <h5>Produk Kategori: <?= ucwords($data[0]['nama_kategori']); ?></h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle" style="--bs-table-bg: transparent !important;">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data as $produk) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= ucwords($produk['nama_produk']); ?></td>
                                <td>Rp. <?= number_format($produk['harga'], 0, ',', '.'); ?></td>
                                <td><?= $produk['stok']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
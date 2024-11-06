<?php
include "header.php";
include '../koneksi.php'; // Koneksi ke database
include "../logic/functions.php"; // Include file fungsi

try {
    $data = ambilDataProduk($mysqli); // Ambil data produk
    $kategoriQuery = $mysqli->query("SELECT * FROM kategori_produk"); // Ambil data kategori
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

$kategoriArray = [];
while ($kategori = $kategoriQuery->fetch_assoc()) {
    $kategoriArray[] = $kategori;
}
?>

<div id="content">
    <div class="container mt-2">
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambah-data">
                    Tambah Data
                </button>
                <?php if (isset($_GET['pesan'])) { ?>
                    <div class="alert alert-success" role="alert">
                        Data Berhasil di <?= ucfirst($_GET['pesan']); ?>
                    </div>
                <?php } ?>

                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle" style="--bs-table-bg: transparent !important;">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($d = mysqli_fetch_array($data)) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= ucwords($d['nama_produk']); ?></td>
                                    <td><?= ucwords($d['nama_kategori'] ?? "*belum di set"); ?></td>
                                    <td>Rp. <?= number_format($d['harga'], 0, ',', '.'); ?></td>
                                    <td><?= $d['stok']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?= $d['id_produk']; ?>">Edit</button>
                                        <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 1): ?>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?= $d['id_produk']; ?>">Hapus</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Modal edit data -->
                                <div class="modal fade" id="edit-data<?= $d['id_produk']; ?>" data-bs-backdrop="false" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                                <h5 class="modal-title">Edit Produk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="proses_update_barang.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_produk" value="<?= $d['id_produk']; ?>">
                                                    <div class="mb-3">
                                                        <label>Nama Produk</label>
                                                        <input type="text" name="nama_produk" class="form-control" value="<?= $d['nama_produk']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Kategori Produk</label>
                                                        <select name="id_kategori" class="form-control" required>
                                                            <option value="">Pilih Kategori</option>
                                                            <?php foreach ($kategoriArray as $kategori) {
                                                                $selected = ($kategori['id_kategori'] == $d['id_kategori']) ? 'selected' : '';
                                                                echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama_kategori']}</option>";
                                                            } ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Harga Produk</label>
                                                        <input type="number" name="harga" class="form-control" value="<?= $d['harga']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Stok Produk</label>
                                                        <input type="number" name="stok" class="form-control" value="<?= $d['stok']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal hapus data -->
                                <div class="modal fade" id="hapus-data<?= $d['id_produk']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Hapus Produk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="post" action="delete_product.php">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_produk" value="<?= $d['id_produk']; ?>">
                                                    Apakah anda yakin akan menghapus data <b><?= $d['nama_produk']; ?></b>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal tambah data -->
        <div class="modal fade" id="tambah-data" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="add_product.php" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Kategori Produk</label>
                                <select name="id_kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($kategoriArray as $kategori) {
                                        echo "<option value='{$kategori['id_kategori']}'>{$kategori['nama_kategori']}</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Harga Produk</label>
                                <input type="number" name="harga" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Stok Produk</label>
                                <input type="number" name="stok" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
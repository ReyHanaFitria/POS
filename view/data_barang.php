<?php
include "header.php";
include "navbar.php";
include '../koneksi.php'; // Include database connection
include "../logic/functions.php"; // Include functions file

try {
    // Fetch products from the database
    $data = ambilDataProduk($mysqli);
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

<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .card {
        border-radius: 0.5rem;
        transition: transform 0.3s;
        margin-bottom: 20px;
    }

    .table {
        background-color: white;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-info {
        background-color: #17a2b8;
    }

    .btn-info:hover {
        background-color: #138496;
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .modal-header {
        background-color: #f1f1f1;
    }
</style>

<div class="card mt-2">
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah-data">
            Tambah Data
        </button>
    </div>

    <div class="card-body">
        <?php
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "simpan") { ?>
                <div class="alert alert-success" role="alert">
                    Data Berhasil di Simpan
                </div>
            <?php } ?>
            <?php if ($_GET['pesan'] == "update") { ?>
                <div class="alert alert-success" role="alert">
                    Data Berhasil di Update
                </div>
            <?php } ?>
            <?php if ($_GET['pesan'] == "hapus") { ?>
                <div class="alert alert-success" role="alert">
                    Data Berhasil di Hapus
                </div>
            <?php } ?>
        <?php } ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th> <!-- Tambahkan kolom kategori -->
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= ucwords($d['nama_produk']); ?></td>
                        <td><?= ucwords($d['nama_kategori'] ?? "*belum di set"); ?></td> <!-- Tampilkan kategori -->
                        <td>Rp. <?= number_format($d['harga'], 0, ',', '.'); ?></td>
                        <td><?= $d['stok']; ?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?= $d['id_produk']; ?>">Edit </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?= $d['id_produk']; ?>">Hapus</button>
                        </td>
                    </tr>

                    <!-- Modal edit data -->
                    <div class="modal fade" id="edit-data<?= $d['id_produk']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $d['id_produk']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel<?= $d['id_produk']; ?>">EDIT</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="proses_update_barang.php" method="post">
                                    <div class="modal-body">
                                        <div class="form-group mb-3">
                                            <label>Nama Produk</label>
                                            <input type="hidden" name="id_produk" value="<?= $d['id_produk']; ?>">
                                            <input type="text" name="nama_produk" class="form-control" value="<?= $d['nama_produk']; ?>" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Kategori Produk</label>
                                            <select name="id_kategori" class="form-control" required>
                                                <option value="">Pilih Kategori</option>
                                                <?php
                                                foreach ($kategoriArray as $kategori) {
                                                    // Cek apakah kategori saat ini adalah kategori produk yang sedang diedit
                                                    $selected = ($kategori['id_kategori'] == $d['id_kategori']) ? 'selected' : '';
                                                    echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama_kategori']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Harga Produk</label>
                                            <input type="number" name="harga" class="form-control" value="<?= $d['harga']; ?>" required>
                                        </div>
                                        <div class="form-group mb-3">
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
                    <div class="modal fade" id="hapus-data<?= $d['id_produk']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel<?= $d['id_produk']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="hapusModalLabel<?= $d['id_produk']; ?>">HAPUS</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

<!-- Modal tambah data -->
<div class="modal fade" id="tambah-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="add_product.php" method="post">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Kategori Produk</label>
                        <select name="id_kategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            foreach ($kategoriArray as $kategori) {
                                // Cek apakah kategori saat ini adalah kategori produk yang sedang diedit
                                $selected = ($kategori['id_kategori'] == $d['id_kategori']) ? 'selected' : '';
                                echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama_kategori']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Harga Produk</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Stok Produk</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
<?php
include "header.php";
include "navbar.php";
include '../koneksi.php'; // Include database connection
include "../logic/functions.php"; // Include functions file

try {
    // Fetch products from the database
    $data = ambilDataProduk($mysqli);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<style>
    body {
        background-color: #f8f9fa;
        /* Latar belakang terang */
        font-family: Arial, sans-serif;
        /* Font yang lebih modern */
    }

    .card {
        border-radius: 0.5rem;
        /* Sudut membulat */
        transition: transform 0.3s;
        /* Transisi halus */
        margin-bottom: 20px;
        /* Jarak antar kartu */
    }

    .table {
        background-color: white;
        /* Warna latar tabel */
        border-radius: 0.5rem;
        /* Sudut tabel membulat */
        overflow: hidden;
        /* Menghindari elemen keluar dari tabel */
    }

    .table th,
    .table td {
        vertical-align: middle;
        /* Penempatan konten di tengah */
    }

    .btn-primary {
        background-color: #007bff;
        /* Warna tombol */
        border-color: #007bff;
        /* Warna border tombol */
    }

    .btn-primary:hover {
        background-color: #0056b3;
        /* Warna latar belakang saat hover */
    }

    .btn-info {
        background-color: #17a2b8;
        /* Warna tombol edit */
    }

    .btn-info:hover {
        background-color: #138496;
        /* Warna latar belakang saat hover */
    }

    .btn-danger {
        background-color: #dc3545;
        /* Warna tombol hapus */
    }

    .btn-danger:hover {
        background-color: #c82333;
        /* Warna latar belakang saat hover */
    }

    .modal-header {
        background-color: #f1f1f1;
        /* Warna latar belakang header modal */
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
                                        <div class="form-group">
                                            <label>Nama Produk</label>
                                            <input type="hidden" name="id_produk" value="<?= $d['id_produk']; ?>">
                                            <input type="text" name="nama_produk" class="form-control" value="<?= $d['nama_produk']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Produk</label>
                                            <input type="number" name="harga" class="form-control" value="<?= $d['harga']; ?>" required>
                                        </div>
                                        <div class="form-group">
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
                                <form method="post" action="proses_hapus_barang.php">
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
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Produk</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                    <div class="form-group">
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

<?php
include "footer.php";
?>
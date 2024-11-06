<?php
include "header.php";
include '../koneksi.php'; // Include database connection
include "../logic/functions.php"; // Include functions file

try {
    // Fetch products from the database
    $data = ambilDataCategory($mysqli);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<div id="content">
    <div class="container mt-2">
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambah-data">
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
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle" style="--bs-table-bg: transparent !important;">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
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
                                    <td>
                                        <a href="produk_per_kategori.php?id_kategori=<?= $d['id_kategori']; ?>" class="text-decoration-none">
                                            <?= ucwords($d['nama_kategori']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit-data<?= $d['id_kategori']; ?>">Edit </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-data<?= $d['id_kategori']; ?>">Hapus</button>
                                    </td>
                                </tr>

                                <!-- Modal edit data -->
                                <div class="modal fade" id="edit-data<?= $d['id_kategori']; ?>" tabindex="-1" data-bs-backdrop="false" aria-labelledby="editModalLabel<?= $d['id_kategori']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editModalLabel<?= $d['id_kategori']; ?>">EDIT</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="proses_update_kategori.php" method="post">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Kategori</label>
                                                        <input type="hidden" name="id_kategori" value="<?= $d['id_kategori']; ?>">
                                                        <input type="text" name="nama_kategori" class="form-control" value="<?= $d['nama_kategori']; ?>" required>
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
                                <div class="modal fade" id="hapus-data<?= $d['id_kategori']; ?>" tabindex="-1" data-bs-backdrop="false" aria-labelledby="hapusModalLabel<?= $d['id_kategori']; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="hapusModalLabel<?= $d['id_kategori']; ?>">HAPUS</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="delete_category.php">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_kategori" value="<?= $d['id_kategori']; ?>">
                                                    Apakah anda yakin akan menghapus data <b><?= $d['nama_kategori']; ?></b>?
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
        <div class="modal fade" id="tambah-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="add_category.php" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" name="nama_kategori" class="form-control" required>
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
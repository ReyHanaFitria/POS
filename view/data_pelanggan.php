<?php
include "header.php";
include "../koneksi.php"; // Include database connection
include "../logic/functions.php"; // Include functions file

try {
    // Fetch customers from the database
    $result = ambilDataPelanggan($mysqli);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<div id="content">
    <div class="container mt-2">
        <div class="card shadow-lg border-0 mb-4" style="backdrop-filter: blur(10px);">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambah-data">
                    Tambah Data
                </button>
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
                <table class="table table-hover table-borderless align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Nomor HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $pelanggan): ?>
                            <tr>
                                <td><?php echo $pelanggan['PelangganID']; ?></td>
                                <td><?php echo $pelanggan['NamaPelanggan']; ?></td>
                                <td><?php echo $pelanggan['Alamat']; ?></td>
                                <td><?php echo $pelanggan['NomorTelepon']; ?></td>
                                <td>
                                    <a href="edit_customer.php?id=<?php echo $pelanggan['PelangganID']; ?>" class="btn btn-info btn-sm">Edit</a>
                                    <a href="delete_customer.php?id=<?php echo $pelanggan['PelangganID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
                    <h5 class="modal-title">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="add_customer.php">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="nama_pelanggan" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Address</label>
                            <textarea class="form-control" name="alamat" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="nomor_telepon" required>
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

<?php
include "footer.php";
?>
<?php
// Kode lainnya untuk menampilkan data pengguna
include "header.php";
include "navbar.php";
include "../koneksi.php"; // Include database connection
include "../logic/functions.php"; // Pastikan untuk menyertakan file functions.php

// Cek apakah pengguna sudah login dan memiliki level yang sesuai
if (!isset($_SESSION['level']) || $_SESSION['level'] != 1) {
    // Jika tidak, alihkan ke halaman beranda atau halaman lain
    header("Location: index.php");
    exit();
}
// Fetch users from the database
try {
    $result = ambilDataPetugas($mysqli);
} catch (Exception $e) {
    echo "<div class='alert alert-danger' role='alert'>" . $e->getMessage() . "</div>";
    exit;
}
?>

<div id="content">
    <div class="container mt-2">
        <a href="add_user.php" class="btn btn-primary mb-3">Tambah Pengguna</a>
        <div class="card shadow-lg border-0 mb-4">
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
                <?php
                }
                ?>
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle" style="--bs-table-bg: transparent !important;">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Level</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $user): ?>
                                <tr>
                                    <td><?php echo $user['id_petugas']; ?></td>
                                    <td><?php echo $user['nama_petugas']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['level']; ?></td>
                                    <td>
                                        <a href="edit_user.php?id=<?php echo $user['id_petugas']; ?>" class="btn btn-warning">Edit</a>
                                        <a href="delete_user.php?id=<?php echo $user['id_petugas']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
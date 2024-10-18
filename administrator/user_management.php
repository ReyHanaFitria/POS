<?php
include "header.php";
include "navbar.php";
include "../koneksi.php"; // Include database connection

// Fetch users from the database
$result = $mysqli->query("SELECT * FROM petugas");

?>

<div class="container mt-4">
    <h2>Data Pengguna</h2>
    <a href="add_user.php" class="btn btn-primary mb-3">Tambah Pengguna</a>
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
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_petugas']; ?></td>
                    <td><?php echo $row['nama_petugas']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['level']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['id_petugas']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_user.php?id=<?php echo $row['id_petugas']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
include "footer.php";
?>
<?php
include "header.php";
include "navbar.php";
include "../koneksi.php"; // Include database connection

// Fetch customers from the database
$result = $mysqli->query("SELECT * FROM pelanggan");

?>

<div class="container mt-4">
    <h2>Data Pelanggan</h2>
    <a href="add_customer.php" class="btn btn-primary mb-3">Tambah Pelanggan</a>
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
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Nomor HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['PelangganID']; ?></td>
                    <td><?php echo $row['NamaPelanggan']; ?></td>
                    <td><?php echo $row['Alamat']; ?></td>
                    <td><?php echo $row['NomorTelepon']; ?></td>
                    <td>
                        <a href="edit_customer.php?id=<?php echo $row['PelangganID']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_customer.php?id=<?php echo $row['PelangganID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
include "footer.php";
?>
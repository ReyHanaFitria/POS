<?php
include "header.php";
include "navbar.php";
include "../koneksi.php"; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];

    // Insert customer into the database
    $stmt = $mysqli->prepare("INSERT INTO pelanggan (NamaPelanggan, Alamat, NomorTelepon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama_pelanggan, $alamat, $nomor_telepon);
    $stmt->execute();

    header("Location: customer_management.php?pesan=simpan");
    exit();
}
?>

<div class="container mt-4">
    <h2>Tambah Pelanggan</h2>

    <form method="post" action="">
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
        <button type="submit" class="btn btn-primary mt-3">Tambah Pelanggan</h2>
        </button>
    </form>
</div>

<?php
include "footer.php";
?>
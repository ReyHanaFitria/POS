<?php
include "header.php";
include "navbar.php";
include "../koneksi.php"; // Include database connection
include "../logic/functions.php"; // Include functions file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];

    try {
        // Panggil fungsi untuk menambahkan pelanggan
        tambahPelanggan($mysqli, $nama_pelanggan, $alamat, $nomor_telepon);
        header("Location: data_pelanggan.php?pesan=simpan");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
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
        <button type="submit" class="btn btn-primary mt-3">Tambah Pelanggan</button>
    </form>
</div>

<?php
include "footer.php";
?>
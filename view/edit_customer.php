<?php
include "header.php";
include "navbar.php";
include "../koneksi.php"; // Include database connection
include "../logic/functions.php"; // Include functions file

if (isset($_GET['id'])) {
    $pelanggan_id = $_GET['id'];

    try {
        // Ambil data pelanggan dari database
        $customer = ambilDataPelanggan($mysqli, $pelanggan_id);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

// Proses pembaruan data pelanggan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];

    try {
        // Update customer in the database
        updatePelanggan($mysqli, $pelanggan_id, $nama_pelanggan, $alamat, $nomor_telepon);
        header("Location: data_pelanggan.php?pesan=update");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>

<div class="container mt-4">
    <h2>Edit Pelanggan</h2>
    <form method="post" action="">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="nama_pelanggan" value="<?php echo htmlspecialchars($customer['NamaPelanggan']); ?>" required>
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea class="form-control" name="alamat" required><?php echo htmlspecialchars($customer['Alamat']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" class="form-control" name="nomor_telepon" value="<?php echo htmlspecialchars($customer['NomorTelepon']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Pelanggan</button>
    </form>
</div>

<?php
include "footer.php";
?>
<?php
include "header.php";
include "navbar.php";
include "../koneksi.php"; // Include database connection

if (isset($_GET['id'])) {
    $pelanggan_id = $_GET['id'];

    // Fetch customer data from the database
    $stmt = $mysqli->prepare("SELECT * FROM pelanggan WHERE PelangganID = ?");
    $stmt->bind_param("i", $pelanggan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];

    // Update customer in the database
    $stmt = $mysqli->prepare("UPDATE pelanggan SET NamaPelanggan = ?, Alamat = ?, NomorTelepon = ? WHERE PelangganID = ?");
    $stmt->bind_param("sssi", $nama_pelanggan, $alamat, $nomor_telepon, $pelanggan_id);
    $stmt->execute();

    header("Location: customer_management.php?pesan=update");
    exit();
}
?>

<div class="container mt-4">
    <h2>Edit Pelanggan</h2>
    <form method="post" action="">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="nama_pelanggan" value="<?php echo $customer['NamaPelanggan']; ?>" required>
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea class="form-control" name="alamat" required><?php echo $customer['Alamat']; ?></textarea>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" class="form-control" name="nomor_telepon" value="<?php echo $customer['NomorTelepon']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Pelanggan</button>
    </form>
</div>

<?php
include "footer.php";
?>
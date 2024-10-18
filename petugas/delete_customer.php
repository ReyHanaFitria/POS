<?php
include "../koneksi.php"; // Include database connection

if (isset($_GET['id'])) {
    $pelanggan_id = $_GET['id'];

    // Delete customer from the database
    $stmt = $mysqli->prepare("DELETE FROM pelanggan WHERE PelangganID = ?");
    $stmt->bind_param("i", $pelanggan_id);
    $stmt->execute();

    header("Location: customer_management.php?pesan=hapus");
    exit();
}

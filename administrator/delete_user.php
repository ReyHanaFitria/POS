<?php
include "../koneksi.php"; // Include database connection

if (isset($_GET['id'])) {
    $id_petugas = $_GET['id'];

    // Delete user from the database
    $stmt = $mysqli->prepare("DELETE FROM petugas WHERE id_petugas = ?");
    $stmt->bind_param("i", $id_petugas);
    $stmt->execute();

    header("Location: user_management.php?pesan=hapus");
    exit();
}

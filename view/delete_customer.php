<?php
include "../koneksi.php"; // Include database connection
include "../logic/functions.php"; // Include functions file

if (isset($_GET['id'])) {
    $pelanggan_id = $_GET['id'];

    try {
        // Hapus pelanggan dari database
        hapusPelanggan($mysqli, $pelanggan_id);
        echo '<script>window.location.href = "data_pelanggan.php?pesan=hapus"; </script>';
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

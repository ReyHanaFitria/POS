<?php
session_start(); // Pastikan session dimulai

// Cek apakah pengguna sudah login dan memiliki level yang sesuai
if (!isset($_SESSION['level']) || $_SESSION['level'] != 1) {
    // Jika tidak, alihkan ke halaman beranda atau halaman lain
    header("Location: index.php");
    exit();
}

include "../koneksi.php"; // Include database connection
include "../logic/functions.php"; // Include functions file

if (isset($_GET['id'])) {
    $id_petugas = $_GET['id'];

    try {
        // Hapus petugas dari database
        hapusPetugas($mysqli, $id_petugas);
        echo '<script>window.location.href = "user_management.php?pesan=hapus"; </script>';
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

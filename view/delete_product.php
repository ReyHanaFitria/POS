<?php
include '../koneksi.php';
include '../logic/functions.php'; // Pastikan untuk menyertakan file functions.php

// Menangkap data id yang dikirim dari form
$id_produk = $_POST['id_produk']; // Pastikan nama input di form sesuai

try {
    // Menghapus data dari database
    hapusProduk($mysqli, $id_produk);

    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_barang.php?pesan=hapus");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} catch (Exception $e) {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . $e->getMessage();
}

// Menutup koneksi
$mysqli->close();

<?php
include '../koneksi.php';
include '../logic/functions.php'; // Pastikan untuk menyertakan file functions.php

// Menangkap data id yang dikirim dari form
$id_kategori = $_POST['id_kategori']; // Pastikan nama input di form sesuai

try {
    // Menghapus data dari database
    hapusKategori($mysqli, $id_kategori);

    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_kategori.php?pesan=hapus");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} catch (Exception $e) {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . $e->getMessage();
}

// Menutup koneksi
$mysqli->close();

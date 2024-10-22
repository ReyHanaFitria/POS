<?php
// Koneksi database
include '../koneksi.php';
include '../logic/functions.php'; // Pastikan untuk menyertakan file functions.php

// Menangkap data yang dikirim dari form
$kategoriID = $_POST['id_kategori']; // Pastikan nama input di form sesuai
$namaKategori = $_POST['nama_kategori'];


try {
    // Update data ke database
    updateKategori($mysqli, $kategoriID, $namaKategori);

    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_kategori.php?pesan=update");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} catch (Exception $e) {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . $e->getMessage();
}

// Menutup koneksi
$mysqli->close();

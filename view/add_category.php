<?php
// Koneksi database
include '../koneksi.php';
include '../logic/functions.php'; // Pastikan untuk menyertakan file functions.php

// Menangkap data yang dikirim dari form
$nama_kategori = $_POST['nama_kategori']; // Pastikan nama input di form sesuai

try {
    // Menginput data ke database
    simpanKategri($mysqli, $nama_kategori);

    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_kategori.php?pesan=simpan");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} catch (Exception $e) {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . $e->getMessage();
}

// Menutup koneksi
$mysqli->close();

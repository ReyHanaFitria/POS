<?php
// Koneksi database
include '../koneksi.php';
include 'functions.php'; // Pastikan untuk menyertakan file functions.php

// Menangkap data yang dikirim dari form
$namaProduk = $_POST['nama_produk']; // Pastikan nama input di form sesuai
$harga = $_POST['harga'];
$stok = $_POST['stok'];

try {
    // Menginput data ke database
    simpanProduk($mysqli, $namaProduk, $harga, $stok);

    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_barang.php?pesan=simpan");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} catch (Exception $e) {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . $e->getMessage();
}

// Menutup koneksi
$mysqli->close();

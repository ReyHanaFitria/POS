<?php
// Koneksi database
include '../koneksi.php';
include '../logic/functions.php'; // Pastikan untuk menyertakan file functions.php

// Menangkap data yang dikirim dari form
$namaProduk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

try {
    // Tambah data ke database
    tambahProduk($mysqli, $namaProduk, $harga, $stok);

    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_barang.php?pesan=tambah");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} catch (Exception $e) {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . $e->getMessage();
}

// Menutup koneksi
$mysqli->close();

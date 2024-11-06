<?php
// Koneksi database
include '../koneksi.php';
include '../logic/functions.php'; // Pastikan untuk menyertakan file functions.php

// Menangkap data yang dikirim dari form
$idProduk = $_POST['id_produk']; // Pastikan nama input di form sesuai
$idKategori = $_POST['id_kategori']; // Pastikan nama input di form sesuai
$namaProduk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

try {
    // Update data ke database
    updateProduk($mysqli, $idProduk, $namaProduk, $harga, $stok, $idKategori);

    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_barang.php?pesan=update");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} catch (Exception $e) {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . $e->getMessage();
}

// Menutup koneksi
$mysqli->close();

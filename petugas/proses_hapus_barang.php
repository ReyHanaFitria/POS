<?php
include '../koneksi.php';

// Menangkap data id yang dikirim dari form
$id_produk = $_POST['id_produk']; // Pastikan nama input di form sesuai

// Menghapus data dari database
$query = "DELETE FROM produk WHERE id_produk='$id_produk'";
$result = $mysqli->query($query);

// Cek apakah query berhasil
if ($result) {
    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_barang.php?pesan=hapus");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} else {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . $mysqli->error;
}

// Menutup koneksi
$mysqli->close();

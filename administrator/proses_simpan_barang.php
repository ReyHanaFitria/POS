<?php
// Koneksi database
include '../koneksi.php';

// Menangkap data yang dikirim dari form
$namaProduk = $_POST['nama_produk']; // Pastikan nama input di form sesuai
$harga = $_POST['harga'];
$stok = $_POST['stok'];

// Menginput data ke database
$query = "INSERT INTO produk (nama_produk, harga, stok) VALUES ('$namaProduk', '$harga', '$stok')";
$result = mysqli_query($mysqli, $query);

// Cek apakah query berhasil
if ($result) {
    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_barang.php?pesan=simpan");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} else {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . mysqli_error($mysqli);
}

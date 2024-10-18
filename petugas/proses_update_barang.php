<?php
// Koneksi database
include '../koneksi.php';

// Menangkap data yang dikirim dari form
$produkID = $_POST['id_produk']; // Pastikan nama input di form sesuai
$namaProduk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

// Update data ke database
$query = "UPDATE produk SET nama_produk='$namaProduk', harga='$harga', stok='$stok' WHERE id_produk='$produkID'";
$result = mysqli_query($mysqli, $query);

// Cek apakah query berhasil
if ($result) {
    // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
    header("Location: data_barang.php?pesan=update");
    exit(); // Pastikan untuk menghentikan script setelah redirect
} else {
    // Jika gagal, tampilkan pesan error
    echo "Error: " . mysqli_error($mysqli);
}

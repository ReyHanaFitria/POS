<?php
include "header.php";
include "../koneksi.php"; // Include database connection
include "../logic/functions.php"; // Include functions file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];

    try {
        // Panggil fungsi untuk menambahkan pelanggan
        tambahPelanggan($mysqli, $nama_pelanggan, $alamat, $nomor_telepon);

        // Mengalihkan halaman kembali ke data_barang.php dengan pesan sukses
        echo "<script>
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });
          Toast.fire({
            icon: 'success',
            title: 'Pelanggan Berhasil ditambahkan!'
          }).then(() => {
            window.location.href = 'data_pelanggan.php?pesan=simpan';
        });
        </script>";
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

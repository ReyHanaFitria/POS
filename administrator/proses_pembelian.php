<?php 
// koneksi database
include '../koneksi.php';
 
// menangkap data yang di kirim dari form
$PelangganID = $_POST['PelangganID'];
$NamaPelanggan = $_POST['NamaPelanggan'];
$NoTelepon = $_POST['NoTelepon'];
$Alamat = $_POST['Alamat'];
$TanggalPenjualan = $_POST['TanggalPenjualan'];
 
// menginput data ke database
mysqli_query($koneksi,"insert into pelanggan values('PelangganID','$NamaPelanggan','$NoTelepon','$Alamat')");
mysqli_query($koneksi,"insert into penjualan values('','$TanggalPenjualan','','$PelangganID')");
 
// mengalihkan halaman kembali ke pembelian.php
header("location:pembelian.php?pesan=simpan");
 
?>
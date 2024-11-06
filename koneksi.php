<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "pos";

// Koneksi ke database
$mysqli = new mysqli($host, $user, $pass, $db_name);

// Cek koneksi
if ($mysqli->connect_error) {
	die("Koneksi gagal: " . $mysqli->connect_error);
}

// Function tambahan untuk memformat tanggal
function formatTanggal($tanggal)
{
	// Mengubah string tanggal menjadi objek DateTime
	$dateTime = new DateTime($tanggal);

	// Mendapatkan nama bulan dalam bahasa Indonesia
	$bulan = [
		1 => 'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Desember'
	];

	// Mengambil hari, bulan, dan tahun
	$hari = $dateTime->format('d');
	$bulanIndex = $dateTime->format('n'); // Bulan dalam angka
	$tahun = $dateTime->format('Y');

	// Mengembalikan format yang diinginkan
	return $hari . ' ' . $bulan[$bulanIndex] . ' ' . $tahun;
}

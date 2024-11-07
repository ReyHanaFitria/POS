<?php
// Mulai sesi untuk mengambil data user
session_start();

// Contoh: Ambil nama user dari session (ubah sesuai kebutuhan)
$nama_user = isset($_SESSION['nama_petugas']) ? $_SESSION['nama_petugas'] : 'Pengguna';

// Fungsi logout
if (isset($_POST['logout'])) {
	session_destroy(); // Hapus semua sesi
	header("Location: login.php"); // Redirect ke halaman login
	exit;
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>SINOM CAFFE</title>
	<!-- Link font -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<!-- Include CSS Select2 -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

	<style>
		/* root */
		:root {
			--gradient-1: #FFB5E8;
			--gradient-2: #B8E1FF;
			--gradient-3: #AFF8DB;
		}

		#datatable_filter {
			margin-bottom: 1rem;
		}

		/* navbar */
		.glass-navbar {
			background: rgba(255, 255, 255, 0.1);
			backdrop-filter: blur(12px);
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		.fixed-top {
			z-index: 1030;
			/* Pastikan navbar tetap di atas konten lain */
		}

		/* footer */
		.fixed-bottom {
			position: fixed;
			bottom: 0;
			width: 100%;
			background: rgba(255, 255, 255, 0.3);
			backdrop-filter: blur(10px);
			box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
			z-index: 1000;
		}

		.glass-container {
			background: rgba(255, 255, 255, 0.1);
			border-radius: 8px;
			backdrop-filter: blur(10px);
		}

		/* Design */
		/* Skema Warna Pastel */
		/* Gaya dasar halaman */
		body {
			font-family: 'Poppins', sans-serif;
			background: linear-gradient(-45deg, var(--gradient-1), var(--gradient-2), var(--gradient-3));
			background-size: 1000% 1000%;
			animation: gradient 15s ease infinite;
		}

		/* Animasikan latar belakang gradien */
		@keyframes gradient {
			0% {
				background-position: 0% 50%;
			}

			50% {
				background-position: 100% 50%;
			}

			100% {
				background-position: 0% 50%;
			}
		}

		.btn-primary {
			background-color: #b8d8d8;
			/* Warna pastel hijau */
			border-color: #b8d8d8;
			color: #3b6978;
		}

		.btn-primary:hover {
			background-color: #9dc5c3;
			border-color: #9dc5c3;
		}

		.table-primary {
			background-color: #d9b8c4;
			/* Warna pastel pink */
			color: #3b3b58;
		}

		.table-hover tbody tr:hover {
			background-color: #e6f7f7;
			/* Warna latar belakang saat di-hover */
		}

		.modal-header.bg-primary,
		.modal-header.bg-info,
		.modal-header.bg-danger {
			background-color: rgba(255, 255, 255, 0.2);
			backdrop-filter: blur(10px);
			border-bottom: 1px solid rgba(255, 255, 255, 0.3);
			color: #3b6978;
		}

		/* Efek Glassmorphism pada Card */
		.card {
			background: rgba(255, 255, 255, 0.4);
			/* Transparansi untuk efek glass */
			border-radius: 15px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
			backdrop-filter: blur(10px);
			/* Efek blur */
			border: 1px solid rgba(255, 255, 255, 0.3);
			/* Border untuk efek glass */
		}

		/* Tambahan efek pada tabel */
		.table {
			/* Transparansi pada tabel */
			border-radius: 8px;
			overflow: hidden;
		}

		/* Efek pada modal */
		.modal-content {
			background: rgba(255, 255, 255, 0.7);
			/* Transparansi untuk efek glass */
			backdrop-filter: blur(10px);
			/* Efek blur */
			border-radius: 15px;
			border: 1px solid rgba(255, 255, 255, 0.3);
		}

		/* Tombol dengan warna pastel */
		.btn-info {
			background-color: #d4a5a5;
			/* Warna pastel pink muda */
			color: #3b3b58;
			border-color: #d4a5a5;
		}

		.btn-info:hover {
			background-color: #c78c8c;
			border-color: #c78c8c;
		}

		.btn-danger {
			background-color: #ffb3b3;
			/* Warna pastel merah muda */
			color: #8a2a2a;
			border-color: #ffb3b3;
		}

		.btn-danger:hover {
			background-color: #f09797;
			border-color: #f09797;
		}

		/* table */

		/* Mengatur gaya untuk tabel */
		.table {
			/* background: rgba(255, 255, 255, 0.4); */
			/* Transparansi */
			border-radius: 10px;
			/* Sudut bulat */
			backdrop-filter: blur(10px);
			/* Efek blur */
			/* Border dengan transparansi */
			margin-top: 20px;
			/* Jarak atas tabel */
		}

		.table-hover tbody tr:hover {
			background-color: rgba(0, 123, 255, 0.2);
			/* Efek hover untuk baris tabel */
		}
	</style>
</head>

<body>

	<?php include 'navbar.php' ?>

	<div class="container" style="margin-bottom: 5rem; margin-top: 5rem;">
		<div class="content">
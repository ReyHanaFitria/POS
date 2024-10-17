<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "kasir1";

// Koneksi ke database
$mysqli = new mysqli($host, $user, $pass, $db_name);

// Cek koneksi
if ($mysqli->connect_error) {
	die("Koneksi gagal: " . $mysqli->connect_error);
}

$login = mysqli_connect("localhost", "root", "", "kasir1");

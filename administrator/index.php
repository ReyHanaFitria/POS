<?php
include "header.php";
include "navbar.php";
?>
<style>
body {
    background-color: #f8f9fa; /* Latar belakang terang */
    font-family: Arial, sans-serif; /* Font yang lebih modern */
}

.container {
    max-width: 1200px; /* Lebar maksimum kontainer */
}

.card {
    border-radius: 0.5rem; /* Sudut membulat */
    transition: transform 0.3s; /* Transisi halus */
}

.card:hover {
    transform: scale(1.05); /* Sedikit membesar saat hover */
}

.card-title {
    font-weight: bold; /* Judul tebal */
    margin-bottom: 1rem; /* Jarak bawah judul */
}

.btn-primary {
    background-color: #007bff; /* Warna tombol */
    border-color: #007bff; /* Warna border tombol */
}

.btn-primary:hover {
    background-color: #0056b3; /* Warna latar belakang saat hover */
    border-color: #0056b3; /* Warna border saat hover */
}
</style>

<div class="container mt-3">
    <div class="row">
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Data Barang</h5>
                    <a href="data_barang.php" class="btn btn-primary btn-sm">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Laporan</h5>
                    <a href="laporan.php" class="btn btn-primary btn-sm">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Stok Barang</h5>
                    <a href="data_barang.php" class="btn btn-primary btn-sm">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Data Pengguna</h5>
                    <a href="user_management.php" class="btn btn-primary btn-sm">Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>

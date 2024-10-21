<?php session_start(); ?>
<div class="card mt-5">
    <div class="card-body">
        <a href="index.php" class="btn btn-success">Beranda</a>
        <a href="data_barang.php" class="btn btn-success">Data Barang</a>
        <a href="data_pelanggan.php" class="btn btn-success">Data Pelanggan</a>
        <a href="transaksi.php" class="btn btn-success">Transaksi</a>
        <a href="laporan.php" class="btn btn-success">Laporan Transaksi</a>
        <!--<a href="stok_barang.php" class="btn btn-success">Stok barang</a>-->

        <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 1): ?>
            <a href="user_management.php" class="btn btn-success">Data Pengguna</a>
        <?php endif; ?>

        <a href="../logout.php" class="btn btn-danger">Keluar</a>
    </div>
</div>
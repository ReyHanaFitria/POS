<nav class="navbar navbar-expand-lg glass-navbar shadow fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav">
                <li class="nav-item" style="cursor: pointer;"><a class="nav-link text-dark" href="index.php">Beranda</a></li>
                <li class="nav-item" style="cursor: pointer;"><a class="nav-link text-dark" href="data_kategori.php">Data Kategori</a></li>
                <li class="nav-item" style="cursor: pointer;"><a class="nav-link text-dark" href="data_barang.php">Data Barang</a></li>
                <li class="nav-item" style="cursor: pointer;"><a class="nav-link text-dark" href="data_pelanggan.php">Data Pelanggan</a></li>
                <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 1): ?>
                    <li class="nav-item" style="cursor: pointer;"><a class="nav-link text-dark" href="user_management.php">Data User</a></li>
                <?php endif; ?>
                <li class="nav-item" style="cursor: pointer;"><a class="nav-link text-dark" href="transaksi.php">Transaksi</a></li>
                <li class="nav-item" style="cursor: pointer;"><a class="nav-link text-dark" href="laporan.php">Laporan Transaksi</a></li>
                <li class="nav-item" style="cursor: pointer;"><a class="nav-link text-dark" href="laporan_bulanan.php">Laporan Bulanan</a></li>
            </ul>
        </div>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><?= htmlspecialchars($nama_user); ?></a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a href="../logout.php" class="dropdown-item">Keluar</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
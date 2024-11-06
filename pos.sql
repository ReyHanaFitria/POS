-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 07:28 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_produk`, `jumlah`, `harga`) VALUES
(31, 74, 3, 10, 21000),
(32, 74, 5, 2, 21000),
(33, 74, 11, 2, 20000),
(34, 75, 3, 1, 21000),
(35, 75, 28, 1, 12000),
(36, 76, 3, 2, 21000),
(37, 77, 5, 1, 21000),
(38, 78, 8, 1, 21000),
(39, 79, 5, 1, 21000),
(40, 79, 8, 1, 21000),
(41, 80, 6, 1, 21000),
(42, 80, 18, 1, 10000),
(43, 81, 6, 2, 21000),
(44, 82, 5, 2, 21000),
(45, 83, 5, 1, 21000),
(46, 84, 28, 1, 12000),
(47, 85, 6, 1, 21000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Makanan'),
(2, 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `PelangganID` int(11) NOT NULL,
  `NamaPelanggan` varchar(255) NOT NULL,
  `Alamat` text NOT NULL,
  `NomorTelepon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`PelangganID`, `NamaPelanggan`, `Alamat`, `NomorTelepon`) VALUES
(13, 'INTAN MELIANI', 'MUNJUL, MAJALEGKA', '08976453'),
(14, 'NAESHA', 'BABAKAN ANYAR', '08976564'),
(17, 'caca', 'cribon', '089653267'),
(18, 'CEMA', 'PLANET MARS', '453564545'),
(19, 'ARBIE', 'TANGERANG', '987675446'),
(20, 'edi', 'majalengka', '133455787');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(255) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `level`) VALUES
(1, 'Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(6, 'Rey', 'rey', 'd2b3ea2dfddc40efdc6941359436c847', 1),
(8, 'Petugas', 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', 2),
(9, 'Wikayla', 'anggun', 'f20ab4b0ab9308fbafe7a695e2a49e2e', 2);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `harga`, `stok`) VALUES
(3, 1, 'bakmie kuah', '21000.00', 0),
(5, 1, 'bakmie lampau', '21000.00', 0),
(6, 1, 'dimsum ayam', '21000.00', 113),
(8, 1, 'dimsum sapi', '21000.00', 111),
(9, 1, 'dimsum keju', '21000.00', 124),
(10, 1, 'dimsum udang', '21000.00', 150),
(11, 1, 'kue coklat ', '20000.00', 146),
(12, 1, 'kue coklat matcha', '20000.00', 149),
(13, 1, 'mochi coklat', '10000.00', 150),
(14, 1, 'mochi matcha', '10000.00', 149),
(15, 1, 'mochi green tea', '10000.00', 55),
(16, 1, 'mochi vanilla', '10000.00', 150),
(17, 2, 'kopi hangat', '10000.00', 147),
(18, 2, 'kopi luwak', '10000.00', 146),
(19, 2, 'kopi susu ', '10000.00', 148),
(20, 2, 'kopi jahe', '10000.00', 144),
(21, 2, 'jus mangga', '15000.00', 143),
(22, 2, 'jus jambu', '15000.00', 135),
(23, 2, 'jus jeruk', '15000.00', 149),
(24, 2, 'jus alpukat', '15000.00', 12),
(28, 2, 'jus stobery', '12000.00', 0),
(29, 2, 'Air Mineral', '5000.00', 12),
(30, 2, 'Jus beruk', '12000.00', 100);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `uang` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `id_customer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tanggal`, `uang`, `total_harga`, `kembalian`, `id_customer`) VALUES
(74, '2024-10-21', 300000, 292000, 8000, NULL),
(75, '2024-10-21', 50000, 33000, 17000, 17),
(76, '2024-10-22', 50000, 42000, 8000, 13),
(77, '2024-10-22', 50000, 21000, 29000, 14),
(78, '2024-10-23', 30000, 21000, 9000, 13),
(79, '2024-10-24', 50000, 42000, 8000, 17),
(80, '2024-10-24', 50000, 31000, 19000, 14),
(81, '2024-11-30', 50000, 42000, 8000, 13),
(82, '2024-11-29', 50000, 42000, 8000, 17),
(83, '2024-11-29', 30000, 21000, 9000, NULL),
(84, '2024-11-26', 20000, 12000, 8000, 19),
(85, '2024-10-25', 30000, 21000, 9000, 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`PelangganID`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_customer` (`id_customer`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `PelangganID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `pelanggan` (`PelangganID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

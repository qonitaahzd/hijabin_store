-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2026 at 01:28 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hijabin_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'Administrator', 'admin', '$2y$10$NpzniFQSntlDWF.6OI.MBeb7G/6Hg7oKNhPJHWDpFi1HlUGVWDyGm', '2026-09-30 13:27:34'),
(2, 'Husna', 'salah123', '$2y$10$vc03YXcElqbrrQ2gyKrthePEnlX9lgCFofRBZ40pXMSgijHm3dyXO', '2026-09-30 21:17:34');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bahan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warna` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `bahan`, `warna`, `deskripsi`, `harga`, `stok`, `gambar`, `created_at`) VALUES
(1, 'Pashmina Ceruty Dusty Rose', 'Pashmina', 'Ceruty', 'Dusty Rose', 'Pashmina ceruty babydoll yang jatuh dan ringan. Mudah dibentuk, tidak menerawang, nyaman dipakai seharian.', 89000.00, 30, '20261001001557_48aed484.png', '2026-09-30 13:27:34'),
(2, 'Segi Empat Voal Premium Mocha', 'Segi Empat', 'Voal', 'Mocha', 'Hijab segi empat voal ultrafine dengan jahit tepi rapi. Tekstur lembut dan mudah diatur.', 75000.00, 40, '20261001002220_95644ecb.png', '2026-09-30 13:27:34'),
(3, 'Bergo Instan Jersey Sage', 'Instan', 'Jersey', 'Sage Green', 'Hijab instan jersey dengan pet anti-tembem. Praktis dipakai tanpa jarum dan peniti.', 65000.00, 25, '20261001002657_b37967e8.png', '2026-09-30 13:27:34'),
(4, 'Inner Ciput Rajut Cream', 'Inner', 'Rajut', 'Cream', 'Inner ciput rajut yang adem dan elastis. Menahan hijab agar tidak mudah bergeser.', 25000.00, 100, '20261001003222_cf52226b.jpg', '2026-09-30 13:27:34'),
(5, 'Khimar Syari Satin Silk Black', 'Khimar', 'Satin Silk', 'Hitam', 'Khimar panjang dua layer dengan bahan satin silk berkilau lembut. Nyaman dan elegan untuk acara formal.', 149000.00, 15, '20261001005952_a30fda20.png', '2026-09-30 13:27:34'),
(6, 'Pashban Viscose Soft Pink', 'Pashmina', 'Viscose', 'Soft Pink', 'Pashban Viscose dengan lipatan rapi yang awet dan elegan.', 95000.00, 20, '20261001005055_d8a103e3.png', '2026-09-30 13:27:34'),
(7, 'Segi Empat Satin Velvet Navy', 'Segi Empat', 'Satin Velvet', 'Navy', 'Segi empat satin velvet yang tebal dan berkilau lembut. Tampilan mewah untuk acara spesial.', 99000.00, 12, '20261001004723_fc4fcf99.png', '2026-09-30 13:27:34'),
(8, 'Instan Pashmina Diamond Krem', 'Instan', 'Diamond Crepe', 'Krem', 'Pashmina instan berbahan diamond crepe. Jatuh, tidak licin, dan tidak mudah kusut.', 79000.00, 0, '20261001004306_1913f7b9.png', '2026-09-30 13:27:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

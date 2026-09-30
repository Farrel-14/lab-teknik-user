-- phpMyAdmin SQL Dump
-- version 5.2.3deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 30, 2026 at 10:30 AM
-- Server version: 8.4.11-0ubuntu0.26.04.1
-- PHP Version: 8.5.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lab_teknik`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id` int NOT NULL,
  `kode_alat` varchar(50) NOT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `tersedia` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id`, `kode_alat`, `nama_alat`, `jumlah`, `tersedia`, `created_at`) VALUES
(1, 'ALAT001', 'Multimeter', 5, 5, '2026-09-28 17:08:29'),
(2, 'ALAT002', 'Osiloskop', 2, 2, '2026-09-28 17:08:29'),
(3, 'ALAT003', 'Solder', 5, 5, '2026-09-28 17:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `npm` varchar(30) NOT NULL,
  `alat_id` int NOT NULL,
  `tanggal_pinjam` datetime DEFAULT CURRENT_TIMESTAMP,
  `tanggal_kembali` datetime DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `nama_mahasiswa`, `npm`, `alat_id`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(1, 'sfdsf', 'asds', 1, '2026-09-29 00:23:42', '2026-09-29 00:25:51', 'dikembalikan'),
(2, 'asuuu', '255671637783273', 1, '2026-09-29 00:26:38', '2026-09-29 00:27:31', 'dikembalikan'),
(3, 'gdrgdg', 'drgdrgf', 1, '2026-09-29 00:28:09', '2026-09-29 01:40:32', 'dikembalikan'),
(4, 'setsdf', 'gdffgdf', 3, '2026-09-29 00:28:17', '2026-09-29 01:40:31', 'dikembalikan'),
(5, 'dfhfddd', 'dsfd', 2, '2026-09-29 00:28:23', '2026-09-29 01:40:29', 'dikembalikan'),
(6, 'asuuu', '255671637783273', 2, '2026-09-29 03:29:43', '2026-09-29 20:14:19', 'dikembalikan'),
(7, 'kakka', '4655645654', 2, '2026-09-29 21:18:24', '2026-09-29 21:18:42', 'dikembalikan'),
(8, 'rido', '252263362', 3, '2026-09-30 13:39:20', '2026-09-30 13:39:27', 'dikembalikan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_alat` (`kode_alat`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alat_id` (`alat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`alat_id`) REFERENCES `alat` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

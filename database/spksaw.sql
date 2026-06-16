-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2026 pada 02.32
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spksaw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ahp_comparisons`
--

CREATE TABLE `ahp_comparisons` (
  `id` int(11) NOT NULL,
  `kriteria_1` tinyint(3) UNSIGNED NOT NULL,
  `kriteria_2` tinyint(3) UNSIGNED NOT NULL,
  `nilai` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ahp_comparisons`
--

INSERT INTO `ahp_comparisons` (`id`, `kriteria_1`, `kriteria_2`, `nilai`) VALUES
(1, 23, 24, 0.3300),
(2, 23, 25, 0.2000),
(3, 23, 26, 0.3300),
(4, 23, 27, 0.3300),
(5, 24, 23, 3.0000),
(6, 24, 25, 0.3300),
(7, 24, 26, 3.0000),
(8, 24, 27, 3.0000),
(9, 25, 23, 5.0000),
(10, 25, 24, 3.0000),
(11, 25, 26, 3.0000),
(12, 25, 27, 3.0000),
(13, 26, 23, 3.0000),
(14, 26, 24, 0.3300),
(15, 26, 25, 0.3300),
(16, 26, 27, 3.0000),
(17, 27, 23, 3.0000),
(18, 27, 24, 0.3300),
(19, 27, 25, 0.3300),
(20, 27, 26, 0.3300);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ahp_weights`
--

CREATE TABLE `ahp_weights` (
  `id_criteria` tinyint(3) UNSIGNED NOT NULL,
  `weight` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ahp_weights`
--

INSERT INTO `ahp_weights` (`id_criteria`, `weight`) VALUES
(23, 0.05983),
(24, 0.246629),
(25, 0.414644),
(26, 0.167556),
(27, 0.111341);

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatives`
--

CREATE TABLE `alternatives` (
  `id_alternative` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `alternatives`
--

INSERT INTO `alternatives` (`id_alternative`, `name`) VALUES
(1, 'SmartLamp 001'),
(2, 'SmartPlug 002'),
(3, 'SmartLock 003'),
(4, 'SmartCamera 004'),
(5, 'SmartThermostat 005'),
(6, 'SmartSensor 006'),
(7, 'SmartAlarm 007'),
(8, 'SmartHub 008'),
(9, 'SmartSwitch 009'),
(10, 'SmartCurtain 010'),
(11, 'SmartSpeaker 011'),
(12, 'SmartBell 012'),
(13, 'SmartIrrigation 013'),
(14, 'SmartVacuum 014'),
(15, 'SmartAirPurifier 015'),
(16, 'SmartLamp 016'),
(17, 'SmartPlug 017'),
(18, 'SmartLock 018'),
(19, 'SmartCamera 019'),
(20, 'SmartThermostat 020'),
(21, 'SmartSensor 021'),
(22, 'SmartAlarm 022'),
(23, 'SmartHub 023'),
(24, 'SmartSwitch 024'),
(25, 'SmartCurtain 025'),
(26, 'SmartSpeaker 026'),
(27, 'SmartBell 027'),
(28, 'SmartIrrigation 028'),
(29, 'SmartVacuum 029'),
(30, 'SmartAirPurifier 030'),
(31, 'SmartLamp 031'),
(32, 'SmartPlug 032'),
(33, 'SmartLock 033'),
(34, 'SmartCamera 034'),
(35, 'SmartThermostat 035'),
(36, 'SmartSensor 036'),
(37, 'SmartAlarm 037'),
(38, 'SmartHub 038'),
(39, 'SmartSwitch 039'),
(40, 'SmartCurtain 040'),
(41, 'SmartSpeaker 041'),
(42, 'SmartBell 042'),
(43, 'SmartIrrigation 043'),
(44, 'SmartVacuum 044'),
(45, 'SmartAirPurifier 045'),
(46, 'SmartLamp 046'),
(47, 'SmartPlug 047'),
(48, 'SmartLock 048'),
(49, 'SmartCamera 049'),
(50, 'SmartThermostat 050');

-- --------------------------------------------------------

--
-- Struktur dari tabel `criterias`
--

CREATE TABLE `criterias` (
  `id_criteria` tinyint(3) UNSIGNED NOT NULL,
  `criteria` varchar(100) NOT NULL,
  `attribute` enum('benefit','cost') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `criterias`
--

INSERT INTO `criterias` (`id_criteria`, `criteria`, `attribute`) VALUES
(23, 'Harga', 'cost'),
(24, 'Kualitas', 'benefit'),
(25, 'Kompabilitas', 'benefit'),
(26, 'Dukungan Teknis', 'benefit'),
(27, 'Fitur', 'benefit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluations`
--

CREATE TABLE `evaluations` (
  `id_alternative` int(10) UNSIGNED NOT NULL,
  `id_criteria` tinyint(3) UNSIGNED NOT NULL,
  `value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `evaluations`
--

INSERT INTO `evaluations` (`id_alternative`, `id_criteria`, `value`) VALUES
(1, 23, 1),
(1, 24, 3),
(1, 25, 4),
(1, 26, 4),
(1, 27, 4),
(2, 23, 1),
(2, 24, 4),
(2, 25, 4),
(2, 26, 3),
(2, 27, 4),
(3, 23, 2),
(3, 24, 2),
(3, 25, 4),
(3, 26, 4),
(3, 27, 2),
(4, 23, 1),
(4, 24, 3),
(4, 25, 4),
(4, 26, 4),
(4, 27, 4),
(5, 23, 3),
(5, 24, 5),
(5, 25, 4),
(5, 26, 4),
(5, 27, 3),
(6, 23, 1),
(6, 24, 4),
(6, 25, 4),
(6, 26, 3),
(6, 27, 5),
(7, 23, 1),
(7, 24, 4),
(7, 25, 4),
(7, 26, 4),
(7, 27, 4),
(8, 23, 2),
(8, 24, 4),
(8, 25, 3),
(8, 26, 2),
(8, 27, 4),
(9, 23, 1),
(9, 24, 4),
(9, 25, 4),
(9, 26, 3),
(9, 27, 2),
(10, 23, 2),
(10, 24, 4),
(10, 25, 4),
(10, 26, 4),
(10, 27, 2),
(11, 23, 1),
(11, 24, 4),
(11, 25, 4),
(11, 26, 4),
(11, 27, 4),
(12, 23, 1),
(12, 24, 3),
(12, 25, 4),
(12, 26, 4),
(12, 27, 4),
(13, 23, 2),
(13, 24, 4),
(13, 25, 4),
(13, 26, 4),
(13, 27, 3),
(14, 23, 5),
(14, 24, 4),
(14, 25, 4),
(14, 26, 4),
(14, 27, 3),
(15, 23, 3),
(15, 24, 4),
(15, 25, 4),
(15, 26, 5),
(15, 27, 3),
(16, 23, 1),
(16, 24, 4),
(16, 25, 4),
(16, 26, 4),
(16, 27, 2),
(17, 23, 1),
(17, 24, 4),
(17, 25, 4),
(17, 26, 3),
(17, 27, 4),
(18, 23, 2),
(18, 24, 4),
(18, 25, 4),
(18, 26, 4),
(18, 27, 4),
(19, 23, 3),
(19, 24, 4),
(19, 25, 4),
(19, 26, 4),
(19, 27, 4),
(20, 23, 3),
(20, 24, 4),
(20, 25, 4),
(20, 26, 4),
(20, 27, 4),
(21, 23, 1),
(21, 24, 2),
(21, 25, 4),
(21, 26, 3),
(21, 27, 4),
(22, 23, 1),
(22, 24, 4),
(22, 25, 4),
(22, 26, 4),
(22, 27, 4),
(23, 23, 2),
(23, 24, 4),
(23, 25, 3),
(23, 26, 3),
(23, 27, 3),
(24, 23, 1),
(24, 24, 4),
(24, 25, 5),
(24, 26, 4),
(24, 27, 4),
(25, 23, 2),
(25, 24, 4),
(25, 25, 4),
(25, 26, 4),
(25, 27, 3),
(26, 23, 2),
(26, 24, 4),
(26, 25, 4),
(26, 26, 4),
(26, 27, 2),
(27, 23, 1),
(27, 24, 3),
(27, 25, 4),
(27, 26, 3),
(27, 27, 4),
(28, 23, 2),
(28, 24, 4),
(28, 25, 4),
(28, 26, 2),
(28, 27, 4),
(29, 23, 5),
(29, 24, 4),
(29, 25, 4),
(29, 26, 4),
(29, 27, 4),
(30, 23, 2),
(30, 24, 4),
(30, 25, 4),
(30, 26, 4),
(30, 27, 2),
(31, 23, 1),
(31, 24, 4),
(31, 25, 5),
(31, 26, 4),
(31, 27, 4),
(32, 23, 1),
(32, 24, 4),
(32, 25, 4),
(32, 26, 2),
(32, 27, 2),
(33, 23, 3),
(33, 24, 4),
(33, 25, 4),
(33, 26, 4),
(33, 27, 4),
(34, 23, 1),
(34, 24, 4),
(34, 25, 4),
(34, 26, 4),
(34, 27, 4),
(35, 23, 4),
(35, 24, 4),
(35, 25, 4),
(35, 26, 3),
(35, 27, 3),
(36, 23, 1),
(36, 24, 4),
(36, 25, 4),
(36, 26, 4),
(36, 27, 5),
(37, 23, 1),
(37, 24, 3),
(37, 25, 4),
(37, 26, 4),
(37, 27, 4),
(38, 23, 2),
(38, 24, 4),
(38, 25, 4),
(38, 26, 4),
(38, 27, 5),
(39, 23, 1),
(39, 24, 3),
(39, 25, 4),
(39, 26, 4),
(39, 27, 4),
(40, 23, 2),
(40, 24, 4),
(40, 25, 4),
(40, 26, 4),
(40, 27, 4),
(41, 23, 2),
(41, 24, 4),
(41, 25, 4),
(41, 26, 4),
(41, 27, 4),
(42, 23, 1),
(42, 24, 4),
(42, 25, 4),
(42, 26, 4),
(42, 27, 4),
(43, 23, 2),
(43, 24, 4),
(43, 25, 4),
(43, 26, 4),
(43, 27, 4),
(44, 23, 5),
(44, 24, 4),
(44, 25, 4),
(44, 26, 2),
(44, 27, 3),
(45, 23, 3),
(45, 24, 4),
(45, 25, 4),
(45, 26, 4),
(45, 27, 4),
(46, 23, 1),
(46, 24, 4),
(46, 25, 4),
(46, 26, 4),
(46, 27, 4),
(47, 23, 1),
(47, 24, 3),
(47, 25, 3),
(47, 26, 4),
(47, 27, 3),
(48, 23, 2),
(48, 24, 5),
(48, 25, 3),
(48, 26, 4),
(48, 27, 2),
(49, 23, 1),
(49, 24, 3),
(49, 25, 4),
(49, 26, 4),
(49, 27, 4),
(50, 23, 3),
(50, 24, 4),
(50, 25, 4),
(50, 26, 4),
(50, 27, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `saw_results`
--

CREATE TABLE `saw_results` (
  `id_result` int(11) NOT NULL,
  `id_alternative` int(10) UNSIGNED NOT NULL,
  `final_score` decimal(10,6) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `saw_results`
--

INSERT INTO `saw_results` (`id_result`, `id_alternative`, `final_score`, `created_at`, `score`) VALUES
(8602, 24, 0.894895, '2026-06-14 01:10:03', NULL),
(8603, 31, 0.894895, '2026-06-14 01:10:03', NULL),
(8604, 36, 0.834234, '2026-06-14 01:10:03', NULL),
(8605, 7, 0.811966, '2026-06-14 01:10:03', NULL),
(8606, 11, 0.811966, '2026-06-14 01:10:03', NULL),
(8607, 22, 0.811966, '2026-06-14 01:10:03', NULL),
(8608, 34, 0.811966, '2026-06-14 01:10:03', NULL),
(8609, 42, 0.811966, '2026-06-14 01:10:03', NULL),
(8610, 46, 0.811966, '2026-06-14 01:10:03', NULL),
(8611, 38, 0.804319, '2026-06-14 01:10:03', NULL),
(8612, 6, 0.800723, '2026-06-14 01:10:03', NULL),
(8613, 5, 0.799137, '2026-06-14 01:10:03', NULL),
(8614, 15, 0.783322, '2026-06-14 01:10:03', NULL),
(8615, 18, 0.782051, '2026-06-14 01:10:03', NULL),
(8616, 40, 0.782051, '2026-06-14 01:10:03', NULL),
(8617, 41, 0.782051, '2026-06-14 01:10:03', NULL),
(8618, 43, 0.782051, '2026-06-14 01:10:03', NULL),
(8619, 2, 0.778455, '2026-06-14 01:10:03', NULL),
(8620, 17, 0.778455, '2026-06-14 01:10:03', NULL),
(8621, 19, 0.772079, '2026-06-14 01:10:03', NULL),
(8622, 20, 0.772079, '2026-06-14 01:10:03', NULL),
(8623, 33, 0.772079, '2026-06-14 01:10:03', NULL),
(8624, 45, 0.772079, '2026-06-14 01:10:03', NULL),
(8625, 16, 0.767430, '2026-06-14 01:10:03', NULL),
(8626, 29, 0.764102, '2026-06-14 01:10:03', NULL),
(8627, 1, 0.762640, '2026-06-14 01:10:03', NULL),
(8628, 4, 0.762640, '2026-06-14 01:10:03', NULL),
(8629, 12, 0.762640, '2026-06-14 01:10:03', NULL),
(8630, 37, 0.762640, '2026-06-14 01:10:03', NULL),
(8631, 39, 0.762640, '2026-06-14 01:10:03', NULL),
(8632, 49, 0.762640, '2026-06-14 01:10:03', NULL),
(8633, 13, 0.759783, '2026-06-14 01:10:03', NULL),
(8634, 25, 0.759783, '2026-06-14 01:10:03', NULL),
(8635, 50, 0.749811, '2026-06-14 01:10:03', NULL),
(8636, 14, 0.741834, '2026-06-14 01:10:03', NULL),
(8637, 10, 0.737515, '2026-06-14 01:10:03', NULL),
(8638, 26, 0.737515, '2026-06-14 01:10:03', NULL),
(8639, 30, 0.737515, '2026-06-14 01:10:03', NULL),
(8640, 9, 0.733918, '2026-06-14 01:10:03', NULL),
(8641, 27, 0.729129, '2026-06-14 01:10:03', NULL),
(8642, 28, 0.715029, '2026-06-14 01:10:03', NULL),
(8643, 35, 0.711314, '2026-06-14 01:10:03', NULL),
(8644, 48, 0.703912, '2026-06-14 01:10:03', NULL),
(8645, 32, 0.700407, '2026-06-14 01:10:03', NULL),
(8646, 21, 0.679803, '2026-06-14 01:10:03', NULL),
(8647, 44, 0.674811, '2026-06-14 01:10:03', NULL),
(8648, 47, 0.657443, '2026-06-14 01:10:03', NULL),
(8649, 23, 0.643343, '2026-06-14 01:10:03', NULL),
(8650, 3, 0.638863, '2026-06-14 01:10:03', NULL),
(8651, 8, 0.632100, '2026-06-14 01:10:03', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_criterias`
--

CREATE TABLE `sub_criterias` (
  `id_subcriteria` int(10) UNSIGNED NOT NULL,
  `id_criteria` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sub_criterias`
--

INSERT INTO `sub_criterias` (`id_subcriteria`, `id_criteria`, `name`, `value`) VALUES
(35, 23, '0 - 499.999', 1.00),
(36, 23, '500.000 - 999.999', 2.00),
(37, 23, '1.000.000 - 1.499.999', 3.00),
(38, 23, '1.500.000 - 1.999.999', 4.00),
(39, 23, '2.000.000 - 3.000.000', 5.00),
(40, 24, 'Sangat Rendah', 1.00),
(41, 24, 'Rendah', 2.00),
(42, 24, 'Sedang', 3.00),
(43, 24, 'Tinggi', 4.00),
(44, 24, 'Sangat Tinggi', 5.00),
(46, 25, 'Sangat Rendah', 1.00),
(47, 25, 'Rendah', 2.00),
(48, 25, 'Sedang', 3.00),
(51, 26, 'Sangat Rendah', 1.00),
(52, 26, 'Rendah', 2.00),
(53, 26, 'Sedang', 3.00),
(55, 27, 'Sangat Rendah', 1.00),
(56, 27, 'Rendah', 2.00),
(57, 27, 'Sedang', 3.00),
(58, 27, 'Tinggi', 4.00),
(72, 27, 'Sangat Tinggi', 5.00),
(73, 25, 'Tinggi', 4.00),
(74, 25, 'Sangat Tinggi', 5.00),
(75, 26, 'Tinggi', 4.00),
(76, 26, 'Sangat Tinggi', 5.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$PrxPlXPGHYKCx5lkDWwxiufIFUhU5gMMR/5IxcCQNFXI3g3YBzP5O', 'admin'),
(2, 'user', '$2y$10$.JlVolSfeLvpJomFZivqeu0JpOrRI469k1xKrJxEFq4NxSYxqX7QC', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ahp_comparisons`
--
ALTER TABLE `ahp_comparisons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_1` (`kriteria_1`),
  ADD KEY `kriteria_2` (`kriteria_2`);

--
-- Indeks untuk tabel `ahp_weights`
--
ALTER TABLE `ahp_weights`
  ADD PRIMARY KEY (`id_criteria`);

--
-- Indeks untuk tabel `alternatives`
--
ALTER TABLE `alternatives`
  ADD PRIMARY KEY (`id_alternative`);

--
-- Indeks untuk tabel `criterias`
--
ALTER TABLE `criterias`
  ADD PRIMARY KEY (`id_criteria`);

--
-- Indeks untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id_alternative`,`id_criteria`),
  ADD KEY `id_criteria` (`id_criteria`);

--
-- Indeks untuk tabel `saw_results`
--
ALTER TABLE `saw_results`
  ADD PRIMARY KEY (`id_result`),
  ADD KEY `id_alternative` (`id_alternative`);

--
-- Indeks untuk tabel `sub_criterias`
--
ALTER TABLE `sub_criterias`
  ADD PRIMARY KEY (`id_subcriteria`),
  ADD KEY `id_criteria` (`id_criteria`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `ahp_comparisons`
--
ALTER TABLE `ahp_comparisons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `alternatives`
--
ALTER TABLE `alternatives`
  MODIFY `id_alternative` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `criterias`
--
ALTER TABLE `criterias`
  MODIFY `id_criteria` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `saw_results`
--
ALTER TABLE `saw_results`
  MODIFY `id_result` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8652;

--
-- AUTO_INCREMENT untuk tabel `sub_criterias`
--
ALTER TABLE `sub_criterias`
  MODIFY `id_subcriteria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `ahp_comparisons`
--
ALTER TABLE `ahp_comparisons`
  ADD CONSTRAINT `ahp_comparisons_ibfk_1` FOREIGN KEY (`kriteria_1`) REFERENCES `criterias` (`id_criteria`) ON DELETE CASCADE,
  ADD CONSTRAINT `ahp_comparisons_ibfk_2` FOREIGN KEY (`kriteria_2`) REFERENCES `criterias` (`id_criteria`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ahp_weights`
--
ALTER TABLE `ahp_weights`
  ADD CONSTRAINT `ahp_weights_ibfk_1` FOREIGN KEY (`id_criteria`) REFERENCES `criterias` (`id_criteria`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_ibfk_1` FOREIGN KEY (`id_alternative`) REFERENCES `alternatives` (`id_alternative`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluations_ibfk_2` FOREIGN KEY (`id_criteria`) REFERENCES `criterias` (`id_criteria`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `saw_results`
--
ALTER TABLE `saw_results`
  ADD CONSTRAINT `saw_results_ibfk_1` FOREIGN KEY (`id_alternative`) REFERENCES `alternatives` (`id_alternative`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_criterias`
--
ALTER TABLE `sub_criterias`
  ADD CONSTRAINT `sub_criterias_ibfk_1` FOREIGN KEY (`id_criteria`) REFERENCES `criterias` (`id_criteria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

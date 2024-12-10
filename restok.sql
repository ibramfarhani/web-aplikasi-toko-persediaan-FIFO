-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Nov 2023 pada 02.02
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restok`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`) VALUES
(1, 'Admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `bentuk` enum('Pcs','Duss','Ball') NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `id_supplier` int(11) NOT NULL,
  `expired` date NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `bentuk`, `harga_beli`, `harga_jual`, `tanggal`, `id_supplier`, `expired`, `jumlah`) VALUES
(1, 'Give Sabun Mandi ', 'Pcs', 2600, 2088000, '2023-10-31', 3, '2024-10-31', 70),
(2, 'Teh Rio', 'Duss', 24400, 25000, '2023-10-31', 5, '2024-10-31', 0),
(4, 'Ale Ale', 'Duss', 24420, 25000, '2023-10-31', 5, '2024-04-15', 8),
(5, 'Snack Kerupuk Kulit', 'Ball', 25900, 26000, '2023-10-31', 4, '2023-11-25', 30),
(6, 'Sunlight', 'Pcs', 5000, 105000, '2023-10-31', 3, '2024-10-31', 20),
(7, 'Rinso Anti Noda Detergent (Deterjen Bubuk) 770g', 'Pcs', 34000, 1005000, '2023-10-31', 6, '2024-10-31', 30),
(9, 'top coffee sachet', 'Pcs', 1500, 7000, '2023-11-09', 3, '2024-02-03', 2),
(10, 'Masako', 'Pcs', 5200, 20800, '2023-11-09', 5, '2014-10-18', 48),
(11, 'Ladaku', 'Pcs', 13000, 50000, '2023-11-09', 3, '2024-10-10', 48),
(12, 'Royco', 'Pcs', 6000, 22000, '2023-11-09', 4, '2024-12-07', 46),
(13, 'Energen', 'Pcs', 20000, 78000, '2023-11-09', 5, '2024-08-05', 40),
(14, 'Indomilk Sachet Putih 37gr', 'Duss', 160000, 799995, '2023-11-09', 3, '2024-10-17', 5),
(15, 'Indomie Goreng', 'Duss', 105000, 525000, '2023-11-09', 5, '2024-04-14', 5),
(17, 'Ale Ale', 'Duss', 24420, 25000, '2023-11-15', 5, '2024-11-15', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail`
--

CREATE TABLE `detail` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `detail`
--

INSERT INTO `detail` (`id_detail`, `id_penjualan`, `id_barang`, `harga`, `jumlah`) VALUES
(1, 0, 1, 2, 10000),
(2, 0, 1, 4, 10000),
(3, 0, 0, 0, 0),
(4, 0, 0, 0, 0),
(5, 1, 1, 2, 10000),
(6, 1, 1, 4, 10000),
(7, 1, 0, 0, 0),
(8, 1, 0, 0, 0),
(9, 2, 1, 3, 10000),
(10, 2, 1, 4, 10000),
(11, 2, 0, 0, 0),
(12, 2, 0, 0, 0),
(13, 3, 1, 3, 10000),
(14, 3, 1, 4, 10000),
(15, 3, 0, 0, 0),
(16, 3, 0, 0, 0),
(17, 4, 1, 10000, 4),
(18, 4, 0, 0, 0),
(19, 4, 0, 0, 0),
(20, 4, 0, 0, 0),
(21, 5, 1, 10000, 4),
(22, 5, 0, 0, 0),
(23, 5, 0, 0, 0),
(24, 5, 0, 0, 0),
(25, 6, 1, 10000, 3),
(26, 6, 2, 5000, 4),
(27, 6, 3, 7000, 5),
(28, 6, 0, 0, 0),
(29, 7, 1, 10000, 3),
(30, 7, 2, 5000, 4),
(31, 7, 3, 7000, 5),
(32, 8, 3, 6000, 4),
(33, 8, 3, 6000, 4),
(34, 9, 3, 6000, 5),
(35, 9, 2, 5000, 2),
(36, 10, 3, 6000, 5),
(37, 10, 2, 5000, 2),
(38, 13, 3, 6000, 3),
(39, 13, 2, 5000, 2),
(40, 14, 3, 6000, 2),
(41, 14, 2, 5000, 1),
(42, 14, 2, 5000, 3),
(43, 15, 3, 6000, 3),
(44, 16, 3, 6000, 3),
(45, 17, 1, 4000, 1),
(46, 18, 2, 5000, 2),
(47, 19, 1, 4000, 2),
(48, 20, 1, 4000, 1),
(49, 21, 2, 5000, 10),
(50, 22, 10, 4000, 10),
(51, 23, 2, 5000, 15),
(52, 23, 12, 5000, 10),
(53, 23, 10, 4000, 2),
(54, 23, 2, 5000, 0),
(55, 24, 10, 4000, 1),
(57, 34, 13, 4500, 2),
(58, 35, 14, 90000, 2),
(59, 36, 1, 2088000, 2),
(60, 37, 3, 40000, 6),
(61, 38, 3, 40000, 2),
(62, 39, 3, 40000, 3),
(63, 40, 2, 24400, 1),
(64, 40, 4, 24420, 1),
(65, 41, 2, 24400, 1),
(66, 42, 2, 24400, 1),
(67, 43, 2, 24400, 1),
(68, 44, 2, 24400, 1),
(69, 45, 4, 24420, 1),
(70, 45, 9, 1500, 2),
(71, 46, 6, 5000, 4),
(72, 46, 12, 6000, 2),
(73, 51, 9, 1500, 3),
(74, 52, 9, 1500, 3);

--
-- Trigger `detail`
--
DELIMITER $$
CREATE TRIGGER `kurangi` AFTER INSERT ON `detail` FOR EACH ROW UPDATE barang SET jumlah=jumlah-NEW.jumlah where id_barang=NEW.id_barang
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kasir`
--

CREATE TABLE `kasir` (
  `id_kasir` int(11) NOT NULL,
  `nama_kasir` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kasir`
--

INSERT INTO `kasir` (`id_kasir`, `nama_kasir`, `username`, `password`) VALUES
(1, 'Kasir', 'kasir', 'kasir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `id_kasir` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `nama_pelanggan`, `id_kasir`, `tanggal`) VALUES
(1, '1', 1, '2022-06-10'),
(2, '1', 1, '2022-06-04'),
(3, '1', 1, '2022-06-04'),
(4, '0', 1, '2022-06-04'),
(5, '1', 1, '2022-06-04'),
(6, '1', 1, '2022-06-04'),
(7, '1', 1, '2022-06-04'),
(8, '1', 1, '2022-06-21'),
(9, '1', 1, '2022-06-21'),
(10, '1', 1, '2022-06-21'),
(11, '0', 1, '2022-06-21'),
(12, '0', 1, '2022-06-21'),
(13, 'ahmad', 1, '2022-06-21'),
(14, 'celisa', 1, '2022-06-21'),
(15, 'celisa', 1, '2022-06-21'),
(16, 'celisa', 1, '2022-06-16'),
(17, 'jin', 1, '2022-06-16'),
(18, 'pisa', 1, '2022-06-16'),
(19, 'upin', 1, '2022-06-16'),
(20, 'ipin', 1, '2022-06-16'),
(21, 'siti', 1, '2022-06-28'),
(22, '', 1, '2022-06-28'),
(23, 'refan', 1, '2023-09-28'),
(24, 'refan', 1, '2023-09-28'),
(32, 'gento', 1, '2023-10-03'),
(33, 'fan', 1, '2023-10-03'),
(34, 'fan', 1, '2023-10-03'),
(35, 'refan', 1, '2023-10-11'),
(36, 'sri', 1, '2023-11-08'),
(37, 'Refan', 1, '2023-11-09'),
(38, 'ade', 1, '2023-11-15'),
(39, 'seta', 1, '2023-11-15'),
(40, 'sri', 1, '2023-11-01'),
(41, 'sri', 1, '2023-11-20'),
(42, 'sri', 1, '2023-11-20'),
(43, 'sri', 1, '2023-11-20'),
(44, 'sri', 1, '2023-11-20'),
(45, 'sri', 1, '2023-11-20'),
(46, 'refan', 1, '2023-11-20'),
(47, 'refan', 1, '2023-11-26'),
(48, 'refan', 1, '2023-11-26'),
(49, 'refan', 1, '2023-11-26'),
(50, 'refan', 1, '2023-11-26'),
(51, 'refan', 1, '2023-11-26'),
(52, 'refan', 1, '2023-11-26'),
(53, '', 1, '1970-01-01'),
(54, '', 1, '1970-01-01'),
(55, '', 1, '1970-01-01'),
(56, '', 1, '1970-01-01'),
(57, '', 1, '1970-01-01'),
(58, 'refan', 1, '2023-11-28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `hp`) VALUES
(3, 'Toko Grosir Murah', 'Nganjuk', '082116310002'),
(4, 'Java market distributor dan grosir', 'jalan gatot subroto, nganjuk', '082116310002'),
(5, 'Agen Sembako', 'Tanjunganom nganjuk', '082116310002'),
(6, 'Hans Sembako', 'Bagor, Nganjuk', '082116310002'),
(7, 'Sembako Murah Nganjuk', 'Bogo, Nganjuk', '082116310002');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indeks untuk tabel `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`id_kasir`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `detail`
--
ALTER TABLE `detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

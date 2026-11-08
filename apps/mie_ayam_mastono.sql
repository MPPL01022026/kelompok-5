-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Nov 2026 pada 14.25
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
-- Database: `mie_ayam_mastono`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan`
--

CREATE TABLE `bahan` (
  `id` int(11) NOT NULL,
  `kode_bahan` varchar(20) NOT NULL,
  `nama_bahan` varchar(100) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `satuan` varchar(20) NOT NULL,
  `stok_saat_ini` decimal(10,2) NOT NULL DEFAULT 0.00,
  `batas_minimum` decimal(10,2) NOT NULL DEFAULT 0.00,
  `harga_satuan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `bahan`
--

INSERT INTO `bahan` (`id`, `kode_bahan`, `nama_bahan`, `kategori_id`, `satuan`, `stok_saat_ini`, `batas_minimum`, `harga_satuan`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'BHN-001', 'Mie Basah', 1, 'kg', 25.00, 5.00, 15000.00, NULL, '2026-10-01 22:08:51', NULL),
(2, 'BHN-002', 'Daging Ayam', 1, 'kg', 15.00, 3.00, 35000.00, NULL, '2026-10-01 22:08:51', NULL),
(4, 'BHN-004', 'Minyak Goreng', 2, 'liter', 8.00, 2.00, 18000.00, NULL, '2026-10-01 22:08:51', NULL),
(10, 'BHN-010', 'Bakso', 4, 'kg', 10.00, 2.00, 40000.00, NULL, '2026-10-01 22:08:51', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_bahan`
--

CREATE TABLE `kategori_bahan` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `kategori_bahan`
--

INSERT INTO `kategori_bahan` (`id`, `nama_kategori`, `keterangan`, `created_at`) VALUES
(1, 'Bahan Utama', 'Bahan utama pembuatan mie ayam', '2026-10-01 22:08:51'),
(2, 'Bumbu & Rempah', 'Bumbu dan rempah-rempah', '2026-10-01 22:08:51'),
(3, 'Sayuran', 'Bahan sayuran pendukung', '2026-10-01 22:08:51'),
(4, 'Pelengkap', 'Bahan pelengkap dan topping', '2026-10-01 22:08:51'),
(5, 'Minuman', 'Bahan untuk minuman', '2026-10-01 22:08:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `id` int(11) NOT NULL,
  `tipe` enum('masuk','keluar','edit','hapus') NOT NULL,
  `bahan_id` int(11) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`id`, `tipe`, `bahan_id`, `jumlah`, `keterangan`, `user_id`, `created_at`) VALUES
(1, 'edit', 3, NULL, 'Data bahan diperbarui: Kecap Manis', 1, '2026-10-01 22:39:34'),
(2, 'hapus', 3, NULL, 'Bahan dihapus: Kecap Manis', 1, '2026-10-17 10:37:23'),
(3, 'hapus', 8, NULL, 'Bahan dihapus: Daun Bawang', 1, '2026-10-17 10:38:25'),
(4, 'hapus', 9, NULL, 'Bahan dihapus: Pangsit', 1, '2026-10-17 10:38:33'),
(5, 'hapus', 6, NULL, 'Bahan dihapus: Bawang Putih', 1, '2026-10-17 10:38:38'),
(6, 'hapus', 5, NULL, 'Bahan dihapus: Bawang Merah', 1, '2026-10-17 10:38:41'),
(7, 'hapus', 7, NULL, 'Bahan dihapus: Sawi Hijau', 1, '2026-10-17 10:38:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_keluar`
--

CREATE TABLE `stok_keluar` (
  `id` int(11) NOT NULL,
  `kode_transaksi` varchar(30) NOT NULL,
  `bahan_id` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `tanggal` date NOT NULL,
  `keperluan` varchar(100) DEFAULT 'Pemakaian Harian',
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `id` int(11) NOT NULL,
  `kode_transaksi` varchar(30) NOT NULL,
  `bahan_id` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `harga_beli` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tanggal` date NOT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','karyawan') NOT NULL DEFAULT 'karyawan',
  `foto` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `foto`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', '$2y$10$uoUnHBT0XnRB341IgLWkruJdpyCIXriq9lvmNMR90awDZbMuzTXja', 'admin', NULL, 1, '2026-10-01 22:08:51', '2026-10-01 22:29:03');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bahan`
--
ALTER TABLE `bahan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_bahan` (`kode_bahan`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `kategori_bahan`
--
ALTER TABLE `kategori_bahan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_id` (`bahan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_id` (`bahan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bahan_id` (`bahan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bahan`
--
ALTER TABLE `bahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kategori_bahan`
--
ALTER TABLE `kategori_bahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bahan`
--
ALTER TABLE `bahan`
  ADD CONSTRAINT `fk_bahan_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_bahan` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD CONSTRAINT `fk_stokkeluar_bahan` FOREIGN KEY (`bahan_id`) REFERENCES `bahan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stokkeluar_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD CONSTRAINT `fk_stokmasuk_bahan` FOREIGN KEY (`bahan_id`) REFERENCES `bahan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stokmasuk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

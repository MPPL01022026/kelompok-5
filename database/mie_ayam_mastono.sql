-- ============================================================
-- Database: mie_ayam_mastono
-- Sistem Monitoring Stok Bahan Makanan
-- Warung Mie Ayam Mastono - Digital Twin
-- ============================================================

CREATE DATABASE IF NOT EXISTS `mie_ayam_mastono` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mie_ayam_mastono`;

-- ============================================================
-- Tabel Users (untuk Login)
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','karyawan') NOT NULL DEFAULT 'karyawan',
  `foto` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default admin user (password: admin123)
INSERT INTO `users` (`nama`, `username`, `password`, `role`, `is_active`) VALUES
('Administrator', 'admin', '$2y$10$uoUnHBT0XnRB341IgLWkruJdpyCIXriq9lvmNMR90awDZbMuzTXja', 'admin', 1),
('Dalu Meriana', 'pemilik', '$2y$10$uoUnHBT0XnRB341IgLWkruJdpyCIXriq9lvmNMR90awDZbMuzTXja', 'admin', 1);

-- ============================================================
-- Tabel Kategori Bahan
-- ============================================================
CREATE TABLE IF NOT EXISTS `kategori_bahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `kategori_bahan` (`nama_kategori`, `keterangan`) VALUES
('Bahan Utama', 'Bahan utama pembuatan mie ayam'),
('Bumbu & Rempah', 'Bumbu dan rempah-rempah'),
('Sayuran', 'Bahan sayuran pendukung'),
('Pelengkap', 'Bahan pelengkap dan topping'),
('Minuman', 'Bahan untuk minuman');

-- ============================================================
-- Tabel Bahan Makanan (Data Bahan)
-- ============================================================
CREATE TABLE IF NOT EXISTS `bahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_bahan` varchar(20) NOT NULL,
  `nama_bahan` varchar(100) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `satuan` varchar(20) NOT NULL,
  `stok_saat_ini` decimal(10,2) NOT NULL DEFAULT 0.00,
  `batas_minimum` decimal(10,2) NOT NULL DEFAULT 0.00,
  `harga_satuan` decimal(12,2) NOT NULL DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_bahan` (`kode_bahan`),
  KEY `kategori_id` (`kategori_id`),
  CONSTRAINT `fk_bahan_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_bahan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `bahan` (`kode_bahan`, `nama_bahan`, `kategori_id`, `satuan`, `stok_saat_ini`, `batas_minimum`, `harga_satuan`) VALUES
('BHN-001', 'Mie Basah', 1, 'kg', 25.00, 5.00, 15000.00),
('BHN-002', 'Daging Ayam', 1, 'kg', 15.00, 3.00, 35000.00),
('BHN-003', 'Kecap Manis', 2, 'botol', 10.00, 2.00, 12000.00),
('BHN-004', 'Minyak Goreng', 2, 'liter', 8.00, 2.00, 18000.00),
('BHN-005', 'Bawang Merah', 2, 'kg', 5.00, 1.00, 25000.00),
('BHN-006', 'Bawang Putih', 2, 'kg', 4.00, 1.00, 30000.00),
('BHN-007', 'Sawi Hijau', 3, 'ikat', 20.00, 5.00, 3000.00),
('BHN-008', 'Daun Bawang', 3, 'ikat', 15.00, 3.00, 2000.00),
('BHN-009', 'Pangsit', 4, 'bungkus', 12.00, 3.00, 10000.00),
('BHN-010', 'Bakso', 4, 'kg', 10.00, 2.00, 40000.00);

-- ============================================================
-- Tabel Stok Masuk
-- ============================================================
CREATE TABLE IF NOT EXISTS `stok_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(30) NOT NULL,
  `bahan_id` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `harga_beli` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tanggal` date NOT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bahan_id` (`bahan_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_stokmasuk_bahan` FOREIGN KEY (`bahan_id`) REFERENCES `bahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_stokmasuk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ============================================================
-- Tabel Stok Keluar
-- ============================================================
CREATE TABLE IF NOT EXISTS `stok_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(30) NOT NULL,
  `bahan_id` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `tanggal` date NOT NULL,
  `keperluan` varchar(100) DEFAULT 'Pemakaian Harian',
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bahan_id` (`bahan_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_stokkeluar_bahan` FOREIGN KEY (`bahan_id`) REFERENCES `bahan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_stokkeluar_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ============================================================
-- Tabel Riwayat Aktivitas
-- ============================================================
CREATE TABLE IF NOT EXISTS `riwayat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipe` enum('masuk','keluar','edit','hapus') NOT NULL,
  `bahan_id` int(11) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `bahan_id` (`bahan_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

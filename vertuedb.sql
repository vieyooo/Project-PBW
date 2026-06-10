-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2026 at 07:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vertuedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `ID_BAHAN_BAKU` varchar(10) NOT NULL,
  `JENIS` varchar(100) NOT NULL,
  `KODE` varchar(30) DEFAULT NULL,
  `HARGA_SATUAN` decimal(15,2) NOT NULL,
  `SATUAN` varchar(20) NOT NULL,
  `STOK` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_baku`
--

INSERT INTO `bahan_baku` (`ID_BAHAN_BAKU`, `JENIS`, `KODE`, `HARGA_SATUAN`, `SATUAN`, `STOK`) VALUES
('BB-7001', 'Kulit Sapi Premium (Wollsdorf)', 'KUL-WOL-01', 800000.00, 'meter', 115),
('BB-7002', 'Kulit Semi (Synthetic Leather)', 'KUL-SYN-02', 250000.00, 'meter', 200),
('BB-7003', 'Alcantara', 'ALC-001', 500000.00, 'meter', 80),
('BB-7004', 'Busa Latex Dunlopillo', 'BUS-LTX-01', 360000.00, 'lembar', 43),
('BB-7005', 'Busa Reguler', 'BUS-REG-02', 200000.00, 'lembar', 100),
('BB-7006', 'Benang Jahit Nylon', 'BEN-NYL-01', 150000.00, 'roll', 29),
('BB-7007', 'Benang Jahit Polyester', 'BEN-POL-02', 120000.00, 'roll', 25),
('BB-7008', 'Lem Karet Contact', 'LEM-KRT-01', 70000.00, 'kg', 49),
('BB-7009', 'Karpet Karet', 'KRP-KRT-01', 80000.00, 'meter', 60),
('BB-7010', 'Karpet Bulu', 'KRP-BLU-02', 120000.00, 'meter', 40),
('BB-7011', 'Bracket Besi', 'BRK-BSI-01', 85000.00, 'pcs', 150),
('BB-7012', 'Panel Plastik Interior', 'PNL-PLS-01', 250000.00, 'set', 30),
('BB-7013', 'Velcro/Perekat', 'VEL-001', 60000.00, 'meter', 80),
('BB-7014', 'Kawat Spring Jok', 'KWT-SPG-01', 25000.00, 'meter', 98),
('BB-7015', 'Lapisan Foam Tipis', 'FOM-TPS-01', 45000.00, 'lembar', 70);

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `ID_BARANG` varchar(10) NOT NULL,
  `NAMA_BARANG` varchar(200) NOT NULL,
  `HARGA_SATUAN` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`ID_BARANG`, `NAMA_BARANG`, `HARGA_SATUAN`) VALUES
('BRG-3001', 'Lapis Jok Kulit Full (Mobil Sedan)', 7700000.00),
('BRG-3002', 'Lapis Jok Kulit Full (Mobil SUV)', 9450000.00),
('BRG-3003', 'Retrim Doortrim (per pintu)', 1200000.00),
('BRG-3004', 'Lapis Dashboard Soft Touch', 3500000.00),
('BRG-3005', 'Custom Arm Rest Console', 850000.00),
('BRG-3006', 'Setir Lapis Kulit', 950000.00),
('BRG-3007', 'Karpet Mobil Custom (set)', 1800000.00),
('BRG-3008', 'Modifikasi Bracket Sandaran Jok', 1500000.00),
('BRG-3009', 'Penambahan Busa Latex Jok', 3000000.00),
('BRG-3010', 'Restomod Interior Period-Correct', 15000000.00),
('BRG-3011', 'Lapis Headliner (kain/alcantara)', 2200000.00),
('BRG-3012', 'Shift Knob Custom', 450000.00),
('BRG-3013', 'Lapis Jok Motor (Sport)', 1750000.00),
('BRG-3014', 'Lapis Jok Motor (Matic)', 1250000.00),
('BRG-3015', 'Custom Full Interior (1 mobil)', 25000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `bom`
--

CREATE TABLE `bom` (
  `ID_BARANG` varchar(10) NOT NULL,
  `ID_BAHAN_BAKU` varchar(10) NOT NULL,
  `JUMLAH` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bom`
--

INSERT INTO `bom` (`ID_BARANG`, `ID_BAHAN_BAKU`, `JUMLAH`) VALUES
('BRG-3001', 'BB-7001', 4.50),
('BRG-3001', 'BB-7004', 2.00),
('BRG-3001', 'BB-7006', 1.00),
('BRG-3001', 'BB-7008', 0.50),
('BRG-3001', 'BB-7014', 2.00),
('BRG-3002', 'BB-7001', 5.50),
('BRG-3002', 'BB-7004', 2.50),
('BRG-3002', 'BB-7006', 1.20),
('BRG-3002', 'BB-7008', 0.70),
('BRG-3002', 'BB-7014', 2.50),
('BRG-3003', 'BB-7002', 1.50),
('BRG-3003', 'BB-7005', 0.50),
('BRG-3003', 'BB-7007', 0.50),
('BRG-3003', 'BB-7008', 0.20),
('BRG-3004', 'BB-7003', 2.00),
('BRG-3004', 'BB-7006', 0.50),
('BRG-3004', 'BB-7008', 0.30),
('BRG-3005', 'BB-7002', 0.50),
('BRG-3005', 'BB-7005', 0.30),
('BRG-3005', 'BB-7008', 0.10),
('BRG-3005', 'BB-7012', 1.00),
('BRG-3006', 'BB-7001', 0.80),
('BRG-3006', 'BB-7006', 0.30),
('BRG-3006', 'BB-7008', 0.10),
('BRG-3007', 'BB-7009', 4.00),
('BRG-3007', 'BB-7010', 2.00),
('BRG-3007', 'BB-7013', 2.00),
('BRG-3008', 'BB-7011', 2.00),
('BRG-3008', 'BB-7014', 1.00),
('BRG-3009', 'BB-7004', 1.00),
('BRG-3009', 'BB-7008', 0.20),
('BRG-3010', 'BB-7001', 8.00),
('BRG-3010', 'BB-7003', 4.00),
('BRG-3010', 'BB-7004', 3.00),
('BRG-3010', 'BB-7006', 2.00),
('BRG-3010', 'BB-7008', 1.00),
('BRG-3010', 'BB-7012', 2.00),
('BRG-3011', 'BB-7003', 2.50),
('BRG-3011', 'BB-7008', 0.50),
('BRG-3012', 'BB-7001', 0.20),
('BRG-3012', 'BB-7011', 1.00),
('BRG-3013', 'BB-7002', 1.50),
('BRG-3013', 'BB-7005', 1.00),
('BRG-3013', 'BB-7008', 0.30),
('BRG-3014', 'BB-7002', 1.20),
('BRG-3014', 'BB-7005', 0.80),
('BRG-3014', 'BB-7008', 0.20),
('BRG-3015', 'BB-7001', 12.00),
('BRG-3015', 'BB-7003', 6.00),
('BRG-3015', 'BB-7004', 5.00),
('BRG-3015', 'BB-7006', 3.00),
('BRG-3015', 'BB-7008', 2.00),
('BRG-3015', 'BB-7009', 6.00),
('BRG-3015', 'BB-7012', 4.00);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `NO_INVOICE` varchar(15) NOT NULL,
  `ID_BAHAN_BAKU` varchar(10) NOT NULL,
  `QTY` int(11) DEFAULT 0,
  `HARGA_JUAL` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`NO_INVOICE`, `ID_BAHAN_BAKU`, `QTY`, `HARGA_JUAL`) VALUES
('PO-6001', 'BB-7001', 10, 800000.00),
('PO-6001', 'BB-7002', 1, 500000.00),
('PO-6002', 'BB-7004', 20, 360000.00),
('PO-6003', 'BB-7005', 50, 80000.00),
('PO-6004', 'BB-7006', 20, 150000.00),
('PO-6005', 'BB-7008', 20, 85000.00),
('PO-6006', 'BB-7007', 20, 70000.00),
('PO-6007', 'BB-7011', 10, 500000.00),
('PO-6008', 'BB-7010', 4, 300000.00),
('PO-6009', 'BB-7012', 50, 50000.00),
('PO-6010', 'BB-7003', 30, 120000.00);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `ID_PENJUALAN` varchar(15) NOT NULL,
  `ID_BARANG` varchar(10) NOT NULL,
  `QTY` int(11) NOT NULL,
  `JUMLAH` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`ID_PENJUALAN`, `ID_BARANG`, `QTY`, `JUMLAH`) VALUES
('INV-4001', 'BRG-3001', 1, 4500000.00),
('INV-4001', 'BRG-3002', 1, 5500000.00),
('INV-4001', 'BRG-3006', 2, 1900000.00),
('INV-4002', 'BRG-3002', 1, 5500000.00),
('INV-4003', 'BRG-3010', 1, 15000000.00),
('INV-4004', 'BRG-3004', 1, 3500000.00),
('INV-4005', 'BRG-3005', 1, 850000.00),
('INV-4006', 'BRG-3006', 1, 950000.00),
('INV-4007', 'BRG-3007', 1, 1800000.00),
('INV-4008', 'BRG-3008', 1, 1500000.00),
('INV-4009', 'BRG-3009', 1, 3000000.00),
('INV-4010', 'BRG-3011', 1, 2200000.00),
('INV-4011', 'BRG-3012', 1, 450000.00),
('INV-4012', 'BRG-3013', 1, 1750000.00),
('INV-4013', 'BRG-3014', 1, 1250000.00),
('INV-4014', 'BRG-3015', 1, 25000000.00),
('INV-4015', 'BRG-3003', 4, 4800000.00),
('INV-4016', 'BRG-3004', 1, 3500000.00),
('INV-4017', 'BRG-3005', 1, 850000.00),
('INV-4018', 'BRG-3001', 1, 4500000.00),
('INV-4019', 'BRG-3007', 1, 1800000.00),
('INV-4020', 'BRG-3010', 1, 15000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_PELANGGAN` varchar(10) NOT NULL,
  `NAMA_PELANGGAN` varchar(100) NOT NULL,
  `ALAMAT` text DEFAULT NULL,
  `NO_TELP` varchar(20) DEFAULT NULL,
  `FAX` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`ID_PELANGGAN`, `NAMA_PELANGGAN`, `ALAMAT`, `NO_TELP`, `FAX`) VALUES
('PLG-2001', 'Arief Muhammad', 'Pondok Indah, Jakarta Selatan', '081234567890', NULL),
('PLG-2002', 'Andi Gumilar', 'Senayan City, Jakarta Pusat', '081298765432', NULL),
('PLG-2003', 'Budi Doremi', 'Kelapa Gading, Jakarta Utara', '081345678901', '(021)45871234'),
('PLG-2004', 'Citra Kirana', 'Ciputat, Tangerang Selatan', '081256789012', NULL),
('PLG-2005', 'Dian Sastro', 'Kemang, Jakarta Selatan', '081367890123', '(021)71923456'),
('PLG-2006', 'Eka Gustiwana', 'BSD City, Tangerang', '081278901234', NULL),
('PLG-2007', 'Fadil Jaidi', 'Bekasi Barat, Bekasi', '081389012345', '(021)88345678'),
('PLG-2008', 'Gading Marten', 'Pantai Indah Kapuk, Jakarta Utara', '081290123456', '(021)29671234'),
('PLG-2009', 'Hesti Purwadinata', 'Depok, Jawa Barat', '081301234567', NULL),
('PLG-2010', 'Iis Dahlia', 'Cibubur, Jakarta Timur', '081312345678', '(021)87324567');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `NO_INVOICE` varchar(15) NOT NULL,
  `TANGGAL` date NOT NULL,
  `ID_SUPPLIER` varchar(10) NOT NULL,
  `NILAI_DPP` decimal(15,2) DEFAULT 0.00,
  `PPN` decimal(15,2) DEFAULT 0.00,
  `ONGKOS_KIRIM` decimal(15,2) DEFAULT 0.00,
  `DISKON` decimal(15,2) DEFAULT 0.00,
  `TOTAL_INVOICE` decimal(15,2) NOT NULL,
  `JUMLAH_HARGA` decimal(15,2) DEFAULT 0.00,
  `SCAN_NOTA` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`NO_INVOICE`, `TANGGAL`, `ID_SUPPLIER`, `NILAI_DPP`, `PPN`, `ONGKOS_KIRIM`, `DISKON`, `TOTAL_INVOICE`, `JUMLAH_HARGA`, `SCAN_NOTA`) VALUES
('PO-6001', '2026-01-05', 'SP-5001', 8000000.00, 880000.00, 200000.00, 0.00, 9080000.00, 8000000.00, NULL),
('PO-6002', '2026-01-10', 'SP-5003', 7200000.00, 792000.00, 150000.00, 0.00, 8142000.00, 7200000.00, NULL),
('PO-6003', '2026-01-15', 'SP-5005', 4000000.00, 440000.00, 100000.00, 0.00, 4540000.00, 4000000.00, NULL),
('PO-6004', '2026-01-20', 'SP-5006', 3000000.00, 330000.00, 100000.00, 0.00, 3430000.00, 3000000.00, NULL),
('PO-6005', '2026-01-25', 'SP-5008', 1700000.00, 187000.00, 50000.00, 0.00, 1937000.00, 1700000.00, NULL),
('PO-6006', '2026-02-01', 'SP-5010', 1400000.00, 154000.00, 50000.00, 0.00, 1604000.00, 1400000.00, NULL),
('PO-6007', '2026-02-05', 'SP-5002', 5000000.00, 550000.00, 150000.00, 0.00, 5700000.00, 5000000.00, NULL),
('PO-6008', '2026-02-10', 'SP-5004', 12000000.00, 1320000.00, 300000.00, 500000.00, 14500000.00, 12000000.00, NULL),
('PO-6009', '2026-02-15', 'SP-5007', 2500000.00, 275000.00, 100000.00, 0.00, 2875000.00, 2500000.00, NULL),
('PO-6010', '2026-02-20', 'SP-5009', 3600000.00, 396000.00, 100000.00, 0.00, 4096000.00, 3600000.00, NULL),
('PO-6011', '2026-06-03', 'SP-5007', 720720.72, 79279.28, 80000.00, 0.00, 880000.00, 800000.00, 'img/scan_nota/PO-6011_20260603063458.jpg'),
('PO-6012', '2026-06-05', 'SP-5003', 335719584030.63, 36929154243.37, 43287472.00, 837927.00, 372691187819.00, 372648738274.00, 'img/scan_nota/PO-6012_20260605053617.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `ID_PENJUALAN` varchar(15) NOT NULL,
  `TANGGAL` date NOT NULL,
  `JATUH_TEMPO` date NOT NULL,
  `ID_PETUGAS` varchar(10) NOT NULL,
  `ID_PELANGGAN` varchar(10) NOT NULL,
  `SUBTOTAL` decimal(15,2) NOT NULL,
  `DISKON` decimal(15,2) DEFAULT 0.00,
  `TOTAL` decimal(15,2) NOT NULL,
  `SISA_TAGIHAN` decimal(15,2) NOT NULL,
  `PESAN` text DEFAULT NULL,
  `TERBILANG` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`ID_PENJUALAN`, `TANGGAL`, `JATUH_TEMPO`, `ID_PETUGAS`, `ID_PELANGGAN`, `SUBTOTAL`, `DISKON`, `TOTAL`, `SISA_TAGIHAN`, `PESAN`, `TERBILANG`) VALUES
('INV-4001', '2025-10-01', '2025-11-01', 'PG-1001', 'PLG-2001', 4500000.00, 0.00, 4500000.00, 0.00, 'Lapis jok mobil sedan warna hitam', 'Empat Juta Lima Ratus Ribu Rupiah'),
('INV-4002', '2025-10-05', '2025-11-05', 'PG-1002', 'PLG-2002', 5500000.00, 500000.00, 5000000.00, 0.00, 'Promo diskon 500rb untuk mobil SUV', 'Lima Juta Rupiah'),
('INV-4003', '2025-10-10', '2025-11-10', 'PG-1003', 'PLG-2003', 15000000.00, 0.00, 15000000.00, 7500000.00, 'DP 50% restomod Porsche 911', 'Lima Belas Juta Rupiah'),
('INV-4004', '2025-10-15', '2025-11-15', 'PG-1004', 'PLG-2004', 3500000.00, 350000.00, 3150000.00, 0.00, 'Lapis dashboard + disco 10%', 'Tiga Juta Seratus Lima Puluh Ribu Rupiah'),
('INV-4005', '2025-10-20', '2025-11-20', 'PG-1005', 'PLG-2005', 850000.00, 0.00, 850000.00, 850000.00, 'Arm rest console untuk Avanza', 'Delapan Ratus Lima Puluh Ribu Rupiah'),
('INV-4006', '2025-10-25', '2025-11-25', 'PG-1001', 'PLG-2006', 950000.00, 0.00, 950000.00, 0.00, 'Setir lapis kulit untuk BMW', 'Sembilan Ratus Lima Puluh Ribu Rupiah'),
('INV-4007', '2025-11-01', '2025-12-01', 'PG-1002', 'PLG-2007', 1800000.00, 0.00, 1800000.00, 900000.00, 'DP 50% karpet custom Xpander', 'Satu Juta Delapan Ratus Ribu Rupiah'),
('INV-4008', '2025-11-05', '2025-12-05', 'PG-1003', 'PLG-2008', 1500000.00, 0.00, 1500000.00, 1500000.00, 'Bracket sandaran jok untuk Pajero', 'Satu Juta Lima Ratus Ribu Rupiah'),
('INV-4009', '2025-11-10', '2025-12-10', 'PG-1004', 'PLG-2009', 3000000.00, 0.00, 3000000.00, 1500000.00, 'Penambahan busa latex + DP 50%', 'Tiga Juta Rupiah'),
('INV-4010', '2025-11-15', '2025-12-15', 'PG-1007', 'PLG-2010', 2200000.00, 0.00, 2200000.00, 0.00, 'Lapis headliner alcantara', 'Dua JutaDua Ratus Ribu Rupiah'),
('INV-4011', '2025-11-20', '2025-12-20', 'PG-1001', 'PLG-2001', 450000.00, 0.00, 450000.00, 450000.00, 'Shift knob custom untuk Civic', 'Empat Ratus Lima Puluh Ribu Rupiah'),
('INV-4012', '2025-11-25', '2025-12-25', 'PG-1002', 'PLG-2002', 1750000.00, 175000.00, 1575000.00, 0.00, 'Lapis jok motor sport + disco 10%', 'Satu Juta Lima Ratus Tujuh Puluh Lima Ribu Rupiah'),
('INV-4013', '2025-12-01', '2026-01-01', 'PG-1003', 'PLG-2003', 1250000.00, 0.00, 1250000.00, 1250000.00, 'Lapis jok motor matic untuk Nmax', 'Satu Juta Dua Ratus Lima Puluh Ribu Rupiah'),
('INV-4014', '2025-12-05', '2026-01-05', 'PG-1004', 'PLG-2004', 25000000.00, 0.00, 25000000.00, 12500000.00, 'Custom full interior Innova Zenix', 'Dua Puluh Lima Juta Rupiah'),
('INV-4015', '2025-12-10', '2026-01-10', 'PG-1005', 'PLG-2005', 1200000.00, 0.00, 1200000.00, 0.00, 'Retrim doortrim 4 pintu', 'Satu Juta Dua Ratus Ribu Rupiah'),
('INV-4016', '2025-12-15', '2026-01-15', 'PG-1001', 'PLG-2006', 3500000.00, 0.00, 3500000.00, 1750000.00, 'Lapis dashboard + DP 50%', 'Tiga Juta Lima Ratus Ribu Rupiah'),
('INV-4017', '2025-12-20', '2026-01-20', 'PG-1002', 'PLG-2007', 850000.00, 0.00, 850000.00, 0.00, 'Arm rest console untuk Rush', 'Delapan Ratus Lima Puluh Ribu Rupiah'),
('INV-4018', '2025-12-25', '2026-01-25', 'PG-1003', 'PLG-2008', 4500000.00, 0.00, 4500000.00, 0.00, 'Lapis jok full kulit sedan', 'Empat Juta Lima Ratus Ribu Rupiah'),
('INV-4019', '2026-01-01', '2026-02-01', 'PG-1004', 'PLG-2009', 1800000.00, 0.00, 1800000.00, 900000.00, 'Karpet custom + DP 50%', 'Satu Juta Delapan Ratus Ribu Rupiah'),
('INV-4020', '2026-01-05', '2026-02-05', 'PG-1005', 'PLG-2010', 15000000.00, 1500000.00, 13500000.00, 0.00, 'Restomod period correct + disco 10%', 'Tiga Belas Juta Lima Ratus Ribu Rupiah');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `ID_PETUGAS` varchar(10) NOT NULL,
  `NAMA_PETUGAS` varchar(100) NOT NULL,
  `JABATAN` varchar(50) NOT NULL,
  `FILE_TTD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`ID_PETUGAS`, `NAMA_PETUGAS`, `JABATAN`, `FILE_TTD`) VALUES
('PG-1001', 'Edy', 'Owner/Konsultan Interior', 'PG-1001_20260603030619.jpg'),
('PG-1002', 'Bambang Suharto', 'Head of Production', ''),
('PG-1003', 'Rizky Fadillah', 'Teknisi Senior (Restomod)', ''),
('PG-1004', 'Prasetyo Andi', 'Teknisi Junior (Jahit/Pola)', ''),
('PG-1005', 'Siti Nurjanah', 'Admin & Customer Service', ''),
('PG-1006', 'Sherly', 'Admin & Customer Services', 'uploads/ttd/PG-1006_20260602183958.jpg'),
('PG-1007', 'Eric', 'Teknisi Junior (Jahit/Pola)', 'PG-1007_20260603030123.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `ID_SUPPLIER` varchar(10) NOT NULL,
  `NAMA_SUPPLIER` varchar(100) NOT NULL,
  `ALAMAT` text DEFAULT NULL,
  `NO_TELP` varchar(20) DEFAULT NULL,
  `FAX` varchar(20) DEFAULT NULL,
  `PIC_SUPPLIER` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`ID_SUPPLIER`, `NAMA_SUPPLIER`, `ALAMAT`, `NO_TELP`, `FAX`, `PIC_SUPPLIER`) VALUES
('SP-5001', 'PT. Indo Leather Prima', 'Jl. Mangga Dua Raya No.18, Jakarta Utara', '(021)6123456', '(021)6123457', 'Hendra Wijaya'),
('SP-5002', 'CV. Alcantara Indonesia', 'Jl. Pulo Gadung Raya No.45, Jakarta Timur', '(021)47823456', '', 'Rina Kartika'),
('SP-5003', 'PT. Dunlopillo Indonesia', 'Jl. Cakung Cilincing Raya No.89, Jakarta Utara', '(021)44892345', '(021)44892346', 'Andi Setiawan'),
('SP-5004', 'PT. Wollsdorf Asia', 'Jl. Hayam Wuruk No.12, Jakarta Pusat', '(021)6257890', '(021)6257891', 'Richard Halim'),
('SP-5005', 'CV. Busa Jaya Abadi', 'Jl. Jatinegara Barat No.67, Jakarta Timur', '(021)8192345', '', 'Bayu Pradana'),
('SP-5006', 'PT. Benang Nusantara', 'Jl. Gajah Mada No.34, Jakarta Barat', '(021)6334567', '(021)6334568', 'Dedi Kurniawan'),
('SP-5007', 'CV. Trim Solution', 'Jl. Daan Mogot No.123, Jakarta Barat', '(021)5601234', '', 'Mega Suryani'),
('SP-5008', 'PT. Saratoga Sparepart', 'Jl. Otista Raya No.45, Jakarta Timur', '(021)8098765', '(021)8098766', 'Joko Prasetyo'),
('SP-5009', 'CV. Karpet Mobil Center', 'Jl. Tebet Raya No.78, Jakarta Selatan', '(021)8304567', '', 'Dewi Lestari'),
('SP-5010', 'PT. Lem Nusantara Chemical', 'Jl. PIK 2 Boulevard, Jakarta Utara', '(021)29567890', '(021)29567891', 'Budi Santoso');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`ID_BAHAN_BAKU`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`ID_BARANG`);

--
-- Indexes for table `bom`
--
ALTER TABLE `bom`
  ADD PRIMARY KEY (`ID_BARANG`,`ID_BAHAN_BAKU`),
  ADD KEY `ID_BAHAN` (`ID_BAHAN_BAKU`);

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`NO_INVOICE`,`ID_BAHAN_BAKU`),
  ADD KEY `fk_detail_bahan_baku` (`ID_BAHAN_BAKU`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`ID_PENJUALAN`,`ID_BARANG`),
  ADD KEY `ID_BARANG` (`ID_BARANG`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_PELANGGAN`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`NO_INVOICE`),
  ADD KEY `ID_SUPPLIER` (`ID_SUPPLIER`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`ID_PENJUALAN`),
  ADD KEY `ID_PETUGAS` (`ID_PETUGAS`),
  ADD KEY `ID_PELANGGAN` (`ID_PELANGGAN`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`ID_PETUGAS`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`ID_SUPPLIER`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bom`
--
ALTER TABLE `bom`
  ADD CONSTRAINT `bom_ibfk_1` FOREIGN KEY (`ID_BARANG`) REFERENCES `barang` (`ID_BARANG`),
  ADD CONSTRAINT `bom_ibfk_2` FOREIGN KEY (`ID_BAHAN_BAKU`) REFERENCES `bahan_baku` (`ID_BAHAN_BAKU`);

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `fk_detail_bahan_baku` FOREIGN KEY (`ID_BAHAN_BAKU`) REFERENCES `bahan_baku` (`ID_BAHAN_BAKU`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detail_pembelian` FOREIGN KEY (`NO_INVOICE`) REFERENCES `pembelian` (`NO_INVOICE`) ON DELETE CASCADE;

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`ID_PENJUALAN`) REFERENCES `penjualan` (`ID_PENJUALAN`),
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`ID_BARANG`) REFERENCES `barang` (`ID_BARANG`);

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`ID_SUPPLIER`) REFERENCES `supplier` (`ID_SUPPLIER`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`ID_PETUGAS`) REFERENCES `petugas` (`ID_PETUGAS`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

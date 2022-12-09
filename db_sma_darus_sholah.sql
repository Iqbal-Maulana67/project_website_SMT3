-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2022 at 02:39 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sma_darus_sholah`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `level` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `nama_admin`, `level`) VALUES
('admin', 'admin', 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` varchar(12) NOT NULL,
  `judul` varchar(60) NOT NULL,
  `tanggal_berita` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `thumbnail_berita` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_berita` enum('REKOMENDASI','BIASA') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul`, `tanggal_berita`, `thumbnail_berita`, `deskripsi`, `status_berita`) VALUES
('BRT012543', '1231232', '2022-12-06 02:39:43', 'image_berita_BRT012543.png', 'awdawdadwawdawdawdawd\r\nawdokawdoakwdoakwdoawdkawodkawodkawodkaowd\r\naowdkoawkdoakwdoadwkoawkdadw\r\nawdokaowdkaowdkaowdk', 'REKOMENDASI');

-- --------------------------------------------------------

--
-- Table structure for table `history_logs`
--

CREATE TABLE `history_logs` (
  `username` varchar(25) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` varchar(20) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_logs`
--

INSERT INTO `history_logs` (`username`, `timestamp`, `action`, `deskripsi`) VALUES
('admin', '2022-12-06 07:28:56', 'TAMBAH', 'admin telah melakukan TAMBAH pada data 00341232411 di Data Alumni');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` varchar(10) NOT NULL,
  `nama_jurusan` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
('JRS0000001', 'IPA'),
('JRS0000002', 'Umum');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_aktif`
--

CREATE TABLE `siswa_aktif` (
  `nisn` varchar(10) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `kelas` enum('X','XI','XII') DEFAULT NULL,
  `golongan` char(1) DEFAULT NULL,
  `id_jurusan` varchar(10) DEFAULT NULL,
  `nama_ortu` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) NOT NULL,
  `status` enum('TIDAK AKTIF','AKTIF','ALUMNI') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa_aktif`
--

INSERT INTO `siswa_aktif` (`nisn`, `nama_siswa`, `jenis_kelamin`, `kelas`, `golongan`, `id_jurusan`, `nama_ortu`, `alamat`, `status`) VALUES
('0032412301', 'Maulanaa', 'L', 'XII', 'A', 'JRS0000002', 'Iya', 'Bali', 'AKTIF'),
('0034123231', 'Wasap', 'L', 'XII', 'B', 'JRS0000001', 'Asep', 'Paiton', 'AKTIF'),
('0034123241', 'Wasap', 'L', 'XI', 'A', 'JRS0000002', 'Iya', 'awdawd', 'AKTIF'),
('12341282', 'Fiekriie', 'P', 'X', 'C', 'JRS0000001', 'Iqbal Maulana', 'Paiton', 'AKTIF'),
('351231753', 'Iqbal', 'L', 'XII', 'B', 'JRS0000002', 'Maulana Fiekri', 'Mastrip', 'ALUMNI');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_alumni`
--

CREATE TABLE `siswa_alumni` (
  `nisn` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `nomer_hp` varchar(13) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tahun_lulusan` varchar(4) NOT NULL,
  `status_alumni` enum('Kuliah','Kerja') NOT NULL,
  `nama_instansi` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa_alumni`
--

INSERT INTO `siswa_alumni` (`nisn`, `nama`, `jenis_kelamin`, `nomer_hp`, `alamat`, `tahun_lulusan`, `status_alumni`, `nama_instansi`, `password`) VALUES
('00341231', 'Maulane', 'L', '08343834311', 'Paiton', '2022', 'Kerja', 'POLIJE', '3123123'),
('0083491293', 'Nalar', 'L', '083833383383', 'Diluar Nalar', '2021', 'Kuliah', 'POLIJE', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `validasi_status_alumni`
--

CREATE TABLE `validasi_status_alumni` (
  `nisn` varchar(10) NOT NULL,
  `status_alumni` enum('Kuliah','Kerja') NOT NULL,
  `nama_instansi` varchar(50) NOT NULL,
  `img_pendukung` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `validasi_status_alumni`
--

INSERT INTO `validasi_status_alumni` (`nisn`, `status_alumni`, `nama_instansi`, `img_pendukung`) VALUES
('0083491293', 'Kuliah', 'POLINEMA', 'validasi_status_images_0083491293.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `siswa_aktif`
--
ALTER TABLE `siswa_aktif`
  ADD PRIMARY KEY (`nisn`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indexes for table `siswa_alumni`
--
ALTER TABLE `siswa_alumni`
  ADD PRIMARY KEY (`nisn`);

--
-- Indexes for table `validasi_status_alumni`
--
ALTER TABLE `validasi_status_alumni`
  ADD KEY `nisn` (`nisn`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `siswa_aktif`
--
ALTER TABLE `siswa_aktif`
  ADD CONSTRAINT `siswa_aktif_ibfk_1` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`);

--
-- Constraints for table `validasi_status_alumni`
--
ALTER TABLE `validasi_status_alumni`
  ADD CONSTRAINT `validasi_status_alumni_ibfk_1` FOREIGN KEY (`nisn`) REFERENCES `siswa_alumni` (`nisn`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

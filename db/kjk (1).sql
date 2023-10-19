-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Feb 2021 pada 07.32
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kjk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id_jenis` varchar(50) NOT NULL,
  `jenis_brg` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_barang`
--

INSERT INTO `jenis_barang` (`id_jenis`, `jenis_brg`) VALUES
('1', 'ATK'),
('2', 'ALAT KEBERSIHAN'),
('3', 'PERLENGKAPAN LAINNYA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id` int(11) NOT NULL,
  `unit` varchar(30) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemasukan`
--

INSERT INTO `pemasukan` (`id`, `unit`, `kode_brg`, `jumlah`, `tgl_masuk`) VALUES
(18, 'Siti Rusdah', '111.002', 100, '2020-11-12'),
(19, 'Siti Rusdah', '111.001', 12, '2020-11-13'),
(20, 'Siti Rusdah', '111.001', 10, '2020-11-13'),
(21, 'Siti Rusdah', '111.002', 10, '2020-11-13'),
(22, 'Siti Rusdah', '111.003', 10, '2020-11-13'),
(23, 'Siti Rusdah', '111.001', 10, '2020-11-19'),
(24, 'Siti Rusdah', '112.002', 10, '2020-11-19');

--
-- Trigger `pemasukan`
--
DELIMITER $$
CREATE TRIGGER `MASUK` AFTER INSERT ON `pemasukan` FOR EACH ROW BEGIN
  update stokbarang SET stok=stok + NEW.jumlah 
  WHERE kode_brg = NEW.kode_brg;
  
  update stokbarang SET sisa=sisa + NEW.jumlah 
  WHERE kode_brg = NEW.kode_brg;
  
	update pengajuan SET status=1 WHERE kode_brg=NEW.kode_brg AND 
	unit=NEW.unit;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(11) NOT NULL,
  `hargabarang` double NOT NULL,
  `total` double NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengajuan`
--

INSERT INTO `pengajuan` (`id_pengajuan`, `unit`, `kode_brg`, `id_jenis`, `jumlah`, `satuan`, `hargabarang`, `total`, `tgl_pengajuan`, `status`) VALUES
(48, 'Siti Rusdah', '111.002', 1, 100, 'PACK', 15000, 1500000, '2020-11-12', 1),
(49, 'Siti Rusdah', '111.001', 1, 12, 'PACK', 25000, 300000, '2020-11-13', 1),
(50, 'Siti Rusdah', '111.001', 1, 10, 'PACK', 25000, 250000, '2020-11-13', 1),
(51, 'Siti Rusdah', '111.002', 1, 10, 'PACK', 15000, 150000, '2020-11-13', 1),
(52, 'Siti Rusdah', '111.003', 1, 10, 'RIM', 45000, 450000, '2020-11-13', 1),
(53, 'Siti Rusdah', '111.001', 1, 10, 'PACK', 25000, 250000, '2020-11-19', 1),
(54, 'Siti Rusdah', '112.002', 2, 10, 'BUAH', 15000, 150000, '2020-11-19', 1),
(55, 'Siti Rusdah', '113.003', 3, 100, 'PACK', 15000, 1500000, '2021-02-12', 0),
(56, 'Siti Rusdah', '112.004', 2, 100, 'SATUAN', 10000, 1000000, '2021-02-12', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_sementara`
--

CREATE TABLE `pengajuan_sementara` (
  `id_pengajuan_sementara` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `hargabarang` double NOT NULL,
  `total` double NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_keluar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `unit`, `kode_brg`, `jumlah`, `tgl_keluar`) VALUES
(52, 'Desi Novita', '111.001', 10, '2020-11-12'),
(53, 'Desi Novita', '111.003', 10, '2020-11-13'),
(54, 'Desi Novita', '111.001', 5, '2020-11-19'),
(55, 'Desi Novita', '112.001', 5, '2020-11-19'),
(56, 'Ratna Fauziah', '111.001', 1, '2021-02-12'),
(57, 'Ratna Fauziah', '112.001', 2, '2021-02-12'),
(58, 'Desi Novita', '112.001', 2, '2021-02-12');

--
-- Trigger `pengeluaran`
--
DELIMITER $$
CREATE TRIGGER `TG_STOK_UPDATE` AFTER INSERT ON `pengeluaran` FOR EACH ROW BEGIN
	update stokbarang SET keluar=keluar + NEW.jumlah, 
	sisa=stok-keluar WHERE 
	kode_brg = NEW.kode_brg;

	update permintaan SET status=1 WHERE kode_brg=NEW.kode_brg AND 
	unit=NEW.unit;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `permintaan`
--

CREATE TABLE `permintaan` (
  `id_permintaan` int(100) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `instansi` varchar(20) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `permintaan`
--

INSERT INTO `permintaan` (`id_permintaan`, `unit`, `instansi`, `kode_brg`, `id_jenis`, `jumlah`, `tgl_permintaan`, `status`) VALUES
(103, 'Ratna Fauziah', 'PPSU', '111.001', 1, 1, '2021-02-12', 1),
(105, 'Ratna Fauziah', 'PPSU', '112.002', 2, 1, '2021-02-12', 2),
(102, 'Desi Novita', 'RPTRA', '112.001', 2, 2, '2021-02-12', 1),
(100, 'Desi Novita', 'RPTRA', '111.001', 1, 5, '2020-11-19', 1),
(101, 'Desi Novita', 'RPTRA', '112.001', 2, 5, '2020-11-19', 1),
(104, 'Ratna Fauziah', 'PPSU', '112.001', 2, 2, '2021-02-12', 1),
(98, 'Desi Novita', 'RPTRA', '111.001', 1, 10, '2020-11-12', 1),
(99, 'Desi Novita', 'RPTRA', '111.003', 1, 10, '2020-11-13', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sementara`
--

CREATE TABLE `sementara` (
  `id_sementara` int(100) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `instansi` varchar(20) NOT NULL,
  `kode_brg` varchar(7) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stokbarang`
--

CREATE TABLE `stokbarang` (
  `id_kode_brg` int(2) NOT NULL,
  `kode_brg` varchar(7) CHARACTER SET latin1 NOT NULL,
  `id_jenis` int(2) NOT NULL,
  `nama_brg` varchar(50) CHARACTER SET latin1 NOT NULL,
  `hargabarang` varchar(50) CHARACTER SET latin1 NOT NULL,
  `satuan` varchar(50) CHARACTER SET latin1 NOT NULL,
  `stok` int(11) NOT NULL,
  `keluar` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  `keterangan` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stokbarang`
--

INSERT INTO `stokbarang` (`id_kode_brg`, `kode_brg`, `id_jenis`, `nama_brg`, `hargabarang`, `satuan`, `stok`, `keluar`, `sisa`, `keterangan`) VALUES
(23, '111.001', 1, 'BALLPOINT', '25000', 'PACK', 132, 16, 116, ''),
(24, '111.002', 1, 'PENSIL', '15000', 'PACK', 110, 0, 120, ''),
(25, '111.003', 1, 'KERTAS F4', '45000', 'RIM', 110, 10, 100, ''),
(26, '111.004', 1, 'PENGHAPUS KARET', '5500', 'SET', 0, 0, 0, ''),
(27, '111.005', 1, 'PENGHAPUS CAIR', '14000', 'LUSIN', 0, 0, 0, ''),
(28, '111.006', 1, 'BUKU TULIS FOLIO', '15500', 'PACK', 0, 0, 0, ''),
(29, '111.007', 1, 'ODNER KARTON', '10000', 'BUAH', 0, 0, 0, 'STOK ABIS'),
(30, '111.008', 1, 'ISI CUTTOR', '5000', 'BUAH', 0, 0, 0, ''),
(31, '111.009', 1, 'LAKBAN BENING GOLD TAPE', '12000', 'BUAH', 0, 0, 0, ''),
(32, '111.010', 1, 'DOUBLE TAPE', '15000', 'PACK', 0, 0, 0, ''),
(33, '111.011', 1, 'SELOTIP', '8000', 'PACK', 0, 0, 0, ''),
(34, '111.012', 1, 'LEM KERTAS', '2500', 'SATUAN', 0, 0, 0, ''),
(35, '111.013', 1, 'REMOVER STAPLER', '9000', 'SATUAN', 0, 0, 0, ''),
(36, '112.001', 2, 'LAP PEL', '15000', 'BUAH', 100, 9, 91, ''),
(37, '112.002', 2, 'EMBER', '15000', 'BUAH', 10, 0, 10, ''),
(40, '112.004', 2, 'KANEBO', '10000', 'SATUAN', 0, 0, 0, ''),
(41, '112.005', 2, 'PEMBERSIH KACA', '15000', 'SATUAN', 0, 0, 0, ''),
(42, '112.006', 2, 'SABUN CUCI TANGAN', '24000', 'SATUAN', 0, 0, 0, ''),
(43, '112.007', 2, 'PEWANGI LANTAI', '5000', 'SATUAN', 0, 0, 0, ''),
(44, '112.008', 2, 'TISSUE', '10000', 'SATUAN', 0, 0, 0, ''),
(45, '112.009', 2, 'PROSTEX', '15000', 'SATUAN', 0, 5, 0, ''),
(46, '112.010', 2, 'SABUN CUCI PIRING', '10000', 'SATUAN', 0, 0, 0, ''),
(47, '112.011', 2, 'SAPU LIDI', '12500', 'UNIT', 0, 0, 0, ''),
(52, '113.001', 3, 'LAMPU HEMAT ENERGI', '45000', 'SATUAN', 100, 0, 0, ''),
(53, '113.002', 3, 'LAMPU TEMBAK', '85000', 'SATUAN', 0, 0, 0, 'STOK ABIS'),
(54, '113.003', 3, 'BATTERAI', '15000', 'PACK', 0, 0, 0, ''),
(55, '111.014', 1, 'TES', '25000', 'DUS', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('instansi','bendahara','it') NOT NULL,
  `jabatan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level`, `jabatan`) VALUES
(1, 'Siti Rusdah', '21232f297a57a5a743894a0e4a801fc3', 'bendahara', 'BENDAHARA'),
(10, 'Ratna Fauziah', '21232f297a57a5a743894a0e4a801fc3', 'instansi', 'PPSU'),
(13, 'Desi Novita', '21232f297a57a5a743894a0e4a801fc3', 'instansi', 'RPTRA');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indeks untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indeks untuk tabel `pengajuan_sementara`
--
ALTER TABLE `pengajuan_sementara`
  ADD PRIMARY KEY (`id_pengajuan_sementara`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`id_permintaan`);

--
-- Indeks untuk tabel `sementara`
--
ALTER TABLE `sementara`
  ADD PRIMARY KEY (`id_sementara`);

--
-- Indeks untuk tabel `stokbarang`
--
ALTER TABLE `stokbarang`
  ADD PRIMARY KEY (`id_kode_brg`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `pengajuan_sementara`
--
ALTER TABLE `pengajuan_sementara`
  MODIFY `id_pengajuan_sementara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `id_permintaan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT untuk tabel `sementara`
--
ALTER TABLE `sementara`
  MODIFY `id_sementara` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT untuk tabel `stokbarang`
--
ALTER TABLE `stokbarang`
  MODIFY `id_kode_brg` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

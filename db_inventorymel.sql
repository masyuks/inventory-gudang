-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 27 Feb 2021 pada 05.57
-- Versi Server: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventorymel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `baku`
--

CREATE TABLE `baku` (
  `id_baku` bigint(20) NOT NULL,
  `nama_baku` varchar(100) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `produsen` varchar(50) DEFAULT NULL,
  `stok` double NOT NULL,
  `stok_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `input_baku`
--

CREATE TABLE `input_baku` (
  `id_input` bigint(20) NOT NULL,
  `id_baku` bigint(20) NOT NULL,
  `id_supplier` bigint(20) NOT NULL,
  `qty_input` double NOT NULL,
  `tgl_input` date NOT NULL,
  `h_stokInput` int(11) NOT NULL,
  `nama_baku` varchar(100) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `produsen` varchar(50) DEFAULT NULL,
  `id_user` bigint(20) NOT NULL,
  `batch` varchar(50) NOT NULL,
  `expired` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `fifo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `input_items`
--

CREATE TABLE `input_items` (
  `id_input` bigint(11) NOT NULL,
  `id_item` bigint(11) DEFAULT NULL,
  `id_supplier` bigint(11) DEFAULT NULL,
  `qty_input` int(11) NOT NULL,
  `kb_input` int(11) NOT NULL,
  `tgl_input` date NOT NULL,
  `h_stokInput` int(11) NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `netto` varchar(50) NOT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `id_user` bigint(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `items`
--

CREATE TABLE `items` (
  `id_item` bigint(11) NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `netto` varchar(50) NOT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `stok` int(11) NOT NULL,
  `kb` int(11) NOT NULL,
  `stok_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `output_baku`
--

CREATE TABLE `output_baku` (
  `id_output` bigint(20) NOT NULL,
  `id_baku` bigint(20) NOT NULL,
  `qty_output` double NOT NULL,
  `tgl_output` date NOT NULL,
  `h_stokOutput` int(11) NOT NULL,
  `nama_baku` varchar(100) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `produsen` varchar(50) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `id_user` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `output_items`
--

CREATE TABLE `output_items` (
  `id_output` bigint(11) NOT NULL,
  `id_item` bigint(11) DEFAULT NULL,
  `qty_output` int(11) NOT NULL,
  `kb_output` int(11) NOT NULL,
  `tgl_output` date NOT NULL,
  `h_stokOutput` int(11) NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `netto` varchar(50) NOT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `id_user` bigint(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id_supplier` bigint(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `kontak` varchar(30) DEFAULT NULL,
  `transaksi_terakhir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers_baku`
--

CREATE TABLE `suppliers_baku` (
  `id_supplier` bigint(20) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `kontak` varchar(30) DEFAULT NULL,
  `transaksi_terakhir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_baku`
--

CREATE TABLE `transaksi_baku` (
  `id_tb` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `stok_masuk` double NOT NULL,
  `stok_keluar` double NOT NULL,
  `sisa_stok` double NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `id_baku` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_items`
--

CREATE TABLE `transaksi_items` (
  `id_ti` bigint(11) NOT NULL,
  `tanggal` date NOT NULL,
  `stok_masuk` int(11) NOT NULL,
  `kb_masuk` int(11) NOT NULL,
  `stok_keluar` int(11) NOT NULL,
  `kb_keluar` int(11) NOT NULL,
  `sisa_stok` int(11) DEFAULT NULL,
  `sisa_kb` int(11) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `id_item` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` bigint(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `email`, `password`, `level`) VALUES
(2, 'superadmin', 'superadmin@superadmin.com', '17c4520f6cfd1ab53d8745e84681eb49', 'superadmin'),
(10, 'admin kemas', 'adminkemas@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'adminkemas'),
(11, 'admin baku', 'adminbaku@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'adminbaku');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baku`
--
ALTER TABLE `baku`
  ADD PRIMARY KEY (`id_baku`);

--
-- Indexes for table `input_baku`
--
ALTER TABLE `input_baku`
  ADD PRIMARY KEY (`id_input`);

--
-- Indexes for table `input_items`
--
ALTER TABLE `input_items`
  ADD PRIMARY KEY (`id_input`),
  ADD KEY `id_items` (`id_item`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `output_baku`
--
ALTER TABLE `output_baku`
  ADD PRIMARY KEY (`id_output`);

--
-- Indexes for table `output_items`
--
ALTER TABLE `output_items`
  ADD PRIMARY KEY (`id_output`),
  ADD KEY `id_items` (`id_item`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `suppliers_baku`
--
ALTER TABLE `suppliers_baku`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `transaksi_baku`
--
ALTER TABLE `transaksi_baku`
  ADD PRIMARY KEY (`id_tb`);

--
-- Indexes for table `transaksi_items`
--
ALTER TABLE `transaksi_items`
  ADD PRIMARY KEY (`id_ti`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baku`
--
ALTER TABLE `baku`
  MODIFY `id_baku` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `input_baku`
--
ALTER TABLE `input_baku`
  MODIFY `id_input` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `input_items`
--
ALTER TABLE `input_items`
  MODIFY `id_input` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id_item` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `output_baku`
--
ALTER TABLE `output_baku`
  MODIFY `id_output` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `output_items`
--
ALTER TABLE `output_items`
  MODIFY `id_output` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id_supplier` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suppliers_baku`
--
ALTER TABLE `suppliers_baku`
  MODIFY `id_supplier` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transaksi_baku`
--
ALTER TABLE `transaksi_baku`
  MODIFY `id_tb` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transaksi_items`
--
ALTER TABLE `transaksi_items`
  MODIFY `id_ti` bigint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

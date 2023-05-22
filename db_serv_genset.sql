-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Bulan Mei 2023 pada 11.24
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_serv_genset`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_avatar`
--

CREATE TABLE `tb_avatar` (
  `id` int(11) NOT NULL,
  `username_user` varchar(50) NOT NULL,
  `nama_file` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_avatar`
--

INSERT INTO `tb_avatar` (`id`, `username_user`, `nama_file`) VALUES
(1, 'admin', 'nopic.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_genset`
--

CREATE TABLE `tb_genset` (
  `id_genset` int(11) NOT NULL,
  `kode_genset` varchar(20) NOT NULL,
  `nama_genset` varchar(50) NOT NULL,
  `daya` varchar(20) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `stok_gd` varchar(20) NOT NULL,
  `stok_pj` varchar(20) NOT NULL,
  `gambar_genset` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_genset`
--

INSERT INTO `tb_genset` (`id_genset`, `kode_genset`, `nama_genset`, `daya`, `harga`, `stok_gd`, `stok_pj`, `gambar_genset`) VALUES
(2, '02', 'Hartech 45 P-02', '40', '1000000', '1', '0', 'ht45p-02.jpg'),
(3, '07', 'Denyo 25 ES-07', '20', '750000', '1', '0', 'denyo25es-07.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pemakai`
--

CREATE TABLE `tb_pemakai` (
  `id_pemakai` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `tgl_update` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_pemakai`
--

INSERT INTO `tb_pemakai` (`id_pemakai`, `nama`, `alamat`, `no_hp`, `tgl_update`) VALUES
(10, 'Adul', 'Jl. AKT', '0895619213134', '2023-04-10'),
(11, 'Aldi', 'Jl. sungai miai', '089561921342', '2023-04-11'),
(12, 'Abu', 'Handil Bakti', '0895619019104', '2023-04-12'),
(13, 'Ahmad Yani', 'Berangas', '0895619211231', '2023-04-13'),
(14, 'Amat', 'BJIB', '0895619213124', '2023-04-14'),
(15, 'Budi', 'Jl. Batu benawa', '0895619213234', '2023-04-17'),
(16, 'Halikin', 'Jl. Sultan', '0895619014532', '2023-04-18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_serv_genset`
--

CREATE TABLE `tb_serv_genset` (
  `id_perbaikan_gst` int(11) NOT NULL,
  `id_genset` int(11) NOT NULL,
  `id_sparepart` int(11) NOT NULL,
  `id_pemakai` int(11) NOT NULL,
  `jenis_perbaikan` varchar(255) NOT NULL,
  `tgl_perbaikan` date NOT NULL,
  `ket_perbaikan` varchar(255) NOT NULL,
  `biaya_perbaikan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_serv_genset`
--

INSERT INTO `tb_serv_genset` (`id_perbaikan_gst`, `id_genset`, `id_sparepart`, `id_pemakai`, `jenis_perbaikan`, `tgl_perbaikan`, `ket_perbaikan`, `biaya_perbaikan`) VALUES
(3, 2, 1, 10, 'Filter masuk angin', '2023-04-21', 'Selesai Diperbaiki', '0'),
(4, 2, 2, 11, 'Ganti Oli', '2023-04-20', 'Selesai Diperbaiki', '100000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sparepart`
--

CREATE TABLE `tb_sparepart` (
  `id_sparepart` int(11) NOT NULL,
  `nama_sparepart` varchar(255) NOT NULL,
  `tanggal_beli` date NOT NULL,
  `tempat_beli` varchar(255) NOT NULL,
  `stok` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_sparepart`
--

INSERT INTO `tb_sparepart` (`id_sparepart`, `nama_sparepart`, `tanggal_beli`, `tempat_beli`, `stok`) VALUES
(1, 'Filter Oli Donaldson', '2023-04-04', 'Multi Filter', '2'),
(2, 'oli sx', '2023-04-03', 'Bengkel Yuno', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `last_login` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `nama`, `password`, `role`, `last_login`) VALUES
(1, 'admin', 'admin1', '$2y$10$aO3xt9YrcbuTWoyMr92ksu5jQBccl2e4U7wKk3Yr29RcZ2LPOeFUm', 0, '23-04-2023 17:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_avatar`
--
ALTER TABLE `tb_avatar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_genset`
--
ALTER TABLE `tb_genset`
  ADD PRIMARY KEY (`id_genset`);

--
-- Indeks untuk tabel `tb_pemakai`
--
ALTER TABLE `tb_pemakai`
  ADD PRIMARY KEY (`id_pemakai`);

--
-- Indeks untuk tabel `tb_serv_genset`
--
ALTER TABLE `tb_serv_genset`
  ADD PRIMARY KEY (`id_perbaikan_gst`),
  ADD KEY `id_genset` (`id_genset`,`id_sparepart`),
  ADD KEY `id_pemakai` (`id_pemakai`),
  ADD KEY `id_sparepart` (`id_sparepart`);

--
-- Indeks untuk tabel `tb_sparepart`
--
ALTER TABLE `tb_sparepart`
  ADD PRIMARY KEY (`id_sparepart`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_avatar`
--
ALTER TABLE `tb_avatar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_genset`
--
ALTER TABLE `tb_genset`
  MODIFY `id_genset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_pemakai`
--
ALTER TABLE `tb_pemakai`
  MODIFY `id_pemakai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `tb_serv_genset`
--
ALTER TABLE `tb_serv_genset`
  MODIFY `id_perbaikan_gst` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_sparepart`
--
ALTER TABLE `tb_sparepart`
  MODIFY `id_sparepart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_serv_genset`
--
ALTER TABLE `tb_serv_genset`
  ADD CONSTRAINT `tb_serv_genset_ibfk_1` FOREIGN KEY (`id_genset`) REFERENCES `tb_genset` (`id_genset`),
  ADD CONSTRAINT `tb_serv_genset_ibfk_2` FOREIGN KEY (`id_sparepart`) REFERENCES `tb_sparepart` (`id_sparepart`),
  ADD CONSTRAINT `tb_serv_genset_ibfk_3` FOREIGN KEY (`id_pemakai`) REFERENCES `tb_pemakai` (`id_pemakai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

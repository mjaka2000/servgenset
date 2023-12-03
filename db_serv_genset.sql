-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Des 2023 pada 15.15
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
-- Struktur dari tabel `tb_detail_serv`
--

CREATE TABLE `tb_detail_serv` (
  `id_detail_serv` int(11) NOT NULL,
  `id_perbaikan_gst` int(11) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `kendala` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `ket_genset` tinyint(4) NOT NULL DEFAULT 0,
  `gambar_genset` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_genset`
--

INSERT INTO `tb_genset` (`id_genset`, `kode_genset`, `nama_genset`, `daya`, `harga`, `ket_genset`, `gambar_genset`) VALUES
(1, '10', 'Denyo 25 ES-10', '20', '750000', 0, 'denyo25es-10.jpg'),
(2, '07', 'Denyo 25 ES-07', '20', '750000', 0, 'denyo25es-07.jpg'),
(3, '13', 'Denyo 25 ES-13', '20', '750000', 0, 'denyo25es-13.jpg'),
(4, '08', 'Kubota 13-08', '13', '500000', 0, 'kubota13-08.jpg'),
(5, '02', 'Hartech 45 P-02', '40', '1000000', 0, 'ht45p-02.jpg'),
(6, '18', 'Hartech 45 P-18', '40', '1000000', 0, 'ht45p-18.jpg'),
(7, '16', 'Hartech 50 P-16', '50', '1250000', 0, 'ht50p-16.jpg'),
(8, '200', 'Denyo 150', '150', '2500000', 0, 'denyo_dca-150_spk-200.jpg'),
(11, '250', 'Hartech C-250', '250', '3500000', 0, 'ht250.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pemakai`
--

CREATE TABLE `tb_pemakai` (
  `id_pemakai` int(11) NOT NULL,
  `nama_pemakai` varchar(50) NOT NULL,
  `alamat_pemakai` varchar(50) NOT NULL,
  `no_hp_pemakai` varchar(20) NOT NULL,
  `tgl_update_pemakai` date NOT NULL,
  `status_pemakai` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengeluaran`
--

CREATE TABLE `tb_pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `pengeluaran` varchar(255) NOT NULL,
  `biaya_pengeluaran` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `jam_pakai` varchar(10) NOT NULL,
  `ket_perbaikan` varchar(255) NOT NULL,
  `biaya_perbaikan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_serv_gst_acc`
--

CREATE TABLE `tb_serv_gst_acc` (
  `id_serv_gst_acc` int(11) NOT NULL,
  `id_perbaikan_gst` int(11) NOT NULL,
  `tgl_setujui` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status_ajuan` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sparepart`
--

CREATE TABLE `tb_sparepart` (
  `id_sparepart` int(11) NOT NULL,
  `nama_sparepart` varchar(255) NOT NULL,
  `tanggal_beli` date NOT NULL,
  `tempat_beli` varchar(255) NOT NULL,
  `stok` varchar(20) NOT NULL,
  `harga_sparepart` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `nama_file` varchar(150) NOT NULL,
  `last_login` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `nama`, `password`, `role`, `nama_file`, `last_login`) VALUES
(1, 'admin', 'admin1', '$2y$10$aO3xt9YrcbuTWoyMr92ksu5jQBccl2e4U7wKk3Yr29RcZ2LPOeFUm', 0, 'Muhammad_Jaka_Permana_(Latar_Merah)-square.jpg', '03-12-2023 21:41');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_detail_serv`
--
ALTER TABLE `tb_detail_serv`
  ADD PRIMARY KEY (`id_detail_serv`);

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
-- Indeks untuk tabel `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indeks untuk tabel `tb_serv_genset`
--
ALTER TABLE `tb_serv_genset`
  ADD PRIMARY KEY (`id_perbaikan_gst`),
  ADD KEY `id_genset` (`id_genset`,`id_sparepart`),
  ADD KEY `id_pemakai` (`id_pemakai`),
  ADD KEY `id_sparepart` (`id_sparepart`);

--
-- Indeks untuk tabel `tb_serv_gst_acc`
--
ALTER TABLE `tb_serv_gst_acc`
  ADD PRIMARY KEY (`id_serv_gst_acc`);

--
-- Indeks untuk tabel `tb_sparepart`
--
ALTER TABLE `tb_sparepart`
  ADD PRIMARY KEY (`id_sparepart`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_detail_serv`
--
ALTER TABLE `tb_detail_serv`
  MODIFY `id_detail_serv` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_genset`
--
ALTER TABLE `tb_genset`
  MODIFY `id_genset` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_pemakai`
--
ALTER TABLE `tb_pemakai`
  MODIFY `id_pemakai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_serv_genset`
--
ALTER TABLE `tb_serv_genset`
  MODIFY `id_perbaikan_gst` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_serv_gst_acc`
--
ALTER TABLE `tb_serv_gst_acc`
  MODIFY `id_serv_gst_acc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_sparepart`
--
ALTER TABLE `tb_sparepart`
  MODIFY `id_sparepart` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_serv_genset`
--
ALTER TABLE `tb_serv_genset`
  ADD CONSTRAINT `tb_serv_genset_ibfk_1` FOREIGN KEY (`id_sparepart`) REFERENCES `tb_sparepart` (`id_sparepart`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_serv_genset_ibfk_2` FOREIGN KEY (`id_pemakai`) REFERENCES `tb_pemakai` (`id_pemakai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_serv_genset_ibfk_3` FOREIGN KEY (`id_genset`) REFERENCES `tb_genset` (`id_genset`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

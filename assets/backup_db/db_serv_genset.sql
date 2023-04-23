#
# TABLE STRUCTURE FOR: tb_avatar
#

DROP TABLE IF EXISTS `tb_avatar`;

CREATE TABLE `tb_avatar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username_user` varchar(50) NOT NULL,
  `nama_file` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_avatar` (`id`, `username_user`, `nama_file`) VALUES (1, 'admin', 'nopic.png');


#
# TABLE STRUCTURE FOR: tb_genset
#

DROP TABLE IF EXISTS `tb_genset`;

CREATE TABLE `tb_genset` (
  `id_genset` int(11) NOT NULL AUTO_INCREMENT,
  `kode_genset` varchar(20) NOT NULL,
  `nama_genset` varchar(50) NOT NULL,
  `daya` varchar(20) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `stok_gd` varchar(20) NOT NULL,
  `stok_pj` varchar(20) NOT NULL,
  `gambar_genset` varchar(50) NOT NULL,
  PRIMARY KEY (`id_genset`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_genset` (`id_genset`, `kode_genset`, `nama_genset`, `daya`, `harga`, `stok_gd`, `stok_pj`, `gambar_genset`) VALUES (2, '02', 'Hartech 45 P-02', '40', '1000000', '1', '0', 'ht45p-02.jpg');
INSERT INTO `tb_genset` (`id_genset`, `kode_genset`, `nama_genset`, `daya`, `harga`, `stok_gd`, `stok_pj`, `gambar_genset`) VALUES (3, '07', 'Denyo 25 ES-07', '20', '750000', '1', '0', 'denyo25es-07.jpg');


#
# TABLE STRUCTURE FOR: tb_pemakai
#

DROP TABLE IF EXISTS `tb_pemakai`;

CREATE TABLE `tb_pemakai` (
  `id_pemakai` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `tgl_update` date NOT NULL,
  PRIMARY KEY (`id_pemakai`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_pemakai` (`id_pemakai`, `nama`, `alamat`, `no_hp`, `tgl_update`) VALUES (10, 'Adul', 'Jl. AKT', '0895619213134', '2023-04-10');
INSERT INTO `tb_pemakai` (`id_pemakai`, `nama`, `alamat`, `no_hp`, `tgl_update`) VALUES (11, 'Aldi', 'Jl. sungai miai', '089561921342', '2023-04-11');
INSERT INTO `tb_pemakai` (`id_pemakai`, `nama`, `alamat`, `no_hp`, `tgl_update`) VALUES (12, 'Abu', 'Handil Bakti', '0895619019104', '2023-04-12');
INSERT INTO `tb_pemakai` (`id_pemakai`, `nama`, `alamat`, `no_hp`, `tgl_update`) VALUES (13, 'Ahmad Yani', 'Berangas', '0895619211231', '2023-04-13');
INSERT INTO `tb_pemakai` (`id_pemakai`, `nama`, `alamat`, `no_hp`, `tgl_update`) VALUES (14, 'Amat', 'BJIB', '0895619213124', '2023-04-14');
INSERT INTO `tb_pemakai` (`id_pemakai`, `nama`, `alamat`, `no_hp`, `tgl_update`) VALUES (15, 'Budi', 'Jl. Batu benawa', '0895619213234', '2023-04-17');
INSERT INTO `tb_pemakai` (`id_pemakai`, `nama`, `alamat`, `no_hp`, `tgl_update`) VALUES (16, 'Halikin', 'Jl. Sultan', '0895619014532', '2023-04-18');


#
# TABLE STRUCTURE FOR: tb_serv_genset
#

DROP TABLE IF EXISTS `tb_serv_genset`;

CREATE TABLE `tb_serv_genset` (
  `id_perbaikan_gst` int(11) NOT NULL AUTO_INCREMENT,
  `id_genset` int(11) NOT NULL,
  `id_sparepart` int(11) NOT NULL,
  `id_pemakai` int(11) NOT NULL,
  `jenis_perbaikan` varchar(255) NOT NULL,
  `tgl_perbaikan` date NOT NULL,
  `ket_perbaikan` varchar(255) NOT NULL,
  `biaya_perbaikan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_perbaikan_gst`),
  KEY `id_genset` (`id_genset`,`id_sparepart`),
  KEY `id_pemakai` (`id_pemakai`),
  KEY `id_sparepart` (`id_sparepart`),
  CONSTRAINT `tb_serv_genset_ibfk_1` FOREIGN KEY (`id_genset`) REFERENCES `tb_genset` (`id_genset`),
  CONSTRAINT `tb_serv_genset_ibfk_2` FOREIGN KEY (`id_sparepart`) REFERENCES `tb_sparepart` (`id_sparepart`),
  CONSTRAINT `tb_serv_genset_ibfk_3` FOREIGN KEY (`id_pemakai`) REFERENCES `tb_pemakai` (`id_pemakai`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# TABLE STRUCTURE FOR: tb_sparepart
#

DROP TABLE IF EXISTS `tb_sparepart`;

CREATE TABLE `tb_sparepart` (
  `id_sparepart` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sparepart` varchar(255) NOT NULL,
  `tanggal_beli` date NOT NULL,
  `tempat_beli` varchar(255) NOT NULL,
  `stok` varchar(20) NOT NULL,
  PRIMARY KEY (`id_sparepart`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_sparepart` (`id_sparepart`, `nama_sparepart`, `tanggal_beli`, `tempat_beli`, `stok`) VALUES (1, 'Filter Oli Donaldson', '2023-04-04', 'Multi Filter', '3');
INSERT INTO `tb_sparepart` (`id_sparepart`, `nama_sparepart`, `tanggal_beli`, `tempat_beli`, `stok`) VALUES (2, 'oli sx', '2023-04-03', 'Bengkel Yuno', '1');


#
# TABLE STRUCTURE FOR: tb_user
#

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `last_login` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `tb_user` (`id`, `username`, `nama`, `password`, `role`, `last_login`) VALUES (1, 'admin', 'admin1', '$2y$10$aO3xt9YrcbuTWoyMr92ksu5jQBccl2e4U7wKk3Yr29RcZ2LPOeFUm', 0, '23-04-2023 17:36');



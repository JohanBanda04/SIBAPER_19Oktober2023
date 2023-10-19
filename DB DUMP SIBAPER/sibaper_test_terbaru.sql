/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100420
 Source Host           : localhost:3306
 Source Schema         : sibaper_test

 Target Server Type    : MariaDB
 Target Server Version : 100420
 File Encoding         : 65001

 Date: 19/10/2023 16:14:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for jenis_barang
-- ----------------------------
DROP TABLE IF EXISTS `jenis_barang`;
CREATE TABLE `jenis_barang`  (
  `id_jenis` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jenis_brg` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_jenis`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jenis_barang
-- ----------------------------
INSERT INTO `jenis_barang` VALUES ('1', 'ATK');
INSERT INTO `jenis_barang` VALUES ('2', 'ALAT KEBERSIHAN');
INSERT INTO `jenis_barang` VALUES ('3', 'PERLENGKAPAN LAINNYA');
INSERT INTO `jenis_barang` VALUES ('4', 'NON-ATK');

-- ----------------------------
-- Table structure for level
-- ----------------------------
DROP TABLE IF EXISTS `level`;
CREATE TABLE `level`  (
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `nama_level` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  PRIMARY KEY (`id_level`, `nama_level`) USING BTREE,
  INDEX `nama_level`(`nama_level`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of level
-- ----------------------------
INSERT INTO `level` VALUES (1, 'instansi', '2022-09-27', '2022-09-27');
INSERT INTO `level` VALUES (2, 'bendahara', '2022-09-27', '2022-09-27');
INSERT INTO `level` VALUES (3, 'kasub_pengguna', '2022-09-27', '2022-09-27');
INSERT INTO `level` VALUES (4, 'kasub_operator', '2022-09-27', '2022-09-27');
INSERT INTO `level` VALUES (5, 'pengguna', '2022-09-27', '2022-09-27');
INSERT INTO `level` VALUES (6, 'operator', '2022-09-27', '2022-09-27');
INSERT INTO `level` VALUES (7, 'it', '2022-09-27', '2022-09-27');
INSERT INTO `level` VALUES (8, 'instansi', '2022-09-27', '2022-09-27');
INSERT INTO `level` VALUES (9, 'bendahara', '2022-09-27', '2022-09-27');
INSERT INTO `level` VALUES (10, 'kaur_umum', '2023-10-03', '2023-10-03');

-- ----------------------------
-- Table structure for pemasukan
-- ----------------------------
DROP TABLE IF EXISTS `pemasukan`;
CREATE TABLE `pemasukan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kode_brg` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `id_pengajuan_sementara` int(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pemasukan
-- ----------------------------
INSERT INTO `pemasukan` VALUES (14, 'abdul2', '000002', 13, '2023-10-04', 27);
INSERT INTO `pemasukan` VALUES (15, 'bendahara1', '000007', 11, '2023-10-04', 28);
INSERT INTO `pemasukan` VALUES (16, 'bendahara1', '000008', 11, '2023-10-04', 29);

-- ----------------------------
-- Table structure for pengajuan
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan`;
CREATE TABLE `pengajuan`  (
  `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `kode_brg` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `hargabarang` double NOT NULL,
  `total` double NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` int(11) NOT NULL,
  `id_pengajuan_sementara` int(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengajuan
-- ----------------------------
INSERT INTO `pengajuan` VALUES (20, 'Abdul Malik ', 54, '000002', 1, 13, 'BH', 22000, 286000, '2023-10-04', 1, 27);
INSERT INTO `pengajuan` VALUES (21, 'Bendahara 1', 58, '000007', 4, 11, 'BH', 11550, 127050, '2023-10-04', 1, 28);
INSERT INTO `pengajuan` VALUES (22, 'Bendahara 1', 58, '000008', 4, 11, 'BH', 16060, 176660, '2023-10-04', 1, 29);

-- ----------------------------
-- Table structure for pengajuan_sementara
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_sementara`;
CREATE TABLE `pengajuan_sementara`  (
  `id_pengajuan_sementara` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `kode_brg` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `hargabarang` double NOT NULL,
  `total` double NOT NULL,
  `tgl_pengajuan` date NOT NULL,
  `status` int(11) NOT NULL,
  `status_pengajuan` enum('Permintaan Pengajuan Baru','setujui pengajuan','tidak_setujui pengajuan','Input Pengajuan Ke Stok','Selesai') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_pengajuan_sementara`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengajuan_sementara
-- ----------------------------
INSERT INTO `pengajuan_sementara` VALUES (27, 'Abdul Malik ', 54, '000002', 1, 13, 'BH', 22000, 286000, '2023-10-04', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (28, 'Bendahara 1', 58, '000007', 4, 11, 'BH', 11550, 127050, '2023-10-04', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (29, 'Bendahara 1', 58, '000008', 4, 11, 'BH', 16060, 176660, '2023-10-04', 1, 'Input Pengajuan Ke Stok');

-- ----------------------------
-- Table structure for pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `pengeluaran`;
CREATE TABLE `pengeluaran`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `kode_brg` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `id_sementara` int(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengeluaran
-- ----------------------------
INSERT INTO `pengeluaran` VALUES (44, 'wika', 50, '000002', 2, '2023-10-04', 446);
INSERT INTO `pengeluaran` VALUES (45, 'wika', 50, '000007', 2, '2023-10-04', 447);
INSERT INTO `pengeluaran` VALUES (46, 'nuraini', 51, '000004', 2, '2023-10-05', 449);
INSERT INTO `pengeluaran` VALUES (47, 'nuraini', 51, '000012', 3, '2023-10-05', 451);
INSERT INTO `pengeluaran` VALUES (48, 'dani', 52, '000054', 1, '2023-10-05', 452);

-- ----------------------------
-- Table structure for permintaan
-- ----------------------------
DROP TABLE IF EXISTS `permintaan`;
CREATE TABLE `permintaan`  (
  `id_permintaan` int(100) NOT NULL AUTO_INCREMENT,
  `unit` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `instansi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_brg` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `status` int(11) NOT NULL,
  `id_sementara` int(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_permintaan`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 362 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permintaan
-- ----------------------------
INSERT INTO `permintaan` VALUES (361, 'dani', 52, 'pengguna', '000054', 1, 1, '2023-10-05', 1, 452);
INSERT INTO `permintaan` VALUES (360, 'nuraini', 51, 'pengguna', '000012', 4, 3, '2023-10-05', 1, 451);
INSERT INTO `permintaan` VALUES (359, 'nuraini', 51, 'pengguna', '000004', 1, 2, '2023-10-05', 1, 449);
INSERT INTO `permintaan` VALUES (358, 'wika', 50, 'pengguna', '000007', 4, 2, '2023-10-04', 1, 447);
INSERT INTO `permintaan` VALUES (357, 'wika', 50, 'pengguna', '000002', 1, 2, '2023-10-04', 1, 446);

-- ----------------------------
-- Table structure for sementara
-- ----------------------------
DROP TABLE IF EXISTS `sementara`;
CREATE TABLE `sementara`  (
  `id_sementara` int(100) NOT NULL AUTO_INCREMENT,
  `unit` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `instansi` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kode_brg` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_permintaan` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `pemberitahuan_kasub` int(11) NOT NULL DEFAULT 0,
  `acc_kasub` int(11) NOT NULL DEFAULT 0,
  `id_subbidang` int(11) NOT NULL,
  `status_acc` enum('Permintaan Baru','setuju','tidak_setuju','Pengajuan Bendahara','Pengajuan Kasub Bendahara','Setuju Kasub Bendahara','Tidak Setuju Kasub Bendahara','Penyerahan Barang Ke Pengguna','Penerimaan Barang Dari Bendahara','Selesai','Pengajuan Kasub') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bendahara` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bendahara_id` int(11) NULL DEFAULT NULL,
  `note_bendahara` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `note_kasub_pengguna` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `note_kasub_operator` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `path_foto` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id_sementara`) USING BTREE,
  INDEX `id_subbidang`(`id_subbidang`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 461 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sementara
-- ----------------------------
INSERT INTO `sementara` VALUES (460, 'wika', 50, 'pengguna', '000110', 4, 5, '2023-10-19', 0, 0, 0, 11, 'Permintaan Baru', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (458, 'wika', 50, 'pengguna', '000004', 1, 5, '2023-10-19', 0, 0, 0, 11, 'Permintaan Baru', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (456, 'wika', 50, 'pengguna', '000002', 1, 6, '2023-10-19', 0, 0, 0, 11, 'Pengajuan Kasub', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (457, 'wika', 50, 'pengguna', '000009', 4, 5, '2023-10-19', 0, 0, 0, 11, 'Pengajuan Kasub', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (455, 'abdul', 53, 'pengguna', '000001', 1, 1, '2023-10-05', 0, 0, 0, 13, 'Pengajuan Kasub', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (453, 'dani', 52, 'pengguna', '000039', 1, 1, '2023-10-05', 0, 0, 0, 10, 'Pengajuan Kasub', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (454, 'dani', 52, 'pengguna', '000008', 4, 1, '2023-10-05', 0, 0, 0, 10, 'Pengajuan Kasub', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (452, 'dani', 52, 'pengguna', '000054', 1, 1, '2023-10-05', 0, 0, 1, 10, 'Selesai', 'abdul2', 54, NULL, NULL, NULL, 'assets/file/37.jpeg');
INSERT INTO `sementara` VALUES (449, 'nuraini', 51, 'pengguna', '000004', 1, 2, '2023-10-05', 0, 0, 1, 12, 'Selesai', 'abdul2', 54, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-08-11 at 11.34.30.jpeg');
INSERT INTO `sementara` VALUES (451, 'nuraini', 51, 'pengguna', '000012', 4, 3, '2023-10-05', 0, 0, 1, 12, 'Selesai', 'abdul2', 54, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-09-07 at 14.55.52.jpeg');
INSERT INTO `sementara` VALUES (446, 'wika', 50, 'pengguna', '000002', 1, 2, '2023-10-04', 0, 0, 1, 11, 'Selesai', 'abdul2', 54, NULL, NULL, NULL, 'assets/file/WDFAJAR.jpeg');
INSERT INTO `sementara` VALUES (447, 'wika', 50, 'pengguna', '000007', 4, 2, '2023-10-04', 0, 0, 1, 11, 'Selesai', 'abdul2', 54, NULL, NULL, NULL, 'assets/file/IGNATIUS.jpeg');

-- ----------------------------
-- Table structure for stokbarang
-- ----------------------------
DROP TABLE IF EXISTS `stokbarang`;
CREATE TABLE `stokbarang`  (
  `id_kode_brg` int(2) NOT NULL AUTO_INCREMENT,
  `kode_brg` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bendahara_id` int(11) NULL DEFAULT NULL,
  `bendahara` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_jenis` int(2) NOT NULL,
  `nama_brg` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `hargabarang` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `satuan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `stok` int(11) NOT NULL,
  `keluar` int(11) NOT NULL,
  `sisa` int(11) NOT NULL,
  `keterangan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tgl_masuk` date NULL DEFAULT NULL,
  PRIMARY KEY (`id_kode_brg`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 255 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stokbarang
-- ----------------------------
INSERT INTO `stokbarang` VALUES (75, '000002', 54, 'abdul2', 1, 'BOLPOINT SNOWMAN V-1', '22000', 'BH', 35, 2, 33, 'tambah 2', '2023-10-02');
INSERT INTO `stokbarang` VALUES (76, '000004', 54, 'abdul2', 1, 'BOLPOINT BALLINER HITAM', '245000', 'BH', 20, 2, 18, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (77, '010010', 54, 'abdul2', 1, 'PENSIL 2-B', '2750', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (78, '000025', 54, 'abdul2', 1, 'BOLPOINT MEJA TRIFELO', '24200', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (79, '000034', 54, 'abdul2', 1, 'BOLPOINT BALLINER HITAM', '22200', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (80, '000039', 54, 'abdul2', 1, 'PENSIL', '5000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (81, '000044', 54, 'abdul2', 1, 'BOLPOINT SNOWMAN V-5', '9680', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (82, '000054', 54, 'abdul2', 1, 'STABILO', '12650', 'BH', 20, 1, 19, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (83, '000058', 54, 'abdul2', 1, 'Bollpoint Snowman V5', '42180', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (84, '000005', 54, 'abdul2', 1, 'BINDER CLIP NO.155 JOYKO', '19800', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (85, '000006', 54, 'abdul2', 1, 'BINDER CLIP NO.260 JOYKO', '7260', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (87, '000016', 54, 'abdul2', 1, 'BINDER CLIP NO. 107.', '3330', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (88, '000017', 54, 'abdul2', 1, 'BINDER CLIP NO. 200', '17600', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (89, '000023', 54, 'abdul2', 1, 'TRIGONAL CLIP NO. 3', '3300', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (90, '000024', 54, 'abdul2', 1, 'TRIGONAL CLIP NO. 3', '24200', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (91, '000027', 54, 'abdul2', 1, 'BINDER CLIP NO. 111', '8800', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (92, '000001', 54, 'abdul2', 1, 'TIP-EX', '4510', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (93, '000005', 54, 'abdul2', 1, 'PENGHAPUS PENSIL', '17760', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (94, '000011', 54, 'abdul2', 1, 'TIPE X KUAS', '8250', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (96, '000003', 54, 'abdul2', 1, 'BUKU EXPEDISI', '19800', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (97, '000006', 54, 'abdul2', 1, 'BUKU KWARTO', '42900', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (98, '000013', 54, 'abdul2', 1, 'BUKU EXPEDISI MIRAGE 100 L', '28600', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (99, '000015', 54, 'abdul2', 1, 'BUKU AGENDA', '21450', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (101, '000005', 54, 'abdul2', 1, 'BOX ARSIP', '57200', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (103, '001010', 54, 'abdul2', 1, 'MAP WNA WARNA MERAH', '28600', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (104, '000011', 54, 'abdul2', 1, 'MAP BUFALO', '3850', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (105, '000017', 54, 'abdul2', 1, 'MAP PLASTIK KANCING SEA GULL', '110000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (106, '000021', 54, 'abdul2', 1, 'ORDNER BESAR GOBI 03', '18600', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (107, '000027', 54, 'abdul2', 1, 'ORDNER GOBI.', '111000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (108, '000037', 54, 'abdul2', 1, 'MAP DOSER PEGAWAI', '4950', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (109, '000042', 54, 'abdul2', 1, 'MAP WNA WARNA MERAH', '29700', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (110, '000043', 54, 'abdul2', 1, 'MAP WNA WARNA MERAH', '11000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (111, '000045', 54, 'abdul2', 1, 'MAP DINAS FULL COLOR LOGO IMIGRASI', '7700', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (112, '000046', 54, 'abdul2', 1, 'MAP DINAS LOGO IMIGRASI', '19800', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (113, '000047', 54, 'abdul2', 1, 'MAP PERMOHONAN SPRI', '10450', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (116, '000007', 54, 'abdul2', 4, 'Shower Cebok', '11550', 'BH', 31, 2, 29, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (117, '000008', 54, 'abdul2', 4, 'Selang Flexibel Anyam', '16060', 'BH', 31, 0, 31, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (118, '000009', 54, 'abdul2', 4, 'Stop Kran ', '8250', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (119, '000110', 54, 'abdul2', 4, 'Socket Langgeng', '22000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (121, '000013', 54, 'abdul2', 4, 'Seal Tape', '64900', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (124, '000006', 54, 'abdul2', 4, 'LAKBAN BENING', '60000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (126, '000012', 54, 'abdul2', 4, 'LAKBAN HITAM NACHI TIPE 46', '60500', 'BH', 20, 3, 17, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (127, '000015', 54, 'abdul2', 4, 'LAKBAN BENING NACHITAPE', '16500', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (128, '000026', 54, 'abdul2', 4, 'LAKBAN DOUBLE TAPE', '8800', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (129, '000036', 54, 'abdul2', 4, 'DOUBLE TAPE', '11000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (131, '000015', 54, 'abdul2', 4, 'FLASHDISK 32 GB									\r\n', '8880', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (133, '000015', 54, 'abdul2', 4, 'SAPU LANTAI', '30250', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (134, '000017', 54, 'abdul2', 4, 'SIKAT WC', '60830', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (135, '000020', 54, 'abdul2', 4, 'SIKAT WC SPT 003', '44000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (136, '000021', 54, 'abdul2', 4, 'SAPU NGT 548', '30800', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (137, '000022', 54, 'abdul2', 4, 'SAPU NGT 8517', '14300', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (138, '000023', 54, 'abdul2', 4, 'SAPU PLAPON HAWAI', '23100', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (139, '000024', 54, 'abdul2', 4, 'SAPU KIPAS VICTORY PIONER', '126500', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (140, '000025', 54, 'abdul2', 4, 'KEMUCING COKLAT SUPER', '132000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (141, '000011', 54, 'abdul2', 4, 'TISSUE REFIL', '132000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (142, '000013', 54, 'abdul2', 4, 'ALAT PEL EASY MOP', '291500', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (143, '000018', 54, 'abdul2', 4, 'TISSUE PASEO KOTAK', '352000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (144, '000020', 54, 'abdul2', 4, 'ALAT PEL DEBU.', '1595000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (145, '000027', 54, 'abdul2', 4, 'LAP KANEBO', '1292484', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (146, '000029', 54, 'abdul2', 4, 'TISSU PASEO', '105450', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (147, '000033', 54, 'abdul2', 4, 'TISSU BASAH', '104500', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (149, '000041', 54, 'abdul2', 4, 'TISSU GULUNG', '104500', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (150, '000042', 54, 'abdul2', 4, 'TISSU BASAH', '52250', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (151, '000043', 54, 'abdul2', 4, 'LAP KAI BIRU', '52250', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (152, '000045', 54, 'abdul2', 4, 'Serbet Microfiber', '52250', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (153, '000046', 54, 'abdul2', 4, 'PEL DEBU NGT 9873', '52250', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (154, '000047', 54, 'abdul2', 4, 'PEL DEBU MMR 008', '194700', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (155, '000048', 54, 'abdul2', 4, 'ALAT PEL BESAR', '297000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (161, '000010', 54, 'abdul2', 4, 'Kran AIr', '126500', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (162, '000011', 54, 'abdul2', 4, 'pipa plastik 3/4', '88000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (167, '000013', 54, 'abdul2', 4, 'elbow pipa', '12000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (168, '000014', 54, 'abdul2', 4, 'Seal Tape', '50500', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (169, '000015', 54, 'abdul2', 4, 'T sambungan pipa', '85000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (174, '000011', 54, 'abdul2', 4, 'SUN LIGHT', '30000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (175, '000021', 54, 'abdul2', 4, 'WIPOL', '35000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (176, '000023', 54, 'abdul2', 4, 'SUNLIGHT 400 ML', '20000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (177, '000031', 54, 'abdul2', 4, 'VIXAL', '104000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (178, '000035', 54, 'abdul2', 4, 'WIPOL', '6000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (179, '000037', 54, 'abdul2', 4, 'DETTOL', '45000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (180, '000042', 54, 'abdul2', 4, 'SUNLIGHT', '35000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (181, '000043', 54, 'abdul2', 4, 'Vixal Besar', '25000', 'BH', 20, 0, 20, '', '2023-10-02');
INSERT INTO `stokbarang` VALUES (253, '200002', 54, 'abdul2', 1, 'Tes Input Baru', '20000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (254, '700007', 54, 'abdul2', 4, 'Tes non atk baru', '12000', 'BH', 0, 0, 0, '', NULL);

-- ----------------------------
-- Table structure for subbidang
-- ----------------------------
DROP TABLE IF EXISTS `subbidang`;
CREATE TABLE `subbidang`  (
  `id_subbidang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_subbidang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_subbidang`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of subbidang
-- ----------------------------
INSERT INTO `subbidang` VALUES (10, 'Lalu Lintas dan Izin Tinggal Keimigrasian');
INSERT INTO `subbidang` VALUES (11, 'Teknologi Informasi dan Komunikasi Keimigrasian');
INSERT INTO `subbidang` VALUES (12, 'Intelijen dan Penindakan Keimigrasian ');
INSERT INTO `subbidang` VALUES (13, 'Tata Usaha');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_lengkap` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nik` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `level` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jabatan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `jabatan_detail` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `subbidang_id` int(11) NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  INDEX `level`(`level`) USING BTREE,
  INDEX `subbidang_id`(`subbidang_id`) USING BTREE,
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`level`) REFERENCES `level` (`nama_level`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`subbidang_id`) REFERENCES `subbidang` (`id_subbidang`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (45, 'loreta', 'Erna Loreta', '198008292002122001', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 'Kasi', 11, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (46, 'yusa', 'Yusa Setia Budi', '198406072003121002', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 'Kasi', 12, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (47, 'yanuarso', 'Yanuarso', '197501112002121001', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 'Kasi', 10, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (48, 'edi', 'Edi Sukriawan', '198002222000031001', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 'Kasubbag', 13, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (49, 'edi2', 'Edi Sukriawan', '198002222000031001', '21232f297a57a5a743894a0e4a801fc3', 'kasub_operator', 'Kasub Operator', 'Kasubbag', 13, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (50, 'wika', ' I Gede Wika Asta Yama', '200110032020121002', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 'Staf', 11, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (51, 'nuraini', 'Nuraini', '197404031995032001', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 'Staf', 12, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (52, 'dani', 'Muhammad Dani Firmansyah', '199911042020121001', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 'Staf', 10, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (53, 'abdul', 'Abdul Malik ', '197806212014101001', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 'Staf', 13, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (54, 'abdul2', 'Abdul Malik ', '197806212014101001', '21232f297a57a5a743894a0e4a801fc3', 'operator', 'Operator', 'Staf', 13, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (57, 'sulaiman', 'Sulaiman, S.H ', '197108051991031001', '21232f297a57a5a743894a0e4a801fc3', 'kaur_umum', 'Kaur Umum', 'Kaur', 13, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (58, 'bendahara1', 'Bendahara 1', '197806212014101011', '21232f297a57a5a743894a0e4a801fc3', 'operator', 'Operator', 'Staf', 13, 'hidupsehat973@gmail.com');

-- ----------------------------
-- Triggers structure for table pemasukan
-- ----------------------------
DROP TRIGGER IF EXISTS `MASUK`;
delimiter ;;
CREATE TRIGGER `MASUK` AFTER INSERT ON `pemasukan` FOR EACH ROW BEGIN
  update stokbarang SET stok=stok + NEW.jumlah 
  WHERE kode_brg = NEW.kode_brg;
  
  update stokbarang SET sisa=sisa + NEW.jumlah 
  WHERE kode_brg = NEW.kode_brg;
  
	update pengajuan SET status=1 WHERE kode_brg=NEW.kode_brg AND 
	unit=NEW.unit;
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table pengeluaran
-- ----------------------------
DROP TRIGGER IF EXISTS `TG_STOK_UPDATE`;
delimiter ;;
CREATE TRIGGER `TG_STOK_UPDATE` AFTER INSERT ON `pengeluaran` FOR EACH ROW BEGIN
	update stokbarang SET keluar=keluar + NEW.jumlah, 
	sisa=stok-keluar WHERE 
	kode_brg = NEW.kode_brg;

	update permintaan SET status=1 WHERE kode_brg=NEW.kode_brg AND 
	unit=NEW.unit;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;

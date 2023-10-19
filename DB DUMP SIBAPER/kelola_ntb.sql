/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100420
 Source Host           : localhost:3306
 Source Schema         : kelola_ntb

 Target Server Type    : MariaDB
 Target Server Version : 100420
 File Encoding         : 65001

 Date: 26/09/2023 18:10:28
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
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pemasukan
-- ----------------------------
INSERT INTO `pemasukan` VALUES (1, 'Sinar', '1.01.03.01.002.000144', 100, '2023-07-26', 2);
INSERT INTO `pemasukan` VALUES (2, 'Sinar', '1.01.03.01.001.000142', 2, '2023-07-28', 1);
INSERT INTO `pemasukan` VALUES (3, 'Tika', '1.01.03.01.003.000195', 100, '2023-07-28', 3);
INSERT INTO `pemasukan` VALUES (4, 'Tika', '1.01.03.01.001.000203', 25, '2023-08-02', 4);
INSERT INTO `pemasukan` VALUES (5, 'Tika', '1.01.03.05.003.000184', 100, '2023-08-02', 5);
INSERT INTO `pemasukan` VALUES (6, 'Tika', '1.01.03.06.002.000197', 100, '2023-08-02', 6);
INSERT INTO `pemasukan` VALUES (7, 'Sinar', '1.01.03.99.999.000069', 50, '2023-08-08', 7);
INSERT INTO `pemasukan` VALUES (8, 'Sinar', '1.01.03.06.002.000180', 100, '2023-08-08', 8);
INSERT INTO `pemasukan` VALUES (9, 'Sinar', '1.01.03.05.005.000010', 100, '2023-08-08', 9);
INSERT INTO `pemasukan` VALUES (10, 'Sinar', '1.01.03.01.001.000142', 100, '2023-08-08', 10);

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengajuan
-- ----------------------------
INSERT INTO `pengajuan` VALUES (1, 'Sinar', 21, '1.01.03.01.001.000142', 1, 2, 'BH', 2750, 5500, '2023-02-06', 1, 1);
INSERT INTO `pengajuan` VALUES (2, 'Sinar', 21, '1.01.03.01.002.000144', 1, 100, 'BH', 9680, 968000, '2023-07-26', 1, 2);
INSERT INTO `pengajuan` VALUES (3, 'Tika', 31, '1.01.03.01.003.000195', 1, 100, 'KTK', 7260, 726000, '2023-07-28', 1, 3);
INSERT INTO `pengajuan` VALUES (4, 'Tika', 31, '1.01.03.01.001.000203', 1, 25, 'BH', 24200, 605000, '2023-08-02', 1, 4);
INSERT INTO `pengajuan` VALUES (5, 'Tika', 31, '1.01.03.05.003.000184', 2, 100, 'BH', 12000, 1200000, '2023-08-02', 1, 5);
INSERT INTO `pengajuan` VALUES (6, 'Tika', 31, '1.01.03.06.002.000197', 3, 100, 'BUAH', 65000, 6500000, '2023-08-02', 1, 6);
INSERT INTO `pengajuan` VALUES (7, 'Sinar', 21, '1.01.03.99.999.000069', 2, 50, 'BH', 8450, 422500, '2023-08-08', 1, 7);
INSERT INTO `pengajuan` VALUES (8, 'Sinar', 21, '1.01.03.06.002.000180', 3, 100, 'BH', 35000, 3500000, '2023-08-08', 1, 8);
INSERT INTO `pengajuan` VALUES (9, 'Sinar', 21, '1.01.03.05.005.000010', 3, 100, 'BH', 40000, 4000000, '2023-08-08', 1, 9);
INSERT INTO `pengajuan` VALUES (10, 'Sinar', 21, '1.01.03.01.001.000142', 1, 100, 'BH', 2750, 275000, '2023-08-08', 1, 10);

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengajuan_sementara
-- ----------------------------
INSERT INTO `pengajuan_sementara` VALUES (1, 'Sinar', 21, '1.01.03.01.001.000142', 1, 2, 'BH', 2750, 5500, '2023-02-06', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (2, 'Sinar', 21, '1.01.03.01.002.000144', 1, 100, 'BH', 9680, 968000, '2023-07-26', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (3, 'Tika', 31, '1.01.03.01.003.000195', 1, 100, 'KTK', 7260, 726000, '2023-07-28', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (4, 'Tika', 31, '1.01.03.01.001.000203', 1, 25, 'BH', 24200, 605000, '2023-08-02', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (5, 'Tika', 31, '1.01.03.05.003.000184', 2, 100, 'BH', 12000, 1200000, '2023-08-02', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (6, 'Tika', 31, '1.01.03.06.002.000197', 3, 100, 'BUAH', 65000, 6500000, '2023-08-02', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (7, 'Sinar', 21, '1.01.03.99.999.000069', 2, 50, 'BH', 8450, 422500, '2023-08-08', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (8, 'Sinar', 21, '1.01.03.06.002.000180', 3, 100, 'BH', 35000, 3500000, '2023-08-08', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (9, 'Sinar', 21, '1.01.03.05.005.000010', 3, 100, 'BH', 40000, 4000000, '2023-08-08', 1, 'Input Pengajuan Ke Stok');
INSERT INTO `pengajuan_sementara` VALUES (10, 'Sinar', 21, '1.01.03.01.001.000142', 1, 100, 'BH', 2750, 275000, '2023-08-08', 1, 'Input Pengajuan Ke Stok');

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
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengeluaran
-- ----------------------------
INSERT INTO `pengeluaran` VALUES (9, 'Undar', 23, '1.01.03.01.001.000142', 2, '2023-01-06', 383);
INSERT INTO `pengeluaran` VALUES (18, 'Bela', 26, '1.01.03.01.001.000203', 2, '2023-01-09', 392);
INSERT INTO `pengeluaran` VALUES (19, 'Undar', 23, '1.01.03.01.001.000203', 2, '2023-01-17', 390);
INSERT INTO `pengeluaran` VALUES (20, 'Undar', 23, '1.01.03.01.001.000204', 2, '2023-01-17', 391);
INSERT INTO `pengeluaran` VALUES (21, 'Undar', 23, '1.01.03.01.001.000204', 2, '2023-03-02', 410);
INSERT INTO `pengeluaran` VALUES (22, 'Undar', 23, '1.01.03.01.001.000217', 1, '2023-03-02', 412);
INSERT INTO `pengeluaran` VALUES (23, 'Undar', 23, '1.01.03.01.003.000196', 2, '2023-03-02', 411);
INSERT INTO `pengeluaran` VALUES (24, 'Undar', 23, '1.01.03.01.003.000194', 3, '2023-08-02', 420);
INSERT INTO `pengeluaran` VALUES (25, 'Undar', 23, '1.01.03.06.002.000197', 3, '2023-08-02', 419);
INSERT INTO `pengeluaran` VALUES (26, 'Undar', 23, '1.01.03.01.001.000217', 1, '2023-09-21', 430);
INSERT INTO `pengeluaran` VALUES (27, 'Undar', 23, '1.01.03.01.003.000193', 2, '2023-09-21', 429);
INSERT INTO `pengeluaran` VALUES (28, 'Undar', 23, '1.01.03.01.003.000214', 2, '2023-09-21', 431);
INSERT INTO `pengeluaran` VALUES (29, 'Undar', 23, '1.01.03.01.003.000193', 2, '2023-09-23', 432);
INSERT INTO `pengeluaran` VALUES (30, 'Undar', 23, '1.01.03.05.003.000184', 2, '2023-09-23', 433);

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
) ENGINE = MyISAM AUTO_INCREMENT = 346 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permintaan
-- ----------------------------
INSERT INTO `permintaan` VALUES (306, 'Undar', 23, 'pengguna', '1.01.03.01.001.000203', 1, 2, '2023-01-09', 1, 390);
INSERT INTO `permintaan` VALUES (307, 'Undar', 23, 'pengguna', '1.01.03.01.001.000204', 1, 2, '2023-01-09', 1, 391);
INSERT INTO `permintaan` VALUES (308, 'Bela', 26, 'pengguna', '1.01.03.01.001.000203', 1, 2, '2023-01-09', 1, 392);
INSERT INTO `permintaan` VALUES (335, 'Undar', 23, 'pengguna', '1.01.03.01.001.000217', 1, 1, '2023-02-28', 1, 412);
INSERT INTO `permintaan` VALUES (334, 'Undar', 23, 'pengguna', '1.01.03.01.001.000204', 1, 2, '2023-02-28', 1, 410);
INSERT INTO `permintaan` VALUES (336, 'Undar', 23, 'pengguna', '1.01.03.01.003.000196', 1, 2, '2023-02-28', 1, 411);
INSERT INTO `permintaan` VALUES (337, 'Undar', 23, 'pengguna', '1.01.03.01.003.000194', 1, 3, '2023-08-02', 1, 420);
INSERT INTO `permintaan` VALUES (338, 'Undar', 23, 'pengguna', '1.01.03.06.002.000197', 3, 3, '2023-08-02', 1, 419);
INSERT INTO `permintaan` VALUES (339, 'Undar', 23, 'pengguna', '1.01.03.01.001.000203', 1, 3, '2023-08-08', 0, 426);
INSERT INTO `permintaan` VALUES (340, 'Undar', 23, 'pengguna', '1.01.03.01.001.000204', 1, 1, '2023-08-08', 0, 427);
INSERT INTO `permintaan` VALUES (341, 'Undar', 23, 'pengguna', '1.01.03.01.001.000217', 1, 1, '2023-09-21', 1, 430);
INSERT INTO `permintaan` VALUES (342, 'Undar', 23, 'pengguna', '1.01.03.01.003.000193', 1, 2, '2023-09-21', 1, 429);
INSERT INTO `permintaan` VALUES (343, 'Undar', 23, 'pengguna', '1.01.03.01.003.000214', 1, 2, '2023-09-21', 1, 431);
INSERT INTO `permintaan` VALUES (344, 'Undar', 23, 'pengguna', '1.01.03.01.003.000193', 1, 2, '2023-09-23', 1, 432);
INSERT INTO `permintaan` VALUES (345, 'Undar', 23, 'pengguna', '1.01.03.05.003.000184', 2, 2, '2023-09-23', 1, 433);

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
) ENGINE = MyISAM AUTO_INCREMENT = 434 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sementara
-- ----------------------------
INSERT INTO `sementara` VALUES (410, 'Undar', 23, 'pengguna', '1.01.03.01.001.000204', 1, 2, '2023-02-28', 0, 0, 1, 1, 'Selesai', 'Sinar', 21, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-08-03 at 08.56.50.jpeg');
INSERT INTO `sementara` VALUES (391, 'Undar', 23, 'pengguna', '1.01.03.01.001.000204', 1, 2, '2023-01-09', 0, 0, 1, 1, 'Selesai', 'Tika', 31, NULL, NULL, NULL, 'assets/file/bg win 10.jpeg');
INSERT INTO `sementara` VALUES (392, 'Bela', 26, 'pengguna', '1.01.03.01.001.000203', 1, 2, '2023-01-09', 0, 0, 1, 1, 'Selesai', 'Sinar', 21, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-01-01 at 17.13.04.jpeg');
INSERT INTO `sementara` VALUES (393, 'Bela', 26, 'pengguna', '1.01.03.01.001.000217', 1, 1, '2023-01-09', 0, 0, 0, 1, 'tidak_setuju', NULL, NULL, NULL, 'stok terbatas', NULL, NULL);
INSERT INTO `sementara` VALUES (390, 'Undar', 23, 'pengguna', '1.01.03.01.001.000203', 1, 2, '2023-01-09', 0, 0, 1, 1, 'Selesai', 'Tika', 31, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-01-04 at 10.40.51.jpeg');
INSERT INTO `sementara` VALUES (408, 'Bela', 26, 'pengguna', '1.01.03.01.001.000204', 1, 1, '2023-02-07', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (407, 'Undar', 23, 'pengguna', '1.01.03.01.001.000204', 1, 2, '2023-02-07', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (411, 'Undar', 23, 'pengguna', '1.01.03.01.003.000196', 1, 2, '2023-02-28', 0, 0, 1, 1, 'Selesai', 'Sinar', 21, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2022-12-09 at 17.23.29.jpeg');
INSERT INTO `sementara` VALUES (412, 'Undar', 23, 'pengguna', '1.01.03.01.001.000217', 1, 1, '2023-02-28', 0, 0, 1, 1, 'Selesai', 'Sinar', 21, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-07-27 at 11.48.13.jpeg');
INSERT INTO `sementara` VALUES (413, 'Bela', 26, 'pengguna', '1.01.03.01.002.000144', 1, 2, '2023-03-06', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (414, 'Bela', 26, 'pengguna', '1.01.03.01.004.000142', 1, 2, '2023-03-06', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (415, 'Bela', 26, 'pengguna', '1.01.03.04.004.000252', 1, 1, '2023-03-06', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (417, 'Undar', 23, 'pengguna', '1.01.03.04.004.000233', 1, 2, '2023-03-06', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (418, 'Undar', 23, 'pengguna', '1.01.03.04.004.000234', 1, 1, '2023-03-06', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (419, 'Undar', 23, 'pengguna', '1.01.03.06.002.000197', 3, 3, '2023-08-02', 0, 0, 1, 1, 'Selesai', 'Tika', 31, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-08-02 at 13.15.50.jpeg');
INSERT INTO `sementara` VALUES (420, 'Undar', 23, 'pengguna', '1.01.03.01.003.000194', 1, 3, '2023-08-02', 0, 0, 1, 1, 'Selesai', 'Tika', 31, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-08-02 at 13.19.43.jpeg');
INSERT INTO `sementara` VALUES (421, 'Undar', 23, 'pengguna', '1.01.03.01.001.000203', 1, 1, '2023-08-04', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (422, 'Undar', 23, 'pengguna', '1.01.03.05.003.000184', 2, 4, '2023-08-07', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (423, 'Undar', 23, 'pengguna', '1.01.03.01.001.000204', 1, 2, '2023-08-07', 0, 0, 1, 1, 'setuju', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (424, 'Bela', 26, 'pengguna', '1.01.03.99.999.000069', 2, 2, '2023-08-08', 0, 0, 0, 1, 'Pengajuan Kasub', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (425, 'Bela', 26, 'pengguna', '1.01.03.01.001.000204', 1, 2, '2023-08-08', 0, 0, 0, 1, 'Pengajuan Kasub', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (426, 'Undar', 23, 'pengguna', '1.01.03.01.001.000203', 1, 3, '2023-08-08', 0, 0, 1, 1, 'Setuju Kasub Bendahara', 'Sinar', 21, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (427, 'Undar', 23, 'pengguna', '1.01.03.01.001.000204', 1, 1, '2023-08-08', 0, 0, 1, 1, 'Setuju Kasub Bendahara', 'Sinar', 21, NULL, NULL, NULL, NULL);
INSERT INTO `sementara` VALUES (430, 'Undar', 23, 'pengguna', '1.01.03.01.001.000217', 1, 1, '2023-09-21', 0, 0, 1, 1, 'Selesai', 'Sinar', 21, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-09-18 at 09.02.48.jpeg');
INSERT INTO `sementara` VALUES (429, 'Undar', 23, 'pengguna', '1.01.03.01.003.000193', 1, 2, '2023-09-21', 0, 0, 1, 1, 'Selesai', 'Sinar', 21, NULL, NULL, NULL, 'assets/file/WhatsApp Image 2023-09-18 at 09.02.48.jpeg');
INSERT INTO `sementara` VALUES (431, 'Undar', 23, 'pengguna', '1.01.03.01.003.000214', 1, 2, '2023-09-21', 0, 0, 1, 1, 'Selesai', 'Sinar', 21, NULL, NULL, NULL, 'assets/file/HD-wallpaper-blue-water-texture-macro-water-textures-blue-backgrounds-blue-water-water-backgrounds.jpg');
INSERT INTO `sementara` VALUES (432, 'Undar', 23, 'pengguna', '1.01.03.01.003.000193', 1, 2, '2023-09-23', 0, 0, 1, 1, 'Selesai', 'Sinar', 21, NULL, NULL, NULL, 'assets/file/15x.jpeg');
INSERT INTO `sementara` VALUES (433, 'Undar', 23, 'pengguna', '1.01.03.05.003.000184', 2, 2, '2023-09-23', 0, 0, 1, 1, 'Selesai', 'Sinar', 21, NULL, NULL, NULL, 'assets/file/13x.jpeg');

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
) ENGINE = InnoDB AUTO_INCREMENT = 253 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stokbarang
-- ----------------------------
INSERT INTO `stokbarang` VALUES (75, '1.01.01.01.021.000001', 21, 'Sinar', 3, 'THINER II', '22000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (76, '1.01.01.01.999.000036', 21, 'Sinar', 3, 'PAPAN KAYU', '245000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (77, '1.01.03.01.001.000142', 21, 'Sinar', 1, 'BOLPOINT FASTER I', '2750', 'BH', 120, 18, 102, '', NULL);
INSERT INTO `stokbarang` VALUES (78, '1.01.03.01.001.000203', 21, 'Sinar', 1, 'BOLPOINT BOLINER BIRU BH', '24200', 'BH', 40, 20, 20, '', NULL);
INSERT INTO `stokbarang` VALUES (79, '1.01.03.01.001.000204', 21, 'Sinar', 1, 'BOLPOINT BOLINER HITAM BH', '22200', 'BH', 34, 4, 30, '', NULL);
INSERT INTO `stokbarang` VALUES (80, '1.01.03.01.001.000217', 21, 'Sinar', 1, 'Spidol Permanent', '5000', 'BH', 3, 2, 1, '', NULL);
INSERT INTO `stokbarang` VALUES (81, '1.01.03.01.002.000144', 21, 'Sinar', 1, 'TINTA STEMPEL', '9680', 'BH', 107, 0, 107, '', NULL);
INSERT INTO `stokbarang` VALUES (82, '1.01.03.01.002.000146', 21, 'Sinar', 1, 'BAK STEMPEL', '12650', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (83, '1.01.03.01.003.000193', 21, 'Sinar', 1, 'STEPLES NOMOR 24', '42180', 'BH', 11, 4, 7, '', NULL);
INSERT INTO `stokbarang` VALUES (84, '1.01.03.01.003.000194', 21, 'Sinar', 1, 'STEPLES NOMOR 10', '19800', 'BH', 19, 3, 16, '', NULL);
INSERT INTO `stokbarang` VALUES (85, '1.01.03.01.003.000195', 21, 'Sinar', 1, 'ISI STEPLES NO 24', '7260', 'KTK', 112, 0, 112, '', NULL);
INSERT INTO `stokbarang` VALUES (86, '1.01.03.01.003.000196', 21, 'Sinar', 1, 'ISI STEPLES NO 10', '3300', 'KTK', 43, 2, 41, '', NULL);
INSERT INTO `stokbarang` VALUES (87, '1.01.03.01.003.000197', 21, 'Sinar', 1, 'BINDER KLIP KECIL NO. 107', '3330', 'KTK', 22, 0, 22, '', NULL);
INSERT INTO `stokbarang` VALUES (88, '1.01.03.01.003.000198', 21, 'Sinar', 1, 'BINDER KLIP NO.200 KTK', '17600', 'KTK', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (89, '1.01.03.01.003.000207', 21, 'Sinar', 1, 'TRIGONAL KLIP', '3300', 'KOTAK KCL', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (90, '1.01.03.01.003.000208', 21, 'Sinar', 1, 'BINDER KLIP 260', '24200', 'KOTAK', 10, 0, 10, '', NULL);
INSERT INTO `stokbarang` VALUES (91, '1.01.03.01.003.000209', 21, 'Sinar', 1, 'BINDER KLIP 111', '8800', 'KOTAK KECIL', 6, 0, 6, '', NULL);
INSERT INTO `stokbarang` VALUES (92, '1.01.03.01.003.000211', 21, 'Sinar', 1, 'BINDER KLIP 105', '4510', 'KOTAK KCL', 30, 0, 30, '', NULL);
INSERT INTO `stokbarang` VALUES (93, '1.01.03.01.003.000214', 21, 'Sinar', 1, 'BINDER KLIP 200', '17760', 'BUAH', 4, 2, 2, '', NULL);
INSERT INTO `stokbarang` VALUES (94, '1.01.03.01.004.000142', 21, 'Sinar', 1, 'TIP-EX', '8250', 'BH', 9, 0, 9, '', NULL);
INSERT INTO `stokbarang` VALUES (95, '1.01.03.01.004.000143', 21, 'Sinar', 1, 'PENGHAPUS', '1100', 'BJ', 1, 0, 1, '', NULL);
INSERT INTO `stokbarang` VALUES (96, '1.01.03.01.005.000141', 21, 'Sinar', 1, 'BUKU EKSPEDISI', '19800', 'BH', 8, 0, 8, '', NULL);
INSERT INTO `stokbarang` VALUES (97, '1.01.03.01.005.000144', 21, 'Sinar', 1, 'BUKU AGENDA K M', '42900', 'BH', 11, 0, 11, '', NULL);
INSERT INTO `stokbarang` VALUES (98, '1.01.03.01.005.000172', 21, 'Sinar', 1, 'BUKU FOLIO', '28600', 'BH', 3, 0, 3, '', NULL);
INSERT INTO `stokbarang` VALUES (99, '1.01.03.01.006.000172', 21, 'Sinar', 1, 'PELUBANG KERTAS', '21450', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (100, '1.01.03.01.006.000179', 21, 'Sinar', 1, 'MAP PLASTIK', '19250', 'BH', 10, 0, 10, '', NULL);
INSERT INTO `stokbarang` VALUES (101, '1.01.03.01.006.000201', 21, 'Sinar', 1, 'ORDNER FILE', '57200', 'BH', 2, 0, 2, '', NULL);
INSERT INTO `stokbarang` VALUES (102, '1.01.03.01.006.000202', 21, 'Sinar', 1, 'BOX FILE', '16500', 'BH', 7, 0, 7, '', NULL);
INSERT INTO `stokbarang` VALUES (103, '1.01.03.01.006.000203', 21, 'Sinar', 1, 'STOP MAP PAK', '28600', 'PAK', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (104, '1.01.03.01.006.000204', 21, 'Sinar', 1, 'MAP BATIK', '3850', 'BUAH', 41, 0, 41, '', NULL);
INSERT INTO `stokbarang` VALUES (105, '1.01.03.01.006.000205', 21, 'Sinar', 1, 'MAP ARSIP', '110000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (106, '1.01.03.01.006.000206', 21, 'Sinar', 1, 'MAP KANTOR', '18600', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (107, '1.01.03.01.006.000207', 21, 'Sinar', 1, 'MAP ARSIP WARNA', '111000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (108, '1.01.03.01.007.000174', 21, 'Sinar', 1, 'PENGGARIS BESI', '4950', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (109, '1.01.03.01.008.000133', 21, 'Sinar', 1, 'CUTTER', '29700', 'BH', 1, 0, 1, '', NULL);
INSERT INTO `stokbarang` VALUES (110, '1.01.03.01.008.000134', 21, 'Sinar', 1, 'GUNTING', '11000', 'BH', 11, 0, 11, '', NULL);
INSERT INTO `stokbarang` VALUES (111, '1.01.03.01.008.000135', 21, 'Sinar', 1, 'ISI CUTTER', '7700', 'SET', 2, 0, 2, '', NULL);
INSERT INTO `stokbarang` VALUES (112, '1.01.03.01.008.000136', 21, 'Sinar', 1, 'GUNTING BESAR', '19800', 'BH', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (113, '1.01.03.01.010.000119', 21, 'Sinar', 1, 'LEM BESAR', '10450', 'BH', 6, 0, 6, '', NULL);
INSERT INTO `stokbarang` VALUES (114, '1.01.03.01.010.000135', 21, 'Sinar', 1, 'LAK BAN BENING BESAR', '14300', 'ROL', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (115, '1.01.03.01.010.000136', 21, 'Sinar', 1, 'LAK BAN HITAM BESAR', '22000', 'ROL', 6, 0, 6, '', NULL);
INSERT INTO `stokbarang` VALUES (116, '1.01.03.01.010.000181', 21, 'Sinar', 1, 'DOUBEL TAPE', '11550', 'BH', 6, 0, 6, '', NULL);
INSERT INTO `stokbarang` VALUES (117, '1.01.03.01.010.000185', 21, 'Sinar', 1, 'LAK BAN COKLAT BSR', '16060', 'BH', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (118, '1.01.03.01.010.000187', 21, 'Sinar', 1, 'LEM STICK', '8250', 'BH', 20, 0, 20, '', NULL);
INSERT INTO `stokbarang` VALUES (119, '1.01.03.01.010.000188', 21, 'Sinar', 1, 'LAK BAN MERAH BESAR', '22000', 'BH', 9, 0, 9, '', NULL);
INSERT INTO `stokbarang` VALUES (120, '1.01.03.01.999.000178', 21, 'Sinar', 1, 'STABILO BH', '9900', 'BH', 6, 0, 6, '', NULL);
INSERT INTO `stokbarang` VALUES (121, '1.01.03.02.001.000101', 21, 'Sinar', 1, 'KERTAS HVS F4 FOLIO', '64900', 'RIM', 19, 0, 19, '', NULL);
INSERT INTO `stokbarang` VALUES (122, '1.01.03.02.001.000144', 21, 'Sinar', 1, 'KERTAS HVS F4 WARNA KUNING', '56100', 'RIM', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (123, '1.01.03.02.001.000145', 21, 'Sinar', 1, 'KERTAS HVS F4 HIJAU', '60000', 'RIM', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (124, '1.01.03.02.001.000146', 21, 'Sinar', 1, 'KERTAS HVS F4 MERAH', '60000', 'RIM', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (125, '1.01.03.02.001.000147', 21, 'Sinar', 1, 'KERTAS HVS F4 BIRU', '60000', 'RIM', 4, 0, 4, '', NULL);
INSERT INTO `stokbarang` VALUES (126, '1.01.03.02.001.000148', 21, 'Sinar', 1, 'KERTAS HVS A4', '60500', 'RIM', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (127, '1.01.03.02.002.000199', 21, 'Sinar', 1, 'POST ID SEDANG', '16500', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (128, '1.01.03.02.002.000200', 21, 'Sinar', 1, 'POST ID KECIL', '8800', 'BH', 6, 0, 6, '', NULL);
INSERT INTO `stokbarang` VALUES (129, '1.01.03.02.002.000213', 21, 'Sinar', 1, 'KERTAS STIKER A4', '11000', 'PAK', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (130, '1.01.03.02.002.000216', 21, 'Sinar', 1, 'POST IT BESAR', '16650', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (131, '1.01.03.02.002.000217', 21, 'Sinar', 1, 'KERTAS POST ID KECIL', '8880', 'BUAH', 10, 0, 10, '', NULL);
INSERT INTO `stokbarang` VALUES (132, '1.01.03.02.002.000218', 21, 'Sinar', 1, 'KERTAS POST IT BESAR', '11100', 'BUAH', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (133, '1.01.03.02.003.000133', 21, 'Sinar', 1, 'KERTAS BUFALOW', '30250', 'PAK', 3, 0, 3, '', NULL);
INSERT INTO `stokbarang` VALUES (134, '1.01.03.02.003.000134', 21, 'Sinar', 1, 'KERTAS BUFALOW PUTIH', '60830', 'PAK', 1, 0, 1, '', NULL);
INSERT INTO `stokbarang` VALUES (135, '1.01.03.02.003.000135', 21, 'Sinar', 1, 'PLASTIK JILID', '44000', 'PAK', 2, 0, 2, '', NULL);
INSERT INTO `stokbarang` VALUES (136, '1.01.03.02.004.000102', 21, 'Sinar', 1, 'AMPLOP COKLAT BESAR', '30800', 'PAK', 9, 0, 9, '', NULL);
INSERT INTO `stokbarang` VALUES (137, '1.01.03.02.004.000132', 21, 'Sinar', 1, 'AMPLOP COKLAT KECIL', '14300', 'PAK', 2, 0, 2, '', NULL);
INSERT INTO `stokbarang` VALUES (138, '1.01.03.02.004.000157', 21, 'Sinar', 1, 'AMPLOP ROYAL', '23100', 'KOTAK', 23, 0, 23, '', NULL);
INSERT INTO `stokbarang` VALUES (139, '1.01.03.04.004.000210', 21, 'Sinar', 1, 'TINTA EPSON HITAM KTK', '126500', 'KOTAK', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (140, '1.01.03.04.004.000218', 21, 'Sinar', 1, 'CATRIDGE HP HITAM 704', '132000', 'BH', 8, 0, 8, '', NULL);
INSERT INTO `stokbarang` VALUES (141, '1.01.03.04.004.000219', 21, 'Sinar', 1, 'CATRIDGE HP WARNA 704', '132000', 'BH', 8, 0, 8, '', NULL);
INSERT INTO `stokbarang` VALUES (142, '1.01.03.04.004.000220', 21, 'Sinar', 1, 'CATRIDGE CANNON HITAM 810', '291500', 'BH', 3, 0, 3, '', NULL);
INSERT INTO `stokbarang` VALUES (143, '1.01.03.04.004.000221', 21, 'Sinar', 1, 'CATRIDGE CANNON WARNA 811', '352000', 'BH', 9, 0, 9, '', NULL);
INSERT INTO `stokbarang` VALUES (144, '1.01.03.04.004.000228', 21, 'Sinar', 1, 'CARTRIDGE LASER Z05A', '1595000', 'BUAH', 1, 0, 1, '', NULL);
INSERT INTO `stokbarang` VALUES (145, '1.01.03.04.004.000229', 21, 'Sinar', 1, 'CARTRIDGE LASER Z85A', '1292484', 'BUAH', 1, 0, 1, '', NULL);
INSERT INTO `stokbarang` VALUES (146, '1.01.03.04.004.000232', 21, 'Sinar', 1, 'TINTA EPSON BLACK', '105450', 'BUAH', 4, 0, 4, '', NULL);
INSERT INTO `stokbarang` VALUES (147, '1.01.03.04.004.000233', 21, 'Sinar', 1, 'TINTA EPSON KUNING', '104500', 'BUAH', 7, 0, 7, '', NULL);
INSERT INTO `stokbarang` VALUES (148, '1.01.03.04.004.000234', 21, 'Sinar', 1, 'TINTA EPSON MERAH', '104500', 'BUAH', 6, 0, 6, '', NULL);
INSERT INTO `stokbarang` VALUES (149, '1.01.03.04.004.000235', 21, 'Sinar', 1, 'TINTA EPSON BIRU', '104500', 'BUAH', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (150, '1.01.03.04.004.000239', 21, 'Sinar', 1, 'TINTA BLUE PRINT MERAH', '52250', 'BOTOL', 10, 0, 10, '', NULL);
INSERT INTO `stokbarang` VALUES (151, '1.01.03.04.004.000240', 21, 'Sinar', 1, 'TINTA BLUE PRINT KUNING', '52250', 'BOTOL', 10, 0, 10, '', NULL);
INSERT INTO `stokbarang` VALUES (152, '1.01.03.04.004.000241', 21, 'Sinar', 1, 'TINTA BLUE PRINT BIRU', '52250', 'BOTOL', 10, 0, 10, '', NULL);
INSERT INTO `stokbarang` VALUES (153, '1.01.03.04.004.000242', 21, 'Sinar', 1, 'TINTA BLUE PRINT HITAM', '52250', 'BOTOL', 10, 0, 10, '', NULL);
INSERT INTO `stokbarang` VALUES (154, '1.01.03.04.004.000244', 21, 'Sinar', 1, 'CATRIDGE 680 WARNA', '194700', 'BUAH', 2, 0, 2, '', NULL);
INSERT INTO `stokbarang` VALUES (155, '1.01.03.04.004.000245', 21, 'Sinar', 1, 'CATRIDGE 680 HITAM', '297000', 'BUAH', 5, 0, 5, '', NULL);
INSERT INTO `stokbarang` VALUES (156, '1.01.03.04.004.000246', 21, 'Sinar', 1, 'CATRIDGE 746', '231000', 'BUAH', 7, 0, 7, '', NULL);
INSERT INTO `stokbarang` VALUES (157, '1.01.03.04.004.000247', 21, 'Sinar', 1, 'CATRIDGE 745', '214500', 'BUAH', 9, 0, 9, '', NULL);
INSERT INTO `stokbarang` VALUES (158, '1.01.03.04.004.000248', 21, 'Sinar', 1, 'TINTA EPSON 003 HITAM', '126500', 'BOTOL', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (159, '1.01.03.04.004.000249', 21, 'Sinar', 1, 'TINTA EPSON 003 KUNING', '126500', 'BOTOL', 1, 0, 1, '', NULL);
INSERT INTO `stokbarang` VALUES (160, '1.01.03.04.004.000250', 21, 'Sinar', 1, 'TINTA EPSON 003 BIRU', '126500', 'BOTOL', 1, 0, 1, '', NULL);
INSERT INTO `stokbarang` VALUES (161, '1.01.03.04.004.000251', 21, 'Sinar', 1, 'TINTA EPSON 003 MERAH', '126500', 'BOTOL', 1, 0, 1, '', NULL);
INSERT INTO `stokbarang` VALUES (162, '1.01.03.04.004.000252', 21, 'Sinar', 1, 'TINTA EPSON HITAM', '88000', 'BH', 4, 0, 4, '', NULL);
INSERT INTO `stokbarang` VALUES (166, '1.01.03.05.003.000181', 21, 'Sinar', 2, 'GAYUNG', '11000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (167, '1.01.03.05.003.000184', 21, 'Sinar', 2, 'EMBER II', '12000', 'BH', 100, 2, 98, '', NULL);
INSERT INTO `stokbarang` VALUES (168, '1.01.03.05.004.000211', 21, 'Sinar', 2, 'BAK SAMPAH PLASTIK', '50500', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (169, '1.01.03.05.005.000001', 21, 'Sinar', 3, 'KUNCI PINTU', '85000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (170, '1.01.03.05.005.000007', 21, 'Sinar', 3, 'GRENDEL', '25000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (171, '1.01.03.05.005.000008', 21, 'Sinar', 3, 'KRAN', '21000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (172, '1.01.03.05.005.000009', 21, 'Sinar', 3, 'ISOLASI KECIL', '5000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (173, '1.01.03.05.005.000010', 21, 'Sinar', 3, 'SILICON', '40000', 'BH', 100, 0, 100, '', NULL);
INSERT INTO `stokbarang` VALUES (174, '1.01.03.05.005.000011', 21, 'Sinar', 3, 'TEMBAKAN SILICON', '30000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (175, '1.01.03.05.005.000012', 21, 'Sinar', 3, 'LEM KACA', '35000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (176, '1.01.03.05.013.000001', 21, 'Sinar', 3, 'KUAS', '20000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (177, '1.01.03.05.999.000006', 21, 'Sinar', 3, 'BENDERA MERAH PUTIH', '104000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (178, '1.01.03.06.001.000004', 21, 'Sinar', 3, 'KABEL LIN MINUS', '6000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (179, '1.01.03.06.002.000201', 21, 'Sinar', 3, 'LAMPU PHILIPS', '45000', 'BH', 2, 0, 2, '', NULL);
INSERT INTO `stokbarang` VALUES (180, '1.01.03.06.002.000180', 21, 'Sinar', 3, 'BOLA LAMPU', '35000', 'BH', 100, 0, 100, '', NULL);
INSERT INTO `stokbarang` VALUES (181, '1.01.03.06.002.000196', 21, 'Sinar', 3, 'LAMPU GOLD DREAM', '25000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (182, '1.01.03.06.002.000197', 21, 'Sinar', 3, 'LAMPU MEXAL', '65000', 'BUAH', 100, 3, 97, '', NULL);
INSERT INTO `stokbarang` VALUES (183, '1.01.03.06.002.000198', 21, 'Sinar', 3, 'LAMPU MEUAL', '30000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (184, '1.01.03.06.002.000199', 21, 'Sinar', 3, 'LAMPU LED 15W', '25000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (185, '1.01.03.06.002.000200', 21, 'Sinar', 3, 'LAMPU PANDAWA', '45000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (186, '1.01.03.06.008.000001', 21, 'Sinar', 3, 'VITTINGAN LAMPU', '14000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (187, '1.01.03.06.999.000017', 21, 'Sinar', 3, 'KLEM KABEL', '12500', 'KTK', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (188, '1.01.03.09.001.000003', 21, 'Sinar', 3, 'Materai 10000', '10000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (189, '1.01.03.10.001.000001', 21, 'Sinar', 3, 'MASKER', '40000', 'KOTAK', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (190, '1.01.03.14.999.000002', 21, 'Sinar', 3, 'IODINE POVODONE', '90000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (191, '1.01.03.14.999.000003', 21, 'Sinar', 3, 'BETADINE KUMUR 100', '45000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (192, '1.01.03.14.999.000004', 21, 'Sinar', 3, 'XPLASH PLESTER LUKA', '35000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (193, '1.01.03.14.999.000005', 21, 'Sinar', 3, 'ENTROSTOP TAB', '20000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (194, '1.01.03.14.999.000006', 21, 'Sinar', 3, 'PROMAG TAB', '10000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (195, '1.01.03.14.999.000007', 21, 'Sinar', 3, 'CENDO LYTER TM', '50000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (196, '1.01.03.14.999.000008', 21, 'Sinar', 3, 'GELIGA BALSEM', '35000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (197, '1.01.03.14.999.000009', 21, 'Sinar', 3, 'PARACETAMOL TAB 500', '50000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (198, '1.01.03.14.999.000010', 21, 'Sinar', 3, 'WOODS EXP 60', '35000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (199, '1.01.03.14.999.000011', 21, 'Sinar', 3, 'VICKS F44 54', '35000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (200, '1.01.03.14.999.000012', 21, 'Sinar', 3, 'KAPAS 100 GR', '50000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (201, '1.01.03.14.999.000013', 21, 'Sinar', 3, 'HOTIJN CREAM PUMP', '55000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (202, '1.01.03.14.999.000014', 21, 'Sinar', 3, 'PANADOL EXTRA', '25000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (203, '1.01.03.99.999.000021', 21, 'Sinar', 3, 'Antis', '14000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (204, '1.01.03.99.999.000024', 21, 'Sinar', 3, 'Paku', '9000', 'kg', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (205, '1.01.03.99.999.000032', 21, 'Sinar', 3, 'TISU KOTAK', '13750', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (206, '1.01.03.99.999.000035', 21, 'Sinar', 3, 'Alat Rapid Test', '60000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (207, '1.01.03.99.999.000041', 21, 'Sinar', 3, 'SUPERPEL', '13500', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (208, '1.01.03.99.999.000042', 21, 'Sinar', 3, 'CLING', '5000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (209, '1.01.03.99.999.000043', 21, 'Sinar', 3, 'UNIK CHAMOIS MOBIL T', '25790', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (210, '1.01.03.99.999.000044', 21, 'Sinar', 3, 'B&C LAP MOBIL', '21600', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (211, '1.01.03.99.999.000045', 21, 'Sinar', 3, 'SOS REFFIL', '9450', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (212, '1.01.03.99.999.000046', 21, 'Sinar', 3, 'SOS KARBOL', '11770', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (213, '1.01.03.99.999.000048', 21, 'Sinar', 3, 'WINGS CLING', '11240', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (214, '1.01.03.99.999.000049', 21, 'Sinar', 3, 'CLING PB KACA REF', '3580', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (215, '1.01.03.99.999.000050', 21, 'Sinar', 3, 'CLING PB KACA 440ML', '8210', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (216, '1.01.03.99.999.000051', 21, 'Sinar', 3, 'HARPIC LIQ', '22990', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (217, '1.01.03.99.999.000052', 21, 'Sinar', 3, 'HARPIC PENGHANCUR', '22990', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (218, '1.01.03.99.999.000053', 21, 'Sinar', 3, 'HARPIC LIQ 450 ML', '17570', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (219, '1.01.03.99.999.000055', 21, 'Sinar', 3, 'HARPIC LIQ 495 ML', '22990', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (220, '1.01.03.99.999.000056', 21, 'Sinar', 3, 'SIKAT WC', '30210', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (221, '1.01.03.99.999.000057', 21, 'Sinar', 3, 'SIKAT WC NAGATA', '22980', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (222, '1.01.03.99.999.000058', 21, 'Sinar', 3, 'SAPU TAMAN', '14180', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (223, '1.01.03.99.999.000059', 21, 'Sinar', 3, 'CAT AVITEX', '155000', 'GLN', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (224, '1.01.03.99.999.000060', 21, 'Sinar', 3, 'KUAS 4\"', '25000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (225, '1.01.03.99.999.000061', 21, 'Sinar', 3, 'CAT TNK 1000 DARK GREY 5 KG', '272000', 'GLN', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (226, '1.01.03.99.999.000062', 21, 'Sinar', 3, 'KUAS PRIMA 833', '26000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (227, '1.01.03.99.999.000063', 21, 'Sinar', 3, 'CAT AVITEX SUPER WHITE 25KG', '678950', 'PAIL', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (228, '1.01.03.99.999.000064', 21, 'Sinar', 3, 'KUAS ROLLER NP 9inc', '28000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (229, '1.01.03.99.999.000066', 21, 'Sinar', 3, 'CAT NO DROP', '80000', 'KG', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (230, '1.01.03.99.999.000067', 21, 'Sinar', 3, 'KUAS CAT', '15000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (231, '1.01.03.99.999.000068', 21, 'Sinar', 3, 'TISU JOLLY', '7990', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (232, '1.01.03.99.999.000069', 21, 'Sinar', 2, 'TISU PASEO', '8450', 'BH', 50, 0, 50, '', NULL);
INSERT INTO `stokbarang` VALUES (233, '1.01.03.99.999.000070', 21, 'Sinar', 3, 'Gembok Gerbang', '55000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (234, '1.01.03.99.999.000072', 21, 'Sinar', 3, 'ENGSEL 3/4', '12000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (235, '1.01.03.99.999.000073', 21, 'Sinar', 3, 'DINABOLD', '2500', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (236, '1.01.03.99.999.000074', 21, 'Sinar', 3, 'SOK 1/2 GI', '10000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (237, '1.01.03.99.999.000075', 21, 'Sinar', 3, 'SOK 1/2 STEANLIS', '15000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (238, '1.01.03.99.999.000076', 21, 'Sinar', 3, 'SELTIF', '15000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (239, '1.01.03.99.999.000077', 21, 'Sinar', 3, 'KERAN AIR TIDY RHINE', '307800', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (240, '1.01.03.99.999.000078', 21, 'Sinar', 3, 'KERAN AIR WESTAFEL', '212285', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (241, '1.01.03.99.999.000079', 21, 'Sinar', 3, 'PAKU BETON', '17000', 'KOTAK', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (242, '1.01.03.99.999.000080', 21, 'Sinar', 3, 'BENANG', '5000', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (243, '1.01.03.99.999.000081', 21, 'Sinar', 3, 'HANDSOAP CHOICE', '53900', 'JERIGEN', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (244, '1.01.03.99.999.000082', 21, 'Sinar', 3, 'TISU CHOICE', '29900', 'PACK', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (245, '1.01.03.99.999.000083', 21, 'Sinar', 3, 'TISU NICE', '19500', 'BUAH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (246, '1.01.03.99.999.000084', 21, 'Sinar', 3, 'KAWAT', '23000', 'BH', 0, 0, 0, '', NULL);
INSERT INTO `stokbarang` VALUES (247, '1.01.03.99.999.000085', 21, 'Sinar', 3, 'MASKER MOUSON', '50000', 'KOTAK', 135, 0, 135, '', NULL);
INSERT INTO `stokbarang` VALUES (248, '1.01.03.99.999.000086', 21, 'Sinar', 3, 'DETTOL ANTISEPTIC', '18150', 'BUAH', 40, 0, 40, '', NULL);
INSERT INTO `stokbarang` VALUES (249, '1.01.03.99.999.000087', 21, 'Sinar', 3, 'DETTOL HANDWASH 135 ML', '25000', 'BUAH', 100, 0, 100, '', NULL);
INSERT INTO `stokbarang` VALUES (250, '1.01.03.99.999.000088', 21, 'Sinar', 3, 'HS ANTIS SPRAY', '15400', 'BUAH', 100, 0, 100, '', NULL);
INSERT INTO `stokbarang` VALUES (251, '1.01.03.99.999.000089', 21, 'Sinar', 3, 'TISSUE NICE', '9500', 'BUAH', 60, 0, 60, '', NULL);
INSERT INTO `stokbarang` VALUES (252, '1.01.04.01.999.000189', 21, 'Sinar', 3, 'IMBOOST FORCE', '225000', 'BOX', 0, 0, 0, '', NULL);

-- ----------------------------
-- Table structure for subbidang
-- ----------------------------
DROP TABLE IF EXISTS `subbidang`;
CREATE TABLE `subbidang`  (
  `id_subbidang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_subbidang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_subbidang`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of subbidang
-- ----------------------------
INSERT INTO `subbidang` VALUES (1, 'Program dan Pelaporan');
INSERT INTO `subbidang` VALUES (2, 'Humas dan RBTI');
INSERT INTO `subbidang` VALUES (3, 'Keuangan dan BMN');
INSERT INTO `subbidang` VALUES (4, 'Penyuluhan Hukum, Bantuan Hukum Dan Jaringan Dokumentasi Informasi Hukum');
INSERT INTO `subbidang` VALUES (5, 'Pelayanan Administrasi Hukum Umum');
INSERT INTO `subbidang` VALUES (6, 'Fasilitasi Pembentukan Produk Hukum Daerah');
INSERT INTO `subbidang` VALUES (7, 'Pelayanan Kekayaan Intelektual');
INSERT INTO `subbidang` VALUES (8, 'Pemajuan HAM');
INSERT INTO `subbidang` VALUES (9, 'Pengkajian, Penelitian, Dan Pengembangan Hukum Dan HAM');

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
  `subbidang_id` int(11) NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  INDEX `level`(`level`) USING BTREE,
  INDEX `subbidang_id`(`subbidang_id`) USING BTREE,
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`level`) REFERENCES `level` (`nama_level`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`subbidang_id`) REFERENCES `subbidang` (`id_subbidang`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (14, 'tisa', 'Ulfatisa Cahyani', '199110928202203013', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 2, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (15, 'Johan', 'Johan Iswara', '199110928202203014', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 2, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (16, 'John', 'John Satriani', '199110928202203015', '21232f297a57a5a743894a0e4a801fc3', 'bendahara', 'BENDAHARA', 1, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (17, 'Admin', 'Administrator', '199110928202203016', '21232f297a57a5a743894a0e4a801fc3', 'bendahara', 'IT', 1, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (19, 'Riki', 'Ricky Aditya Supratman, S.E. ', '198710282010121003', '21232f297a57a5a743894a0e4a801fc3', 'kasub_operator', 'Kasub Operator', 3, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (21, 'Sinar', 'Hik Sinar Wardi', '199206282019011001', '21232f297a57a5a743894a0e4a801fc3', 'operator', 'Operator', 3, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (22, 'Lia', 'Rr. Faqih Aulia Rahmah, A.Md.E', '199904292022032008', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pemohon', 3, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (23, 'Undar', 'Undar Tanti Nurhayati, S.E.', '199109282022032003', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 1, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (24, 'Prima ', 'I Gede Perima Wasana, S.E.', '198205212010121003', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 1, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (25, 'Nyoman', 'I Nyoman Mas Sumerta Jaya, S.E.', '197905202010121001', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 2, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (26, 'Bela', 'Made Bela Pramesthi Putri, S.Kom.', '199510122019012001', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 1, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (29, 'Theresia', 'Theresia Epifanie, S.H.', '198908032022032002', '21232f297a57a5a743894a0e4a801fc3', 'operator', 'Operator', 3, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (31, 'Tika', 'Yustika Sari', '199109132019012001', '21232f297a57a5a743894a0e4a801fc3', 'operator', 'Operator', 3, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (32, 'Dite', 'I Made Sartana Dita, S.H.', '197411241997031001', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 4, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (33, 'Isna', 'Isna Matya Febnurjannah Yn, S.H.', '198402082005012001', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 5, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (34, 'Bambang', 'Bambang Mustiko N, S.H.', '196712311989031169', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 6, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (35, 'Ngurah', 'Gusti Ngurah Suryana Yuliadi, S.H., M.H.', '197207232001121001', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 7, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (36, 'Supardan', 'Supardan, S.H.', '197112311991031002', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 8, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (37, 'Indra', 'Indra Firmansyah, S.H.', '198509092005011001', '21232f297a57a5a743894a0e4a801fc3', 'kasub_pengguna', 'Kasub Pengguna', 9, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (38, 'penyuluh_staf', 'Penyuluh Staf', '', '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 4, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (39, 'ahu_staf', 'AHU Staf', NULL, '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 5, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (40, 'pphd_staf', 'PPHD Staf', NULL, '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 6, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (41, 'ki_staf', 'KI Staf', NULL, '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 7, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (42, 'pemajuan_ham_staf', 'Pemajuan HAM Staf', NULL, '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 8, 'hidupsehat973@gmail.com');
INSERT INTO `user` VALUES (43, 'litbangham_staf', 'Pengkajian, Penelitian, Dan Pengembangan Hukum Dan', NULL, '21232f297a57a5a743894a0e4a801fc3', 'pengguna', 'Pengguna', 9, 'hidupsehat973@gmail.com');

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

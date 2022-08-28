-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.0.28-MariaDB-2+b1 - Raspbian testing-staging
-- Server OS:                    debian-linux-gnueabihf
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table hlp_arsip.tbl_dokumen
DROP TABLE IF EXISTS `tbl_dokumen`;
CREATE TABLE IF NOT EXISTS `tbl_dokumen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_dokumen` varchar(100) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `nomor` varchar(50) DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table hlp_arsip.tbl_dokumen: ~1 rows (approximately)
INSERT INTO `tbl_dokumen` (`id`, `id_kategori`, `nama_dokumen`, `tahun`, `nomor`, `file`, `keterangan`) VALUES
	(1, 1, 'RKP Desa Tayu', '2020', '11/A/B', '1_20220621171019.pdf', '');

-- Dumping structure for table hlp_arsip.tbl_kategori_dokumen
DROP TABLE IF EXISTS `tbl_kategori_dokumen`;
CREATE TABLE IF NOT EXISTS `tbl_kategori_dokumen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(200) DEFAULT NULL,
  `status` enum('Aktif','Tidak') DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table hlp_arsip.tbl_kategori_dokumen: ~2 rows (approximately)
INSERT INTO `tbl_kategori_dokumen` (`id`, `nama_kategori`, `status`) VALUES
	(1, 'RKP Desa', 'Aktif'),
	(5, 'APBT', 'Aktif');

-- Dumping structure for table hlp_arsip.tbl_user
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(100) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `level` enum('Admin','Lurah') DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table hlp_arsip.tbl_user: ~2 rows (approximately)
INSERT INTO `tbl_user` (`username`, `password`, `nama`, `level`) VALUES
	('admin', '21232f297a57a5a743894a0e4a801fc3', 'Erma Fitriyani', 'Admin'),
	('lurah', '04960f28e4129aac5bdc9da32056560d', 'Pak Lurah Desa', 'Lurah');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

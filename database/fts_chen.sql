/*
SQLyog Ultimate v9.50 
MySQL - 5.5.5-10.4.22-MariaDB : Database - fts_chen
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fts_chen` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `fts_chen`;

/*Table structure for table `tb_hasil` */

DROP TABLE IF EXISTS `tb_hasil`;

CREATE TABLE `tb_hasil` (
  `id_hasil` int(11) NOT NULL AUTO_INCREMENT,
  `kode_jenis` varchar(16) DEFAULT NULL,
  `periode` int(4) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  PRIMARY KEY (`id_hasil`)
) ENGINE=InnoDB AUTO_INCREMENT=234 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_hasil` */

insert  into `tb_hasil`(`id_hasil`,`kode_jenis`,`periode`,`jumlah`) values (231,'J01',2023,2.0875),(232,'J01',2023,2.0875),(233,'J01',2023,2.0875);

/*Table structure for table `tb_jenis` */

DROP TABLE IF EXISTS `tb_jenis`;

CREATE TABLE `tb_jenis` (
  `kode_jenis` varchar(16) NOT NULL,
  `nama_jenis` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kode_jenis`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_jenis` */

insert  into `tb_jenis`(`kode_jenis`,`nama_jenis`) values ('J01','Ketinggian Air Laut (m)');

/*Table structure for table `tb_periode` */

DROP TABLE IF EXISTS `tb_periode`;

CREATE TABLE `tb_periode` (
  `id_periode` int(16) NOT NULL AUTO_INCREMENT,
  `waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id_periode`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_periode` */

insert  into `tb_periode`(`id_periode`,`waktu`) values (1,'2023-11-30 01:00:00'),(2,'2023-11-30 02:00:00'),(3,'2023-11-30 03:00:00'),(4,'2023-11-30 04:00:00'),(5,'2023-11-30 06:00:00'),(6,'2023-11-30 07:00:00');

/*Table structure for table `tb_relasi` */

DROP TABLE IF EXISTS `tb_relasi`;

CREATE TABLE `tb_relasi` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `id_periode` int(11) DEFAULT NULL,
  `kode_jenis` varchar(16) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_relasi` */

insert  into `tb_relasi`(`ID`,`id_periode`,`kode_jenis`,`nilai`) values (1,1,'J01',1.6),(2,2,'J01',2.74),(3,3,'J01',2.94),(4,4,'J01',1.78),(5,5,'J01',2.06),(6,6,'J01',1.69);

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `user` varchar(16) DEFAULT NULL,
  `pass` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_user` */

insert  into `tb_user`(`user`,`pass`) values ('admin','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

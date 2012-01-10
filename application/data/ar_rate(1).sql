-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2012 at 05:15 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `finance`
--

-- --------------------------------------------------------

--
-- Table structure for table `ar_rate`
--

CREATE TABLE IF NOT EXISTS `ar_rate` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(20) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `fare` decimal(9,2) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` bigint(20) unsigned DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `ar_rate`
--

INSERT INTO `ar_rate` (`id`, `category`, `name`, `description`, `fare`, `created`, `modified`, `modified_by`) VALUES
(1, 'SPP', 'Uang SPP', 'Sumbangan Pengembangan Pendidikan', 455000.00, '0000-00-00 00:00:00', '2011-12-28 19:10:37', NULL),
(2, 'Uang Masuk TA', 'Uang Masuk Taman Azhar', '', 7000000.00, '0000-00-00 00:00:00', '2011-12-28 19:10:23', NULL),
(3, 'Uang Masuk SD1', 'Uang Masuk SD Kelas 1', NULL, 6000000.00, '0000-00-00 00:00:00', '2011-12-20 12:54:03', NULL),
(4, 'Uang Buku TA', 'Uang Buku Paket Taman Azhar', NULL, 200000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(5, 'Uang Buku TA', 'Uang Buku Non Paket Taman Azhar', '', 100000.00, '0000-00-00 00:00:00', '2011-12-27 05:47:17', NULL),
(6, 'Uang Buku TA', 'Uang Buku LKS Taman Azhar', NULL, 50000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(7, 'Uang Buku TA', 'Uang Buku Lain-lain Taman Azhar', NULL, 75000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(8, 'Uang Kegiatan TA', 'Uang Kegiatan Taman Azhar', NULL, 15000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(9, 'Uang Seragam TA', 'Uang Seragam Taman Azhar', NULL, 125000.00, '0000-00-00 00:00:00', '2011-12-20 12:55:06', NULL),
(10, 'Uang Seragam SD', 'Uang Seragam SD', NULL, 125000.00, '0000-00-00 00:00:00', '2011-12-20 12:55:06', NULL),
(11, 'Uang Antar Jemput', 'Uang Antar Jemput', NULL, 100000.00, '0000-00-00 00:00:00', '2012-01-04 02:37:00', NULL),
(12, 'Uang Sanggar', 'Uang Sanggar', 'Uang Sanggar', 75000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(13, 'Uang Tunggakan Buku', 'Uang Tunggakan Buku', 'Uang Tunggakan Buku', 250000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(14, 'BPPS', 'BPPS', 'BPPS', 70000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(15, 'Uang Kegiatan TK', 'Uang Kegiatan Taman Azhar', NULL, 15000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(16, 'Uang Kegiatan SD', 'Uang Kegiatan Taman Azhar', NULL, 15000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(17, 'Uang Kegiatan SMP', 'Uang Kegiatan Taman Azhar', NULL, 15000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(18, 'Uang Seragam TK', 'Uang Seragam TK', NULL, 125000.00, '0000-00-00 00:00:00', '2011-12-20 20:55:06', NULL),
(19, 'Uang Seragam SMP', 'Uang Seragam SMP', NULL, 125000.00, '0000-00-00 00:00:00', '2011-12-20 20:55:06', NULL),
(20, 'Uang Masuk TK', 'Uang Masuk TK', '', 2000000.00, '0000-00-00 00:00:00', '2011-12-29 03:10:23', NULL),
(21, 'Uang Masuk SMP', 'Uang Masuk SMP', NULL, 7000000.00, '0000-00-00 00:00:00', '2011-12-20 20:54:03', NULL),
(22, 'UangDaftar Ulang TA', 'Uang Daftar Ulang TA', NULL, 100000.00, '0000-00-00 00:00:00', '2011-12-20 20:54:03', NULL),
(23, 'UangDaftar Ulang TK', 'Uang Daftar Ulang TK', NULL, 200000.00, '0000-00-00 00:00:00', '2011-12-20 20:54:03', NULL),
(24, 'UangDaftar Ulang SD', 'Uang Daftar Ulang SD', NULL, 300000.00, '0000-00-00 00:00:00', '2011-12-20 20:54:03', NULL),
(25, 'UangDaftar Ulang SMP', 'Uang Daftar Ulang SMP', NULL, 400000.00, '0000-00-00 00:00:00', '2011-12-20 20:54:03', NULL),
(26, 'Uang Buku TK', 'Uang Buku Paket TK', NULL, 200000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(27, 'Uang Buku TK', 'Uang Buku Non Paket TK', '', 100000.00, '0000-00-00 00:00:00', '2011-12-27 13:47:17', NULL),
(28, 'Uang Buku TK', 'Uang Buku LKS TK', NULL, 50000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(29, 'Uang Buku TK', 'Uang Buku Lain-lain TK', NULL, 75000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(30, 'Uang Buku SD', 'Uang Buku Paket SD', NULL, 200000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(31, 'Uang Buku SD', 'Uang Buku Non Paket SD', '', 100000.00, '0000-00-00 00:00:00', '2011-12-27 13:47:17', NULL),
(32, 'Uang Buku SD', 'Uang Buku LKS SD', NULL, 50000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(33, 'Uang Buku SD', 'Uang Buku Lain-lain SD', NULL, 75000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(34, 'Uang Buku SMP', 'Uang Buku Paket SMP', NULL, 200000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(35, 'Uang Buku SMP', 'Uang Buku Non Paket SMP', '', 100000.00, '0000-00-00 00:00:00', '2011-12-27 13:47:17', NULL),
(36, 'Uang Buku SMP', 'Uang Buku LKS SMP', NULL, 50000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
(37, 'Uang Buku SMP', 'Uang Buku Lain-lain SMP', NULL, 75000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

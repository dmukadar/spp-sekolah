-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2012 at 02:33 AM
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
-- Table structure for table `ar_invoice`
--

CREATE TABLE IF NOT EXISTS `ar_invoice` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `id_employee` bigint(20) unsigned DEFAULT NULL,
  `id_student` bigint(20) unsigned DEFAULT NULL,
  `id_rate` bigint(20) unsigned DEFAULT NULL,
  `amount` decimal(9,2) DEFAULT NULL,
  `status` tinyint(3) unsigned DEFAULT '0',
  `notes` varchar(255) DEFAULT NULL,
  `last_installment` tinyint(3) unsigned DEFAULT '0',
  `received_amount` decimal(9,2) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` bigint(20) unsigned DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ar_invoice`
--

INSERT INTO `ar_invoice` (`id`, `code`, `created_date`, `due_date`, `description`, `id_employee`, `id_student`, `id_rate`, `amount`, `status`, `notes`, `last_installment`, `received_amount`, `created`, `modified`, `modified_by`) VALUES
(1, '1', '2012-01-02', '2012-01-05', 'keterangan', 1, 27, 11, 100000.00, 0, 'antarjemput', 0, 10000.00, '0000-00-00 00:00:00', '2012-01-04 02:37:41', 0),
(2, '2', '2012-01-02', '2012-01-04', 'keterangan', 1, 28, 11, 100000.00, 0, 'AntarJemput', 0, 20000.00, '0000-00-00 00:00:00', '2012-01-03 21:06:04', 0),
(3, '3', '2012-01-06', '2012-03-02', 'keterangan', 1, 3, 11, 100000.00, 0, 'AntarJemput', 0, 30000.00, '0000-00-00 00:00:00', '2012-01-04 02:38:13', 0),
(4, '4', '2012-01-03', '2012-01-07', 'spp', 1, 27, 1, 455000.00, 0, 'open', 0, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, '5', '2012-01-06', '2012-01-13', 'bpps', 0, 27, 14, 70000.00, 0, 'open', 0, 50000.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(6, NULL, '2012-01-10', '2012-01-28', 'spp', 1, 28, 1, 455000.00, 0, 'open', 0, 0.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(7, NULL, '2012-01-10', '2012-01-28', 'sanggar', 1, 28, 12, 75000.00, 0, 'open', 0, 0.00, '0000-00-00 00:00:00', '2012-01-06 01:01:18', 0),
(8, NULL, '2012-01-10', '2012-01-28', 'kegiatan', 1, 28, 8, 15000.00, 0, 'open', 0, 0.00, '0000-00-00 00:00:00', '2012-01-06 01:00:45', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

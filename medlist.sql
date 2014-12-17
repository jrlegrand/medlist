-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2014 at 05:03 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `medlist`
--
CREATE DATABASE IF NOT EXISTS `medlist` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `medlist`;

-- --------------------------------------------------------

--
-- Table structure for table `med`
--

CREATE TABLE IF NOT EXISTS `med` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `medlist_id` int(10) unsigned NOT NULL,
  `rxnorm_id` int(10) unsigned NOT NULL,
  `name` varchar(2083) NOT NULL,
  `sig` text NOT NULL,
  `indication` varchar(2083) NOT NULL,
  `notes` text NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `medlist_id` (`medlist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `med`
--

INSERT INTO `med` (`id`, `medlist_id`, `rxnorm_id`, `name`, `sig`, `indication`, `notes`, `date_modified`, `date_created`) VALUES
(80, 22222222, 200977, 'Acetaminophen 500 MG Oral Tablet [Panadol]', '', '', '', '2014-11-13 15:46:59', '0000-00-00 00:00:00'),
(81, 22222222, 200801, 'Furosemide 20 MG Oral Tablet [Lasix]', '', '', '', '2014-11-13 15:46:59', '0000-00-00 00:00:00'),
(82, 22222222, 979482, 'Losartan Potassium 100 MG Oral Tablet [Cozaar]', '', '', '', '2014-11-13 15:46:59', '0000-00-00 00:00:00'),
(83, 22222222, 312513, 'Potassium Chloride 20 MEQ Extended Release Oral Tablet [K-Dur]', 'Take one tablet by mouth daily', '', '', '2014-11-13 15:46:59', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `medlist`
--

CREATE TABLE IF NOT EXISTS `medlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22222223 ;

--
-- Dumping data for table `medlist`
--

INSERT INTO `medlist` (`id`, `date_created`, `date_updated`) VALUES
(22222222, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `med`
--
ALTER TABLE `med`
  ADD CONSTRAINT `med_ibfk_1` FOREIGN KEY (`medlist_id`) REFERENCES `medlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

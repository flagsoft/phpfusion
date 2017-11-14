-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 23, 2012 at 04:21 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phpfusion`
--

-- --------------------------------------------------------

--
-- Table structure for table `catalogue`
--

CREATE TABLE IF NOT EXISTS `catalogue` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `size` int(11) DEFAULT NULL,
  `carbrand` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `carname` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `consumption` float NOT NULL,
  `ps` int(11) NOT NULL,
  `greenlabel` varchar(6) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `catalogue`
--

INSERT INTO `catalogue` (`id`, `size`, `carbrand`, `carname`, `consumption`, `ps`, `greenlabel`) VALUES
(1, 4, 'Volvo', 'Abc', 5.1, 200, 'A'),
(2, 2, 'BMW', 'i5', 10, 250, 'B'),
(3, 6, 'Volkswagen', 'VW Bus', 8.1, 120, 'B'),
(4, 4, 'Bulgati', 'BT2', 10.2, 1000, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `description`
--

CREATE TABLE IF NOT EXISTS `description` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lang` text NOT NULL,
  `desc` text CHARACTER SET latin1 COLLATE latin1_general_cs,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `description`
--

INSERT INTO `description` (`id`, `lang`, `desc`) VALUES
(1, 'EN', 'This is your Catalogue description. Here you can search for cars.'),
(2, 'DE', 'Dies ist Ihre Katalog Beschreibung in Deutsch.');

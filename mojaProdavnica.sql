-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2018 at 11:53 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mojaProdavnica`
--
CREATE DATABASE IF NOT EXISTS `mojaProdavnica` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mojaProdavnica`;

-- --------------------------------------------------------

--
-- Table structure for table `Korisnici`
--

DROP TABLE IF EXISTS `Korisnici`;
CREATE TABLE IF NOT EXISTS `Korisnici` (
  `korisnik_id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnik_fname` varchar(128) COLLATE utf8_bin NOT NULL,
  `korisnik_lname` varchar(128) COLLATE utf8_bin NOT NULL,
  `korisnik_email` varchar(512) CHARACTER SET utf8 NOT NULL,
  `korisnik_lozinka` varchar(512) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`korisnik_id`),
  KEY `korisnik_email` (`korisnik_email`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

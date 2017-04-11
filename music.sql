-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2017 at 04:34 AM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `music`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `albumId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `albumName` varchar(30) NOT NULL,
  `artistId` tinyint(4) NOT NULL,
  `year` year(4) NOT NULL,
  PRIMARY KEY (`albumId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`albumId`, `albumName`, `artistId`, `year`) VALUES
(1, '19', 1, 2008),
(2, '21', 1, 2011),
(3, '25', 1, 2015),
(4, 'Handwritten', 2, 2015),
(5, 'Illuminative', 2, 2016),
(6, 'x', 3, 2014),
(7, ':', 3, 2017),
(8, 'Nine Track Mind', 4, 2016),
(9, 'Are You With Me', 5, 2015),
(10, 'Reality', 5, 2015),
(11, 'Trxye', 6, 2014),
(12, 'WILD', 6, 2015),
(13, 'Blue Neighbourhood', 6, 2015);

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `artistId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `artistName` varchar(30) NOT NULL,
  `nationality` varchar(20) NOT NULL,
  PRIMARY KEY (`artistId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`artistId`, `artistName`, `nationality`) VALUES
(1, 'Adele', 'British'),
(2, 'Shawn Mendes', 'Canadian'),
(3, 'Ed Sheeran', 'British'),
(4, 'Charlie Puth', 'American'),
(5, 'Lost Frequencies', 'Belgian'),
(6, 'Troye Sivan', 'Australian');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE IF NOT EXISTS `song` (
  `songId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `songName` varchar(50) NOT NULL,
  `artistId` tinyint(4) NOT NULL,
  `albumId` tinyint(4) NOT NULL,
  `length` varchar(5) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`songId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`songId`, `songName`, `artistId`, `albumId`, `length`, `price`) VALUES
(1, 'Make You Feel My Love', 1, 1, '3:32', 1.99),
(2, 'Hometown Glory', 1, 1, '4:31', 1.99),
(3, 'Rolling In The Deep', 1, 2, '3:48', 2.99),
(4, 'Rumour Has It', 1, 2, '3:43', 2.99),
(5, 'Set Fire To The Rain', 1, 2, '4:02', 2.99),
(6, 'Someone Like You', 1, 2, '4:45', 2.99),
(7, 'Hello', 1, 3, '4:55', 2.99),
(8, 'Send My Love (To Your New Lover)', 1, 3, '3:43', 2.99),
(9, 'Stiches', 2, 4, '3:26', 1.99),
(10, 'Mercy', 2, 5, '3:28', 1.99),
(11, 'Treat You Better', 2, 5, '3:07', 2.99),
(12, 'Thinking Out Loud', 3, 6, '4:41', 1.99),
(13, 'Photograph', 3, 6, '4:18', 1.99),
(14, 'Castle On The Hill', 3, 7, '4:21', 2.99),
(15, 'Shape Of You', 3, 7, '3:53', 2.99),
(16, 'One Call Away', 4, 8, '3:14', 1.99),
(17, 'Marvin Gayle', 4, 8, '3:10', 1.99),
(18, 'We Don''t Talk Anymore', 4, 8, '3:37', 2.99),
(19, 'Are You With Me', 5, 9, '2:18', 1.99),
(20, 'Reality', 5, 10, '2:38', 1.99),
(21, 'Happy Little Pill', 6, 11, '3:44', 1.99),
(22, 'WILD', 6, 12, '3:47', 1.99),
(23, 'FOOLS', 6, 12, '3:40', 1.99),
(24, 'YOUTH', 6, 13, '3:05', 2.99);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

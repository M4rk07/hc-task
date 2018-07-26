-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 26, 2018 at 04:08 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_holycode`
--

-- --------------------------------------------------------

--
-- Table structure for table `hc_trip`
--

DROP TABLE IF EXISTS `hc_trip`;
CREATE TABLE IF NOT EXISTS `hc_trip` (
  `id_trip` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_trip`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hc_trip`
--

INSERT INTO `hc_trip` (`id_trip`, `name`, `id_user`) VALUES
(13, 'Easy drive', 7),
(15, 'Running', 7),
(16, 'Funny drive', 9),
(17, 'Long running', 9),
(18, 'Some trip waypoints', 9),
(19, 'Old route', 9),
(20, 'Driving around', 10);

-- --------------------------------------------------------

--
-- Table structure for table `hc_user`
--

DROP TABLE IF EXISTS `hc_user`;
CREATE TABLE IF NOT EXISTS `hc_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hc_user`
--

INSERT INTO `hc_user` (`id_user`, `username`, `password`, `attempts`) VALUES
(7, 'marko@gmail.com', '$2y$13$93XfhiOfgnQG6EHFjdixKuacJxgERnvwro2/ktp3rozW3VJCfSjQ6', 0),
(8, 'stefan@gmail.com', '$2y$13$MaqGbK/VVsS5i9FZCd.7TOIjVLI9r1lydis9cc5JBEdZkg/xrKbT2', 0),
(9, 'root@gmail.com', '$2y$13$Jr0LqwN1lVChEJkt3PX.meNDFlvvzT6NTlTdF3mTN60kn5fWhvKFi', 0),
(10, 'ana@gmail.com', '$2y$13$NzmUtd1USWBUWKnKWcejrubn7wTSTtV3n4hDXuvnHuaiCm7pNZM5K', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hc_trip`
--
ALTER TABLE `hc_trip`
  ADD CONSTRAINT `hc_trip_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `hc_user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

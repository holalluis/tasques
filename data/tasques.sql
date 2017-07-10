-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2017 at 05:12 PM
-- Server version: 5.5.55-0+deb8u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tasques`
--

-- --------------------------------------------------------

--
-- Table structure for table `acabades`
--

CREATE TABLE IF NOT EXISTS `acabades` (
`id` int(11) NOT NULL,
  `tasca` text NOT NULL,
  `projecte` text NOT NULL,
  `area` text NOT NULL,
  `acabada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acabades`
--

INSERT INTO `acabades` (`id`, `tasca`, `projecte`, `area`, `acabada`) VALUES
(142, 'Tasca completada de mostra', 'Projecte de mostra', 'ICRA', '2016-04-26 17:20:17'),
(143, 'Tasca 3', 'Projecte de mostra', 'ICRA', '2017-02-27 15:45:11');

-- --------------------------------------------------------

--
-- Table structure for table `arees`
--

CREATE TABLE IF NOT EXISTS `arees` (
`id` int(11) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `arees`
--

INSERT INTO `arees` (`id`, `nom`) VALUES
(32, 'ICRA'),
(33, 'Espera');

-- --------------------------------------------------------

--
-- Table structure for table `deadlines`
--

CREATE TABLE IF NOT EXISTS `deadlines` (
`id` int(11) NOT NULL,
  `id_tasca` int(11) NOT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `periodiques`
--

CREATE TABLE IF NOT EXISTS `periodiques` (
`id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `freq` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `periodiques`
--

INSERT INTO `periodiques` (`id`, `nom`, `freq`) VALUES
(33, 'Gmail', 0),
(36, 'Netejar inbox', 0),
(38, 'Skype dels dimarts', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pla_setmanal`
--

CREATE TABLE IF NOT EXISTS `pla_setmanal` (
`id` int(11) NOT NULL,
  `id_tasca` int(11) NOT NULL,
  `dia` int(11) NOT NULL COMMENT 'dilluns a diumenge (0,...,6)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projectes`
--

CREATE TABLE IF NOT EXISTS `projectes` (
`id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `id_area` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projectes`
--

INSERT INTO `projectes` (`id`, `nom`, `id_area`) VALUES
(199, 'Sambanet', 33),
(200, 'InnoWatt', 32),
(201, 'Ecam', 32),
(202, 'Mbr', 33),
(203, 'Ecoinvent', 32);

-- --------------------------------------------------------

--
-- Table structure for table `tasques`
--

CREATE TABLE IF NOT EXISTS `tasques` (
`id` int(11) NOT NULL,
  `id_projecte` int(11) NOT NULL,
  `descripcio` text NOT NULL,
  `acabada` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1880 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasques`
--

INSERT INTO `tasques` (`id`, `id_projecte`, `descripcio`, `acabada`) VALUES
(1877, 202, 'Tot instalat i funcionant', 0),
(1878, 201, 'Update server', 0),
(1879, 199, 'Taula tecnologies afegir', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acabades`
--
ALTER TABLE `acabades`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arees`
--
ALTER TABLE `arees`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deadlines`
--
ALTER TABLE `deadlines`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periodiques`
--
ALTER TABLE `periodiques`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pla_setmanal`
--
ALTER TABLE `pla_setmanal`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projectes`
--
ALTER TABLE `projectes`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasques`
--
ALTER TABLE `tasques`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acabades`
--
ALTER TABLE `acabades`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=144;
--
-- AUTO_INCREMENT for table `arees`
--
ALTER TABLE `arees`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `deadlines`
--
ALTER TABLE `deadlines`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `periodiques`
--
ALTER TABLE `periodiques`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `pla_setmanal`
--
ALTER TABLE `pla_setmanal`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projectes`
--
ALTER TABLE `projectes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=204;
--
-- AUTO_INCREMENT for table `tasques`
--
ALTER TABLE `tasques`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1880;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

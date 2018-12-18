-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 18, 2018 at 08:31 AM
-- Server version: 5.5.62-0+deb8u1
-- PHP Version: 5.6.38-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `slm2698a`
--

-- --------------------------------------------------------

--
-- Table structure for table `identifiant`
--

CREATE TABLE IF NOT EXISTS `identifiant` (
`id` int(11) NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Mdp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `joueur`
--

CREATE TABLE IF NOT EXISTS `joueur` (
  `NumLicence` int(11) NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DateDeNaissance` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `Taille` smallint(11) DEFAULT NULL,
  `Poids` smallint(3) DEFAULT NULL,
  `PostePref` enum('1','2','3') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Statut` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `joueur`
--

INSERT INTO `joueur` (`NumLicence`, `Nom`, `Prenom`, `DateDeNaissance`, `Taille`, `Poids`, `PostePref`, `Statut`) VALUES
(111, 'Fabre', 'Maxime', '0001-05-20', 111, 111, '1', '1'),
(154, 'Mou', 'Jean', '20/10/1999', 180, 78, '1', '1'),
(222, 'Salvagnac', 'Maxime', '2020-02-20', 1465, 546, '2', '3'),
(11521, 'efnkn', 'mdjsc', '2018-01-01', 111, 111, '1', '1'),
(65465, 'dff', 'rf', '2018-01-01', 13, 24, '3', '3');

-- --------------------------------------------------------

--
-- Table structure for table `participerremplacant`
--

CREATE TABLE IF NOT EXISTS `participerremplacant` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') NOT NULL,
  `Role` enum('1','2','3') NOT NULL,
  `Commentaire` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `participertitulaire`
--

CREATE TABLE IF NOT EXISTS `participertitulaire` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') DEFAULT NULL,
  `Role` enum('1','2','3','') NOT NULL,
  `Commentaire` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rencontre`
--

CREATE TABLE IF NOT EXISTS `rencontre` (
`IdRencontre` int(11) NOT NULL,
  `DateRencontre` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `LieuRencontre` enum('Domicile','Exterieur') CHARACTER SET utf8 NOT NULL,
  `EquipeAdverse` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ResultatEquipe` smallint(6) DEFAULT NULL,
  `ResultatAdverse` smallint(6) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rencontre`
--

INSERT INTO `rencontre` (`IdRencontre`, `DateRencontre`, `LieuRencontre`, `EquipeAdverse`, `ResultatEquipe`, `ResultatAdverse`) VALUES
(1, '20/20/2020', 'Exterieur', 'Castre', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `identifiant`
--
ALTER TABLE `identifiant`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `joueur`
--
ALTER TABLE `joueur`
 ADD PRIMARY KEY (`NumLicence`);

--
-- Indexes for table `participerremplacant`
--
ALTER TABLE `participerremplacant`
 ADD PRIMARY KEY (`NumLicence`,`IdRencontre`);

--
-- Indexes for table `participertitulaire`
--
ALTER TABLE `participertitulaire`
 ADD PRIMARY KEY (`NumLicence`,`IdRencontre`);

--
-- Indexes for table `rencontre`
--
ALTER TABLE `rencontre`
 ADD PRIMARY KEY (`IdRencontre`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `identifiant`
--
ALTER TABLE `identifiant`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rencontre`
--
ALTER TABLE `rencontre`
MODIFY `IdRencontre` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

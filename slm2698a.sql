-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2018 at 09:20 AM
-- Server version: 5.5.60-0+deb8u1
-- PHP Version: 5.6.36-0+deb8u1

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
-- Table structure for table `Joueur`
--

CREATE TABLE IF NOT EXISTS `Joueur` (
  `NumLicence` int(11) NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Prenom` int(11) NOT NULL,
  `DateDeNaissance` date NOT NULL,
  `Taille` smallint(11) DEFAULT NULL,
  `Poids` smallint(3) DEFAULT NULL,
  `PostePref` enum('1','2','3') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Commentaire` longtext COLLATE utf8_unicode_ci,
  `Statut` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ParticiperRemplacant`
--

CREATE TABLE IF NOT EXISTS `ParticiperRemplacant` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') NOT NULL,
  `Role` enum('1','2','3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ParticiperTitulaire`
--

CREATE TABLE IF NOT EXISTS `ParticiperTitulaire` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') DEFAULT NULL,
  `Role` enum('1','2','3','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Rencontre`
--

CREATE TABLE IF NOT EXISTS `Rencontre` (
`IdRencontre` int(11) NOT NULL,
  `DateRencontre` date NOT NULL,
  `LieuRencontre` enum('Domicile','Exterieur') CHARACTER SET utf8 NOT NULL,
  `EquipeAdverse` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ResultatEquipe` smallint(6) NOT NULL,
  `ResultatAdverse` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Joueur`
--
ALTER TABLE `Joueur`
 ADD PRIMARY KEY (`NumLicence`);

--
-- Indexes for table `ParticiperRemplacant`
--
ALTER TABLE `ParticiperRemplacant`
 ADD PRIMARY KEY (`NumLicence`,`IdRencontre`);

--
-- Indexes for table `ParticiperTitulaire`
--
ALTER TABLE `ParticiperTitulaire`
 ADD PRIMARY KEY (`NumLicence`,`IdRencontre`);

--
-- Indexes for table `Rencontre`
--
ALTER TABLE `Rencontre`
 ADD PRIMARY KEY (`IdRencontre`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Rencontre`
--
ALTER TABLE `Rencontre`
MODIFY `IdRencontre` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

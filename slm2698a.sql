-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 18 déc. 2018 à 07:14
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `slm2698a`
--

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `NumLicence` int(11) NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DateDeNaissance` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `Taille` smallint(11) DEFAULT NULL,
  `Poids` smallint(3) DEFAULT NULL,
  `PostePref` enum('1','2','3') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Statut` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`NumLicence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`NumLicence`, `Nom`, `Prenom`, `DateDeNaissance`, `Taille`, `Poids`, `PostePref`, `Statut`) VALUES
(111, 'Fabre', 'Maxime', '0001-05-20', 111, 111, '1', '1'),
(154, 'Mou', 'Jean', '20/10/1999', 180, 78, '1', '1'),
(222, 'Salvagnac', 'Maxime', '2020-02-20', 1465, 546, '2', '3'),
(11521, 'efnkn', 'mdjsc', '2018-01-01', 111, 111, '1', '1'),
(65465, 'dff', 'rf', '2018-01-01', 13, 24, '3', '3');

-- --------------------------------------------------------

--
-- Structure de la table `participerremplacant`
--

DROP TABLE IF EXISTS `participerremplacant`;
CREATE TABLE IF NOT EXISTS `participerremplacant` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') NOT NULL,
  `Role` enum('1','2','3') NOT NULL,
  `Commentaire` longtext NOT NULL,
  PRIMARY KEY (`NumLicence`,`IdRencontre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `participertitulaire`
--

DROP TABLE IF EXISTS `participertitulaire`;
CREATE TABLE IF NOT EXISTS `participertitulaire` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') DEFAULT NULL,
  `Role` enum('1','2','3','') NOT NULL,
  `Commentaire` longtext NOT NULL,
  PRIMARY KEY (`NumLicence`,`IdRencontre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rencontre`
--

DROP TABLE IF EXISTS `rencontre`;
CREATE TABLE IF NOT EXISTS `rencontre` (
  `IdRencontre` int(11) NOT NULL AUTO_INCREMENT,
  `DateRencontre` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `LieuRencontre` enum('Domicile','Exterieur') CHARACTER SET utf8 NOT NULL,
  `EquipeAdverse` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ResultatEquipe` smallint(6) DEFAULT NULL,
  `ResultatAdverse` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`IdRencontre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `rencontre`
--

INSERT INTO `rencontre` (`IdRencontre`, `DateRencontre`, `LieuRencontre`, `EquipeAdverse`, `ResultatEquipe`, `ResultatAdverse`) VALUES
(1, '20/20/2020', 'Exterieur', 'Castre', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

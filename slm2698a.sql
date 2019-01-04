-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 04 jan. 2019 à 20:10
-- Version du serveur :  10.3.10-MariaDB-log
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `identifiant`
--

CREATE TABLE `identifiant` (
  `Id` int(11) NOT NULL,
  `Login` varchar(50) NOT NULL DEFAULT 'lapin',
  `Mdp` varchar(255) NOT NULL DEFAULT 'canard'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `identifiant`
--

INSERT INTO `identifiant` (`Id`, `Login`, `Mdp`) VALUES
(1, 'lapin', '$2y$10$qZIqYM7RH7o9YALLv51qbODuqI1mOs6kovlrAXjNh9KPJLSQFTCYa');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `NumLicence` int(11) NOT NULL,
  `Nom` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DateDeNaissance` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `Taille` smallint(11) DEFAULT NULL,
  `Poids` smallint(3) DEFAULT NULL,
  `PostePref` enum('1','2','3') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Statut` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `extPhoto` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`NumLicence`, `Nom`, `Prenom`, `DateDeNaissance`, `Taille`, `Poids`, `PostePref`, `Statut`, `extPhoto`) VALUES
(111, 'Fabre', 'Maxime', '15/01/2018', 111, 111, '1', '1', 'jpg'),
(154, 'Mou', 'Jean', '20/10/1999', 180, 78, '1', '1', 'jpg'),
(222, 'Salvagnac', 'Maxime', '2020-02-20', 1465, 546, '2', '1', NULL),
(11521, 'efnkn', 'mdjsc', '2018-01-01', 111, 111, '1', '1', NULL),
(65465, 'dff', 'rf', '2018-01-01', 13, 24, '3', '1', NULL),
(98765, 'Ikjnjo', 'onon', '20/20/20', 170, 165, '1', '1', NULL),
(1234567899, 'Didider', 'Canard', '15/15/15', 170, 170, '1', '1', NULL),
(86797665, 'CACA', 'BOUDIN', '30/30/30', 170, 170, '1', '1', 'jpg');

-- --------------------------------------------------------

--
-- Structure de la table `participerremplacant`
--

CREATE TABLE `participerremplacant` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') NOT NULL,
  `Role` enum('1','2','3') DEFAULT NULL,
  `Commentaire` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `participerremplacant`
--

INSERT INTO `participerremplacant` (`NumLicence`, `IdRencontre`, `Notation`, `Role`, `Commentaire`) VALUES
(11521, 1, '1', '1', NULL),
(65465, 1, '1', '2', NULL),
(98765, 1, '1', '3', NULL),
(65465, 1, '1', '1', NULL),
(98765, 1, '1', '2', NULL),
(11521, 1, '1', '3', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `participertitulaire`
--

CREATE TABLE `participertitulaire` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') DEFAULT NULL,
  `Role` enum('1','2','3','') DEFAULT NULL,
  `Commentaire` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `participertitulaire`
--

INSERT INTO `participertitulaire` (`NumLicence`, `IdRencontre`, `Notation`, `Role`, `Commentaire`) VALUES
(111, 1, NULL, '1', NULL),
(154, 1, NULL, '2', NULL),
(222, 1, NULL, '3', NULL),
(111, 1, NULL, '1', NULL),
(222, 1, NULL, '2', NULL),
(154, 1, NULL, '3', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rencontre`
--

CREATE TABLE `rencontre` (
  `IdRencontre` int(11) NOT NULL,
  `DateRencontre` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `LieuRencontre` enum('Domicile','Exterieur') CHARACTER SET utf8 NOT NULL,
  `EquipeAdverse` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ResultatEquipe` smallint(6) DEFAULT NULL,
  `ResultatAdverse` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `rencontre`
--

INSERT INTO `rencontre` (`IdRencontre`, `DateRencontre`, `LieuRencontre`, `EquipeAdverse`, `ResultatEquipe`, `ResultatAdverse`) VALUES
(1, '20/20/2020', 'Exterieur', 'Castre', 15, 13);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `identifiant`
--
ALTER TABLE `identifiant`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `identifiant`
--
ALTER TABLE `identifiant`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

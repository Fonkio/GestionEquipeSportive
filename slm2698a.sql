
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


CREATE TABLE IF NOT EXISTS `ParticiperRemplacant` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') NOT NULL,
  `Role` enum('1','2','3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `ParticiperTitulaire` (
  `NumLicence` int(11) NOT NULL,
  `IdRencontre` int(11) NOT NULL,
  `Notation` enum('1','2','3','4','5') DEFAULT NULL,
  `Role` enum('1','2','3','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `Rencontre` (
`IdRencontre` int(11) NOT NULL,
  `DateRencontre` date NOT NULL,
  `LieuRencontre` enum('Domicile','Exterieur') CHARACTER SET utf8 NOT NULL,
  `EquipeAdverse` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ResultatEquipe` smallint(6) NOT NULL,
  `ResultatAdverse` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `Joueur`
 ADD PRIMARY KEY (`NumLicence`);

ALTER TABLE `ParticiperRemplacant`
 ADD PRIMARY KEY (`NumLicence`,`IdRencontre`);

ALTER TABLE `ParticiperTitulaire`
 ADD PRIMARY KEY (`NumLicence`,`IdRencontre`);

ALTER TABLE `Rencontre`
 ADD PRIMARY KEY (`IdRencontre`);

ALTER TABLE `Rencontre`
MODIFY `IdRencontre` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

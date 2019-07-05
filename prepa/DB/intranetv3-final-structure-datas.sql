-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 03 juil. 2019 à 14:34
-- Version du serveur :  5.7.24
-- Version de PHP :  7.3.1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données :  `intranetv3`
--
CREATE DATABASE IF NOT EXISTS `intranetv3` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `intranetv3`;

-- --------------------------------------------------------

--
-- Structure de la table `lafiliere`
--

DROP TABLE IF EXISTS `lafiliere`;
CREATE TABLE IF NOT EXISTS `lafiliere` (
  `idlafiliere` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lenom` varchar(45) NOT NULL,
  `lacronyme` varchar(10) NOT NULL,
  `lacouleur` varchar(10) DEFAULT NULL,
  `lepicto` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idlafiliere`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lafiliere`
--

INSERT INTO `lafiliere` (`idlafiliere`, `lenom`, `lacronyme`, `lacouleur`, `lepicto`) VALUES
(1, 'Web Developer', 'WEB', NULL, 'images/web.png'),
(2, 'Animateur Multimédia', 'AMM', NULL, 'images/amm.png');

-- --------------------------------------------------------

--
-- Structure de la table `lasession`
--

DROP TABLE IF EXISTS `lasession`;
CREATE TABLE IF NOT EXISTS `lasession` (
  `idlasession` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lenom` varchar(45) NOT NULL,
  `lacronyme` varchar(10) NOT NULL,
  `lannee` year(4) NOT NULL,
  `lenumero` tinyint(1) DEFAULT NULL,
  `letype` tinyint(1) NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `lafiliere_idfiliere` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`idlasession`),
  KEY `fk_session_filiere1_idx` (`lafiliere_idfiliere`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lasession`
--

INSERT INTO `lasession` (`idlasession`, `lenom`, `lacronyme`, `lannee`, `lenumero`, `letype`, `debut`, `fin`, `lafiliere_idfiliere`) VALUES
(1, 'WEB2019', 'WEB2019', 2019, 1, 2, '2019-01-07', '2019-11-08', 1),
(2, 'AMM2019', 'AMM2019', 2019, 1, 2, '2019-02-04', '2019-12-20', 2);

-- --------------------------------------------------------

--
-- Structure de la table `ledroit`
--

DROP TABLE IF EXISTS `ledroit`;
CREATE TABLE IF NOT EXISTS `ledroit` (
  `idledroit` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lintitule` varchar(60) NOT NULL,
  `ladescription` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idledroit`),
  UNIQUE KEY `theintitule_UNIQUE` (`lintitule`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ledroit`
--

INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES
(1, 'Imprimer la feuille de signature', 'Imprimer la feuille de signature pour chaque groupe'),
(2, 'Modifier un droit', 'Pouvoir modifier un droit existant'),
(3, 'Créer un rôle', 'Pouvoir créer un nouveau rôle pour l\'associer à un utilisateur'),
(4, 'Supprimer un droit', 'Pouvoir supprimer un droit existant'),
(5, 'Lire un droit', 'Pouvoir lire un droit existant associé à un rôle'),
(6, 'Créer un droit', 'Pouvoir créer un nouveau droit pour l\'associer à un rôle'),
(7, 'Lire un rôle', 'Pouvoir lire un rôle existant associé à un utilisateur'),
(8, 'Modifier un rôle', 'Pouvoir modifier un rôle existant'),
(9, 'Supprimer un rôle', 'Pouvoir supprimer un rôle existant'),
(10, 'Encoder les présences', 'Pouvoir encoder les présences, les retards, les absences des stagiaires'),
(11, 'Consulter les présences', 'Pouvoir visualiser les statistiques de présence des stagiaires');

-- --------------------------------------------------------

--
-- Structure de la table `lerole`
--

DROP TABLE IF EXISTS `lerole`;
CREATE TABLE IF NOT EXISTS `lerole` (
  `idlerole` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lintitule` varchar(60) NOT NULL,
  `ladescription` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idlerole`),
  UNIQUE KEY `intitule_UNIQUE` (`lintitule`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lerole`
--

INSERT INTO `lerole` (`idlerole`, `lintitule`, `ladescription`) VALUES
(1, 'Membre du personnel', 'Toute personne faisant partie du personnel du CF2M'),
(2, 'Agent d\'accueil', 'La personne à l\'accueil qui enregistre les arrivées et départs des stagiaires'),
(3, 'Référent Pédagogique', 'La personne qui s\'occupe du suivi pédagogique des stagiaires'),
(4, 'Administrateur Technique', 'La personne qui gère la configuration du système'),
(5, 'Stagiaire', 'La personne qui suit une formation au CF2M');

-- --------------------------------------------------------

--
-- Structure de la table `lerole_has_ledroit`
--

DROP TABLE IF EXISTS `lerole_has_ledroit`;
CREATE TABLE IF NOT EXISTS `lerole_has_ledroit` (
  `lerole_idlerole` smallint(5) UNSIGNED NOT NULL,
  `ledroit_idledroit` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`lerole_idlerole`,`ledroit_idledroit`),
  KEY `fk_lerole_has_ledroit_ledroit1_idx` (`ledroit_idledroit`),
  KEY `fk_lerole_has_ledroit_lerole1_idx` (`lerole_idlerole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lerole_has_ledroit`
--

INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES
(1, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 9),
(2, 10),
(3, 10),
(3, 11);

-- --------------------------------------------------------

--
-- Structure de la table `linscription`
--

DROP TABLE IF EXISTS `linscription`;
CREATE TABLE IF NOT EXISTS `linscription` (
  `idlinscription` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `debut` date DEFAULT NULL,
  `fin` date DEFAULT NULL,
  `utilisateur_idutilisateur` mediumint(8) UNSIGNED NOT NULL,
  `lasession_idsession` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`idlinscription`),
  KEY `fk_inscription_utilisateur1_idx` (`utilisateur_idutilisateur`),
  KEY `fk_inscription_session1_idx` (`lasession_idsession`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `linscription`
--

INSERT INTO `linscription` (`idlinscription`, `debut`, `fin`, `utilisateur_idutilisateur`, `lasession_idsession`) VALUES
(1, '2019-01-07', '2019-11-08', 9, 1),
(2, '2019-02-04', '2019-11-08', 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `lutilisateur`
--

DROP TABLE IF EXISTS `lutilisateur`;
CREATE TABLE IF NOT EXISTS `lutilisateur` (
  `idlutilisateur` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lenomutilisateur` varchar(80) NOT NULL,
  `lemotdepasse` varchar(255) NOT NULL COMMENT 'crypt with password_hash - PASSWORD_DEFAULT ',
  `lenom` varchar(45) NOT NULL,
  `leprenom` varchar(45) NOT NULL,
  `lemail` varchar(180) NOT NULL,
  `luniqueid` char(26) NOT NULL COMMENT 'create with uniqid(key,true) string(26)',
  PRIMARY KEY (`idlutilisateur`),
  UNIQUE KEY `lenomutilisateur_UNIQUE` (`lenomutilisateur`),
  UNIQUE KEY `lemail_UNIQUE` (`lemail`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lutilisateur`
--

INSERT INTO `lutilisateur` (`idlutilisateur`, `lenomutilisateur`, `lemotdepasse`, `lenom`, `leprenom`, `lemail`, `luniqueid`) VALUES
(1, 'sylviane.mol', '', 'Mol', 'Sylviane', 'sylviane.mol@cf2m.be', ''),
(2, 'pierre.sandron', '', 'Sandron', 'Pierre', 'pierre.sandron@cf2m.be', ''),
(9, 'oumar.abakar', '', 'Abakar', 'Oumar', 'oumar.abakar@cf2m', ''),
(10, 'dimitri.bouvy', '', 'Bouvy', 'Dimitri', 'dimitri.bouvy@cf2m', '');

-- --------------------------------------------------------

--
-- Structure de la table `lutilisateur_has_lerole`
--

DROP TABLE IF EXISTS `lutilisateur_has_lerole`;
CREATE TABLE IF NOT EXISTS `lutilisateur_has_lerole` (
  `lutilisateur_idutilisateur` mediumint(8) UNSIGNED NOT NULL,
  `lerole_idlerole` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`lutilisateur_idutilisateur`,`lerole_idlerole`),
  KEY `fk_utilisateur_has_lerole_lerole1_idx` (`lerole_idlerole`),
  KEY `fk_utilisateur_has_lerole_utilisateur_idx` (`lutilisateur_idutilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lutilisateur_has_lerole`
--

INSERT INTO `lutilisateur_has_lerole` (`lutilisateur_idutilisateur`, `lerole_idlerole`) VALUES
(1, 1),
(2, 1),
(1, 3),
(2, 4),
(9, 5),
(10, 5);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lasession`
--
ALTER TABLE `lasession`
  ADD CONSTRAINT `fk_session_filiere1` FOREIGN KEY (`lafiliere_idfiliere`) REFERENCES `lafiliere` (`idlafiliere`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `lerole_has_ledroit`
--
ALTER TABLE `lerole_has_ledroit`
  ADD CONSTRAINT `fk_lerole_has_ledroit_ledroit1` FOREIGN KEY (`ledroit_idledroit`) REFERENCES `ledroit` (`idledroit`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_lerole_has_ledroit_lerole1` FOREIGN KEY (`lerole_idlerole`) REFERENCES `lerole` (`idlerole`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `linscription`
--
ALTER TABLE `linscription`
  ADD CONSTRAINT `fk_inscription_session1` FOREIGN KEY (`lasession_idsession`) REFERENCES `lasession` (`idlasession`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscription_utilisateur1` FOREIGN KEY (`utilisateur_idutilisateur`) REFERENCES `lutilisateur` (`idlutilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `lutilisateur_has_lerole`
--
ALTER TABLE `lutilisateur_has_lerole`
  ADD CONSTRAINT `fk_utilisateur_has_lerole_lerole1` FOREIGN KEY (`lerole_idlerole`) REFERENCES `lerole` (`idlerole`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_utilisateur_has_lerole_utilisateur` FOREIGN KEY (`lutilisateur_idutilisateur`) REFERENCES `lutilisateur` (`idlutilisateur`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;


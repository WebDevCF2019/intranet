-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 03 juil. 2019 à 13:58
-- Version du serveur :  5.7.24
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `intranetv3`
--

--
-- Déchargement des données de la table `lafiliere`
--

INSERT INTO `lafiliere` (`idlafiliere`, `lenom`, `lacronyme`, `lacouleur`, `lepicto`) VALUES(1, 'Web Developer', 'WEB', NULL, 'images/web.png');
INSERT INTO `lafiliere` (`idlafiliere`, `lenom`, `lacronyme`, `lacouleur`, `lepicto`) VALUES(2, 'Animateur Multimédia', 'AMM', NULL, 'images/amm.png');

--
-- Déchargement des données de la table `lasession`
--

INSERT INTO `lasession` (`idlasession`, `lenom`, `lacronyme`, `lannee`, `lenumero`, `letype`, `debut`, `fin`, `lafiliere_idfiliere`) VALUES(1, 'WEB2019', 'WEB2019', 2019, 1, 2, '2019-01-07', '2019-11-08', 1);
INSERT INTO `lasession` (`idlasession`, `lenom`, `lacronyme`, `lannee`, `lenumero`, `letype`, `debut`, `fin`, `lafiliere_idfiliere`) VALUES(2, 'AMM2019', 'AMM2019', 2019, 1, 2, '2019-02-04', '2019-12-20', 2);

--
-- Déchargement des données de la table `ledroit`
--

INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(1, 'Imprimer la feuille de signature', 'Imprimer la feuille de signature pour chaque groupe');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(2, 'Modifier un droit', 'Pouvoir modifier un droit existant');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(3, 'Créer un rôle', 'Pouvoir créer un nouveau rôle pour l\'associer à un utilisateur');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(4, 'Supprimer un droit', 'Pouvoir supprimer un droit existant');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(5, 'Lire un droit', 'Pouvoir lire un droit existant associé à un rôle');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(6, 'Créer un droit', 'Pouvoir créer un nouveau droit pour l\'associer à un rôle');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(7, 'Lire un rôle', 'Pouvoir lire un rôle existant associé à un utilisateur');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(8, 'Modifier un rôle', 'Pouvoir modifier un rôle existant');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(9, 'Supprimer un rôle', 'Pouvoir supprimer un rôle existant');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(10, 'Encoder les présences', 'Pouvoir encoder les présences, les retards, les absences des stagiaires');
INSERT INTO `ledroit` (`idledroit`, `lintitule`, `ladescription`) VALUES(11, 'Consulter les présences', 'Pouvoir visualiser les statistiques de présence des stagiaires');

--
-- Déchargement des données de la table `lerole`
--

INSERT INTO `lerole` (`idlerole`, `lintitule`, `ladescription`) VALUES(1, 'Membre du personnel', 'Toute personne faisant partie du personnel du CF2M');
INSERT INTO `lerole` (`idlerole`, `lintitule`, `ladescription`) VALUES(2, 'Agent d\'accueil', 'La personne à l\'accueil qui enregistre les arrivées et départs des stagiaires');
INSERT INTO `lerole` (`idlerole`, `lintitule`, `ladescription`) VALUES(3, 'Référent Pédagogique', 'La personne qui s\'occupe du suivi pédagogique des stagiaires');
INSERT INTO `lerole` (`idlerole`, `lintitule`, `ladescription`) VALUES(4, 'Administrateur Technique', 'La personne qui gère la configuration du système');
INSERT INTO `lerole` (`idlerole`, `lintitule`, `ladescription`) VALUES(5, 'Stagiaire', 'La personne qui suit une formation au CF2M');

--
-- Déchargement des données de la table `lerole_has_ledroit`
--

INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(1, 1);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(4, 2);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(4, 3);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(4, 4);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(4, 5);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(4, 6);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(4, 7);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(4, 8);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(4, 9);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(2, 10);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(3, 10);
INSERT INTO `lerole_has_ledroit` (`lerole_idlerole`, `ledroit_idledroit`) VALUES(3, 11);

--
-- Déchargement des données de la table `linscription`
--

INSERT INTO `linscription` (`idlinscription`, `debut`, `fin`, `utilisateur_idutilisateur`, `lasession_idsession`) VALUES(1, '2019-01-07', '2019-11-08', 9, 1);
INSERT INTO `linscription` (`idlinscription`, `debut`, `fin`, `utilisateur_idutilisateur`, `lasession_idsession`) VALUES(2, '2019-02-04', '2019-11-08', 10, 1);

--
-- Déchargement des données de la table `lutilisateur`
--

INSERT INTO `lutilisateur` (`idlutilisateur`, `lenomutilisateur`, `lemotdepasse`, `lenom`, `leprenom`, `lemail`, `luniqueid`) VALUES(1, 'sylviane.mol', '', 'Mol', 'Sylviane', 'sylviane.mol@cf2m.be', '');
INSERT INTO `lutilisateur` (`idlutilisateur`, `lenomutilisateur`, `lemotdepasse`, `lenom`, `leprenom`, `lemail`, `luniqueid`) VALUES(2, 'pierre.sandron', '', 'Sandron', 'Pierre', 'pierre.sandron@cf2m.be', '');
INSERT INTO `lutilisateur` (`idlutilisateur`, `lenomutilisateur`, `lemotdepasse`, `lenom`, `leprenom`, `lemail`, `luniqueid`) VALUES(9, 'oumar.abakar', '', 'Abakar', 'Oumar', 'oumar.abakar@cf2m', '');
INSERT INTO `lutilisateur` (`idlutilisateur`, `lenomutilisateur`, `lemotdepasse`, `lenom`, `leprenom`, `lemail`, `luniqueid`) VALUES(10, 'dimitri.bouvy', '', 'Bouvy', 'Dimitri', 'dimitri.bouvy@cf2m', '');

--
-- Déchargement des données de la table `lutilisateur_has_lerole`
--

INSERT INTO `lutilisateur_has_lerole` (`lutilisateur_idutilisateur`, `lerole_idlerole`) VALUES(1, 1);
INSERT INTO `lutilisateur_has_lerole` (`lutilisateur_idutilisateur`, `lerole_idlerole`) VALUES(2, 1);
INSERT INTO `lutilisateur_has_lerole` (`lutilisateur_idutilisateur`, `lerole_idlerole`) VALUES(1, 3);
INSERT INTO `lutilisateur_has_lerole` (`lutilisateur_idutilisateur`, `lerole_idlerole`) VALUES(2, 4);
INSERT INTO `lutilisateur_has_lerole` (`lutilisateur_idutilisateur`, `lerole_idlerole`) VALUES(9, 5);
INSERT INTO `lutilisateur_has_lerole` (`lutilisateur_idutilisateur`, `lerole_idlerole`) VALUES(10, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

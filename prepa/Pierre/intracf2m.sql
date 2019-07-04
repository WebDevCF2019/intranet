-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 27 juin 2019 à 08:56
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `intracf2m`
--
CREATE DATABASE IF NOT EXISTS `intracf2m` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `intracf2m`;

-- --------------------------------------------------------

--
-- Structure de la table `conges`
--

DROP TABLE IF EXISTS `conges`;
CREATE TABLE IF NOT EXISTS `conges` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_id` int(10) UNSIGNED NOT NULL COMMENT 'session de formation',
  `debut` date NOT NULL COMMENT 'début du congé',
  `fin` date NOT NULL COMMENT 'fin du congé',
  `type` tinyint(1) NOT NULL COMMENT '1 = matin, 2 = après-midi, 3 = toute la journée',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `conges`
--

INSERT INTO `conges` (`id`, `session_id`, `debut`, `fin`, `type`) VALUES
(1, 123, '2019-05-31', '2019-05-31', 2),
(2, 123, '2019-12-27', '2019-12-27', 2),
(3, 123, '2019-07-06', '2019-08-25', 3),
(4, 123, '2019-06-19', '2019-06-19', 1),
(5, 123, '2019-05-02', '2019-05-02', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

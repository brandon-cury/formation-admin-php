-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 11 juin 2024 à 17:53
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `elearning`
--

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

DROP TABLE IF EXISTS `formations`;
CREATE TABLE IF NOT EXISTS `formations` (
  `id_formation` int NOT NULL AUTO_INCREMENT,
  `nom_formation` varchar(255) NOT NULL,
  `duree_formation` int NOT NULL,
  `nom_enseignant` varchar(255) NOT NULL,
  `nb_etudiants_max` int NOT NULL,
  `fichier_horaire_pdf` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_formation`)
) ;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id_formation`, `nom_formation`, `duree_formation`, `nom_enseignant`, `nb_etudiants_max`, `fichier_horaire_pdf`, `active`) VALUES
(1, 'Coiffure', 55, 'Pr. Dupont', 18, 'horaire1.pdf', 1),
(2, 'Programmation', 72, 'Pr. Dubois', 12, 'horaire2.pdf', 1),
(3, 'Esthétique', 90, 'Pr. Laurent', 15, 'horaire3.pdf', 0),
(4, 'CAP', 60, 'Pr. Mercier', 17, 'horaire4.pdf', 1),
(5, 'Géomètre', 85, 'Pr. Rousseau', 14, 'horaire5.pdf', 1),
(6, 'Droit', 45, 'Pr. Petit', 20, 'horaire6.pdf', 1),
(7, 'Secrétariat', 100, 'Pr. Lefebvre', 11, 'horaire7.pdf', 0),
(8, 'Communication', 68, 'Pr. Martin', 19, 'horaire8.pdf', 1),
(9, 'Marketing', 82, 'Pr. Durand', 13, 'horaire9.pdf', 1),
(10, 'Design', 48, 'Pr. Bernard', 16, 'horaire10.pdf', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

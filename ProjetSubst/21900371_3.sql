-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 09 juin 2021 à 01:54
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `21900371_3`
--

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

DROP TABLE IF EXISTS `club`;
CREATE TABLE IF NOT EXISTS `club` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sport` varchar(255) NOT NULL,
  `club` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `valide` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`club`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `club`
--

INSERT INTO `club` (`id`, `sport`, `club`, `twitter`, `site`, `image`, `valide`) VALUES
(6, 'test', 'test', 'test', 'test', '', NULL),
(20, 'Basketball', 'Golden State Warriors', 'warriors', 'GSW', 'upload/logogsw', 1),
(25, 'Football', 'LOSC', 'losclive', 'losc.fr', 'upload/2021_05_22_13_20_51.jpg', 1),
(30, 'Football', 'LOSC', 'losclive', 'losc.fr', 'upload/2021_05_22_13_20_51.jpg', 1),
(31, 'Football', 'LOSC', 'losclive', 'losc.fr', 'upload/2021_05_22_13_20_51.jpg', 1),
(32, 'Football', 'France', 'equipedefrance', 'fff.fr', 'upload/2021_06_08_17_34_03.jpg', 1),
(34, 'Test', 'Test', 'Test', 'Test', 'upload/2021_06_08_21_42_10.jpg', 1),
(35, 'Test', 'Test', 'Test', 'Test', 'upload/2021_06_08_21_43_11.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `nom` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`nom`, `login`, `pass`, `statut`) VALUES
('admin', 'admin', '$2y$10$2GpYEIMkTUJzsD0i7uTlle8EoOhv4wcNNNe9x9lXMOr8eAlg2MfK2', 'admin'),
('azer', 'azer', '$2y$10$h/dREnnRUn.BkjDhO7nuwudj5Q.k2/OtdVwHgdqhoNeew9nOsXcPe', 'admin'),
('Diallo', 'Diallo', '$2y$10$58NSotk5yOLI5GQJ0jGgau0ArDPsN/4rfMd8X9q19.evRz2Zkmiq6', 'admin'),
('DIALLO', 'djoulde', '$2y$10$YJVL.UMd3VjQ.mrK5Qp00eBQMsATcBBrU5ndUjwAGhIqn/OhNAoIS', 'admin'),
('test', 'test', '$2y$10$qoYoiPeQ3q.du68F9TSfBOKxZZlb84hQdLldWfmrAjoPIcmBsfgxm', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

DROP TABLE IF EXISTS `follow`;
CREATE TABLE IF NOT EXISTS `follow` (
  `user` varchar(255) NOT NULL,
  `club` int(11) NOT NULL,
  PRIMARY KEY (`user`,`club`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `follow`
--

INSERT INTO `follow` (`user`, `club`) VALUES
('azer', 1),
('azer', 2),
('azer', 3),
('test', 2),
('test', 5),
('test', 18),
('test', 20),
('test', 25),
('test', 30),
('test', 31),
('thomas', 5),
('Thomastest', 2),
('toto', 2),
('toto', 25);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

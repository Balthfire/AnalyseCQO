-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 10 Mai 2016 à 17:50
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `erdf`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartient`
--

DROP TABLE IF EXISTS `appartient`;
CREATE TABLE IF NOT EXISTS `appartient` (
  `NNI` char(6) NOT NULL,
  `id_Unite` int(11) NOT NULL,
  PRIMARY KEY (`NNI`,`id_Unite`),
  KEY `FK_Appartient_id_Unite` (`id_Unite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `champ`
--

DROP TABLE IF EXISTS `champ`;
CREATE TABLE IF NOT EXISTS `champ` (
  `id_Champ` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  `txtChamp` varchar(25) DEFAULT NULL,
  `numChamp` double DEFAULT NULL,
  `estNumerique` tinyint(1) DEFAULT NULL,
  `id_Ligne` int(11) DEFAULT NULL,
  `id_Champ_Modele` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Champ`),
  KEY `FK_Champ_id_Ligne` (`id_Ligne`),
  KEY `FK_Champ_id_Champ_Modele` (`id_Champ_Modele`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `changemet_statut`
--

DROP TABLE IF EXISTS `changemet_statut`;
CREATE TABLE IF NOT EXISTS `changemet_statut` (
  `Date_changement` date DEFAULT NULL,
  `id_Statut` int(11) NOT NULL,
  `NNI` char(6) NOT NULL,
  `id_Controle` int(11) NOT NULL,
  PRIMARY KEY (`id_Statut`,`NNI`,`id_Controle`),
  KEY `FK_Changemet_Statut_NNI` (`NNI`),
  KEY `FK_Changemet_Statut_id_Controle` (`id_Controle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `controle`
--

DROP TABLE IF EXISTS `controle`;
CREATE TABLE IF NOT EXISTS `controle` (
  `id_Controle` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(25) DEFAULT NULL,
  `description` varchar(25) DEFAULT NULL,
  `num_vague` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `note` double DEFAULT NULL,
  `Niveau_Qualite` int(11) DEFAULT NULL,
  `id_Type_Controle` int(11) DEFAULT NULL,
  `NNI` char(6) NOT NULL,
  `id_Modele_Controle` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Controle`),
  KEY `FK_Controle_id_Type_Controle` (`id_Type_Controle`),
  KEY `FK_Controle_NNI` (`NNI`),
  KEY `FK_Controle_id_Modele_Controle` (`id_Modele_Controle`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `controle`
--

INSERT INTO `controle` (`id_Controle`, `designation`, `description`, `num_vague`, `date_debut`, `date_fin`, `note`, `Niveau_Qualite`, `id_Type_Controle`, `NNI`, `id_Modele_Controle`) VALUES
(1, 'lalal', 'lalal', 1, '2016-03-08', '2016-03-23', 1, 1, 1, 'G09876', 2),
(2, 'lalaaaal', 'lalal', 1, '2016-03-08', '2016-03-23', 1, 1, 1, 'G09876', 2),
(3, 'lululu', 'lululu', 1, '1993-12-25', '1993-12-25', 5, 2, 1, 'G09876', 1);

-- --------------------------------------------------------

--
-- Structure de la table `donnee_indicateur`
--

DROP TABLE IF EXISTS `donnee_indicateur`;
CREATE TABLE IF NOT EXISTS `donnee_indicateur` (
  `id_Donnee` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) DEFAULT NULL,
  `valeur` double DEFAULT NULL,
  `Requete_Calcul` varchar(25) DEFAULT NULL,
  `id_Indicateur` int(11) DEFAULT NULL,
  `id_Modele_Donnees_Indicateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Donnee`),
  KEY `FK_Donnee_Indicateur_id_Indicateur` (`id_Indicateur`),
  KEY `FK_Donnee_Indicateur_id_Modele_Donnees_Indicateur` (`id_Modele_Donnees_Indicateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `indicateur`
--

DROP TABLE IF EXISTS `indicateur`;
CREATE TABLE IF NOT EXISTS `indicateur` (
  `id_Indicateur` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(25) DEFAULT NULL,
  `description` varchar(25) DEFAULT NULL,
  `id_Type_Indicateur` int(11) DEFAULT NULL,
  `id_Controle` int(11) DEFAULT NULL,
  `id_Modele_Indicateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Indicateur`),
  KEY `FK_Indicateur_id_Type_Indicateur` (`id_Type_Indicateur`),
  KEY `FK_Indicateur_id_Controle` (`id_Controle`),
  KEY `FK_Indicateur_id_Modele_Indicateur` (`id_Modele_Indicateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ligne`
--

DROP TABLE IF EXISTS `ligne`;
CREATE TABLE IF NOT EXISTS `ligne` (
  `id_Ligne` int(11) NOT NULL AUTO_INCREMENT,
  `id_Donnee` int(11) DEFAULT NULL,
  `id_Modele_Ligne` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Ligne`),
  KEY `FK_Ligne_id_Donnee` (`id_Donnee`),
  KEY `FK_Ligne_id_Modele_Ligne` (`id_Modele_Ligne`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `modele_champ`
--

DROP TABLE IF EXISTS `modele_champ`;
CREATE TABLE IF NOT EXISTS `modele_champ` (
  `id_Champ_Modele` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) DEFAULT NULL,
  `estNumerique` tinyint(1) DEFAULT NULL,
  `Description` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_Champ_Modele`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `modele_controle`
--

DROP TABLE IF EXISTS `modele_controle`;
CREATE TABLE IF NOT EXISTS `modele_controle` (
  `id_Modele_Controle` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(25) DEFAULT NULL,
  `description` varchar(25) DEFAULT NULL,
  `Coefficient_Importance` double DEFAULT NULL,
  PRIMARY KEY (`id_Modele_Controle`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `modele_controle`
--

INSERT INTO `modele_controle` (`id_Modele_Controle`, `designation`, `description`, `Coefficient_Importance`) VALUES
(1, 'abcd', 'chips', 1),
(2, 'abcd', 'chips', 1),
(3, 'sqfqfqdfq', 'chipssqdgsgsqdg', 8);

-- --------------------------------------------------------

--
-- Structure de la table `modele_donnees_indicateur`
--

DROP TABLE IF EXISTS `modele_donnees_indicateur`;
CREATE TABLE IF NOT EXISTS `modele_donnees_indicateur` (
  `id_Modele_Donnees_Indicateur` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(25) DEFAULT NULL,
  `valeur` double DEFAULT NULL,
  PRIMARY KEY (`id_Modele_Donnees_Indicateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `modele_indicateur`
--

DROP TABLE IF EXISTS `modele_indicateur`;
CREATE TABLE IF NOT EXISTS `modele_indicateur` (
  `id_Modele_Indicateur` int(11) NOT NULL AUTO_INCREMENT,
  `Designation` varchar(25) DEFAULT NULL,
  `decription` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_Modele_Indicateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `modele_ligne`
--

DROP TABLE IF EXISTS `modele_ligne`;
CREATE TABLE IF NOT EXISTS `modele_ligne` (
  `id_Modele_Ligne` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_Modele_Ligne`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

DROP TABLE IF EXISTS `statut`;
CREATE TABLE IF NOT EXISTS `statut` (
  `id_Statut` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_Statut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `structure_controle_indicateur`
--

DROP TABLE IF EXISTS `structure_controle_indicateur`;
CREATE TABLE IF NOT EXISTS `structure_controle_indicateur` (
  `id_Modele_Controle` int(11) NOT NULL,
  `id_Modele_Indicateur` int(11) NOT NULL,
  PRIMARY KEY (`id_Modele_Controle`,`id_Modele_Indicateur`),
  KEY `FK_Structure_Controle_Indicateur_id_Modele_Indicateur` (`id_Modele_Indicateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `structure_donnee_ligne`
--

DROP TABLE IF EXISTS `structure_donnee_ligne`;
CREATE TABLE IF NOT EXISTS `structure_donnee_ligne` (
  `id_Modele_Donnees_Indicateur` int(11) NOT NULL,
  `id_Modele_Ligne` int(11) NOT NULL,
  PRIMARY KEY (`id_Modele_Donnees_Indicateur`,`id_Modele_Ligne`),
  KEY `FK_Structure_Donnee_Ligne_id_Modele_Ligne` (`id_Modele_Ligne`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `structure_indicateur_donnee`
--

DROP TABLE IF EXISTS `structure_indicateur_donnee`;
CREATE TABLE IF NOT EXISTS `structure_indicateur_donnee` (
  `id_Modele_Indicateur` int(11) NOT NULL,
  `id_Modele_Donnees_Indicateur` int(11) NOT NULL,
  PRIMARY KEY (`id_Modele_Indicateur`,`id_Modele_Donnees_Indicateur`),
  KEY `FK_Structure_Indicateur_Donnee_id_Modele_Donnees_Indicateur` (`id_Modele_Donnees_Indicateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `structure_ligne_champ`
--

DROP TABLE IF EXISTS `structure_ligne_champ`;
CREATE TABLE IF NOT EXISTS `structure_ligne_champ` (
  `id_Modele_Ligne` int(11) NOT NULL,
  `id_Champ_Modele` int(11) NOT NULL,
  PRIMARY KEY (`id_Modele_Ligne`,`id_Champ_Modele`),
  KEY `FK_Structure_Ligne_Champ_id_Champ_Modele` (`id_Champ_Modele`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type_controle`
--

DROP TABLE IF EXISTS `type_controle`;
CREATE TABLE IF NOT EXISTS `type_controle` (
  `id_Type_Controle` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_Type_Controle`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `type_controle`
--

INSERT INTO `type_controle` (`id_Type_Controle`, `libelle`) VALUES
(1, 'TypeControle001');

-- --------------------------------------------------------

--
-- Structure de la table `type_indicateur`
--

DROP TABLE IF EXISTS `type_indicateur`;
CREATE TABLE IF NOT EXISTS `type_indicateur` (
  `id_Type_Indicateur` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_Type_Indicateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type_user`
--

DROP TABLE IF EXISTS `type_user`;
CREATE TABLE IF NOT EXISTS `type_user` (
  `id_Type_User` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_Type_User`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `unite`
--

DROP TABLE IF EXISTS `unite`;
CREATE TABLE IF NOT EXISTS `unite` (
  `id_Unite` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_Unite`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `NNI` char(6) NOT NULL,
  `Nom` varchar(25) DEFAULT NULL,
  `Prenom` varchar(25) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL,
  `id_Type_User` int(11) DEFAULT NULL,
  PRIMARY KEY (`NNI`),
  KEY `FK_Utilisateur_id_Type_User` (`id_Type_User`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`NNI`, `Nom`, `Prenom`, `password`, `id_Type_User`) VALUES
('G09876', 'Couturier', 'Aurelien', '1234', NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `appartient`
--
ALTER TABLE `appartient`
  ADD CONSTRAINT `FK_Appartient_NNI` FOREIGN KEY (`NNI`) REFERENCES `utilisateur` (`NNI`),
  ADD CONSTRAINT `FK_Appartient_id_Unite` FOREIGN KEY (`id_Unite`) REFERENCES `unite` (`id_Unite`);

--
-- Contraintes pour la table `champ`
--
ALTER TABLE `champ`
  ADD CONSTRAINT `FK_Champ_id_Champ_Modele` FOREIGN KEY (`id_Champ_Modele`) REFERENCES `modele_champ` (`id_Champ_Modele`),
  ADD CONSTRAINT `FK_Champ_id_Ligne` FOREIGN KEY (`id_Ligne`) REFERENCES `ligne` (`id_Ligne`);

--
-- Contraintes pour la table `changemet_statut`
--
ALTER TABLE `changemet_statut`
  ADD CONSTRAINT `FK_Changemet_Statut_NNI` FOREIGN KEY (`NNI`) REFERENCES `utilisateur` (`NNI`),
  ADD CONSTRAINT `FK_Changemet_Statut_id_Controle` FOREIGN KEY (`id_Controle`) REFERENCES `controle` (`id_Controle`),
  ADD CONSTRAINT `FK_Changemet_Statut_id_Statut` FOREIGN KEY (`id_Statut`) REFERENCES `statut` (`id_Statut`);

--
-- Contraintes pour la table `controle`
--
ALTER TABLE `controle`
  ADD CONSTRAINT `FK_Controle_NNI` FOREIGN KEY (`NNI`) REFERENCES `utilisateur` (`NNI`),
  ADD CONSTRAINT `FK_Controle_id_Modele_Controle` FOREIGN KEY (`id_Modele_Controle`) REFERENCES `modele_controle` (`id_Modele_Controle`),
  ADD CONSTRAINT `FK_Controle_id_Type_Controle` FOREIGN KEY (`id_Type_Controle`) REFERENCES `type_controle` (`id_Type_Controle`);

--
-- Contraintes pour la table `donnee_indicateur`
--
ALTER TABLE `donnee_indicateur`
  ADD CONSTRAINT `FK_Donnee_Indicateur_id_Indicateur` FOREIGN KEY (`id_Indicateur`) REFERENCES `indicateur` (`id_Indicateur`),
  ADD CONSTRAINT `FK_Donnee_Indicateur_id_Modele_Donnees_Indicateur` FOREIGN KEY (`id_Modele_Donnees_Indicateur`) REFERENCES `modele_donnees_indicateur` (`id_Modele_Donnees_Indicateur`);

--
-- Contraintes pour la table `indicateur`
--
ALTER TABLE `indicateur`
  ADD CONSTRAINT `FK_Indicateur_id_Controle` FOREIGN KEY (`id_Controle`) REFERENCES `controle` (`id_Controle`),
  ADD CONSTRAINT `FK_Indicateur_id_Modele_Indicateur` FOREIGN KEY (`id_Modele_Indicateur`) REFERENCES `modele_indicateur` (`id_Modele_Indicateur`),
  ADD CONSTRAINT `FK_Indicateur_id_Type_Indicateur` FOREIGN KEY (`id_Type_Indicateur`) REFERENCES `type_indicateur` (`id_Type_Indicateur`);

--
-- Contraintes pour la table `ligne`
--
ALTER TABLE `ligne`
  ADD CONSTRAINT `FK_Ligne_id_Donnee` FOREIGN KEY (`id_Donnee`) REFERENCES `donnee_indicateur` (`id_Donnee`),
  ADD CONSTRAINT `FK_Ligne_id_Modele_Ligne` FOREIGN KEY (`id_Modele_Ligne`) REFERENCES `modele_ligne` (`id_Modele_Ligne`);

--
-- Contraintes pour la table `structure_controle_indicateur`
--
ALTER TABLE `structure_controle_indicateur`
  ADD CONSTRAINT `FK_Structure_Controle_Indicateur_id_Modele_Controle` FOREIGN KEY (`id_Modele_Controle`) REFERENCES `modele_controle` (`id_Modele_Controle`),
  ADD CONSTRAINT `FK_Structure_Controle_Indicateur_id_Modele_Indicateur` FOREIGN KEY (`id_Modele_Indicateur`) REFERENCES `modele_indicateur` (`id_Modele_Indicateur`);

--
-- Contraintes pour la table `structure_donnee_ligne`
--
ALTER TABLE `structure_donnee_ligne`
  ADD CONSTRAINT `FK_Structure_Donnee_Ligne_id_Modele_Donnees_Indicateur` FOREIGN KEY (`id_Modele_Donnees_Indicateur`) REFERENCES `modele_donnees_indicateur` (`id_Modele_Donnees_Indicateur`),
  ADD CONSTRAINT `FK_Structure_Donnee_Ligne_id_Modele_Ligne` FOREIGN KEY (`id_Modele_Ligne`) REFERENCES `modele_ligne` (`id_Modele_Ligne`);

--
-- Contraintes pour la table `structure_indicateur_donnee`
--
ALTER TABLE `structure_indicateur_donnee`
  ADD CONSTRAINT `FK_Structure_Indicateur_Donnee_id_Modele_Donnees_Indicateur` FOREIGN KEY (`id_Modele_Donnees_Indicateur`) REFERENCES `modele_donnees_indicateur` (`id_Modele_Donnees_Indicateur`),
  ADD CONSTRAINT `FK_Structure_Indicateur_Donnee_id_Modele_Indicateur` FOREIGN KEY (`id_Modele_Indicateur`) REFERENCES `modele_indicateur` (`id_Modele_Indicateur`);

--
-- Contraintes pour la table `structure_ligne_champ`
--
ALTER TABLE `structure_ligne_champ`
  ADD CONSTRAINT `FK_Structure_Ligne_Champ_id_Champ_Modele` FOREIGN KEY (`id_Champ_Modele`) REFERENCES `modele_champ` (`id_Champ_Modele`),
  ADD CONSTRAINT `FK_Structure_Ligne_Champ_id_Modele_Ligne` FOREIGN KEY (`id_Modele_Ligne`) REFERENCES `modele_ligne` (`id_Modele_Ligne`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_Utilisateur_id_Type_User` FOREIGN KEY (`id_Type_User`) REFERENCES `type_user` (`id_Type_User`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1:3306
-- Généré le :  Mar 05 Décembre 2017 à 12:36
-- Version du serveur :  5.5.24
-- Version de PHP :  5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bd_garage`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie_employe`
--

CREATE TABLE `categorie_employe` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `categorie_employe`
--

INSERT INTO `categorie_employe` (`cat_id`, `cat_name`) VALUES
(1, 'agent'),
(2, 'mecanicien'),
(3, 'directeur');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `client_firstname` varchar(25) COLLATE utf8_bin NOT NULL,
  `client_lastname` varchar(25) COLLATE utf8_bin NOT NULL,
  `client_address` varchar(50) COLLATE utf8_bin NOT NULL,
  `client_phonenum` varchar(10) COLLATE utf8_bin NOT NULL,
  `client_mail` varchar(30) COLLATE utf8_bin NOT NULL,
  `client_birthday` date NOT NULL,
  `client_maxdiff` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`client_id`, `client_firstname`, `client_lastname`, `client_address`, `client_phonenum`, `client_mail`, `client_birthday`, `client_maxdiff`) VALUES
(1, 'Jean-Pierre', 'Pernaut', '6 rue des tulipes', '0612121212', 'jpp@mail.com', '1950-04-08', 300),
(2, 'Vincent', 'Lagaf', '12 rue des carottes', '0983736337', 'bolelavabo@mail.com', '1959-10-30', 1000),
(3, 'Bob', 'Marley', '12000 route du Zion', '0392819232', 'vivelestulipes@mail.com', '1945-02-06', 500),
(4, 'Vincent', 'Lagaf', '12 rue des carottes', '0983736337', 'bolelavabo@mail.com', '1959-10-02', 1000),
(16, 'Bob', 'Marley', '12000 route du Zion', '0392819232', 'vivelestulipes@mail.com', '1945-02-06', 500),
(17, 'Bob', 'Marley', '12000 route du Zion', '0392819232', 'vivelestulipes@mail.com', '1945-02-06', 500),
(18, 'Bob', 'Marley', '12000 route du Zion', '0392819232', 'vivelestulipes@mail.com', '1945-02-06', 500),
(19, 'Bob', 'Marley', '12000 route du Zion', '0392819232', 'vivelestulipes@mail.com', '1945-02-06', 500),
(20, 'Bob', 'Marley', '12000 route du Zion', '0392819232', 'vivelestulipes@mail.com', '1945-02-06', 500);

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `empl_id` int(11) NOT NULL,
  `empl_identifiant` varchar(20) COLLATE utf8_bin NOT NULL,
  `empl_password` varchar(20) COLLATE utf8_bin NOT NULL,
  `empl_catid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `employe`
--

INSERT INTO `employe` (`empl_id`, `empl_identifiant`, `empl_password`, `empl_catid`) VALUES
(1, 'agent', 'douze', 1),
(2, 'mecanicien', 'douze', 2),
(3, 'directeur', 'douze', 3);

-- --------------------------------------------------------

--
-- Structure de la table `etat_facture`
--

CREATE TABLE `etat_facture` (
  `etat_facture_char` varchar(2) COLLATE utf8_bin NOT NULL,
  `etat_facture_value` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `etat_facture`
--

INSERT INTO `etat_facture` (`etat_facture_char`, `etat_facture_value`) VALUES
('AP', 'attente de paiement'),
('DF', 'en différé'),
('P', 'payé');

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE `intervention` (
  `interv_id` int(11) NOT NULL,
  `interv_client` int(11) NOT NULL,
  `interv_typeid` int(11) NOT NULL,
  `interv_mecanicien` int(11) NOT NULL,
  `interv_etatfacture` varchar(2) COLLATE utf8_bin NOT NULL DEFAULT 'AP',
  `interv_tarif` float NOT NULL,
  `interv_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `intervention`
--

INSERT INTO `intervention` (`interv_id`, `interv_client`, `interv_typeid`, `interv_mecanicien`, `interv_etatfacture`, `interv_tarif`, `interv_date`) VALUES
(5, 1, 3, 2, 'AP', 160, '2017-07-06'),
(6, 1, 1, 2, 'P', 50, '2017-09-21'),
(7, 1, 4, 2, 'DF', 250, '2017-11-03'),
(8, 1, 5, 2, 'P', 400, '2017-04-19');

-- --------------------------------------------------------

--
-- Structure de la table `type_intervention`
--

CREATE TABLE `type_intervention` (
  `typeinterv_id` int(11) NOT NULL,
  `typeinterv_nom` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `type_intervention`
--

INSERT INTO `type_intervention` (`typeinterv_id`, `typeinterv_nom`) VALUES
(1, 'vidange'),
(2, 'courroie de distribution'),
(3, 'plaquettes'),
(4, 'parallélisme'),
(5, 'changement embrayage');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie_employe`
--
ALTER TABLE `categorie_employe`
  ADD PRIMARY KEY (`cat_id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`empl_id`),
  ADD KEY `FK_CAT_EMPL` (`empl_catid`);

--
-- Index pour la table `etat_facture`
--
ALTER TABLE `etat_facture`
  ADD UNIQUE KEY `etat_facture_char` (`etat_facture_char`);

--
-- Index pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD PRIMARY KEY (`interv_id`),
  ADD KEY `interv_client` (`interv_client`),
  ADD KEY `interv_etatfacture` (`interv_etatfacture`),
  ADD KEY `interv_typeid` (`interv_typeid`),
  ADD KEY `interv_mecanicien` (`interv_mecanicien`);

--
-- Index pour la table `type_intervention`
--
ALTER TABLE `type_intervention`
  ADD PRIMARY KEY (`typeinterv_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie_employe`
--
ALTER TABLE `categorie_employe`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `empl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `intervention`
--
ALTER TABLE `intervention`
  MODIFY `interv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `type_intervention`
--
ALTER TABLE `type_intervention`
  MODIFY `typeinterv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `FK_EMPL_CAT` FOREIGN KEY (`empl_catid`) REFERENCES `categorie_employe` (`cat_id`);

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `FK_INTER_CLIENT` FOREIGN KEY (`interv_client`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `FK_INTER_ETAT_FACT` FOREIGN KEY (`interv_etatfacture`) REFERENCES `etat_facture` (`etat_facture_char`),
  ADD CONSTRAINT `FK_INTER_MECANICIEN` FOREIGN KEY (`interv_mecanicien`) REFERENCES `employe` (`empl_id`),
  ADD CONSTRAINT `FK_INTER_TYPE_ID` FOREIGN KEY (`interv_typeid`) REFERENCES `type_intervention` (`typeinterv_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

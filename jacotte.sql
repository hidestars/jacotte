-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Jeu 04 Mai 2017 à 14:55
-- Version du serveur :  5.6.35
-- Version de PHP :  7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `jacotte`
--

-- --------------------------------------------------------

--
-- Structure de la table `boisson`
--

CREATE TABLE `boisson` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` text NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `prix` float NOT NULL,
  `qte` int(11) NOT NULL,
  `image` text NOT NULL,
  `allergenes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `boisson`
--

INSERT INTO `boisson` (`id`, `nom`, `type`, `description`, `prix`, `qte`, `image`, `allergenes`) VALUES
(0, 'aucun', 'aucun', 'aucun', 0, -1, 'aucun', 'aucun');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ville` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `newsletter` varchar(255) NOT NULL,
  `dateLivraison` varchar(255) NOT NULL,
  `prixTotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commandemenu`
--

CREATE TABLE `commandemenu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idMenu` int(11) NOT NULL,
  `idCommande` int(11) NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dessert`
--

CREATE TABLE `dessert` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` text NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `prix` float NOT NULL,
  `qte` int(11) NOT NULL,
  `image` text NOT NULL,
  `allergenes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `dessert`
--

INSERT INTO `dessert` (`id`, `nom`, `type`, `description`, `prix`, `qte`, `image`, `allergenes`) VALUES
(0, 'aucun', 'aucun', 'aucun', 0, -1, 'aucun', 'aucun');

-- --------------------------------------------------------

--
-- Structure de la table `entree`
--

CREATE TABLE `entree` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` text NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `prix` float NOT NULL,
  `qte` int(11) NOT NULL,
  `image` text NOT NULL,
  `allergenes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `entree`
--

INSERT INTO `entree` (`id`, `nom`, `type`, `description`, `prix`, `qte`, `image`, `allergenes`) VALUES
(1, 'aucun', 'aucun', 'aucun', 0, -1, 'aucun', 'aucun');

-- --------------------------------------------------------

--
-- Structure de la table `fromage`
--

CREATE TABLE `fromage` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` text NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `prix` float NOT NULL,
  `qte` int(11) NOT NULL,
  `image` text NOT NULL,
  `allergenes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fromage`
--

INSERT INTO `fromage` (`id`, `nom`, `type`, `description`, `prix`, `qte`, `image`, `allergenes`) VALUES
(0, 'aucun', 'aucun', 'aucun', 0, -1, 'aucun', 'aucun');

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` text NOT NULL,
  `description` text,
  `prix` float NOT NULL,
  `allergenes` text,
  `type` text,
  `image` text NOT NULL,
  `idEntree` int(11) DEFAULT NULL,
  `idPlat` int(11) DEFAULT NULL,
  `idDessert` int(11) DEFAULT NULL,
  `idFromage` int(11) DEFAULT NULL,
  `idBoisson` int(11) DEFAULT NULL,
  `perso` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `plat`
--

CREATE TABLE `plat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` text NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `prix` float NOT NULL,
  `qte` int(11) NOT NULL,
  `image` text NOT NULL,
  `allergenes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `plat`
--

INSERT INTO `plat` (`id`, `nom`, `type`, `description`, `prix`, `qte`, `image`, `allergenes`) VALUES
(0, 'aucun', 'aucun', 'aucun', 0, -1, 'aucun', 'aucun');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `boisson`
--
ALTER TABLE `boisson`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `commandemenu`
--
ALTER TABLE `commandemenu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `dessert`
--
ALTER TABLE `dessert`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `entree`
--
ALTER TABLE `entree`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `fromage`
--
ALTER TABLE `fromage`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `plat`
--
ALTER TABLE `plat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `commandemenu`
--
ALTER TABLE `commandemenu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `entree`
--
ALTER TABLE `entree`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
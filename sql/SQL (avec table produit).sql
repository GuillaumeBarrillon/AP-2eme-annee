-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 12 oct. 2023 à 13:54
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ap3`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `ID_Commande` int(11) NOT NULL,
  `Date_heure` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Total_TTC` decimal(10,0) NOT NULL,
  `Type_de_commande` varchar(50) NOT NULL,
  `TVA` decimal(10,0) NOT NULL,
  `Etat` int(11) NOT NULL,
  `ID_Etat` int(11) NOT NULL,
  `ID_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE `etat` (
  `ID_Etat` int(11) NOT NULL,
  `Libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_de_commande`
--

CREATE TABLE `ligne_de_commande` (
  `ID_LigneCommande` int(11) NOT NULL,
  `Quantite` int(11) NOT NULL,
  `Total_HT` decimal(10,0) NOT NULL,
  `ID_Produit` int(11) NOT NULL,
  `ID_Commande` int(11) NOT NULL,
  `ID_Produit_Reference` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `ID_Produit` int(11) NOT NULL,
  `Libelle` varchar(50) NOT NULL,
  `Prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`ID_Produit`, `Libelle`, `Prix`) VALUES
(1, 'Pizza Bosca                                       ', 17),
(2, 'Pizza Full Formaggi', 15),
(3, 'Pizza Basta Cosi', 14),
(4, 'Katsu viande et aubergines', 17),
(5, 'Katsu poisson et aubergines', 13),
(6, 'Coxinhas boeuf', 8),
(7, 'Coxinhas vegan', 8),
(8, 'Coxinhas fromage', 8);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `ID_utilisateur` int(11) NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Mot_de_passe` varchar(250) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`ID_Commande`),
  ADD UNIQUE KEY `Commande_AK` (`Etat`),
  ADD KEY `Commande_Etat_FK` (`ID_Etat`),
  ADD KEY `Commande_Utilisateur0_FK` (`ID_utilisateur`);

--
-- Index pour la table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`ID_Etat`);

--
-- Index pour la table `ligne_de_commande`
--
ALTER TABLE `ligne_de_commande`
  ADD PRIMARY KEY (`ID_LigneCommande`),
  ADD UNIQUE KEY `Ligne_de_commande_AK` (`ID_Produit`),
  ADD KEY `Ligne_de_commande_Commande_FK` (`ID_Commande`),
  ADD KEY `Ligne_de_commande_Produit0_FK` (`ID_Produit_Reference`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`ID_Produit`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`ID_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `ID_Commande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `etat`
--
ALTER TABLE `etat`
  MODIFY `ID_Etat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_de_commande`
--
ALTER TABLE `ligne_de_commande`
  MODIFY `ID_LigneCommande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `ID_Produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `ID_utilisateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `Commande_Etat_FK` FOREIGN KEY (`ID_Etat`) REFERENCES `etat` (`ID_Etat`),
  ADD CONSTRAINT `Commande_Utilisateur0_FK` FOREIGN KEY (`ID_utilisateur`) REFERENCES `utilisateur` (`ID_utilisateur`);

--
-- Contraintes pour la table `ligne_de_commande`
--
ALTER TABLE `ligne_de_commande`
  ADD CONSTRAINT `Ligne_de_commande_Commande_FK` FOREIGN KEY (`ID_Commande`) REFERENCES `commande` (`ID_Commande`),
  ADD CONSTRAINT `Ligne_de_commande_Produit0_FK` FOREIGN KEY (`ID_Produit_Reference`) REFERENCES `produit` (`ID_Produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

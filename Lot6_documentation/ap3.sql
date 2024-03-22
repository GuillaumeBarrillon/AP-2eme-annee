-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 14, 2023 at 03:38 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ap3`
--

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_etat` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_commande` decimal(10,2) NOT NULL DEFAULT '0.00',
  `type_conso` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_user`, `id_etat`, `date`, `total_commande`, `type_conso`) VALUES
(1, 3, 0, '2023-11-16 14:17:31', '25.30', 2),
(2, 4, 0, '2023-11-30 20:01:56', '19.80', 2),
(3, 4, 0, '2023-11-30 20:02:08', '4.40', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ligne`
--

CREATE TABLE `ligne` (
  `id_ligne` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `qte` int(11) NOT NULL DEFAULT '0',
  `total_ligne_ht` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ligne`
--

INSERT INTO `ligne` (`id_ligne`, `id_commande`, `id_produit`, `qte`, `total_ligne_ht`) VALUES
(1, 1, 1, 1, '2.00'),
(2, 1, 2, 2, '10.00'),
(3, 1, 3, 1, '3.00'),
(4, 1, 4, 2, '8.00'),
(5, 2, 1, 3, '6.00'),
(6, 2, 3, 4, '12.00'),
(7, 3, 1, 2, '4.00');

--
-- Triggers `ligne`
--
DELIMITER $$
CREATE TRIGGER `after_ligne_insert` AFTER INSERT ON `ligne` FOR EACH ROW BEGIN
    set @total_commande = 0;
    set @type_conso = 0;
    set @tva = 0;
    -- Lit la commande
    SELECT type_conso INTO @type_conso FROM commande where commande.id_commande = NEW.id_commande;
    -- Détermine le taux de TVA
    IF @type_conso=1 THEN SET @tva=1.055; END IF;
    IF @type_conso=2 THEN SET @tva=1.1; END IF;
    -- Calcule le total HT des lignes de la commande
    SELECT sum(total_ligne_ht) INTO @total_commande FROM ligne WHERE ligne.id_commande = NEW.id_commande;
    -- Calcule le total TTC
    SET @total_commande=@total_commande*@tva;
    --  Met à jour le total commande 
    UPDATE commande SET total_commande=@total_commande where commande.id_commande = NEW.id_commande;
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_ligne_update` AFTER UPDATE ON `ligne` FOR EACH ROW BEGIN
    set @total_commande = 0;
    set @type_conso = 0;
    set @tva = 0;
    -- Lit la commande
    SELECT type_conso INTO @type_conso FROM commande where commande.id_commande = NEW.id_commande;
    -- Détermine le taux de TVA
    IF @type_conso=1 THEN SET @tva=1.055; END IF;
    IF @type_conso=2 THEN SET @tva=1.1; END IF;
    -- Calcule le total HT des lignes de la commande
    SELECT sum(total_ligne_ht) INTO @total_commande FROM ligne WHERE ligne.id_commande = NEW.id_commande;
    -- Calcule le total TTC
    SET @total_commande=@total_commande*@tva;
    --  Met à jour le total commande 
    UPDATE commande SET total_commande=@total_commande where commande.id_commande = NEW.id_commande;
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_ligne_insert` BEFORE INSERT ON `ligne` FOR EACH ROW BEGIN
    set @prix_ht = 0;
    -- Lit le prix du produit
    SELECT prix_ht INTO @prix_ht FROM produit WHERE produit.id_produit = NEW.id_produit; 
    --  Calcule le total ligne 
    SET NEW.total_ligne_ht = @prix_ht * NEW.qte;
  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_ligne_update` BEFORE UPDATE ON `ligne` FOR EACH ROW BEGIN
    set @prix_ht = 0;
    -- Lit le prix du produit
    SELECT prix_ht INTO @prix_ht FROM produit WHERE produit.id_produit = NEW.id_produit; 
    --  Calcule le total ligne 
    SET NEW.total_ligne_ht = @prix_ht * NEW.qte;
  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `prix_ht` decimal(10,2) NOT NULL,
  `Image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `libelle`, `prix_ht`, `Image`) VALUES
(1, 'Pâtes', '2.00', 'pates.jpg'),
(2, 'Pizza', '5.00', 'pizza.jpg'),
(3, 'Salade cesar', '3.00', 'salade_cesar.jpg'),
(4, 'Colombo de Poisson', '4.00', 'colombo_de_poisson.jpg'),
(5, 'Riz', '2.00', 'riz.jpg'),
(6, 'Burger', '17.00', 'burger.jpg'),
(7, 'Filet Mignon', '8.00', 'filet_mignon.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `login`, `password`, `email`) VALUES
(3, 'bob', '$2y$10$54cbwFEJBEhomqMeayt6mOVc4Mj4bWvD6ATJ.ex5oYNSJWWbm5Fs2', 'bob@bob.bob'),
(4, 'test', '$2y$10$.87oyHdNDqORwjqgb2DXf.ORsjXWI2MCf7nO99BZwOBsoryUxbjZG', 'test@test.test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_etat` (`id_etat`);

--
-- Indexes for table `ligne`
--
ALTER TABLE `ligne`
  ADD PRIMARY KEY (`id_ligne`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ligne`
--
ALTER TABLE `ligne`
  MODIFY `id_ligne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `ligne`
--
ALTER TABLE `ligne`
  ADD CONSTRAINT `ligne_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`),
  ADD CONSTRAINT `ligne_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

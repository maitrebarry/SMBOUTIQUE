-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 14 fév. 2025 à 00:42
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_supermarche`
--

-- --------------------------------------------------------

--
-- Structure de la table `boutique`
--

CREATE TABLE `boutique` (
  `id_boutique` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `quartier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `boutique`
--

INSERT INTO `boutique` (`id_boutique`, `nom`, `quartier`) VALUES
(1, 'S M Boutique', 'Sebougou');

-- --------------------------------------------------------

--
-- Structure de la table `caisse`
--

CREATE TABLE `caisse` (
  `id_caisse` int(11) NOT NULL,
  `date_caisse` date DEFAULT NULL,
  `montant_initial` int(255) DEFAULT NULL,
  `statut` varchar(100) DEFAULT 'on',
  `reference_caisse` varchar(100) NOT NULL,
  `Montant_total_caisse` int(255) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `caisse`
--

INSERT INTO `caisse` (`id_caisse`, `date_caisse`, `montant_initial`, `statut`, `reference_caisse`, `Montant_total_caisse`) VALUES
(1, '2025-02-11', 500, 'on', 'CAISSE-02-2025-N°1', 17300);

-- --------------------------------------------------------

--
-- Structure de la table `client_grossiste`
--

CREATE TABLE `client_grossiste` (
  `id_client_gr` int(11) NOT NULL,
  `nom_client_grossiste` varbinary(100) NOT NULL,
  `prenom_du_client_grossiste` varchar(100) NOT NULL,
  `ville_client_grossiste` varchar(100) NOT NULL,
  `contact_client_grossiste` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client_grossiste`
--

INSERT INTO `client_grossiste` (`id_client_gr`, `nom_client_grossiste`, `prenom_du_client_grossiste`, `ville_client_grossiste`, `contact_client_grossiste`) VALUES
(1, 0x424148, 'Moussa', 'segou', '89765432'),
(2, 0x4449414c4c4f, 'Adam', 'sebougou', 'lafia'),
(3, 0x4241525259, 'Moustapha', 'segou', '74745669'),
(4, 0x4241525259, 'Moustapha', 'segou', '74745669'),
(5, 0x4241525259, 'Moustapha', 'segou', '74745669'),
(6, 0x4241525259, 'Moustapha', 'segou', '74745669');

-- --------------------------------------------------------

--
-- Structure de la table `commande_client`
--

CREATE TABLE `commande_client` (
  `id_cmd_client` int(11) NOT NULL,
  `id_client_gr` int(11) NOT NULL,
  `date_cmd_client` datetime NOT NULL,
  `reference` varchar(255) NOT NULL,
  `total` int(100) NOT NULL,
  `paie` int(11) DEFAULT 0,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande_client`
--

INSERT INTO `commande_client` (`id_cmd_client`, `id_client_gr`, `date_cmd_client`, `reference`, `total`, `paie`, `id_utilisateur`) VALUES
(1, 2, '2025-02-11 09:27:00', 'CCC1102202501', 500, 0, 1),
(2, 1, '2025-02-11 09:39:00', 'CCC1102202502', 500, 0, 1),
(3, 3, '2025-02-11 09:47:00', 'CCC1102202503', 50000, 0, 1),
(4, 4, '2025-02-11 09:52:00', 'CCC1102202504', 900, 0, 1),
(5, 5, '2025-02-11 09:52:00', 'CCC1102202504', 900, 0, 1),
(6, 5, '2025-02-11 10:55:00', 'CCC1102202506', 500, 0, 1),
(7, 6, '2025-02-11 15:24:00', 'CCC1102202507', 500, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `commande_fournisseur`
--

CREATE TABLE `commande_fournisseur` (
  `id_commande_fournisseur` int(11) NOT NULL,
  `id_fournisseur` int(11) NOT NULL,
  `date_de_commande` datetime NOT NULL,
  `reference` varchar(255) NOT NULL,
  `total` int(255) DEFAULT NULL,
  `paie` int(11) NOT NULL DEFAULT 0,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande_fournisseur`
--

INSERT INTO `commande_fournisseur` (`id_commande_fournisseur`, `id_fournisseur`, `date_de_commande`, `reference`, `total`, `paie`, `id_utilisateur`) VALUES
(1, 1, '2025-02-11 08:01:00', 'CCF1102202504', 800, 0, 1),
(2, 2, '2025-02-11 08:02:00', 'CCF1102202502', 125, 0, 1),
(3, 2, '2025-02-11 15:15:00', 'CCF1102202503', 5000, 5000, 1),
(4, 1, '2025-02-13 22:36:00', 'CCF1302202504', 400, 0, 1),
(5, 4, '2025-02-13 23:11:00', 'CCF1302202505', 4800, 0, 1),
(6, 3, '2025-02-13 22:43:00', 'CCF1302202506', 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `depense`
--

CREATE TABLE `depense` (
  `id_depense` int(11) NOT NULL,
  `reference_caisse` varchar(100) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `montant` int(100) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

CREATE TABLE `fournisseur` (
  `id_fournisseur` int(11) NOT NULL,
  `prenom_fournisseur` varchar(30) DEFAULT NULL,
  `nom_fournisseur` varchar(30) DEFAULT NULL,
  `contact_fournisseur` int(15) DEFAULT NULL,
  `ville_fournisseur` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id_fournisseur`, `prenom_fournisseur`, `nom_fournisseur`, `contact_fournisseur`, `ville_fournisseur`) VALUES
(1, 'ibrahima', 'Diakite', 74411001, 'Segou'),
(2, 'Saliamatou', 'Sow', 89764567, 'segou'),
(3, 'Fatoumata', 'Tangara', 91156734, 'segou'),
(4, 'Moustapha', 'BARRY', 74745669, 'segou');

-- --------------------------------------------------------

--
-- Structure de la table `inventaire`
--

CREATE TABLE `inventaire` (
  `id_inventaire` int(11) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `date_inventaire` datetime NOT NULL,
  `boutique` varchar(100) DEFAULT NULL,
  `reference_inventaire` varchar(100) NOT NULL,
  `regulariser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inventaire`
--

INSERT INTO `inventaire` (`id_inventaire`, `id_utilisateur`, `date_inventaire`, `boutique`, `reference_inventaire`, `regulariser`) VALUES
(1, 1, '2025-02-05 21:59:00', '', 'R-IV-N°01', 'non'),
(2, 1, '2025-02-05 22:04:00', NULL, 'R-IV-N°02', 'oui'),
(3, 1, '2025-02-06 10:41:00', NULL, 'R-IV-N°03', 'oui');

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `id_ligne` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `id_commande_fournisseur` int(11) DEFAULT NULL,
  `quantite` int(255) DEFAULT NULL,
  `qte_livre` int(11) NOT NULL DEFAULT 0,
  `new_price_cmndFour` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id_ligne`, `id`, `id_commande_fournisseur`, `quantite`, `qte_livre`, `new_price_cmndFour`) VALUES
(1, 7, 3, 10, 10, 500),
(2, 5, 4, 1, 0, NULL),
(3, 7, 5, 1, 0, NULL),
(4, 21, 5, 1, 0, NULL),
(5, 37, 5, 1, 0, NULL),
(6, 33, 6, 1, 0, NULL),
(7, 34, 6, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande_client`
--

CREATE TABLE `ligne_commande_client` (
  `id_ligne_cl` int(11) NOT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `id_cmd_client` int(11) DEFAULT NULL,
  `quantite` int(50) DEFAULT NULL,
  `qte_livre` int(11) NOT NULL DEFAULT 0,
  `new_price_cmndClient` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ligne_commande_client`
--

INSERT INTO `ligne_commande_client` (`id_ligne_cl`, `id_produit`, `id_cmd_client`, `quantite`, `qte_livre`, `new_price_cmndClient`) VALUES
(1, 7, 1, 1, 0, NULL),
(2, 7, 2, 1, 0, NULL),
(3, 30, 3, 1, 0, NULL),
(4, 10, 5, 1, 0, NULL),
(5, 15, 5, 1, 0, NULL),
(6, 7, 6, 1, 0, NULL),
(7, 6, 7, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_inventaire`
--

CREATE TABLE `ligne_inventaire` (
  `id_ligne_inventaire` int(11) NOT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `id_inventaire` int(11) NOT NULL,
  `quantite_physique` int(255) NOT NULL,
  `ecart_stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ligne_inventaire`
--

INSERT INTO `ligne_inventaire` (`id_ligne_inventaire`, `id_produit`, `id_inventaire`, `quantite_physique`, `ecart_stock`) VALUES
(1, 5, 1, 100, 100),
(2, 4, 1, 100, 100),
(3, 3, 1, 100, 100),
(4, 35, 2, 100, 100),
(5, 33, 2, 100, 100),
(6, 32, 2, 104, 100),
(7, 28, 2, 103, 100),
(8, 26, 2, 102, 100),
(9, 25, 2, 105, 100),
(10, 24, 2, 100, 100),
(11, 23, 2, 100, 100),
(12, 22, 2, 100, 100),
(13, 18, 2, 100, 83),
(14, 17, 2, 105, 100),
(15, 16, 2, 100, 100),
(16, 15, 2, 100, 100),
(17, 14, 2, 100, 100),
(18, 13, 2, 100, 100),
(19, 12, 2, 169, 100),
(20, 11, 2, 100, 100),
(21, 10, 2, 100, 100),
(22, 8, 2, 100, 100),
(23, 7, 2, 100, 100),
(24, 6, 2, 100, 100),
(25, 5, 2, 100, 100),
(26, 4, 2, 100, 100),
(27, 3, 2, 100, 100),
(28, 37, 3, 100, 100),
(29, 36, 3, 95, 95);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_livraison`
--

CREATE TABLE `ligne_livraison` (
  `id_ligne_livraison` int(11) NOT NULL,
  `id_livraison` int(11) DEFAULT NULL,
  `quantite_recu` int(100) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_reception`
--

CREATE TABLE `ligne_reception` (
  `id_ligne_re` int(11) NOT NULL,
  `id_reception` int(11) NOT NULL,
  `quantite_recu` int(50) NOT NULL,
  `id_produit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ligne_reception`
--

INSERT INTO `ligne_reception` (`id_ligne_re`, `id_reception`, `quantite_recu`, `id_produit`) VALUES
(1, 1, 10, 7);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_vente`
--

CREATE TABLE `ligne_vente` (
  `id_ligne_vente` int(11) NOT NULL,
  `id_vente` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(100) NOT NULL,
  `new_price_vente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ligne_vente`
--

INSERT INTO `ligne_vente` (`id_ligne_vente`, `id_vente`, `id_produit`, `quantite`, `new_price_vente`) VALUES
(1, 1, 4, 1, 500),
(2, 2, 7, 3, 5000),
(3, 2, 16, 1, 500),
(4, 3, 7, 1, 500),
(5, 3, 9, 1, 300);

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id_livraison` int(11) NOT NULL,
  `id_commande_client` int(11) DEFAULT NULL,
  `date_livraison` datetime DEFAULT NULL,
  `livraison_refer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livraison`
--

INSERT INTO `livraison` (`id_livraison`, `id_commande_client`, `date_livraison`, `livraison_refer`) VALUES
(1, 7, '2025-01-01 23:24:00', 'L-CC-02012025-01');

-- --------------------------------------------------------

--
-- Structure de la table `magasins`
--

CREATE TABLE `magasins` (
  `id_magasin` int(11) NOT NULL,
  `date` date NOT NULL,
  `nom` varchar(255) NOT NULL,
  `quartier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mouvement`
--

CREATE TABLE `mouvement` (
  `id_mvnt` int(11) NOT NULL,
  `id_ligne_reception` int(11) DEFAULT NULL,
  `id_ligne_livraison` int(11) DEFAULT NULL,
  `id_ligne_vente` int(11) DEFAULT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(100) DEFAULT NULL,
  `type_mvnt` varchar(100) DEFAULT NULL,
  `montant` int(100) DEFAULT NULL,
  `date_mov` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mouvement`
--

INSERT INTO `mouvement` (`id_mvnt`, `id_ligne_reception`, `id_ligne_livraison`, `id_ligne_vente`, `id_produit`, `quantite`, `type_mvnt`, `montant`, `date_mov`) VALUES
(1, NULL, NULL, 1, 4, 1, 'vente_direct', 500, '2025-02-11 08:51:13'),
(2, 1, NULL, NULL, 7, 10, 'reception', 4000, '2025-02-11 15:16:45'),
(3, NULL, NULL, 2, 7, 3, 'vente_direct', 15000, '2025-02-11 15:22:27'),
(4, NULL, NULL, 3, 16, 1, 'vente_direct', 500, '2025-02-11 15:22:27'),
(5, NULL, NULL, 4, 7, 1, 'vente_direct', 500, '2025-02-11 15:24:14'),
(6, NULL, NULL, 5, 9, 1, 'vente_direct', 300, '2025-02-11 15:24:14');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id_paiement` int(11) NOT NULL,
  `montant_paye` int(255) DEFAULT NULL,
  `date_paie` datetime NOT NULL,
  `paie_referrence` varchar(255) NOT NULL,
  `id_commande_fournisseur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id_paiement`, `montant_paye`, `date_paie`, `paie_referrence`, `id_commande_fournisseur`) VALUES
(1, 100, '2024-12-23 00:31:00', 'P-CF-23122024-01', 1),
(2, 50000, '2024-12-26 12:32:00', 'P-CF-26122024-02', 4),
(3, 1120, '2025-02-06 11:07:00', 'P-CF-06022025-03', 8),
(4, 265000, '2025-02-08 19:25:00', 'P-CF-08022025-04', 9),
(5, 5000, '2025-02-11 15:16:00', 'P-CF-11022025-05', 3);

-- --------------------------------------------------------

--
-- Structure de la table `paiement_client`
--

CREATE TABLE `paiement_client` (
  `id_paie_client` int(11) NOT NULL,
  `montant_paye` int(255) NOT NULL,
  `date_paie` datetime NOT NULL,
  `paie_reference` varchar(255) NOT NULL,
  `id_comnd_client` int(11) NOT NULL,
  `reference_caisse` varchar(100) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `paiement_client`
--

INSERT INTO `paiement_client` (`id_paie_client`, `montant_paye`, `date_paie`, `paie_reference`, `id_comnd_client`, `reference_caisse`) VALUES
(1, 500, '2024-12-25 22:14:00', 'P-CC-25122024-01', 3, 'CAISSE-12-2024-N°1'),
(2, 500, '2024-12-25 22:14:00', 'P-CC-25122024-02', 2, 'CAISSE-12-2024-N°1'),
(3, 1000, '2025-01-30 16:11:00', 'P-CC-30012025-03', 8, 'CAISSE-12-2024-N°1'),
(4, 5500, '2025-01-30 16:19:00', 'P-CC-30012025-04', 9, 'CAISSE-12-2024-N°1'),
(5, 500, '2025-02-08 19:35:00', 'P-CC-08022025-05', 10, 'CAISSE-12-2024-N°1');

-- --------------------------------------------------------

--
-- Structure de la table `proprietaire`
--

CREATE TABLE `proprietaire` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reception`
--

CREATE TABLE `reception` (
  `id_reception` int(11) NOT NULL,
  `id_commande_fournisseur` int(11) NOT NULL,
  `date_reception` datetime NOT NULL,
  `recept_ref` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reception`
--

INSERT INTO `reception` (`id_reception`, `id_commande_fournisseur`, `date_reception`, `recept_ref`) VALUES
(1, 3, '2025-02-11 15:16:00', 'R-CF-11022025-01');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `id_stick` int(11) NOT NULL,
  `quantite_diponible` int(255) DEFAULT 0,
  `id_produit` int(11) NOT NULL,
  `id_magasin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `marque_produit` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `prix_en_gros` int(50) NOT NULL,
  `prix_detail` int(50) NOT NULL,
  `price` int(50) NOT NULL,
  `alerte_article` int(100) NOT NULL,
  `id_boutique` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `id_unite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `name`, `code`, `marque_produit`, `reference`, `prix_en_gros`, `prix_detail`, `price`, `alerte_article`, `id_boutique`, `stock`, `id_unite`) VALUES
(3, 'Savon Santex', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 2, 1),
(4, 'Savon Santex', '', 'mali', 'gyug', 500, 500, 1000, 5, 1, 2, 1),
(5, 'Savon Santex', '', 'mali', 'gyug', 500, 300, 400, 5, 1, 4, 1),
(6, 'OmoSantex', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 4, 1),
(7, 'Alumette', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 1, 1),
(8, 'Chocolat', '', 'mali', 'gyug', 500, 400, 400, 5, 1, 3, 1),
(9, 'Bonbon', '', 'mali', 'gyug', 500, 300, 400, 5, 1, 3, 1),
(10, 'Chuigomme', '', 'mali', 'gyug', 500, 400, 400, 5, 1, 0, 1),
(11, 'Sac', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 100, 1),
(12, 'Ordinateur', '', 'mali', 'gyug', 500, 50000, 400, 5, 1, 159, 1),
(13, 'Gum', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 100, 1),
(14, 'Ouolo', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 99, 1),
(15, 'Ampoule', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 98, 1),
(16, 'Chausseur', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 96, 1),
(17, 'Huile', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 100, 1),
(18, 'Sucre', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 100, 1),
(19, 'Sel', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 199, 1),
(20, 'riz', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 169, 1),
(21, 'Mais', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 188, 1),
(22, 'Fonio', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 100, 1),
(23, 'Haricot', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 101, 1),
(24, 'Zaban', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 100, 1),
(25, 'Matellas', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 105, 1),
(26, 'telepphone', '', 'mali', 'gyug', 500, 500, 400, 5, 1, 102, 1),
(27, 'Tablette', '', 'mali', 'gyug', 5000, 50000, 400, 5, 1, 200, 1),
(28, 'Chaise', '', 'mali', 'gyug', 5000, 50000, 400, 5, 1, 103, 1),
(29, 'TV', '', 'mali', 'gyug', 5000, 50000, 400, 5, 1, 200, 1),
(30, 'maison', '', 'mali', 'gyug', 5000, 50000, 400, 5, 1, 198, 1),
(31, 'Diagoo', '', 'mali', 'gyug', 5000, 50000, 400, 5, 1, 5054, 1),
(32, 'sandwish', '', 'mali', '', 0, 5000, 0, 10, 1, 104, 1),
(33, 'ball', '', 'mali', '', 0, 100, 0, 5, 1, 100, 1),
(34, 'Mon savon', '', 'mali', '', 0, 500, 0, 10, 1, 180, 1),
(35, 'vivalait', '', 'mali', '', 0, 1000, 0, 10, 1, 99, 1),
(36, 'Lait en poudre NIDO 2500g', '', 'holandais', '', 0, 17000, 15000, 20, 1, 99, 1),
(37, 'Mayonnaise BAMA', '', 'holandais', '', 0, 3000, 4000, 20, 1, 86, 3);

-- --------------------------------------------------------

--
-- Structure de la table `unite`
--

CREATE TABLE `unite` (
  `id_unite` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `symbole` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `unite`
--

INSERT INTO `unite` (`id_unite`, `libelle`, `symbole`) VALUES
(1, 'Paque', 'pq'),
(2, 'Cartons', 'crts'),
(3, 'Boites', 'bts');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom_utilisateur` varchar(20) NOT NULL,
  `prenom_utilisateur` varchar(30) NOT NULL,
  `Contact_utilisateur` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `psedeau_utilisateur` varchar(40) NOT NULL,
  `mot_de_passe_utilisateur` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `type_utilisateur` varchar(40) NOT NULL,
  `statut` varchar(55) DEFAULT 'on',
  `reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom_utilisateur`, `prenom_utilisateur`, `Contact_utilisateur`, `email`, `psedeau_utilisateur`, `mot_de_passe_utilisateur`, `adresse`, `avatar`, `type_utilisateur`, `statut`, `reset_token`) VALUES
(1, 'Barry', 'Moustaphe', 92190993, 'barrymoustapha908@gmail.com ', 'maitrebarry', '1990', 'segou-sebougou', '67562a82a699b_Capture d’écran (1).png', 'Superadmin', 'on', NULL),
(7, 'Guem', 'Sadou', 78765606, 'sadou@gmail.com', 'guem', '0000', 'sebougou', 'LD0001665507_2.jpg', 'Superadmin', 'on', NULL),
(8, 'DIALLO', 'Adama', 74745669, 'alimatasow@gmail.com', 'adame', '00ce629b2735ad8217f4d6947d65938269a9a46b', 'lafiabougou-segou', '', 'utilisateur', 'on', NULL),
(9, 'Traore', 'Noe', 71730040, 'kekabaya97@gmail.com.org', 'noe', 'c22954bf5d1d4638575c2b0cc164979a2d836854', 'lafiabougou-segou', 'Annexe_Liste_Abreviations_1.jpg', 'Administrateur', 'on', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisation_pertes`
--

CREATE TABLE `utilisation_pertes` (
  `id_utili_perte` int(11) NOT NULL,
  `motif` varchar(100) NOT NULL,
  `quantite` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(100) NOT NULL,
  `id_article` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

CREATE TABLE `vente` (
  `id_vente` int(11) NOT NULL,
  `nom_client` varchar(100) DEFAULT NULL,
  `date_vente` datetime DEFAULT NULL,
  `montant_total` int(100) DEFAULT NULL,
  `reference_caisse` varchar(100) DEFAULT '0',
  `id_utilisateur` int(11) DEFAULT NULL,
  `remise` int(100) DEFAULT NULL,
  `net_a_payer` int(255) NOT NULL,
  `montant_recu` int(255) NOT NULL,
  `monnaie_rembourse` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`id_vente`, `nom_client`, `date_vente`, `montant_total`, `reference_caisse`, `id_utilisateur`, `remise`, `net_a_payer`, `montant_recu`, `monnaie_rembourse`) VALUES
(1, 'clients divers', '2025-02-11 08:51:00', 500, 'CAISSE-02-2025-N°1', 1, 0, 500, 500, 0),
(2, 'clients divers', '2025-02-11 15:20:00', 15500, 'CAISSE-02-2025-N°1', 1, 0, 15500, 15500, 0),
(3, 'clients divers', '2025-02-11 15:23:00', 800, 'CAISSE-02-2025-N°1', 1, 0, 800, 800, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `boutique`
--
ALTER TABLE `boutique`
  ADD PRIMARY KEY (`id_boutique`);

--
-- Index pour la table `caisse`
--
ALTER TABLE `caisse`
  ADD PRIMARY KEY (`id_caisse`);

--
-- Index pour la table `client_grossiste`
--
ALTER TABLE `client_grossiste`
  ADD PRIMARY KEY (`id_client_gr`);

--
-- Index pour la table `commande_client`
--
ALTER TABLE `commande_client`
  ADD PRIMARY KEY (`id_cmd_client`),
  ADD KEY `id_client_gr` (`id_client_gr`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `commande_fournisseur`
--
ALTER TABLE `commande_fournisseur`
  ADD PRIMARY KEY (`id_commande_fournisseur`),
  ADD KEY `id_fournisseur` (`id_fournisseur`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `depense`
--
ALTER TABLE `depense`
  ADD PRIMARY KEY (`id_depense`);

--
-- Index pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  ADD PRIMARY KEY (`id_fournisseur`);

--
-- Index pour la table `inventaire`
--
ALTER TABLE `inventaire`
  ADD PRIMARY KEY (`id_inventaire`),
  ADD KEY `fk_di_inventaire` (`id_utilisateur`);

--
-- Index pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD PRIMARY KEY (`id_ligne`),
  ADD KEY `id_commande_fournisseur` (`id_commande_fournisseur`),
  ADD KEY `id` (`id`);

--
-- Index pour la table `ligne_commande_client`
--
ALTER TABLE `ligne_commande_client`
  ADD PRIMARY KEY (`id_ligne_cl`),
  ADD KEY `FK_id_produit` (`id_produit`),
  ADD KEY `id_cmd_client` (`id_cmd_client`);

--
-- Index pour la table `ligne_inventaire`
--
ALTER TABLE `ligne_inventaire`
  ADD PRIMARY KEY (`id_ligne_inventaire`),
  ADD KEY `fk_di_lign_inv` (`id_produit`),
  ADD KEY `fk_lign` (`id_inventaire`);

--
-- Index pour la table `ligne_livraison`
--
ALTER TABLE `ligne_livraison`
  ADD PRIMARY KEY (`id_ligne_livraison`),
  ADD KEY `id_fk_produi` (`id_produit`),
  ADD KEY `FK-livraison` (`id_livraison`);

--
-- Index pour la table `ligne_reception`
--
ALTER TABLE `ligne_reception`
  ADD PRIMARY KEY (`id_ligne_re`),
  ADD KEY `ligne_reception_ibfk_1` (`id_produit`),
  ADD KEY `id_reception` (`id_reception`);

--
-- Index pour la table `ligne_vente`
--
ALTER TABLE `ligne_vente`
  ADD PRIMARY KEY (`id_ligne_vente`),
  ADD KEY `id_vente` (`id_vente`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id_livraison`),
  ADD KEY `id_commande_client` (`id_commande_client`);

--
-- Index pour la table `magasins`
--
ALTER TABLE `magasins`
  ADD PRIMARY KEY (`id_magasin`);

--
-- Index pour la table `mouvement`
--
ALTER TABLE `mouvement`
  ADD PRIMARY KEY (`id_mvnt`),
  ADD KEY `id_ligne_reception` (`id_ligne_reception`),
  ADD KEY `id_ligne_livraison` (`id_ligne_livraison`),
  ADD KEY `FK_produit` (`id_produit`),
  ADD KEY `id_ligne_vente` (`id_ligne_vente`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id_paiement`),
  ADD KEY `paiement_ibfk_1` (`id_commande_fournisseur`);

--
-- Index pour la table `paiement_client`
--
ALTER TABLE `paiement_client`
  ADD PRIMARY KEY (`id_paie_client`),
  ADD KEY `id_fk_comnd_client` (`id_comnd_client`);

--
-- Index pour la table `proprietaire`
--
ALTER TABLE `proprietaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reception`
--
ALTER TABLE `reception`
  ADD PRIMARY KEY (`id_reception`),
  ADD KEY `reception_ibfk_1` (`id_commande_fournisseur`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stick`),
  ADD KEY `id_produit` (`id_produit`),
  ADD KEY `id_magasin` (`id_magasin`);

--
-- Index pour la table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_boutique` (`id_boutique`),
  ADD KEY `id_unite` (`id_unite`);

--
-- Index pour la table `unite`
--
ALTER TABLE `unite`
  ADD PRIMARY KEY (`id_unite`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- Index pour la table `utilisation_pertes`
--
ALTER TABLE `utilisation_pertes`
  ADD PRIMARY KEY (`id_utili_perte`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `vente`
--
ALTER TABLE `vente`
  ADD PRIMARY KEY (`id_vente`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `boutique`
--
ALTER TABLE `boutique`
  MODIFY `id_boutique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `caisse`
--
ALTER TABLE `caisse`
  MODIFY `id_caisse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `client_grossiste`
--
ALTER TABLE `client_grossiste`
  MODIFY `id_client_gr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commande_client`
--
ALTER TABLE `commande_client`
  MODIFY `id_cmd_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `commande_fournisseur`
--
ALTER TABLE `commande_fournisseur`
  MODIFY `id_commande_fournisseur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `depense`
--
ALTER TABLE `depense`
  MODIFY `id_depense` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `id_fournisseur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `inventaire`
--
ALTER TABLE `inventaire`
  MODIFY `id_inventaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id_ligne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `ligne_commande_client`
--
ALTER TABLE `ligne_commande_client`
  MODIFY `id_ligne_cl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `ligne_inventaire`
--
ALTER TABLE `ligne_inventaire`
  MODIFY `id_ligne_inventaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `ligne_livraison`
--
ALTER TABLE `ligne_livraison`
  MODIFY `id_ligne_livraison` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_reception`
--
ALTER TABLE `ligne_reception`
  MODIFY `id_ligne_re` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `ligne_vente`
--
ALTER TABLE `ligne_vente`
  MODIFY `id_ligne_vente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id_livraison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `magasins`
--
ALTER TABLE `magasins`
  MODIFY `id_magasin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mouvement`
--
ALTER TABLE `mouvement`
  MODIFY `id_mvnt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id_paiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `paiement_client`
--
ALTER TABLE `paiement_client`
  MODIFY `id_paie_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `proprietaire`
--
ALTER TABLE `proprietaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reception`
--
ALTER TABLE `reception`
  MODIFY `id_reception` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stick` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `unite`
--
ALTER TABLE `unite`
  MODIFY `id_unite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `utilisation_pertes`
--
ALTER TABLE `utilisation_pertes`
  MODIFY `id_utili_perte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vente`
--
ALTER TABLE `vente`
  MODIFY `id_vente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande_client`
--
ALTER TABLE `commande_client`
  ADD CONSTRAINT `commande_client_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `commande_fournisseur`
--
ALTER TABLE `commande_fournisseur`
  ADD CONSTRAINT `commande_fournisseur_ibfk_1` FOREIGN KEY (`id_fournisseur`) REFERENCES `fournisseur` (`id_fournisseur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_fournisseur_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `inventaire`
--
ALTER TABLE `inventaire`
  ADD CONSTRAINT `fk_di_inventaire` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `ligne_commande_ibfk_1` FOREIGN KEY (`id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ligne_commande_ibfk_2` FOREIGN KEY (`id_commande_fournisseur`) REFERENCES `commande_fournisseur` (`id_commande_fournisseur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne_commande_client`
--
ALTER TABLE `ligne_commande_client`
  ADD CONSTRAINT `ligne_commande_client_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ligne_commande_client_ibfk_2` FOREIGN KEY (`id_cmd_client`) REFERENCES `commande_client` (`id_cmd_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne_inventaire`
--
ALTER TABLE `ligne_inventaire`
  ADD CONSTRAINT `fk_di_lign_inv` FOREIGN KEY (`id_produit`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lign` FOREIGN KEY (`id_inventaire`) REFERENCES `inventaire` (`id_inventaire`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne_livraison`
--
ALTER TABLE `ligne_livraison`
  ADD CONSTRAINT `ligne_livraison_ibfk_1` FOREIGN KEY (`id_livraison`) REFERENCES `livraison` (`id_livraison`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ligne_livraison_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne_reception`
--
ALTER TABLE `ligne_reception`
  ADD CONSTRAINT `ligne_reception_ibfk_1` FOREIGN KEY (`id_reception`) REFERENCES `reception` (`id_reception`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ligne_reception_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne_vente`
--
ALTER TABLE `ligne_vente`
  ADD CONSTRAINT `ligne_vente_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ligne_vente_ibfk_2` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id_vente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `livraison_ibfk_1` FOREIGN KEY (`id_commande_client`) REFERENCES `commande_client` (`id_cmd_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mouvement`
--
ALTER TABLE `mouvement`
  ADD CONSTRAINT `mouvement_ibfk_1` FOREIGN KEY (`id_ligne_reception`) REFERENCES `ligne_reception` (`id_ligne_re`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mouvement_ibfk_2` FOREIGN KEY (`id_ligne_livraison`) REFERENCES `ligne_livraison` (`id_ligne_livraison`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mouvement_ibfk_3` FOREIGN KEY (`id_produit`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mouvement_ibfk_4` FOREIGN KEY (`id_ligne_vente`) REFERENCES `ligne_vente` (`id_ligne_vente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_commande_fournisseur`) REFERENCES `commande_fournisseur` (`id_commande_fournisseur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `paiement_client`
--
ALTER TABLE `paiement_client`
  ADD CONSTRAINT `paiement_client_ibfk_1` FOREIGN KEY (`id_comnd_client`) REFERENCES `commande_client` (`id_cmd_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reception`
--
ALTER TABLE `reception`
  ADD CONSTRAINT `reception_ibfk_1` FOREIGN KEY (`id_commande_fournisseur`) REFERENCES `commande_fournisseur` (`id_commande_fournisseur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `tbl_product_ibfk_2` FOREIGN KEY (`id_unite`) REFERENCES `unite` (`id_unite`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_product_ibfk_3` FOREIGN KEY (`id_boutique`) REFERENCES `boutique` (`id_boutique`);

--
-- Contraintes pour la table `utilisation_pertes`
--
ALTER TABLE `utilisation_pertes`
  ADD CONSTRAINT `utilisation_pertes_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vente`
--
ALTER TABLE `vente`
  ADD CONSTRAINT `vente_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

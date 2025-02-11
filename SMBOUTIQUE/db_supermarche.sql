-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 11 déc. 2024 à 19:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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

-- --------------------------------------------------------

--
-- Structure de la table `commande_client`
--

CREATE TABLE `commande_client` (
  `id_cmd_client` int(11) NOT NULL,
  `client` varchar(50) NOT NULL DEFAULT 'client divers',
  `id_client_gr` int(11) NOT NULL,
  `date_cmd_client` datetime NOT NULL,
  `reference` varchar(255) NOT NULL,
  `total` int(100) NOT NULL,
  `paie` int(11) DEFAULT 0,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `id_ligne` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `id_commande_fournisseur` int(11) DEFAULT NULL,
  `quantite` int(255) DEFAULT NULL,
  `qte_livre` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande_client`
--

CREATE TABLE `ligne_commande_client` (
  `id_ligne_cl` int(11) NOT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `id_cmd_client` int(11) DEFAULT NULL,
  `quantite` int(50) DEFAULT NULL,
  `qte_livre` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `ligne_vente`
--

CREATE TABLE `ligne_vente` (
  `id_ligne_vente` int(11) NOT NULL,
  `id_vente` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `alerte_article` varchar(100) NOT NULL,
  `id_boutique` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `id_unite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Paque', 'pq');

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
(1, 'Barry', 'Moustaphe', 92190993, 'guem7876@gmail.com', 'maitrebarry', '1990', 'segou-sebougou', '67562a82a699b_Capture d’écran (1).png', 'Superadmin', 'on', NULL),
(7, 'Maiga', 'Sadou', 78765606, 'sadou@gmail.com', 'Maiga', 'ca3850b3c38a0cff299605c2d6aa3217bb18473c', 'sebougou', 'LD0001665507_2.jpg', 'Administrateur', 'on', NULL);

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
  MODIFY `id_caisse` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `client_grossiste`
--
ALTER TABLE `client_grossiste`
  MODIFY `id_client_gr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_client`
--
ALTER TABLE `commande_client`
  MODIFY `id_cmd_client` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commande_fournisseur`
--
ALTER TABLE `commande_fournisseur`
  MODIFY `id_commande_fournisseur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `depense`
--
ALTER TABLE `depense`
  MODIFY `id_depense` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseur`
--
ALTER TABLE `fournisseur`
  MODIFY `id_fournisseur` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inventaire`
--
ALTER TABLE `inventaire`
  MODIFY `id_inventaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id_ligne` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_commande_client`
--
ALTER TABLE `ligne_commande_client`
  MODIFY `id_ligne_cl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_inventaire`
--
ALTER TABLE `ligne_inventaire`
  MODIFY `id_ligne_inventaire` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_livraison`
--
ALTER TABLE `ligne_livraison`
  MODIFY `id_ligne_livraison` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_reception`
--
ALTER TABLE `ligne_reception`
  MODIFY `id_ligne_re` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ligne_vente`
--
ALTER TABLE `ligne_vente`
  MODIFY `id_ligne_vente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id_livraison` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `magasins`
--
ALTER TABLE `magasins`
  MODIFY `id_magasin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mouvement`
--
ALTER TABLE `mouvement`
  MODIFY `id_mvnt` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id_paiement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiement_client`
--
ALTER TABLE `paiement_client`
  MODIFY `id_paie_client` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `proprietaire`
--
ALTER TABLE `proprietaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reception`
--
ALTER TABLE `reception`
  MODIFY `id_reception` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stick` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `unite`
--
ALTER TABLE `unite`
  MODIFY `id_unite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `utilisation_pertes`
--
ALTER TABLE `utilisation_pertes`
  MODIFY `id_utili_perte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vente`
--
ALTER TABLE `vente`
  MODIFY `id_vente` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `tbl_product_ibfk_2` FOREIGN KEY (`id_unite`) REFERENCES `unite` (`id_unite`) ON DELETE CASCADE ON UPDATE CASCADE;

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

<?php

require_once('partials/database.php');

$output = '';

// session_start();

if (isset($_POST['mon_id'])) {
    $produit_id = intval($_POST['mon_id']);

    if (isset($_POST['ajout']) && $_POST['ajout'] === 'true') {
        $quantite = intval($_POST['quantite']);
        if (isset($_SESSION['shopping_cart'][$produit_id])) {
            $_SESSION['shopping_cart'][$produit_id] += $quantite;
        } else {
            $_SESSION['shopping_cart'][$produit_id] = $quantite;

            $stmt = $bdd->prepare("SELECT price FROM tbl_product WHERE id = ?");
            $stmt->execute([$produit_id]);
            $_SESSION['shopping_cart_prix'][$produit_id] = $stmt->fetchColumn() ?: 0;
        }
    }

    if (isset($_POST['quantite'], $_POST['prix'])) {
        $quantite = intval($_POST['quantite']);
        $prix = floatval($_POST['prix']);

        if ($quantite > 0) {
            $_SESSION['shopping_cart'][$produit_id] = $quantite;
            $_SESSION['shopping_cart_prix'][$produit_id] = $prix;
        } else {
            unset($_SESSION['shopping_cart'][$produit_id], $_SESSION['shopping_cart_prix'][$produit_id]);
        }
    }
}

if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
    $produit_id = intval($_GET["id"]);
    unset($_SESSION['shopping_cart'][$produit_id], $_SESSION['shopping_cart_prix'][$produit_id]);
}

if (!empty($_SESSION['shopping_cart'])) {
    $ids = array_keys($_SESSION['shopping_cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $bdd->prepare("SELECT * FROM tbl_product WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $dataPanier = $stmt->fetchAll(PDO::FETCH_OBJ);

    $total = 0;
    foreach ($dataPanier as $panier) {
        $quantite = $_SESSION['shopping_cart'][$panier->id];
        $prix = $_SESSION['shopping_cart_prix'][$panier->id];
        $montant = $quantite * $prix;
        $total += $montant;
        // Générer le HTML de chaque ligne
        $output .= "<tr><td>{$panier->name}</td><td>{$quantite}</td><td>{$prix}</td><td>{$montant}</td></tr>";
    }
    $output .= "<tr><td colspan='3'>Total</td><td>{$total}</td></tr>";
} else {
    $output = '<tr><td colspan="4">Votre panier est vide</td></tr>';
}

echo $output;
?>

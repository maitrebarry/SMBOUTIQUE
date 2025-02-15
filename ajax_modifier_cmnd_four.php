<?php

require_once('partials/database.php');



$output = '';

// Récupérer les produits existants de la commande
if (isset($_GET['modifi'])) {
    $modifi = $_GET['modifi'];
    $ligen_commande = $bdd->prepare("SELECT * FROM ligne_commande INNER JOIN tbl_product ON tbl_product.id = ligne_commande.id WHERE ligne_commande.id_commande_fournisseur = :id");
    $ligen_commande->execute([':id' => $modifi]);
    $datashow = $ligen_commande->fetchAll(PDO::FETCH_OBJ);
}

// Générer le HTML pour les produits existants
$total = 0;
if (isset($datashow)) {
    foreach ($datashow as $affiche) {
        $total += $affiche->quantite * $affiche->price;
        $output .= "<tr class='existing-product'>
            <td>{$affiche->name}</td>
            <td><input type='number' name='quantite[]' class='form-control quantite-input' data-id='{$affiche->id}' value='{$affiche->quantite}'></td>
            <td><input type='number' name='prix[]' class='form-control prix-input' data-id='{$affiche->id}' value='{$affiche->price}'></td>
            <td class='montant'>" . intval($affiche->quantite * $affiche->price) . "</td>
            <td><button type='button' class='btn btn-danger btn-sm btn-supprimer remove-ligne' data-id='{$affiche->id}'><i class='bi bi-trash'></i></button></td>
        </tr>";
    }
}

// Ajouter le HTML des nouveaux produits sans écraser les existants
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

// Calculer le total après suppression
$total = 0;
if (isset($datashow)) {
    foreach ($datashow as $affiche) {
        $total += $affiche->quantite * $affiche->price;
    }
}

if (!empty($_SESSION['shopping_cart'])) {
    $ids = array_keys($_SESSION['shopping_cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $bdd->prepare("SELECT * FROM tbl_product WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $dataPanier = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($dataPanier as $panier) {
        $quantite = $_SESSION['shopping_cart'][$panier->id];
        $prix = $_SESSION['shopping_cart_prix'][$panier->id];
        $montant = $quantite * $prix;
        $total += $montant;
        $output .= "<tr class='new-product'><td>{$panier->name}</td><td><input type='number' name='quantite[]' class='form-control quantite-input' data-id='{$panier->id}' value='{$quantite}'></td><td><input type='number' name='prix[]' class='form-control prix-input' data-id='{$panier->id}' value='{$prix}'></td><td class='montant'>" . intval($montant) . "</td><td><button type='button' class='btn btn-danger btn-sm btn-supprimer remove-ligne' data-id='{$panier->id}'><i class='bi bi-trash'></i></button></td></tr>";
    }
}

// Ajouter la ligne de total en dehors de la boucle
// $output .= "<script>document.getElementById('total_commande').value = '{$total}';</script>";

echo $output;
?>
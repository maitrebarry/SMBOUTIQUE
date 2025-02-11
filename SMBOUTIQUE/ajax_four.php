<?php

require_once('partials/database.php');

$output = '';

// Partie sélection dans le champ select
if (isset($_POST['mon_id'])) {
    if (isset($_SESSION['shopping_cart'][$_POST['mon_id']])) {
        $_SESSION['shopping_cart'][$_POST['mon_id']]++;
    } else {
        $_SESSION['shopping_cart'][$_POST['mon_id']] = 1;

        // Récupérer le prix initial depuis tbl_product et le stocker dans la session
        $sql = "SELECT price FROM tbl_product WHERE id = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$_POST['mon_id']]);
        $initial_price = $stmt->fetchColumn();
        $_SESSION['shopping_cart_prix'][$_POST['mon_id']] = $initial_price;
    }
}
if (isset($_POST['mon_id']) && isset($_POST['quantite']) && isset($_POST['prix'])) {
    $produit_id = $_POST['mon_id'];
    $quantite = $_POST['quantite'];
    $prix = $_POST['prix']; // Nouveau prix

    // Vérifiez que la quantité est valide
    if ($quantite > 0) {
        $_SESSION['shopping_cart'][$produit_id] = $quantite; // Mise à jour de la quantité dans la session
        $_SESSION['shopping_cart_prix'][$produit_id] = $prix; // Mise à jour du prix dans la session
    } else {
        unset($_SESSION['shopping_cart'][$produit_id]); // Supprimer l'article si la quantité est zéro
        unset($_SESSION['shopping_cart_prix'][$produit_id]); // Supprimer le prix si l'article est supprimé
    }
}
// Partie récupération et mise dans le panier
if (isset($_SESSION['shopping_cart'])) {
    $ids = array_keys($_SESSION['shopping_cart']);

    // Fonction pour générer le HTML du panier
    function generatePanierHTML($dataPanier) {
        global $bdd;
        $output = '';
        $total = 0;

        foreach ($dataPanier as $panier) {
            $current_prix = isset($_SESSION['shopping_cart_prix'][$panier->id]) ? $_SESSION['shopping_cart_prix'][$panier->id] : $panier->price;

            $output .= '<tr>';
            $output .= '<td>' . htmlspecialchars($panier->name) . '<input type="hidden" name="id_article[]" class="form-control" value="' . $panier->id . '"></td>';

            // Vérifier si la clé existe avant d'accéder à la quantité
            $quantite = isset($_SESSION['shopping_cart'][$panier->id]) ? $_SESSION['shopping_cart'][$panier->id] : 0;
            $output .= '<td><input type="number" name="quantite[]" class="form-control quantite" value="' . $quantite . '" oninput="validateNumber(this)"></td>';
            $output .= '<td><input type="number" name="prix[]" class="form-control prix" value="' . htmlspecialchars($current_prix) . '" oninput="updateMontant(this)"></td>';

            // Calculer le montant
            $montant = $quantite * $current_prix;
            $output .= '<td><input type="number" name="montant[]" class="form-control montant" value="' . htmlspecialchars($montant) . '" readOnly></td>';
            $total += $montant;

            $output .= '<td><a href="#" class="btn btn-danger btn-sm btn-supprimer" data-product-id="' . $panier->id . '"><i class="bi bi-trash"></i></a></td>';
            $output .= '</tr>';
        }

        $output .= '<tr>';
        $output .= '<td colspan="3" align="right"><h5 class="text-danger">Total</h5></td>';
        $output .= '<td align="right"><input type="number" name="total" id="total" class="form-control" value="' . htmlspecialchars($total) . '" readOnly></td>';
        $output .= '</tr>';

        return $output;
    }

    // Suppression du produit sélectionné
    if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
        unset($_SESSION["shopping_cart"][$_GET["id"]]);
        unset($_SESSION["shopping_cart_prix"][$_GET["id"]]);
    }

    // Utilisation de la fonction pour générer le HTML du panier
    if (isset($ids) && !empty($ids)) {
        $sql = "SELECT * FROM tbl_product WHERE id IN (" . implode(',', $ids) . ")";
        $data = $bdd->prepare($sql);
        $data->execute();
        $dataPanier = $data->fetchAll(PDO::FETCH_OBJ);

        $output = generatePanierHTML($dataPanier);
    } else {
        // Affichage du message dans le panier si celui-ci est vide
        $output = '<tr><td colspan="5" class="text-danger">Votre panier est vide</td></tr>';
    }
}

echo $output;
?>

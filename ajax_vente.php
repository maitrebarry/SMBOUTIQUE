<?php

require_once('partials/database.php');
$output = '';

// Partie sélection dans le champ select
if (isset($_POST['mon_id'])) {
    if (isset($_SESSION['shopping_cart'][$_POST['mon_id']])) {
        $_SESSION['shopping_cart'][$_POST['mon_id']]++;
    } else {
        $_SESSION['shopping_cart'][$_POST['mon_id']] = 1;
    }
}
if (isset($_POST['mon_id']) && isset($_POST['quantite'])) {
    $produit_id = $_POST['mon_id'];
    $quantite = $_POST['quantite'];

    // Vérifiez que la quantité est valide
    if ($quantite > 0) {
        $_SESSION['shopping_cart'][$produit_id] = $quantite; // Mise à jour de la quantité dans la session
    } else {
        unset($_SESSION['shopping_cart'][$produit_id]); // Supprimer l'article si la quantité est zéro
    }
}
// Partie récupération et mise dans le panier
if (isset($_SESSION['shopping_cart'])) {
    $ids = array_keys($_SESSION['shopping_cart']);
    function generatePanierHTML($dataPanier) {
        $output = '';
        $total = 0;
        foreach ($dataPanier as $panier) {
            $output .= '<tr>';
            $output .= '<td>' . htmlspecialchars($panier->name) . '<input type="hidden" name="id_article[]" class="form-control" value="' . $panier->id . '"></td>';
            if (isset($_SESSION['shopping_cart'][$panier->id])) {
                $output .= '<td><input type="number" name="quantite[]" class="form-control quantite" value="' . $_SESSION['shopping_cart'][$panier->id] . '" oninput="validateNumber(this)"></td>';
            } else {
                $output .= '<td><input type="number" name="quantite[]" class="form-control quantite" value="0" oninput="validateNumber(this)"></td>';
            }
            $output .= '<td><input type="number" name="prix[]" class="form-control prix" value="' . htmlspecialchars($panier->prix_detail) . '" oninput="updateMontant(this)"></td>';
            if (isset($_SESSION['shopping_cart'][$panier->id])) {
                $output .= '<td><input type="text" name="montant[]" class="form-control montant" value="' . htmlspecialchars($panier->prix_detail * $_SESSION['shopping_cart'][$panier->id]) . '" readOnly></td>';
                $total += ($_SESSION["shopping_cart"][$panier->id] * $panier->prix_detail);
            } else {
                $output .= '<td><input type="text" name="montant[]" class="form-control montant" value="0" readOnly></td>';
            }
            $output .= '<td><a href="#" class="btn btn-danger btn-sm btn-supprimer" data-product-id="' . $panier->id . '"><i class="bi bi-trash"></i></a></td>';
            $output .= '</tr>';
        }
        $output .= '<tr>';
        $output .= '<td colspan="3" align="right"><h5 class="text-danger">Total</h5></td>';
        $output .= '<td align="right"><input type="number" name="total" id="total" class="form-control totalcal" value="' . htmlspecialchars($total) . '" readOnly></td>';
        $output .= '</tr>';
        return $output;
    }


    //suppression du produit selectionne 
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "delete") {
            if (isset($_GET["id"])) { 
                unset($_SESSION["shopping_cart"][$_GET["id"]]);
                echo 'Suppression réussie';
            }
        }
    }

    // Utilisation de la fonction pour générer le HTML du panier
    if (isset($ids) && !empty($ids)) {
        $sql = "SELECT * FROM tbl_product WHERE id IN (" . implode(',', $ids) . ")";
        $data = $bdd->prepare($sql);
        $data->execute();
        $dataPanier = $data->fetchAll(PDO::FETCH_OBJ);

        $output = generatePanierHTML($dataPanier);
    } else {
        // affichage  du message dans le panier
        $output = '<tr><td colspan="5" class="text-danger">Votre panier est vide</td></tr>';
    }

    echo $output;
}

?>

<script>
    function validateNumber(input) {
        input.value = input.value.replace(/\D/g, ''); // Remplacer tout caractère non numérique
    }
    
</script>

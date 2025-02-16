<?php
    require_once('partials/database.php');

if (isset($_GET['detail'])) {
    $detail = $_GET['detail'];
    // Récupérer les lignes de vente associées à cette vente
    $ligne_vente = $bdd->query("SELECT * FROM ligne_vente INNER JOIN tbl_product
        ON tbl_product.id = ligne_vente.id_produit WHERE ligne_vente.id_vente = $detail");

    // Récupérer toutes les lignes de vente
    $venteinfo = $ligne_vente->fetchAll(PDO::FETCH_OBJ);
// Récupérer les informations de la vente
    $vente = $bdd->query("SELECT * FROM vente WHERE id_vente = $detail");
    $lignes = $vente->fetch();
    require_once('view/detail_vente.view.php');
} 
?>

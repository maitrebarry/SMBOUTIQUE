<?php
require_once ('partials/database.php');
require_once ('function/function.php');
$produits = recuperation_fonction('*', 'tbl_product', [], "ALL");
function trouver_article_par_id($produits, $article_id) {
            foreach ($produits as $article) {
                if ($article->id == $article_id) {
                    return $article;
                }
            }
            return null; 
        }
if (isset($_POST['ajouter'])) {
    if (!empty($_POST['produit']) && !empty($_POST['date']) && !empty($_POST['quantite']) && !empty($_POST['motif'])) {
        // Extraire les valeurs des champs POST dans des variables distinctes
        extract($_POST);

        // Convertir la date au format attendu par la base de données (YYYY-MM-DD)
        $date = DateTime::createFromFormat('Y-m-d', $_POST['date']);
        $formattedDate = $date ? $date->format('Y-m-d') : null;
        $quantite = $_POST['quantite'];
        $motif = $_POST['motif'];
        $article = $_POST['produit'];

        // Vérifie si la case à cocher "type_utilisation" est cochée
        if (isset($_POST['type_utilisation']) && $_POST['type_utilisation'] === 'utilisation') {
            $type = 'utilisation';
        } 
        // Vérifie si la case à cocher "type_perte" est cochée
        elseif (isset($_POST['type_perte']) && $_POST['type_perte'] === 'perte') {
            $type = 'perte';
        } 
        // Si aucune case n'est cochée, définir la valeur par défaut sur 'utilisation'
        else {
            $type = 'utilisation';
        }

        // Préparer la requête d'insertion pour la caisse
        $insertUtili_pert = 'INSERT INTO utilisation_pertes (motif, quantite, date, type, id_article) VALUES (?, ?, ?, ?, ?)';

        // Exécuter la fonction d'insertion
        $lastid = Insertion_and_update($insertUtili_pert, [$motif, $quantite, $formattedDate, $type, $article], true);

        // Mettre à jour le stock dans la table tb_product
        $article_info = trouver_article_par_id($produits, $article);
        $nouveau_stock = $article_info->stock - $quantite;
        $updateStockQuery = 'UPDATE tbl_product SET stock = ? WHERE id = ?';
        Insertion_and_update($updateStockQuery, [$nouveau_stock, $article], false);

        // Afficher un message de succès
        afficher_message('Utilisation ou perte ajoutée avec succès', 'success');
        header('Location: utilisat_pert.php');
        exit(); // Ajout d'une sortie après la redirection pour éviter l'exécution du code suivant accidentellement
    }
}


require_once ('view/utilisat_pert.view.php');
?>

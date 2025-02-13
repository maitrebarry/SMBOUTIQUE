<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$delete = new CommandeClient();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id_livraison = $_GET['id'];
 
    // Supprimer la livraison
    try {
        //recuperation  ligne de livraison
        $ligne_livraison=$bdd->query("SELECT * FROM ligne_livraison WHERE id_livraison = $id_livraison");
        $lignes=$ligne_livraison->fetchAll(PDO::FETCH_OBJ);

        foreach ($lignes as $ligne) {
            $id_ligne=$ligne->id_ligne_livraison;
            $id_produit=$ligne->id_produit;
            $quantite_recu=$ligne->quantite_recu;
             //recuperatio du produit
                // var_dump($id_produit);exit;
            $prod=$bdd->query("SELECT * FROM tbl_product WHERE id=$id_produit LIMIT 1");
            $fecth_prod=$prod->fetch();
            $stock=$fecth_prod['stock'];
            $new_stock=$stock+$quantite_recu;
            $update_prod_stock=$bdd->query("UPDATE tbl_product SET stock=$new_stock WHERE id=$id_produit");
        }
        $delete->delete_data('DELETE FROM livraison WHERE id_livraison = :id_livraison', [
            ':id_livraison' => $id_livraison
        ]);
             //stockage du message dans la session
            $_SESSION['success_message'] = "Suppression réussie";
        // Redirection après suppression réussie
        header('Location: liste_livraison.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

<?php
require_once('autoload.php');
$delete = new CommandeFour();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id_reception = $_GET['id'];
 
    // Supprimer la livraison
    try {
        //recuperation  ligne de livraison
        $ligne_reception=$bdd->query("SELECT * FROM ligne_reception WHERE id_reception = $id_reception");
        $lignes=$ligne_reception->fetchAll(PDO::FETCH_OBJ);

        foreach ($lignes as $ligne) {
            $id_ligne=$ligne->id_ligne_reception;
            $id_produit=$ligne->id_produit;
            $quantite_recu=$ligne->quantite_recu;
             //recuperation du produit
                // var_dump($id_produit);exit;
            $prod=$bdd->query("SELECT * FROM tbl_product WHERE id=$id_produit LIMIT 1");
            $fecth_prod=$prod->fetch();
            $stock=$fecth_prod['stock'];
            $new_stock=$stock-$quantite_recu;
            $update_prod_stock=$bdd->query("UPDATE tbl_product SET stock=$new_stock WHERE id=$id_produit");
        }
        $delete->delete_data('DELETE FROM reception WHERE id_reception = :id_reception', [
            ':id_reception' => $id_reception
        ]);
            //stockage du message dans la session
            $_SESSION['success_message'] = "Suppression réussie";
        // Redirection après suppression réussie
        header('Location: liste_reception.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

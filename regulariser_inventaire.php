<?php 
    require_once('partials/database.php');

if (isset($_GET['regulariser'])) {
    $regulariser_id = (int) $_GET['regulariser']; 

    //  les détails de l'inventaire
    $commande = $bdd->prepare("SELECT * FROM inventaire 
                               INNER JOIN utilisateur 
                               ON utilisateur.id_utilisateur = inventaire.id_utilisateur 
                               WHERE id_inventaire = :id_inventaire 
                               LIMIT 1");
    $commande->execute([':id_inventaire' => $regulariser_id]);
    $inventaire = $commande->fetch();

    //  les lignes de l'inventaire
    $ligne_inventaire = $bdd->prepare("SELECT * FROM ligne_inventaire 
                                       INNER JOIN tbl_product 
                                       ON tbl_product.id = ligne_inventaire.id_produit 
                                       WHERE ligne_inventaire.id_inventaire = :id_inventaire");
    $ligne_inventaire->execute([':id_inventaire' => $regulariser_id]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantite_physique = $_POST['qte_physique'];
    $produit_ids = $_POST['id_produit'];
    $regulariser_id = (int) $_POST['regulariser_id'];
    $bdd->beginTransaction();
    try {
        // Mise à jour des stocks des produits
        foreach ($produit_ids as $key => $produit_id) {
            $qte_physique = (int) $quantite_physique[$key]; 

            $update_product = $bdd->prepare("UPDATE tbl_product SET stock = :qte_physique WHERE id = :id_produit");
            $update_product->execute([
                ':qte_physique' => $qte_physique,
                ':id_produit' => (int) $produit_id
            ]);
        }

        // Mise à jour de l'inventaire
        $update_inventaire = $bdd->prepare("UPDATE inventaire SET regulariser = 'oui' WHERE id_inventaire = :id_inventaire");
        $update_inventaire->execute([
            ':id_inventaire' => $regulariser_id
        ]);

        $bdd->commit();
        header("Location: liste_inventaire.php");
        exit;
    } catch (Exception $e) {
        $bdd->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}

require_once('view/regulariser_invetaire.view.php');
?>

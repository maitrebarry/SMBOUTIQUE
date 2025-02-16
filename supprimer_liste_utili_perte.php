<?php
require_once('autoload.php');
$delete = new CommandeClient();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id_utili_perte = $_GET['id'];

    // Supprimer la commande_client
    try {
        // Récupération du paiement
        $liste_lutili_perte = $bdd->query("SELECT * FROM utilisation_pertes WHERE id_utili_perte = $id_utili_perte");
        $lutili_perte = $liste_lutili_perte->fetch();
        
        
        $id_article_associé = $lutili_perte['id_article']; // Assurez-vous que cette colonne existe

        $quantite = $lutili_perte['quantite'];

        // Mise à jour du montant total de la caisse
        $bdd->query("UPDATE tbl_product SET stock = stock + $quantite WHERE id = $id_article_associé");

        $delete->delete_data('DELETE FROM utilisation_pertes WHERE id_utili_perte = :id_utili_perte', [
            ':id_utili_perte' => $id_utili_perte
        ]);

        // Stockage du message dans la session
        $_SESSION['success_message'] = "Suppression réussie";

        // Redirection après suppression réussie
        header('Location: lsiteUtilisat_pert.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

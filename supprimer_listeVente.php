<?php
require_once('autoload.php');

$delete = new CommandeClient();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id_vente = $_GET['id'];

    try {
        // Récupération des lignes de vente
        $ligne_vente = $bdd->query("SELECT * FROM ligne_vente WHERE id_vente = $id_vente");
        $lignes = $ligne_vente->fetchAll(PDO::FETCH_OBJ);

        foreach ($lignes as $ligne) {
            $id_ligne = $ligne->id_ligne_vente;
            $id_produit = $ligne->id_produit;
            $quantite = $ligne->quantite;

            // Mise à jour du stock du produit
            $bdd->query("UPDATE tbl_product SET stock = stock + $quantite WHERE id = $id_produit");
        }

        // Récupération de la vente
        $vente = $bdd->query("SELECT * FROM vente WHERE id_vente = $id_vente");
        $vente_info = $vente->fetch();

        $montant_total = $vente_info['montant_total'];

        // Mise à jour du montant total de la caisse
        $bdd->query("UPDATE caisse SET Montant_total_caisse = Montant_total_caisse - $montant_total WHERE statut = 'on'");

        // Suppression de la vente
        $delete->delete_data('DELETE FROM vente WHERE id_vente = :id_vente', [':id_vente' => $id_vente]);

        // Stockage du message dans la session
        $_SESSION['success_message'] = "Suppression réussie";

        // Redirection après suppression réussie
        header('Location: liste_vente.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

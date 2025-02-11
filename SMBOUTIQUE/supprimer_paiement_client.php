
<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$delete = new CommandeClient();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id_paie_client = $_GET['id'];

    // Supprimer la commande_client
    try {
             // Récupération du paiement
            $paiement_client = $bdd->query("SELECT * FROM paiement_client WHERE id_paie_client = $id_paie_client");
            $paiement_client_info = $paiement_client->fetch();

            $montant_total = $paiement_client_info['montant_paye'];

            // Mise à jour du montant total de la caisse
            $bdd->query("UPDATE caisse SET Montant_total_caisse = Montant_total_caisse - $montant_total WHERE statut = 'on'");

            $delete->delete_data('DELETE FROM paiement_client WHERE id_paie_client = :id_paie_client', [
                ':id_paie_client' => $id_paie_client
        ]);
            //stockage du message dans la session
            $_SESSION['success_message'] = "Suppression réussie";
        // Redirection après suppression réussie
        header('Location: liste_paiement_client.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

</body>
</html>



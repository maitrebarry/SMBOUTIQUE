
<?php
require_once('autoload.php');
$delete = new CommandeClient();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id_depense = $_GET['id'];

    // Supprimer la commande_client
    try {
             // Récupération du paiement
            $liste_depense = $bdd->query("SELECT * FROM depense WHERE id_depense = $id_depense");
            $depense = $liste_depense->fetch();
            $montant = $depense['montant'];
            // Mise à jour du montant total de la caisse
            $bdd->query("UPDATE caisse SET Montant_total_caisse = Montant_total_caisse+$montant WHERE statut = 'on'");

            $delete->delete_data('DELETE FROM depense WHERE id_depense = :id_depense', [
                ':id_depense' => $id_depense
        ]);
            //stockage du message dans la session
            $_SESSION['success_message'] = "Suppression réussie";
        // Redirection après suppression réussie
        header('Location: liste_depense_caisse.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

</body>
</html>




<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de commande client</title> -->
   
</head>
<body>

<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$delete = new CommandeFour();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id_commande_fournisseur = $_GET['id'];

    // Supprimer la commande_client
    try {
        $delete->delete_data('DELETE FROM commande_fournisseur WHERE id_commande_fournisseur = :id_commande_fournisseur', [
            ':id_commande_fournisseur' => $id_commande_fournisseur
        ]);
            //stockage du message dans la session
            $_SESSION['success_message'] = "Suppression réussie";
        // Redirection après suppression réussie
        header('Location: liste_commande_four.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

</body>
</html>

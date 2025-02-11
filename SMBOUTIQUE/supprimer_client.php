
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression du fournisseur</title> 
   
</head>
<body>

<?php
    require_once('rentrer_anormal.php') ;
    require_once('autoload.php');
    $delete=new Client();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
     $id_client_gr= $_GET['id'];

    // Supprimer le produit
    try {
        $delete->delete_data('DELETE FROM client_grossiste WHERE id_client_gr = :id_client_gr', [
            ':id_client_gr' => $id_client_gr
        ]);
            //stockage du message dans la session
            $_SESSION['success_message'] = "Suppression réussie";
        // Redirection après suppression réussie
        header('Location: liste_client_gr.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

</body>
</html>



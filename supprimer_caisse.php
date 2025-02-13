
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de la caisse</title> 
   
</head>
<body>

<?php
    require_once('rentrer_anormal.php') ;
    require_once('autoload.php');
    $delete=new CommandeClient();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
     $id_caisse= $_GET['id'];

    // Supprimer la caisse
    try {
        $delete->delete_data('DELETE FROM caisse WHERE id_caisse = :id_caisse', [
            ':id_caisse' => $id_caisse
        ]);
            //stockage du message dans la session
            $_SESSION['success_message'] = "Suppression réussie";
        // Redirection après suppression réussie
        header('Location: liste_caisse.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

</body>
</html>



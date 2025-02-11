
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression du l'unité</title> 
   
</head>
<body>

<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$delete=new Client();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
     $id_unite= $_GET['id'];

    // Supprimer l'unite
    try {
        $delete->delete_data('DELETE FROM unite WHERE id_unite = :id_unite', [
            ':id_unite' => $id_unite
        ]);
            //stockage du message dans la session
            $_SESSION['success_message'] = "Suppression réussie";
        // Redirection après suppression réussie
        header('Location: liste_unite.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

</body>
</html>



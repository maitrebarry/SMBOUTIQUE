
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression du fournisseur</title> 
   
</head>
<body>

<?php
require_once('autoload.php');
$delete=new Fournisseur();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
     $id_fournisseur= $_GET['id'];

    // Supprimer le fournisseur
    try {
        $delete->delete_data('DELETE FROM fournisseur WHERE id_fournisseur = :id_fournisseur', [
            ':id_fournisseur' => $id_fournisseur
        ]);
            
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

</body>
</html>



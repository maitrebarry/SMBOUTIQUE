
<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$delete = new Produit();

// Vérifie si la suppression a été confirmée
if (isset($_GET['id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    $id= $_GET['id'];

    // Supprimer le produit
    try {
        $delete->delete_data('DELETE FROM tbl_product WHERE id = :id', [
            ':id' => $id
        ]);
            //stockage du message dans la session
            $_SESSION['success_message'] = "Suppression réussie";
        // Redirection après suppression réussie
        header('Location: liste_produit.php?success=1');
        exit();
    } catch (PDOException $e) {
        echo 'Erreur de suppression : ' . $e->getMessage();
    }
}
?>

</body>
</html>



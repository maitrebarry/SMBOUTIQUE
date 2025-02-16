<?php
require_once ('partials/database.php');
require_once('function/function.php');
if (isset($_FILES['newAvatar']) && !empty($_FILES['newAvatar']['name'])) {
    $avatar = $_FILES['newAvatar']['name'];
    $taillemax = 2097152; // 2 MO
    $extensionsvalides = array('jpg', 'jpeg', 'gif', 'png');
    // Valider la taille du fichier 
    if ($_FILES['newAvatar']['size'] <= $taillemax) {
        // Valider l'extension du fichier
        $extensionUpload = strtolower(pathinfo($avatar, PATHINFO_EXTENSION));
        if (in_array($extensionUpload, $extensionsvalides)) {
            // Spécifiez le répertoire de destination pour enregistrer l'image
            $uploadDirectory = "user/";
            // Générez un nouveau nom de fichier unique
            $newFileName = uniqid() . "_" . $avatar;
            // Chemin complet pour enregistrer le fichier
            $uploadFilePath = $uploadDirectory . $newFileName;
            
            // Déplacez le fichier téléchargé vers le répertoire de destination
            if (move_uploaded_file($_FILES['newAvatar']['tmp_name'], $uploadFilePath)) {
                // Mettez à jour le nom du fichier dans la base de données
                $userId = $_SESSION['id_utilisateur'];
                $updateavatar = $bdd->prepare('UPDATE utilisateur SET avatar = :avatar WHERE id_utilisateur = :id_utilisateur');
                $updateavatar->execute(array(':avatar' => $newFileName, ':id_utilisateur' => $userId));

                if ($updateavatar) {
                    // Redirection avec un message de succès
                     afficher_message("Image modifiée avec succès", "success");
                    header('LOCATION: users-profile.php?success=1');
                    exit();
                } else {
                    // Erreur lors de la mise à jour de la base de données
                    echo "Erreur lors de la mise à jour de votre photo de profil dans la base de données.";
                }
            } else {
                // Erreur lors du téléchargement du fichier
                echo "Erreur lors du téléchargement du fichier.";
            }
        } else {
            // Extension de fichier non valide
            echo "Votre photo de profil doit être au format jpg, jpeg, gif, png.";
        }
    } else {
        // Taille de fichier dépassée
        echo "Votre photo de profil ne doit pas dépasser 2 MO.";
    }
} else {
    // Aucun fichier sélectionné
    echo "Veuillez sélectionner un fichier.";
}
 
?>

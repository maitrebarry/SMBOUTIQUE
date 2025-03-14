<?php
require_once('partials/database.php');
require_once('function/function.php');
 // Vérifiez si l'utilisateur est connecté et 'id_utilisateur' est défini
    if (!isset($_SESSION['id_utilisateur'])) {
        // Gérez le cas où 'id_utilisateur' n'est pas défini 
            header('Location:index.php');
    }else{
    
        $utilisateur= $_SESSION['id_utilisateur'];
    }
    $modifier = recuperation_fonction('*', 'utilisateur WHERE id_utilisateur=?', [$_SESSION['id_utilisateur']]);
    $errors = [];

    // Vérifier si le formulaire a été soumis
    if (isset($_POST['change'])) {
        // Vérifier si les champs du formulaire sont vides
        if (empty($_POST['ancien_motdepasse']) || empty($_POST['new_mot_de_passe']) || empty($_POST['confirm_mot_de_passe'])) {
            $errors[] = 'Veuillez remplir tous les champs';
        } else {
            // Récupérer les données du formulaire
            $ancien_motdepasse = $_POST['ancien_motdepasse'];
            // var_dump($ancien_motdepasse);exit;
            $new_mot_de_passe = $_POST['new_mot_de_passe'];
            $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'];
            
            // Vérifier la longueur minimale du nouveau mot de passe
            if (!mot_de_passe_longueur_verification($new_mot_de_passe)) {
                $errors[] = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
            }

            // Vérifier la présence de caractères alphanumériques dans le nouveau mot de passe
            if (!mot_de_passe_alphanumerique_verification($new_mot_de_passe)) {
                $errors[] = "Le nouveau mot de passe  doit contenir des caractères alphanumériques.";
            }

            // Vérifier la présence de caractères spéciaux dans le nouveau mot de passe
            if (!mot_de_passe_special_verification($new_mot_de_passe)) {
                $errors[] = "Le nouveau mot de passe doit contenir au moins un caractère spécial.";
            }

            // Vérifier si le nouveau mot de passe correspond à la confirmation
            if ($new_mot_de_passe !== $confirm_mot_de_passe) {
                $errors[] ='Les deux nouveaux mots de passe ne correspondent pas';
            }

            // Vérifier si le mot de passe actuel correspond au mot de passe stocké en base de données
            if ($ancien_motdepasse !== $modifier->mot_de_passe_utilisateur) {
                // var_dump($modifier->mot_de_passe_utilisateur);exit;
                $errors[] ='Ancien mot de passe incorrect';
            }

            // Si aucune erreur n'est détectée, mettre à jour le mot de passe dans la base de données
            if (count($errors) == 0) {
                $modifie = $bdd->prepare("UPDATE utilisateur SET mot_de_passe_utilisateur=? WHERE id_utilisateur=? LIMIT 1");
                $modifie->execute(array($confirm_mot_de_passe, $_SESSION['id_utilisateur'])); 
                afficher_message('Mot de passe changé avec succès', 'success');
                redirecte2('users-profile.php');
            }
        }
    }




    // Requête pour les commandes fournisseurs
    $commandesFournisseurQuery = "SELECT COUNT(*) AS total FROM commande_fournisseur WHERE id_utilisateur = :user_id";
    $commandesFournisseurStmt = $bdd->prepare($commandesFournisseurQuery);
    $commandesFournisseurStmt->execute(['user_id' => $utilisateur]);
    $commandesFournisseur = $commandesFournisseurStmt->fetch(PDO::FETCH_OBJ)->total;

    // Requête pour les ventes en crédit
    $ventesCreditQuery = "SELECT COUNT(*) AS total FROM commande_client WHERE id_utilisateur = :user_id";
    $ventesCreditStmt = $bdd->prepare($ventesCreditQuery);
    $ventesCreditStmt->execute(['user_id' => $utilisateur]);
    $ventesCredit = $ventesCreditStmt->fetch(PDO::FETCH_OBJ)->total;

    // Requête pour les ventes en direct
    $ventesDirectQuery = "SELECT COUNT(*) AS total FROM vente WHERE id_utilisateur = :user_id";
    $ventesDirectStmt = $bdd->prepare($ventesDirectQuery);
    $ventesDirectStmt->execute(['user_id' => $utilisateur]);
    $ventesDirect = $ventesDirectStmt->fetch(PDO::FETCH_OBJ)->total;

    // Requête pour les enregistrements d'inventaire
    $inventaireQuery = "SELECT COUNT(*) AS total FROM inventaire WHERE id_utilisateur = :user_id";
    $inventaireStmt = $bdd->prepare($inventaireQuery);
    $inventaireStmt->execute(['user_id' => $utilisateur]);
    $inventaire = $inventaireStmt->fetch(PDO::FETCH_OBJ)->total;

    // Requête pour les enregistrements de produits
    // $enregistrementProduitsQuery = "SELECT COUNT(*) AS total FROM tbl_product WHERE id_utilisateur = :user_id";
    // $enregistrementProduitsStmt = $bdd->prepare($enregistrementProduitsQuery);
    // $enregistrementProduitsStmt->execute(['user_id' => $utilisateur]);
    // $enregistrementProduits = $enregistrementProduitsStmt->fetch(PDO::FETCH_OBJ)->total;
  


?>

<?php require_once('view/users-profile.view.php')?>

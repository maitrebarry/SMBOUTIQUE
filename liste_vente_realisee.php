<!-- lien  du base de donnee  -->
   <?php
    require_once ('partials/database.php');
    require_once('function/function.php');
    $errors=[];
    if(isset($_POST['enregistrer'])){
        if(verification(["nom_utilisateur","prenom_utilisateur","Contact_utilisateur","email","psedeau_utilisateur","mot_de_passe_utilisateur",
       "mot_de_passe_confirm", "adress","type_utilisateur"])){
          extract($_POST);

            
        if(user_verify("psedeau_utilisateur","utilisateur",$psedeau_utilisateur)){
            $errors[]="Ce pseudo existe déja";
            garder_valeur_input();
        }
        if($mot_de_passe_confirm!==$mot_de_passe_utilisateur){
            $errors[]="Les deux mot de passe ne sont pas identique";
             garder_valeur_input();
        }
          
        if(telephone_numero_verification($Contact_utilisateur)){
            $errors[]=telephone_numero_verification($Contact_utilisateur);
        }
   
        if(user_verify("Contact_utilisateur","utilisateur",$Contact_utilisateur)){
            $errors[]="Ce numero est  déja utilisé";
             garder_valeur_input();
        }
    // $avatar=$_FILES['avatar']['name'];
    $avatar=$_FILES['avatar']['name'];
        if (isset($_FILES['avatar'])) {
            if (isset($_FILES['avatar']) AND !empty($_FILES ['avatar']['name'])) {
                $avatar=$_FILES['avatar']['name'];
                $taillemax= 2067152;
                $extentionValide= array('jpeg','jpg','png','gif');
                if ($_FILES['avatar']['size']<=$taillemax) {
                    $extentionUpload= strtolower(substr(strrchr($_FILES['avatar']['name'] , '.'), 1));
                    if (in_array($extentionUpload, $extentionValide)) {
                        $chemins= "user/".$avatar;
                        $resultat= move_uploaded_file($_FILES['avatar']['tmp_name'], $chemins);
                        if ($resultat) {
                             //insertion d'avatar qui sera fait avec les infos de l'utilisateur
                        }
                    }else {
                        $errors[]= "la photo doit etre en png ou jpeg ";
                         garder_valeur_input();
                    }
                }else {
                    $errors[]= "la photo ne correspond pas";
                     garder_valeur_input();
                }
            }
            // $chemin= "user/".$avatar;
            // $resultat= move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
   }
   if(count($errors)==0){
    $insertion=Insertion_and_update("INSERT INTO utilisateur
    (nom_utilisateur,prenom_utilisateur,Contact_utilisateur,
    email,psedeau_utilisateur, mot_de_passe_utilisateur,adresse,avatar,type_utilisateur)
     VALUES(:nom_utilisateur,:prenom_utilisateur,:Contact_utilisateur,:email,:psedeau_utilisateur,
            :mot_de_passe_utilisateur,:adresse,:avatar,:type_utilisateur)",
                      [
                       ":nom_utilisateur"=>$nom_utilisateur,
                       ":prenom_utilisateur"=>$prenom_utilisateur,
                       ":Contact_utilisateur"=>$Contact_utilisateur,
                       ":email"=>$email,
                       ":psedeau_utilisateur"=>$psedeau_utilisateur,
                       ":mot_de_passe_utilisateur"=>$mot_de_passe_utilisateur,
                       ":adresse"=>$adress,
                       ":avatar"=>$avatar,
                       "type_utilisateur"=>$type_utilisateur]);
                       
                       if($insertion===true){
                        //    echo "l'insertion faite avec succèes";
                         destruction_session_input();
                         afficher_message("insertion faite avec succèes","success");
                       }
                    }
            } else{
            $errors[]="L'un des champs est vide";
        }
}

// noveau pour l'avatar
 // Traitement de l'avatar
if (isset($_FILES['avatar']) && is_uploaded_file($_FILES['avatar']['tmp_name'])) {
    $taillemax = 2067152; // 2 Mo en octets
    $extensionsValides = array('jpeg', 'jpg', 'png', 'gif');
    // Obtenir l'extension du fichier
    $extensionUpload = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION)); 
    if ($_FILES['avatar']['size'] <= $taillemax && in_array($extensionUpload, $extensionsValides)) {
        // Chemin de destination pour enregistrer l'avatar
        $nom_fichier = $_FILES['avatar']['name']; 
        $chemin = "user/" . $nom_fichier;

        // Déplacer le fichier téléchargé vers son emplacement final
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin)) {
            // L'upload du fichier est réussi
            // Stocker le chemin complet de l'avatar
            $nom_avatar = $chemin;
        } else {
            // Gérer les erreurs d'upload
            afficher_message("Une erreur est survenue lors du téléchargement du fichier.");
        }

    } else {
        if ($_FILES['avatar']['size'] > $taillemax) {
            afficher_message("La taille du fichier dépasse la limite autorisée.");
        } else {
            afficher_message("La photo doit être au format JPEG, JPG, PNG ou GIF.");
        }
    }
}
  
    ?>
          
           
 <!-- lien entre creer utilisateur et creer.utilisateur.view -->
 <?php require_once ('view/creer_utilisateur.view.php') ?>
 
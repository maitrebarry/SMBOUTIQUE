<?php
  
    require_once('autoload.php');
    $utilisateur=new Fournisseur();
    require_once('function/function.php');
// Vérification de la soumission du formulaire
// if (isset($_POST['enregistrer'])) {
//    extract($_POST);
//     if ($utilisateur->verification(["nom_utilisateur", "prenom_utilisateur", "Contact_utilisateur", "email", "psedeau_utilisateur", "mot_de_passe_utilisateur",
//         "mot_de_passe_confirm", "adress", "type_utilisateur"])) {
//         extract($_POST);
         
//         // Validation  pour s'assurer que le nom ne contient que des lettres
//         if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $prenom_utilisateur)) {
//             $utilisateur->errors[] = "Le prenom ne doit contenir que des lettres.";
//             $utilisateur->garder_valeur_input();
//         }
//          // Validation  pour s'assurer que le nom ne contient que des lettres
//         if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nom_utilisateur)) {
//             $utilisateur->errors[] = "Le nom ne doit contenir que des lettres.";
//             $utilisateur->garder_valeur_input();
//         }
        
//         if ($utilisateur->user_verify("psedeau_utilisateur", "utilisateur", $psedeau_utilisateur)) {
//                   $utilisateur->errors[]="Ce pseudo existe déjà";
//                   $utilisateur->garder_valeur_input();
//             }
//              $resultat_verification = $utilisateur->telephone_numero_verification($Contact_utilisateur);
//         if ($resultat_verification !== "Numéro de téléphone valide") {
//             // Si la vérification échoue, vous pouvez ajouter une erreur et conserver la valeur d'entrée
//             $utilisateur->errors[] = $resultat_verification;
//             $utilisateur->garder_valeur_input();
//         }
//         // if ($erreur_telephone = $utilisateur->telephone_numero_verification($Contact_utilisateur)) {
//                 // Si la vérification échoue, $erreur_telephone contiendra le message d'erreur
//             //     $utilisateur->errors[]=$erreur_telephone;
//             //     $utilisateur->garder_valeur_input();    
//             // }

//         if($utilisateur->user_verify("Contact_utilisateur","utilisateur",$Contact_utilisateur)){
//            $utilisateur->errors[]="Ce contact existe déja veuillez choisir un autre";
//              $utilisateur->garder_valeur_input();  
           
//         } 
//         if ($erreur_mot_passe = $utilisateur->mot_de_passe_longueur_verification($mot_de_passe_utilisateur)) {
//             // Si la vérification échoue
//             $utilisateur->errors[]=$erreur_mot_passe;
//             $utilisateur->garder_valeur_input();    
//         }
//         if ($erreur_mot_passe_alh_num = $utilisateur->mot_de_passe_alphanumerique_verification($mot_de_passe_utilisateur)) {
//             // Si la vérification échoue
//             $utilisateur->errors[]=$erreur_mot_passe_alh_num;
//             $utilisateur->garder_valeur_input();    
//         }
//          if ($erreur_mot_passe_special_veri = $utilisateur->mot_de_passe_special_verification($mot_de_passe_utilisateur)) {
//             // Si la vérification échoue
//             $utilisateur->errors[]=$erreur_mot_passe_special_veri;
//             $utilisateur->garder_valeur_input();    
//         }
//         if ($mot_de_passe_confirm !== $mot_de_passe_utilisateur) {
//                  $utilisateur->errors[]="Les deux mots de passe ne sont pas identiques";
//                 garder_valeur_input();
//         }
//         // $avatar=$_FILES['avatar']['name'];
//          $avatar=$_FILES['avatar']['name'];
//         if (isset($_FILES['avatar'])) {
//             if (isset($_FILES['avatar']) AND !empty($_FILES ['avatar']['name'])) {
//                 $avatar=$_FILES['avatar']['name'];
//                 $taillemax= 2067152;
//                 $extentionValide= array('jpeg','jpg','png','gif');
//                 if ($_FILES['avatar']['size']<=$taillemax) {
//                     $extentionUpload= strtolower(substr(strrchr($_FILES['avatar']['name'] , '.'), 1));
//                     if (in_array($extentionUpload, $extentionValide)) {
//                         $chemins= "user/".$avatar;
//                         $resultat= move_uploaded_file($_FILES['avatar']['tmp_name'], $chemins);
//                         if ($resultat) {
//                              //insertion d'avatar qui sera fait avec les infos de l'utilisateur
//                         }
//                     }else {
//                         $utilisateur->errors[]= "la photo doit etre en png ou jpeg ";
//                     }
//                 }else {
//                    $utilisateur-> errors[]= "la photo ne correspond pas";
//                 }
//             }
//             // $chemin= "user/".$avatar;
//             // $resultat= move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
//         }
//              if(count($utilisateur->errors)==0){
//                  $password_cripte=sha1($mot_de_passe_utilisateur);
//             $insertion = Insertion_and_update("INSERT INTO utilisateur
//             (nom_utilisateur, prenom_utilisateur, Contact_utilisateur,
//             email, psedeau_utilisateur, mot_de_passe_utilisateur, adresse, avatar, type_utilisateur)
//             VALUES(:nom_utilisateur, :prenom_utilisateur, :Contact_utilisateur, :email, :psedeau_utilisateur,
//                     :mot_de_passe_utilisateur, :adresse, :avatar, :type_utilisateur)",
//                 [
//                     ":nom_utilisateur" => $nom_utilisateur,
//                     ":prenom_utilisateur" => $prenom_utilisateur,
//                     ":Contact_utilisateur" => $Contact_utilisateur,
//                     ":email" => $email,
//                     ":psedeau_utilisateur" => $psedeau_utilisateur,
//                     ":mot_de_passe_utilisateur" => $password_cripte,
//                     ":adresse" => $adress,
//                     ":avatar" => $avatar, // Utilisation du chemin complet de l'avatar
//                     ":type_utilisateur" => $type_utilisateur
//                 ]);


//             if ($insertion === true) {
//                $utilisateur->destruction_session_input();
//                 afficher_message("Insertion faite avec succès", "success");
//                  $utilisateur->redirecte2('creer_utilisateur.php');
//             }
//         }
//     } else {
//        $utilisateur->errors[]="L'un des champs est vide";
//     }
// }

if (isset($_POST['enregistrer'])) {
    extract($_POST);
    if ($utilisateur->verification(["nom_utilisateur", "prenom_utilisateur", "Contact_utilisateur", "email", "psedeau_utilisateur", "mot_de_passe_utilisateur", "mot_de_passe_confirm", "adress", "type_utilisateur"])) {
        extract($_POST);
        
        // Validation  pour s'assurer que le nom ne contient que des lettres
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $prenom_utilisateur)) {
            $utilisateur->errors[] = "Le prenom ne doit contenir que des lettres.";
            $utilisateur->garder_valeur_input();
        }
        
        // Validation  pour s'assurer que le nom ne contient que des lettres
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nom_utilisateur)) {
            $utilisateur->errors[] = "Le nom ne doit contenir que des lettres.";
            $utilisateur->garder_valeur_input();
        }
        
        if ($utilisateur->user_verify("psedeau_utilisateur", "utilisateur", $psedeau_utilisateur)) {
            $utilisateur->errors[] = "Ce pseudo existe déjà";
            $utilisateur->garder_valeur_input();
        }

        // Nettoyage du numéro de téléphone pour supprimer les espaces
        $cleaned_contact = str_replace(' ', '', $Contact_utilisateur);
        
        $resultat_verification = $utilisateur->telephone_numero_verification($cleaned_contact);
        if ($resultat_verification !== "Numéro de téléphone valide") {
            // Si la vérification échoue, vous pouvez ajouter une erreur et conserver la valeur d'entrée
            $utilisateur->errors[] = $resultat_verification;
            $utilisateur->garder_valeur_input();
        }

        if ($utilisateur->user_verify("Contact_utilisateur", "utilisateur", $cleaned_contact)) {
            $utilisateur->errors[] = "Ce contact existe déjà, veuillez choisir un autre";
            $utilisateur->garder_valeur_input();
        }
        
        if ($erreur_mot_passe = $utilisateur->mot_de_passe_longueur_verification($mot_de_passe_utilisateur)) {
            // Si la vérification échoue
            $utilisateur->errors[] = $erreur_mot_passe;
            $utilisateur->garder_valeur_input();
        }
        
        if ($erreur_mot_passe_alh_num = $utilisateur->mot_de_passe_alphanumerique_verification($mot_de_passe_utilisateur)) {
            // Si la vérification échoue
            $utilisateur->errors[] = $erreur_mot_passe_alh_num;
            $utilisateur->garder_valeur_input();
        }
        
        if ($erreur_mot_passe_special_veri = $utilisateur->mot_de_passe_special_verification($mot_de_passe_utilisateur)) {
            // Si la vérification échoue
            $utilisateur->errors[] = $erreur_mot_passe_special_veri;
            $utilisateur->garder_valeur_input();
        }
        
        if ($mot_de_passe_confirm !== $mot_de_passe_utilisateur) {
            $utilisateur->errors[] = "Les deux mots de passe ne sont pas identiques";
            $utilisateur->garder_valeur_input();
        }

        $avatar = $_FILES['avatar']['name'];
        if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
            $taillemax = 2067152;
            $extentionValide = array('jpeg', 'jpg', 'png', 'gif');
            if ($_FILES['avatar']['size'] <= $taillemax) {
                $extentionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                if (in_array($extentionUpload, $extentionValide)) {
                    $chemins = "user/" . $avatar;
                    $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemins);
                    if ($resultat) {
                        // insertion d'avatar qui sera fait avec les infos de l'utilisateur
                    }
                } else {
                    $utilisateur->errors[] = "La photo doit être en png ou jpeg ";
                }
            } else {
                $utilisateur->errors[] = "La photo ne correspond pas";
            }
        }

        if (count($utilisateur->errors) == 0) {
            $password_cripte = sha1($mot_de_passe_utilisateur);
            $insertion = Insertion_and_update("INSERT INTO utilisateur (nom_utilisateur, prenom_utilisateur, Contact_utilisateur, email, psedeau_utilisateur, mot_de_passe_utilisateur, adresse, avatar, type_utilisateur)
                                               VALUES (:nom_utilisateur, :prenom_utilisateur, :Contact_utilisateur, :email, :psedeau_utilisateur, :mot_de_passe_utilisateur, :adresse, :avatar, :type_utilisateur)",
                                               [
                                                   ":nom_utilisateur" => $nom_utilisateur,
                                                   ":prenom_utilisateur" => $prenom_utilisateur,
                                                   ":Contact_utilisateur" => $cleaned_contact,
                                                   ":email" => $email,
                                                   ":psedeau_utilisateur" => $psedeau_utilisateur,
                                                   ":mot_de_passe_utilisateur" => $password_cripte,
                                                   ":adresse" => $adress,
                                                   ":avatar" => $avatar, // Utilisation du chemin complet de l'avatar
                                                   ":type_utilisateur" => $type_utilisateur
                                               ]);

            if ($insertion === true) {
                $utilisateur->destruction_session_input();
                afficher_message("Insertion faite avec succès", "success");
                $utilisateur->redirecte2('creer_utilisateur.php');
            }
        }
    } else {
        $utilisateur->errors[] = "L'un des champs est vide";
    }
}



?>

<!-- lien entre creer utilisateur et creer.utilisateur.view -->
<?php require_once('view/creer_utilisateur.view.php') ?>
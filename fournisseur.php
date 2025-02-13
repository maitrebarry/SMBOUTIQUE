<?php
    require_once('rentrer_anormal.php') ;
    require_once('autoload.php');
    $fournisseur=new Fournisseur();
    require_once('function/function.php');


    if(isset($_POST['Sauvegarder'])){
        if($fournisseur->verification(['nom',"prenom","ville_ou_quartier","contact"])){
            extract($_POST);

            // Validation  pour s'assurer que le nom ne contient que des lettres
            if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nom)) {
                $fournisseur->errors[] = "Le nom ne doit contenir que des lettres.";
                $fournisseur->garder_valeur_input();
            }

            // Validation  pour s'assurer que le prénom ne contient que des lettres
            if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $prenom)) {
                $fournisseur->errors[] = "Le prénom ne doit contenir que des lettres.";
                $fournisseur->garder_valeur_input();
            }

            // Validation  pour s'assurer que la ville ne contient que des lettres
            if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $ville_ou_quartier)) {
                $fournisseur->errors[] = "La ville ou le quartier ne doit contenir que des lettres.";
                $fournisseur->garder_valeur_input();
            }

            // Nettoyage du numéro de téléphone pour supprimer les espaces
            $cleaned_contact = str_replace(' ', '', $contact);

            $resultat_verification = $fournisseur->telephone_numero_verification($cleaned_contact);
            if ($resultat_verification !== "Numéro de téléphone valide") {
                // Si la vérification échoue, vous pouvez ajouter une erreur et conserver la valeur d'entrée
                $fournisseur->errors[] = $resultat_verification;
                $fournisseur->garder_valeur_input();
            }
            
            if($fournisseur->user_verify("contact_fournisseur","fournisseur",$cleaned_contact)){
                $fournisseur->errors[]="Ce contact existe déjà veuillez choisir un autre";
                $fournisseur->garder_valeur_input();
            } 
            
            if(count($fournisseur->errors)==0){
                $fournisseur->insertion_data("INSERT INTO fournisseur (prenom_fournisseur,nom_fournisseur,contact_fournisseur,ville_fournisseur)
                values(:nom_fournisseur,:prenom_fournisseur,:contact_fournisseur,:ville_fournisseur)",
                [':prenom_fournisseur'=>$prenom,
                ':nom_fournisseur'=>$nom,
                ':ville_fournisseur'=>$ville_ou_quartier,
                ':contact_fournisseur'=>$cleaned_contact]);
            }
        } else {
            $fournisseur->errors[]="L'un des champs est vide"; 
        }
    }



require_once ('view/fournisseur.view.php');
?>
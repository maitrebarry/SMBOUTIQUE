<?php
 
require_once('autoload.php');
$client=new Client();
if(isset($_POST['Sauvegarder'])){
    if($client->verification(['nom',"prenom","ville_ou_quartier","contact"])){
        extract($_POST);
        
        // Validation  pour s'assurer que le nom ne contient que des lettres
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nom)) {
            $client->errors[] = "Le nom ne doit contenir que des lettres.";
            $client->garder_valeur_input();
        }

        // Validation  pour s'assurer que le prénom ne contient que des lettres
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $prenom)) {
            $client->errors[] = "Le prénom ne doit contenir que des lettres.";
            $client->garder_valeur_input();
        }

        // Validation  pour s'assurer que la ville ne contient que des lettres
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $ville_ou_quartier)) {
            $client->errors[] = "La ville ou le quartier ne doit contenir que des lettres.";
            $client->garder_valeur_input();
        }
        $resultat_verification = $client->telephone_numero_verification($contact);
        if ($resultat_verification !== "Numéro de téléphone valide") {
            // Si la vérification échoue, vous pouvez ajouter une erreur et conserver la valeur d'entrée
            $client->errors[] = $resultat_verification;
            $client->garder_valeur_input();
        }
        //  if ($client->telephone_numero_verification($contact)) {
        //     $client->errors[]="Veuillez revoir le numero de telephone donné";  
        //       $client->garder_valeur_input();
        // }
         if($client->user_verify("contact_client_grossiste","client_grossiste",$contact)){
           $client->errors[]="Ce contact existe déja veuillez choisir un autre";
             $client->garder_valeur_input();
        } 
        if(count($client->errors)==0){
        $client->insertion_data("INSERT INTO 
        client_grossiste (nom_client_grossiste,prenom_du_client_grossiste,ville_client_grossiste,contact_client_grossiste)
             values(:nom_client_grossiste,:prenom_du_client_grossiste,:ville_client_grossiste,:contact_client_grossiste)",
            [':nom_client_grossiste'=>$nom,
                ':prenom_du_client_grossiste'=>$prenom,
                ':ville_client_grossiste'=>$ville_ou_quartier,
                ':contact_client_grossiste'=>$contact]);
        }
    }else{
            
              $client->errors[]="L'un des champs est vide";
          
    }
   
}



	
	
	
	


?>
<?php require_once ('view/client.view.php') ?>
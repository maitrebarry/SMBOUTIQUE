
<?php
    require_once('rentrer_anormal.php') ;
    require_once('autoload.php');
     $boutique=new CommandeFour();
    if (isset($_POST['enregistrer'])) {
        // echo "okkkkkk";exit;
         if($boutique->verification(["nom","quartier"])) {
        // Extraire les valeurs des champs POST dans des variables distinctes
        extract($_POST);
        $nom = ucfirst(trim($_POST['nom'])); // Mettre la première lettre du nom en majuscule et supprimer les espaces inutiles
        $quartier = $_POST['quartier']; 

         if($boutique->user_verify("nom","boutique",$nom)){
           $boutique->errors[]="Ce nom existe déja veuillez choisir un autre";
            $boutique->garder_valeur_input();
        }
       
        if(count($boutique->errors)==0){
            // Préparer la requête d'insertion pour l'boutique
            $boutique ->Insertion_data('INSERT INTO boutique (nom,quartier ) 
            VALUES (:nom,:quartier)',
            [":nom"=>$nom, "quartier"=>$quartier]);     
        }}else{         
            $boutique->errors[]="L'un des champs est vide";
            $boutique->garder_valeur_input();
    }

}

     require_once('view/boutique.view.php') 
?>
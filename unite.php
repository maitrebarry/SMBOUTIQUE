
<?php
    require_once('autoload.php');
     $unite=new CommandeClient();
    // require_once('function/function.php');
    if (isset($_POST['enregistrer'])) {
        // echo "okkkkkk";exit;
         if($unite->verification(["libelle","symbole"])) {
        // Extraire les valeurs des champs POST dans des variables distinctes
        extract($_POST);
        $libelle = ucfirst(trim($_POST['libelle'])); // Mettre la première lettre du nom en majuscule et supprimer les espaces inutiles
        $symbole = $_POST['symbole']; 

         if($unite->user_verify("libelle","unite",$libelle)){
           $unite->errors[]="Ce libelle existe déja veuillez choisir un autre";
            $unite->garder_valeur_input();
        }
        if($unite->user_verify("symbole", "unite",$symbole )){
           $unite->errors[]="Ce symbole existe déja veuillez choisir un autre";
            $unite->garder_valeur_input();
        }
        if(count($unite->errors)==0){
            // Préparer la requête d'insertion pour l'unite
            $unite ->Insertion_data('INSERT INTO unite (libelle,symbole ) 
            VALUES (:libelle,:symbole)',
            [":libelle"=>$libelle, "symbole"=>$symbole]);     
        }}else{         
            $unite->errors[]="L'un des champs est vide";
            $unite->garder_valeur_input();
    }
}

     require_once('view/unite.view.php') 
?>
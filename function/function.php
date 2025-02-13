<?php 

if(!function_exists('user_verify')){
    function  user_verify($fields,$table,$value){
        global $bdd;
        $user_fetch=$bdd->prepare("SELECT * from $table where $fields=?");
        $user_fetch->execute([$value]);
        $nombre=$user_fetch->rowCount();
        $user_fetch->closeCursor();
        return $nombre;
    }
}
//Insertion,modification,suppresson
function Insertion_and_update($value,$fields=[],$lastInsertId=null){
    global $bdd;
    $insertUpdate=$bdd->prepare($value);
   $valide= $insertUpdate->execute($fields);
    if(isset($lastInsertId)){
        return $bdd->lastInsertId();
    }else{
        return $valide;
    }
}
//insertion,modification,suppression pour image
    function Insertion_and_update1($value, $fields = [], $lastInsertId = null) {
        global $bdd;
        $insertUpdate = $bdd->prepare($value);
        $valide = $insertUpdate->execute($fields);
        if (isset($lastInsertId)) {
            return $bdd->lastInsertId();
        } else {
            return $valide;
        }
    }



// verifier si un champ est vide
if(!function_exists("verification")){
    function verification($champs=[]){
        if(count($champs)>0){
            foreach ($champs as $champ) {
                if (empty($_POST[$champ]) || trim($_POST[$champ])==="") {
                    return false;
                }
            }
            return true;
        }
    }
}

// verifier les caracteres d'un numero de telephone
if(!function_exists("telephone_numero_verification")){
    function telephone_numero_verification($valeur){

        if (!is_numeric($valeur) || strlen($valeur)<8 || strlen($valeur)>8 ){
           return "Veuillez revoir le numero de telephone donné <br>";
        }
    }
}

//verification du code barre
if (!function_exists("code_barre_verification")) {
    function code_barre_verification($valeur){
        // Vérifier si la valeur est numérique et si sa longueur est conforme à la norme EAN-13 (13 chiffres)
        if (!is_numeric($valeur) || strlen($valeur) != 13) {
            return "Le code-barres doit contenir 13 chiffres numériques.<br>";
        }
    }
}

// compter un caractere
if(!function_exists("compter_caractere")){
    function compter_caractere($valeur,int $valeur_comparer){
        if (strlen($valeur) < $valeur_comparer ){
            echo "La valeur donnée doit etre superieur ou egale à  $valeur_comparer <br>";
        }
    }
}
// verifier si un element est numerique
if(!function_exists("numerique_verification")){
    function numerique_verification($valeur){
        if (!is_numeric($valeur) || $valeur>=0){
            echo "Cette veleur doit etre uniquement des nombres <br>";
        }
    }
}
// recuperer et afficher 
if(!function_exists("recuperation_fonction")){
    function recuperation_fonction($select_partie,$tables,$data=[], $all=null){
       global $bdd;
        $monFetch=$bdd->prepare("select $select_partie from $tables");
        $monFetch->execute($data);
        if(isset($all) and $all==="all"|| $all==="All" || $all==="ALL" ||
         $all==="aLL"||$all==="ALl"|| $all==="AlL"){
           return $monFetch->fetchAll(PDO::FETCH_OBJ);
         }else{
           return $monFetch->fetch(PDO::FETCH_OBJ);
         }
    }
}




// la redirection
if(!function_exists('redirecte')){
    function redirecte($page,$dossier=null) {
        if(isset($dossier)){
            header("LOCATION:$dossier/$page.php");
        }else{
            header("LOCATION:$page.php");
        } 
    }
}
// garder la valeur dans input
if(!function_exists('garder_valeur_input')){
    function garder_valeur_input(){
        foreach ($_POST  AS $key => $value) {
            if(strpos($key,"mot_de_passe")===false){
                $_SESSION['input'][$key]=$value;
            }
        }
    }
}
// recuperer la valeur gardee dans input
if(!function_exists('get_valeur_input')){
    function get_valeur_input($key){
       return !empty( $_SESSION['input'][$key])
        ? $_SESSION['input'][$key]
         :null;
    }
}
//
//    function select_fetch_simple($select,$table,$data=[],$fethType=null){
//         global  $bdd;
//         $insertUpdate=$bdd->prepare("SELECT $select FROM $table");
//          $insertUpdate->execute($data);
//          if($fethType=="All"||$fethType=="all"){
//              return $insertUpdate->fetchAll(PDO::FETCH_OBJ);
//          }else{
//             return $insertUpdate->fetch(PDO::FETCH_OBJ);
//          }
//     }
//afficher message
if(!function_exists("afficher_message")){
    function afficher_message($message,$type="danger"){
        $_SESSION["notification"]["message"]=$message;
        $_SESSION["notification"]["type"]=$type;
    }
}
//detruire la session
if (!function_exists("destruction_session_input")) {
     function destruction_session_input(){
        return $_SESSION["input"]=[];

    }
}
    // la redirection 2
 function redirecte2($url) {
    header("Location: $url");
    exit();
}

// Vérification de la longueur minimale du mot de passe
if (!function_exists("mot_de_passe_longueur_verification")) {
    function mot_de_passe_longueur_verification($mot_de_passe) {
        if (strlen($mot_de_passe) >= 8) {
            return true; // Longueur du mot de passe conforme
        } else {
            return false; // Longueur du mot de passe insuffisante
        }
    }
}

// Vérification de la présence de caractères alphanumériques
if (!function_exists("mot_de_passe_alphanumerique_verification")) {
    function mot_de_passe_alphanumerique_verification($mot_de_passe) {
        if (preg_match("/[a-zA-Z]/", $mot_de_passe) && preg_match("/[0-9]/", $mot_de_passe)) {
            return true; // Caractères alphanumériques présents
        } else {
            return false; // Caractères alphanumériques absents
        }
    }
}

// Vérification de la présence de caractères spéciaux
if (!function_exists("mot_de_passe_special_verification")) {
    function mot_de_passe_special_verification($mot_de_passe) {
        if (preg_match("/[^a-zA-Z0-9]/", $mot_de_passe)) {
            return true; // Caractères spéciaux présents
        } else {
            return false; // Caractères spéciaux absents
        }
    }
}


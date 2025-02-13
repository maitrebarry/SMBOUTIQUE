<?php 
//   session_start();
class Fonction{
   
            PRIVATE $DB_HOST;
            PRIVATE $DB_NAME;
            PRIVATE $DB_USERNAME;
            PRIVATE $DB_PASSWORD;
        public function database(){
           
            $this->DB_HOST="127.0.0.1";
            $this->DB_NAME="db_supermarche";
            $this->DB_USERNAME="root";
            $this->DB_PASSWORD='';
           
             $bdd=new PDO("mysql:host=".$this->DB_HOST.";dbname=". $this->DB_NAME,
            $this->DB_USERNAME  ,$this->DB_PASSWORD);
            return $bdd;
        }
    // verifier l'existance d'une chose
   public function  user_verify($fields,$table,$value){
         $bdd=$this->database();
        $user_fetch=$bdd->prepare("SELECT * from $table where $fields=?");
        $user_fetch->execute([$value]);
        $nombre=$user_fetch->rowCount();
        $user_fetch->closeCursor();
        return $nombre;
    }

    //Insertion,modification,suppresson
    public function Insertion_and_update($value, $fields = [], $lastInsertId = null){
        try {
            $bdd = $this->database();
            $insertUpdate = $bdd->prepare($value);

            // Affiche la requête SQL générée pour le débogage
            // echo "Requête SQL : " . $value . PHP_EOL;

            $valide = $insertUpdate->execute($fields);

            if(isset($lastInsertId)){
                return $bdd->lastInsertId();
            } else {
                return $valide;
            }
        } catch (PDOException $e) {
            // Affiche l'erreur détaillée en cas d'échec
            echo "Erreur lors de l'exécution de la requête : " . $e->getMessage() . PHP_EOL;
            return false;
        }
    }
      

// verifier si un champ est vide

    public function verification($champs=[]){
        if(count($champs)>0){
            foreach ($champs as $champ) {
                if (empty($_POST[$champ]) || trim($_POST[$champ])==="") {
                    return false;
                }
            }
            return true;
        }
    }

   public function telephone_numero_verification($valeur) {
    // Vérification de la longueur du numéro de téléphone
    if (!is_numeric($valeur) || strlen($valeur) != 8) {
        return "Veuillez revoir le numéro de téléphone donné";
    }

    // Vérification du premier chiffre
    $premier_chiffre = substr($valeur, 0, 1);
    if (!in_array($premier_chiffre, range(4, 10))) {
        return "Le premier chiffre du numéro de téléphone doit être compris entre 4 et 10";
    }

    // Le numéro de téléphone semble valide
    return "Numéro de téléphone valide";
}



//verification du code barre

    public function code_barre_verification($valeur){
        if (!is_numeric($valeur) || strlen($valeur) != 13) {
            return "Le code-barres doit contenir 13 chiffres numériques.<br>";
        }
    }

// compter un caractere

 public function compter_caractere($valeur,int $valeur_comparer){
        if (strlen($valeur) < $valeur_comparer ){
            echo "La valeur donnée doit etre superieur ou egale à  $valeur_comparer <br>";
        }
    }

// verifier si un element est numerique

  public function numerique_verification($valeur){
        if (!is_numeric($valeur) || $valeur>=0){
            echo "Cette veleur doit etre uniquement des nombres <br>";
        }
    }

// recuperer et afficher 

   public function  recuperation_fonction($select_partie,$tables,$data=[], $all=null){
      $bdd=$this->database();
        $monFetch=$bdd->prepare("select $select_partie from $tables");
        $monFetch->execute($data);
        if(isset($all) and $all==="all"|| $all==="All" || $all==="ALL" ||
         $all==="aLL"||$all==="ALl"|| $all==="AlL"){
           return $monFetch->fetchAll(PDO::FETCH_OBJ);
         }else{
           return $monFetch->fetch(PDO::FETCH_OBJ);
         }
    }
    //recuperer et afficher avec tri
    public function recuperation_fonction_tri($select_partie, $tables, $data = [], $all = null){
        $bdd = $this->database();
        $requete = "SELECT $select_partie FROM $tables";
        $monFetch = $bdd->prepare($requete);
        $monFetch->execute($data); // Utilise les valeurs de $data pour la requête préparée
        if(isset($all) && in_array(strtolower($all), ["all", "al"])) {
            return $monFetch->fetchAll(PDO::FETCH_OBJ);
        } else {
            return $monFetch->fetch(PDO::FETCH_OBJ);
        }
    }
public function recuperation_fonction_join($select_partie, $tables, $data = [], $all = null) {
    $bdd = $this->database();
    
    if (empty($select_partie) || empty($tables)) {
        throw new Exception('Les paramètres de sélection et de table ne peuvent pas être vides.');
    }
    
    $monFetch = $bdd->prepare("SELECT $select_partie FROM $tables");
    $monFetch->execute($data);

    if (strtolower($all) === 'all') {
        return $monFetch->fetchAll(PDO::FETCH_OBJ);
    } else {
        return $monFetch->fetch(PDO::FETCH_OBJ);
    }
}

// la redirection

    public function redirecte($page,$dossier=null) {
        if(isset($dossier)){
            header("LOCATION:$dossier/$page.php");
        }else{
            header("LOCATION:$page.php");
        } 
    }

// la redirection 2
public function redirecte2($url) {
    header("Location: $url");
    exit();
}


// garder la valeur dans input

   public function  garder_valeur_input(){
        foreach ($_POST  AS $key => $value) {
            if(strpos($key,"mot_de_passe")===false){
                $_SESSION['input'][$key]=$value;
            }
        }
    }

// recuperer la valeur gardee dans input

   public function  get_valeur_input($key){
       return !empty( $_SESSION['input'][$key])
        ? $_SESSION['input'][$key]
         :null;
    }
    public function afficher_message($message,$type="danger"){
        $_SESSION["notification"]["message"]=$message;
        $_SESSION["notification"]["type"]=$type;
    }
    //detruire session
    public function destruction_session_input(){
        return $_SESSION["input"]=[];

    }

    // Vérification de la longueur minimale du mot de passe
    public function mot_de_passe_longueur_verification($mot_de_passe) {
        if (strlen($mot_de_passe) < 8) {
            return "Le mot de passe doit contenir au moins 8 caractères.<br>";
        }
    }
    // Vérification de la présence de caractères alphanumériques
    public function mot_de_passe_alphanumerique_verification($mot_de_passe) {      
        if (!preg_match("/[a-zA-Z]/", $mot_de_passe) || !preg_match("/[0-9]/", $mot_de_passe)) {
            return "Le mot de passe doit contenir à la fois des lettres et des chiffres.<br>";
        }
    }
    // Vérification de la présence de caractères spéciaux
    public function mot_de_passe_special_verification($mot_de_passe) {
        if (!preg_match("/[^a-zA-Z0-9]/", $mot_de_passe)) {
            return "Le mot de passe doit contenir au moins un caractère spécial.<br>";
        }
    }
}

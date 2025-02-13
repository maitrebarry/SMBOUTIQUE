<?php 
// class CommandeFour extends Fonction{
//     public $errors=[];
   
     
//     //  recuperer et afficher la liste des receptions
//       public function list(){
//             $recuperer_afficher=$this->recuperation_fonction("*"," reception JOIN commande_fournisseur 
//             ON commande_fournisseur.id_commande_fournisseur=reception.id_commande_fournisseur JOIN fournisseur 
//             ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY id_reception DESC",[],"all");
//             return $recuperer_afficher;
//          }

// //  recuperer et afficher la liste des COMMANDES
//     //   public function list1(){
//     //         $recuperer_afficher_cmnd_fou=$this->recuperation_fonction("*","commande_fournisseur  JOIN fournisseur 
//     //         ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY id_commande_fournisseur DESC",[],"all");
//     //         return $recuperer_afficher_cmnd_fou;
//     //      }
// //recuperer et afficher la liste des commandes par tri
// public function listRecentCommands($limit){
//     $recuperer_afficher_cmnd_recentes = $this->recuperation_fonction_tri("*", "commande_fournisseur JOIN fournisseur 
//             ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY date_de_commande DESC LIMIT $limit", [], "all");
//     return $recuperer_afficher_cmnd_recentes;
// }


// //  recuperer et afficher la liste des paiements
//       public function list2(){
//             $recuperer_afficher_list_paie=$this->recuperation_fonction("*","paiement INNER JOIN commande_fournisseur 
//             ON commande_fournisseur.id_commande_fournisseur=paiement.id_commande_fournisseur
//             INNER JOIN fournisseur ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY id_paiement DESC",[],"all");
//             return $recuperer_afficher_list_paie;
//          }

// //recuperer et afficher le mouvement

         
//          //modification seulement
//     public function update_data($value, $fields = [], $lastInsertId = null){
//     $update = $this->Insertion_and_update($value, $fields, $lastInsertId);
    
    
// }
//    //suppression seulement
//     public function delete_data($value, $fields = [], $lastInsertId = null){
//     $delete = $this->Insertion_and_update($value, $fields, $lastInsertId);
             
//     }

//     // pour la Boutique

//       //insertion seulement
//     public function insertion_data($value,$fields=[],$lastInsertId=null){
//         $insertion=$this->Insertion_and_update($value,$fields,$lastInsertId);
//         if($insertion===true){
//                 $this->destruction_session_input();
//                 $this->afficher_message("Boutique ajouté  avec succès","success");
//                 $this->redirecte2('boutique.php');
//                 //  $this->redirecte2('Location: fournisseur.php');
//             }
//     }
//      //recuperer et afficher la liste des boutique
//         public function list_boutique(){
//             $recuperer_afficher_boutique=$this->recuperation_fonction("*","boutique  ORDER BY id_boutique DESC",[],"all");
//             return $recuperer_afficher_boutique;
//         }
// }





class CommandeFour extends Fonction {
    public $errors = [];

    // Méthode pour récupérer et afficher la liste des réceptions
    public function list() {
        return $this->recuperation_fonction("*", "reception JOIN commande_fournisseur ON commande_fournisseur.id_commande_fournisseur=reception.id_commande_fournisseur JOIN fournisseur ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY id_reception DESC", [], "all");
    }

    // Méthode pour récupérer et afficher la liste des commandes récentes par tri
    public function listRecentCommands($limit) {
        return $this->recuperation_fonction_tri("*", "commande_fournisseur JOIN fournisseur ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY date_de_commande DESC LIMIT $limit", [], "all");
    }

    // Méthode pour récupérer et afficher la liste des paiements
    public function list2() {
        return $this->recuperation_fonction("*", "paiement INNER JOIN commande_fournisseur ON commande_fournisseur.id_commande_fournisseur=paiement.id_commande_fournisseur INNER JOIN fournisseur ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY id_paiement DESC", [], "all");
    }

    // Méthode de modification
    public function update_data($value, $fields = [], $lastInsertId = null) {
        $this->Insertion_and_update($value, $fields, $lastInsertId);
    }

    // Méthode de suppression
    public function delete_data($value, $fields = [], $lastInsertId = null) {
        $this->Insertion_and_update($value, $fields, $lastInsertId);
    }

    // Pour la boutique : méthode d'insertion
    public function insertion_data($value, $fields = [], $lastInsertId = null) {
        $insertion = $this->Insertion_and_update($value, $fields, $lastInsertId);
        if ($insertion === true) {
            $this->destruction_session_input();
            $this->afficher_message("Boutique ajoutée avec succès", "success");
            $this->redirecte2('boutique.php');
        }
    }

    // Méthode pour récupérer et afficher la liste des boutiques
    public function list_boutique() {
        return $this->recuperation_fonction("*", "boutique ORDER BY id_boutique DESC", [], "all");
    }

    // Méthode de vérification d'un utilisateur
    public function user_verify($field, $table, $value, $id = null) {
        $bdd = $this->database(); // Utilisation de la méthode database pour obtenir la connexion PDO
        $query = "SELECT COUNT(*) FROM $table WHERE $field = :value";
        $params = [':value' => $value];
        if ($id !== null) {
            $query .= " AND id_utilisateur != :id";
            $params[':id'] = $id;
        }
        $stmt = $bdd->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    // Méthode de vérification du numéro de téléphone
    public function telephone_numero_verification($valeur) {
        if (!is_numeric($valeur) || strlen($valeur) != 8) {
            return "Veuillez revoir le numéro de téléphone donné";
        }
        $premier_chiffre = substr($valeur, 0, 1);
        if (!in_array($premier_chiffre, range(4, 9))) {
            return "Le premier chiffre du numéro de téléphone doit être compris entre 4 et 9";
        }
        return "Numéro de téléphone valide";
    }
}
?>

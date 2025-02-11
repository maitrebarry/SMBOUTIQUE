<?php 
class CommandeFour extends Fonction{
    public $errors=[];
   
     
    //  recuperer et afficher la liste des receptions
      public function list(){
            $recuperer_afficher=$this->recuperation_fonction("*"," reception JOIN commande_fournisseur 
            ON commande_fournisseur.id_commande_fournisseur=reception.id_commande_fournisseur JOIN fournisseur 
            ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY id_reception DESC",[],"all");
            return $recuperer_afficher;
         }

//  recuperer et afficher la liste des COMMANDES
    //   public function list1(){
    //         $recuperer_afficher_cmnd_fou=$this->recuperation_fonction("*","commande_fournisseur  JOIN fournisseur 
    //         ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY id_commande_fournisseur DESC",[],"all");
    //         return $recuperer_afficher_cmnd_fou;
    //      }
//recuperer et afficher la liste des commandes par tri
public function listRecentCommands($limit){
    $recuperer_afficher_cmnd_recentes = $this->recuperation_fonction_tri("*", "commande_fournisseur JOIN fournisseur 
            ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY date_de_commande DESC LIMIT $limit", [], "all");
    return $recuperer_afficher_cmnd_recentes;
}


//  recuperer et afficher la liste des paiements
      public function list2(){
            $recuperer_afficher_list_paie=$this->recuperation_fonction("*","paiement INNER JOIN commande_fournisseur 
            ON commande_fournisseur.id_commande_fournisseur=paiement.id_commande_fournisseur
            INNER JOIN fournisseur ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur ORDER BY id_paiement DESC",[],"all");
            return $recuperer_afficher_list_paie;
         }

//recuperer et afficher le mouvement

         
         //modification seulement
    public function update_data($value, $fields = [], $lastInsertId = null){
    $update = $this->Insertion_and_update($value, $fields, $lastInsertId);
    
    
}
   //suppression seulement
    public function delete_data($value, $fields = [], $lastInsertId = null){
    $delete = $this->Insertion_and_update($value, $fields, $lastInsertId);
             
    }

    // pour la Boutique

      //insertion seulement
    public function insertion_data($value,$fields=[],$lastInsertId=null){
        $insertion=$this->Insertion_and_update($value,$fields,$lastInsertId);
        if($insertion===true){
                $this->destruction_session_input();
                $this->afficher_message("Boutique ajouté  avec succès","success");
                $this->redirecte2('boutique.php');
                //  $this->redirecte2('Location: fournisseur.php');
            }
    }
     //recuperer et afficher la liste des boutique
        public function list_boutique(){
            $recuperer_afficher_boutique=$this->recuperation_fonction("*","boutique  ORDER BY id_boutique DESC",[],"all");
            return $recuperer_afficher_boutique;
        }
}





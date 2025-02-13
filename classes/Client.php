<?php 
class Client extends Fonction{
    public $errors=[];
    //insertion seulement
    public function insertion_data($value,$fields=[],$lastInsertId=null){
        $insertion=$this->Insertion_and_update($value,$fields,$lastInsertId);
        if($insertion===true){
                $this->destruction_session_input();
                $this->afficher_message("Client ajouté  avec succès","success");
                $this->redirecte2('client.php');
            }
    }
    
    //  recuperer et afficher dans un tableau
      public function list(){
            $recuperer_afficher=$this->recuperation_fonction("*","client_grossiste ORDER BY id_client_gr DESC",[],"all");
            return $recuperer_afficher;
         }
    //recuperation des donnees sur la table mouvement
    public function list1(){
            $recuperer_afficher_mvent=$this->recuperation_fonction("*"," mouvement JOIN tbl_product
         ON tbl_product.id=mouvement.id_produit  ORDER BY id_mvnt DESC",[],"all");
            return $recuperer_afficher_mvent;
         }
//recuperation des donnees sur la table utilisation_perte
    public function list2(){
            $recuperer_afficher_utili_perte=$this->recuperation_fonction("*"," utilisation_pertes JOIN tbl_product
         ON tbl_product.id=utilisation_pertes.id_article  ORDER BY id_utili_perte DESC",[],"all");
            return $recuperer_afficher_utili_perte;
         }
         //recuperation des donnees sur la table utilisateur
    public function list3(){
            $recuperer_afficher_utilisateur=$this->recuperation_fonction("*"," utilisateur ORDER BY id_utilisateur DESC",[],"all");
            return $recuperer_afficher_utilisateur;
         }
         
         //modification seulement
    public function update_data($value, $fields = [], $lastInsertId = null){
    $update = $this->Insertion_and_update($value, $fields, $lastInsertId);
    
    // if ($update === true) {
    //    $this->redirecte2('liste_client_gr.php');
    // } 
        // else {
        //     $this->afficher_message("Erreur lors de la modification", "error");
            // afficher des informations de débogage 
        //     echo "Erreur détaillée : " . $update;
        // }
}
   //suppression seulement
    public function delete_data($value, $fields = [], $lastInsertId = null){
    $delete = $this->Insertion_and_update($value, $fields, $lastInsertId);
            //  if ($delete === true) {
            //     //  $this->redirecte2('liste_client_gr.php');
            //  }  
    }

}





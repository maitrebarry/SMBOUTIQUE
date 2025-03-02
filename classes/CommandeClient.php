<?php 
class CommandeClient extends Fonction{
    public $errors=[];   
    //  recuperer et afficher la liste des livraisons
      public function list(){
            $recuperer_afficher=$this->recuperation_fonction("*","livraison JOIN commande_client ON commande_client.id_cmd_client=livraison.id_commande_client
            JOIN client_grossiste  ON client_grossiste.id_client_gr=commande_client.id_client_gr 
            ORDER BY id_livraison DESC",[],"all");
            return $recuperer_afficher;
         }
 

      public function listRecentCommands($limit){
      $recuperer_afficher_cmnd_recentes = $this->recuperation_fonction_tri("*", "commande_client JOIN client_grossiste 
       ON client_grossiste.id_client_gr=commande_client.id_client_gr
        JOIN utilisateur ON utilisateur.id_utilisateur=commande_client.id_utilisateur
        ORDER BY date_cmd_client DESC LIMIT $limit", [], "all");
      return $recuperer_afficher_cmnd_recentes;
      }
//  recuperer et afficher la liste des paiements
      public function list2(){
            $recuperer_afficher_list_paie=$this->recuperation_fonction("*","paiement_client JOIN commande_client
             ON commande_client.id_cmd_client=paiement_client.id_comnd_client
             JOIN client_grossiste  ON client_grossiste.id_client_gr=commande_client.id_client_gr
           ORDER BY id_paie_client DESC",[],"all");
            return $recuperer_afficher_list_paie;
         }
  
         //recuperer et afficher la liste des ventes realisees par tri
      public function listRecentVente($limit){
            $recuperer_afficher_vente = $this->recuperation_fonction_tri("*", "vente  
            JOIN utilisateur ON utilisateur.id_utilisateur=vente.id_utilisateur
            ORDER BY id_vente DESC LIMIT $limit", [], "all");
            return $recuperer_afficher_vente;
            }
      //  recuperer et afficher la liste des caisses
      public function list4(){
            $recuperer_afficher_caisse=$this->recuperation_fonction("*","caisse  ORDER BY id_caisse DESC",[],"all");
            return $recuperer_afficher_caisse;
         }
         //  recuperer et afficher la liste des depenses
      public function list5(){
            $recuperer_afficher_depense=$this->recuperation_fonction("*","depense  ORDER BY id_depense DESC",[],"all");
            return $recuperer_afficher_depense;
         }
         //modification seulement
      public function update_data($value, $fields = [], $lastInsertId = null){
            $update = $this->Insertion_and_update($value, $fields, $lastInsertId); 
            }
      //suppression seulement
      public function delete_data($value, $fields = [], $lastInsertId = null){
            $delete = $this->Insertion_and_update($value, $fields, $lastInsertId);             
            }

            // pour unites

              //insertion seulement
      public function insertion_data($value,$fields=[],$lastInsertId=null){
        $insertion=$this->Insertion_and_update($value,$fields,$lastInsertId);
            if($insertion===true){
                $this->destruction_session_input();
                $this->afficher_message("unité ajouté  avec succès","success");
                $this->redirecte2('unite.php');
                //  $this->redirecte2('Location: fournisseur.php');
            }
      }

      //recuperer et afficher la liste des unites
      public function list_unite(){
            $recuperer_afficher_unite=$this->recuperation_fonction("*","unite  ORDER BY id_unite DESC",[],"all");
            return $recuperer_afficher_unite;
         }

}





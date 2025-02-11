<?php 
class Produit extends Fonction{
    public $errors=[];
    //insertion seulement
    public function insertion_data($value,$fields=[],$lastInsertId=null){
        $insertion=$this->Insertion_and_update($value,$fields,$lastInsertId);
        if($insertion===true){
                 $this->destruction_session_input();
                 $this->afficher_message("Produit  ajouté  avec succès","success");
                 $this->redirecte2('stock_produit.php');
            }
    }
    
        //  recuperer et afficher dans un tableau
        public function list(){
                $recuperer_afficher=$this->recuperation_fonction("*","tbl_product ORDER BY id DESC",[],"all");
                return $recuperer_afficher;
        }
                //  recuperer et afficher le supermarche
                public function list3(){
                    $recuperer_afficher=$this->recuperation_fonction("*","boutique ORDER BY id_boutique DESC",[],"all");
                    return $recuperer_afficher;
            }
        // recuperation et afficher inventaire et ligne inventaire
        public function list2(){
            $recuperer_afficher_inventaire=$this->recuperation_fonction("*","inventaire
                JOIN ligne_inventaire ON inventaire.id_inventaire = ligne_inventaire.id_inventaire
                JOIN tbl_product ON ligne_inventaire.id_produit = tbl_product.id
                JOIN utilisateur ON inventaire.id_utilisateur = utilisateur.id_utilisateur
                ORDER BY inventaire.id_inventaire DESC",
                [],
                 "all");
            return $recuperer_afficher_inventaire;
        }
        // recuperation et afficher inventaire
        public function list1(){
            $recuperer_afficher_inventaire = $this->recuperation_fonction(
                "*",  "inventaire 
                JOIN utilisateur ON inventaire.id_utilisateur = utilisateur.id_utilisateur
                ORDER BY inventaire.id_inventaire DESC",  [],  "all"    );

            // Retourner les données récupérées
            return $recuperer_afficher_inventaire;
        }

         //modification seulement
    public function update_data($value, $fields = [], $lastInsertId = null){
    $update = $this->Insertion_and_update($value, $fields, $lastInsertId);
    
    // if ($update === true) {
    //    $this->redirecte2('liste_produit.php');
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
             if ($delete === true) {
                 $this->redirecte2('liste_produit.php');
             }  
    }

}





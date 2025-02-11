<?php 
class Fournisseur extends Fonction{
    public $errors=[];
    //insertion seulement
   
public function insertion_data($value, $fields = [], $lastInsertId = null)
{
    $insertion = $this->Insertion_and_update($value, $fields, $lastInsertId);
    if ($insertion === true) {
        $this->destruction_session_input();
        $this->afficher_message("fournisseur ajouté avec succès", "success");
        // Redirection après le message de succès
        $this->redirecte2('fournisseur.php');
    }
}

    //  recuperer et afficher dans un tableau
      public function list(){
            $recuperer_afficher=$this->recuperation_fonction("*","fournisseur ORDER BY id_fournisseur DESC",[],"all");
            return $recuperer_afficher;
         }
         
    //  recuperer et afficher dans un tableau
      public function list1(){
            $recuperer_superadmin=$this->recuperation_fonction("*",'utilisateur WHERE type_utilisateur IN("Administrateur","utilisateur")',[],"all");
            return $recuperer_superadmin;
         }
         //  recuperer et afficher dans un tableau
      public function list2(){
            $recuperer_admin=$this->recuperation_fonction("*",'utilisateur WHERE type_utilisateur IN("Administrateur","utilisateur")',[],"all");
            return $recuperer_admin;
         }
         //modification seulement
    public function update_data($value, $fields = [], $lastInsertId = null){
    $update = $this->Insertion_and_update($value, $fields, $lastInsertId);
    
    // if ($update === true) {
    //       $this->afficher_message("Modification effectuée avec succès!","success");
    //       $this->redirecte2('liste_fournisseur.php');
    // } 
        // else {
        //     $this->afficher_message("Erreur lors de la modification", "error");
            // afficher des informations de débogage 
        //     echo "Erreur détaillée : " . $update;
        // }
}
   //modification seulement l'utilisateur
    public function update_utilisateur($value, $fields = [], $lastInsertId = null){
    $update = $this->Insertion_and_update($value, $fields, $lastInsertId);
    
    if ($update === true) {
          $this->redirecte2(' liste_utilisateur.php');
    } 
        
}

   //suppression seulement
    public function delete_data($value, $fields = [], $lastInsertId = null){
    $delete = $this->Insertion_and_update($value, $fields, $lastInsertId);
             if ($delete === true) {
                 $this->redirecte2('liste_fournisseur.php');
             }  
    }

}





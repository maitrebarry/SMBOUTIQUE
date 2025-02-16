<?php
//unset($_SESSION['pseudo']);
 require_once('autoload.php');
$produit=new Produit();
if(isset($_POST['enregistrer'])){
    if($produit->verification(["nom","marque","prix_detail","alerte","boutique","unite"])){
        extract($_POST);
        // var_dump($_POST);exit();
        if(count($produit->errors)==0){
        $produit->Insertion_data("INSERT INTO tbl_product(name,marque_produit,price,prix_detail,alerte_article,id_boutique,id_unite)
             values(:name,:marque_produit,:price,:prix_detail,:alerte_article,:id_boutique,:id_unite)",
            [':name'=>$nom,
            ':marque_produit'=>$marque,
             ':price'=>$prix_achat,
            ':prix_detail'=>$prix_detail,
            ':alerte_article'=>$alerte,
            ':id_boutique'=>$boutique,
            ':id_unite'=>$unite]);
        }
    }else{
          
           $produit->errors[]="L'un des champs est vide";
            $produit->garder_valeur_input();
    }
   
}
 ?>
<?php require_once('view/stock_produit.view.php') ?>

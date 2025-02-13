<?php
  require_once('rentrer_anormal.php') ;
  require_once('partials/database.php');
?>
<?php 
    if (isset($_GET['detail'])) {
        $detail=$_GET['detail'];
        $reception=$bdd->query("SELECT * FROM reception INNER JOIN commande_fournisseur 
        ON commande_fournisseur.id_commande_fournisseur=reception.id_commande_fournisseur
        INNER JOIN fournisseur ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur 
        WHERE id_reception=$detail LIMIT 1");
        $receptioninfo=$reception->fetch();
        $id_commande=$receptioninfo['id_commande_fournisseur'];
        //afficher la ligne de reception
         $ligen_recept=$bdd->query("SELECT * FROM ligne_reception INNER JOIN tbl_product
         ON tbl_product.id=ligne_reception.id_produit WHERE ligne_reception.id_reception=$detail");
        //afficher la ligne de commande
         $ligen_commande=$bdd->query("SELECT * FROM ligne_commande INNER JOIN tbl_product
         ON tbl_product.id=ligne_commande.id WHERE ligne_commande.id_commande_fournisseur=$id_commande");
         
  }
    require_once ('view/detail_reception_four.view.php');
  ?>
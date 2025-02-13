<?php
  require_once('rentrer_anormal.php') ;
  require_once('partials/database.php');
?>
  <?php 
    if (isset($_GET['detail'])) {
        $detail=$_GET['detail'];
        $commande=$bdd->query("SELECT * FROM commande_fournisseur INNER JOIN fournisseur 
        ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur WHERE id_commande_fournisseur=$detail LIMIT 1");
        $commandeinfo=$commande->fetch();
        //afficher la ligne de commande
        $ligen_commande=$bdd->query("SELECT * FROM ligne_commande INNER JOIN tbl_product
        ON tbl_product.id=ligne_commande.id WHERE ligne_commande.id_commande_fournisseur=$detail" );
         
       
    }
        require_once ('view/detail_com_four.view.php');
  ?>
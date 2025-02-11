<?php
  require_once('rentrer_anormal.php') ;
  require_once('partials/database.php');
?>
  <?php 
    if (isset($_GET['detail'])) {
        $detail=$_GET['detail'];
        $commande=$bdd->query("SELECT * FROM commande_client  WHERE id_cmd_client=$detail LIMIT 1");
        $commandeinfo=$commande->fetch();
        //afficher la ligne de commande
        $ligen_commande=$bdd->query("SELECT * FROM ligne_commande_client INNER JOIN tbl_product
        ON tbl_product.id=ligne_commande_client.id_produit WHERE ligne_commande_client.id_cmd_client=$detail " );
         
       
    }
        require_once ('view/detail_com_client.view.php');
  ?>
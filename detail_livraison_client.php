<?php
  require_once('partials/database.php');
?>
<?php 
    if (isset($_GET['detail'])) {
        $detail=$_GET['detail'];
        $livraison=$bdd->query("SELECT * FROM livraison INNER JOIN commande_client 
        ON commande_client.id_cmd_client=livraison.id_commande_client
        JOIN client_grossiste  ON client_grossiste.id_client_gr=commande_client.id_client_gr
        WHERE id_livraison=$detail LIMIT 1");
        $livraisoninfo=$livraison->fetch();
        $id_commande=$livraisoninfo['id_cmd_client'];
        //afficher la ligne de livraison
         $ligen_livrai=$bdd->query("SELECT * FROM ligne_livraison INNER JOIN tbl_product
         ON tbl_product.id=ligne_livraison.id_produit WHERE ligne_livraison.id_livraison=$detail");
        //afficher la ligne de commande
         $ligen_commande=$bdd->query("SELECT * FROM ligne_commande_client INNER JOIN tbl_product
         ON tbl_product.id=ligne_commande_client.id_produit WHERE ligne_commande_client.id_cmd_client=$id_commande");
         
  }
    require_once ('view/detail_livraison_client.view.php');
?>
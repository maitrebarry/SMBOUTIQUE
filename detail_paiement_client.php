<?php
  require_once('partials/database.php');
?>
<?php  
   if (isset($_GET['detail'])) {
        $detail=$_GET['detail'];
        $paiement=$bdd->query("SELECT * FROM paiement_client INNER JOIN commande_client
        ON commande_client.id_cmd_client=paiement_client.id_comnd_client
        INNER JOIN client_grossiste ON client_grossiste.id_client_gr=commande_client.id_client_gr
        WHERE id_paie_client=$detail LIMIT 1");
        $dpaie=$paiement->fetch();
      }

      
?>


<?php require_once ('view/detail_paiement_client.view.php')?>

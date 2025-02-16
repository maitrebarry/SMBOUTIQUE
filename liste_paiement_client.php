<?php
require_once('autoload.php');
$liste_paie_cl=new CommandeClient();
$recuperer_afficher_list_paie=$liste_paie_cl->list2();

?>
<?php require_once('view/liste_paiement_client.view.php') ?>
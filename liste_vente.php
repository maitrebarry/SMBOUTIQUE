<?php
require_once('autoload.php');
$liste_vente=new CommandeClient();
$recuperer_afficher_vente=$liste_vente->listRecentVente(10);

?>
<?php require_once('view/liste_vente.view.php') ?>
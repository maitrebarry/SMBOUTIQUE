<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
// $liste_cmnd_cl=new CommandeClient();
$liste_cmnd_cl = new CommandeClient();
// Récupère et affiche les 10 commandes les plus récentes
$liste_commandes_recentes = $liste_cmnd_cl->listRecentCommands(10); 

// $recuperer_afficher_cmnd_cl=$liste_cmnd_cl->list1();

?>
<?php require_once('view/liste_commande_client.view.php') ?>
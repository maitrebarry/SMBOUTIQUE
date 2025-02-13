<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$liste_cmnd_fou = new CommandeFour();
// $liste_cmnd_fou=new CommandeFour();
// $recuperer_afficher_cmnd_fou=$liste_cmnd_fou->list1();
$liste_commandes_recentes = $liste_cmnd_fou->listRecentCommands(5); // Récupère et affiche les 10 commandes les plus récentes

 require_once('view/liste_commande_four.view.php') ;

 
  ?>
 
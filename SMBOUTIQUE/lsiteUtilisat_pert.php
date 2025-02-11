<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$liste_utili_perte=new Client();
$recuperer_afficher_utili_perte=$liste_utili_perte->list2();

?>
<?php require_once('view/lsiteUtilisat_pert.view.php') ?>
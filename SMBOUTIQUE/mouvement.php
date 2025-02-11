<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$liste_mouvement=new Client();
$recuperer_afficher_mvent=$liste_mouvement->list1();

?>
<?php require_once('view/liste_mouvement.view.php') ?>
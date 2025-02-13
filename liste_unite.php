<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$liste_unite=new CommandeClient();
$recuperer_afficher_unite=$liste_unite->list_unite();

?>
<?php require_once('view/liste_unite.view.php') ?>
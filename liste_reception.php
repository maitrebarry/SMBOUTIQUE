<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$liste_recep=new CommandeFour();
$recuperer_liste_recep=$liste_recep->list();

?>
<?php require_once('view/liste_reception.view.php') ?>
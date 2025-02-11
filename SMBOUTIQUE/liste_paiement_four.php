<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$liste_paie_four=new CommandeFour();
$recuperer_afficher_list_paie=$liste_paie_four->list2();

?>
<?php require_once('view/liste_paiement_four.view.php') ?>
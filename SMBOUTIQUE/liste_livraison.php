<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$liste_livraison=new CommandeClient();
$recuperer_afficher=$liste_livraison->list();

?>
<?php require_once('view/liste_livraison.view.php') ?>
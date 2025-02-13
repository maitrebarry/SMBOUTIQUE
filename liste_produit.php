<?php
// require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$liste_produit=new Produit();
$recuperer_afficher=$liste_produit->list();

?>
<?php require_once('view/liste_produit.view.php')?>
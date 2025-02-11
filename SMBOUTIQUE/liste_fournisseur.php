<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
$liste_fournisseur=new Fournisseur();
$recuperer_afficher=$liste_fournisseur->list();


?>
<?php require_once('view/liste_fournisseur.view.php') ?>
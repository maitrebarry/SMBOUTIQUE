<?php
require_once('autoload.php');
$liste_utilisateur=new Fournisseur();
$recuperer_superadmin=$liste_utilisateur->list1();

$liste_utilisateur1=new Fournisseur();
$recuperer_admin=$liste_utilisateur1->list2();

?>
<?php require_once('view/lsiteUtilisateur.view.php') ?>
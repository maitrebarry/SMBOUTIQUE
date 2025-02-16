<?php
    require_once('autoload.php');
$liste_boutique=new CommandeFour();
$recuperer_afficher_boutique=$liste_boutique->list_boutique();

?>
<?php require_once('view/liste_boutique.view.php') ?>
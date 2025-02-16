²<?php
require_once('autoload.php');
$liste_caisse=new CommandeClient();
$recuperer_afficher=$liste_caisse->list4();

?>
<?php require_once('view/liste_caisse.view.php') ?>
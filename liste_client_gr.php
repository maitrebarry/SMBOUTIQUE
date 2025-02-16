<?php
require_once('autoload.php');
$liste_client=new Client();
$recuperer_afficher=$liste_client->list();

?>
<?php require_once('view/liste_client_gr.view.php') ?>
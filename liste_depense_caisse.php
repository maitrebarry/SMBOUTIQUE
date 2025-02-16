<?php
    require_once('autoload.php');
    $liste_caisse_depense=new CommandeClient();
    $recuperer_afficher_depense=$liste_caisse_depense->list5();

    require_once('view/liste_depense_caisse.view.php')
?>
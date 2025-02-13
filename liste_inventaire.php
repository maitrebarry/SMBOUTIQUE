
<?php 
    require_once('rentrer_anormal.php') ;
    require_once('autoload.php');
    $liste_inventaire=new Produit();
    $recuperer_afficher_liste_inventaire=$liste_inventaire->list1();

    require_once('view/liste_inventaire.view.php')
 ?>
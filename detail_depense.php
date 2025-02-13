<?php
    require_once('rentrer_anormal.php') ;
    require_once('autoload.php');
    //initialisation de la classe Fournisseur
    $detail=new CommandeClient();

    if (isset($_GET['detail'])) {
    $detail1 = $_GET['detail'];
    //recuperation des donnees dans les champs
    $recuperer=$detail->recuperation_fonction("*","depense WHERE id_depense=$detail1");


    }


    require_once ('view/detail_depense.view.php'); 
   
?>
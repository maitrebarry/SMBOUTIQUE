<?php
require_once('rentrer_anormal.php') ;
session_start();

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        if (isset($_GET["id"])) { // Modifié "ids" en "id"
            unset($_SESSION["shopping_cart"][$_GET["id"]]);
            // echo '<script>window.location="commande_client.php"</script>';
            echo 'Suppression réussie';
        }
    }
}
?>

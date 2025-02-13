<?php
require_once('autoload.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location:index.php');
    exit();
}
?>

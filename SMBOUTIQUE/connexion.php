<?php 
// Connexion à la base de données
$con =mysqli_connect("localhost","root","","db_supermarche");
//verifier la connexion
if(!$con) die('Erreur : '.mysqli_connect_error());



?>
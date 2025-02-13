<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
require_once('function/function.php');

if (isset($_POST['Sauvegarder'])) {
    if (!empty($_POST['date']) && !empty($_POST['reference']) && !empty($_POST['montant_initial'])) {
        // Extraire les valeurs des champs POST dans des variables distinctes
        extract($_POST);

        // Convertir la date au format attendu par la base de données (YYYY-MM-DD)
        $date = DateTime::createFromFormat('Y-m-d', $_POST['date']);
        $formattedDate = $date ? $date->format('Y-m-d') : null;

        $reference = $_POST['reference'];
        $montantInitial = $_POST['montant_initial']; 
        // Le montant initial devient également le montant total de la caisse
        $montantTotalCaisse = $montantInitial;

        // Statut par défaut
        $statut = 'on';

        // Vérifier si une caisse avec le statut 'on' existe déjà
        $existingCaisse = recuperation_fonction("id_caisse", "caisse WHERE statut='on'");

        if ($existingCaisse) {
            // Afficher un message d'erreur sous le champ statut
            afficher_message('La valeur du champ statut est déjà utilisée', 'danger');
        } else {
            // Préparer la requête d'insertion pour la caisse
            $insertCaisse = 'INSERT INTO caisse (date_caisse, montant_initial, montant_total_caisse, statut, reference_caisse) VALUES (?, ?, ?, ?, ?)';
            
            // Exécuter la fonction d'insertion
            $lastid = Insertion_and_update($insertCaisse, [$formattedDate, $montantInitial, $montantTotalCaisse, $statut, $reference], true);

            // Afficher un message de succès
            afficher_message('Caisse créée avec succès', 'success');
            header('Location: caisse.php');
            exit(); // Ajout d'une sortie après la redirection pour éviter l'exécution du code suivant accidentellement
        }
    }
}


require_once('view/caisse.view.php');
?>
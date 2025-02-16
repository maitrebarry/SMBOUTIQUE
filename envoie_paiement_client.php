<?php
require_once('partials/database.php');
require_once('function/function.php');

// Récupérer la référence de la caisse associée avec le statut "on"
$reference_caisse_query = "SELECT reference_caisse FROM caisse WHERE statut = 'on'";
$reference_caisse_result = $bdd->query($reference_caisse_query);
$reference_caisse = $reference_caisse_result->fetchColumn();

// Récupérer la référence de la caisse associée
//  $reference_caisse_obj = recuperation_fonction('reference_caisse', 'caisse', [], "ONE");

if ($reference_caisse) {
    // Requête pour calculer la somme des montants payés dans la table paiement_client
    $sumMontantPayeQuery = "SELECT SUM(montant_paye) AS total_montant_paye FROM paiement_client";
    $sumMontantPayeResult = $bdd->query($sumMontantPayeQuery);
    $sumMontantPaye = $sumMontantPayeResult->fetch(PDO::FETCH_OBJ);
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['id_commande_client']) and !empty($_POST['ref']) and !empty($_POST['map']) and !empty($_POST['dat']) and !empty($_POST['mr'])) {
        extract($_POST);

        $mont_a_paye = $_POST['map'];
        $mont_rest = $_POST['mr'];

        if ($mont_a_paye <= $mont_rest) {
            $paie = $commandeinfo['paie'];
            $new_paie = $paie + $map;

            // Effectuer le paiement
            $montant_paye = $map;
            $paie = $bdd->prepare('INSERT INTO paiement_client(id_comnd_client, montant_paye, date_paie, paie_reference, reference_caisse)
                VALUES(?,?,?,?,?)');
            $paie->execute(array($id_commande_client, $montant_paye, $dat, $ref, $reference_caisse));
            // Obtenir l'ID du dernier paiement inséré
            $id_paie_client = $bdd->lastInsertId();
            // Récupérer la somme actuelle dans la caisse
            $caisse_query = "SELECT Montant_total_caisse FROM caisse WHERE reference_caisse = :reference_caisse AND statut = 'on'";
            $caisse_statement = $bdd->prepare($caisse_query);
            $caisse_statement->bindParam(':reference_caisse', $reference_caisse, PDO::PARAM_STR);
            $caisse_statement->execute();
            $caisse_result = $caisse_statement->fetch(PDO::FETCH_ASSOC);
            $montant_caisse_actuel = $caisse_result['Montant_total_caisse'];

            // Ajouter la somme payée à la somme actuelle dans la caisse
            $nouveau_montant_caisse = $montant_caisse_actuel + $montant_paye;

            // Mettre à jour la somme dans la caisse
            $updateCaisseCommandeQuery = "UPDATE caisse SET Montant_total_caisse = :nouveau_montant_caisse WHERE reference_caisse = :reference_caisse AND statut = 'on'";
            $updateCaisseCommandeStatement = $bdd->prepare($updateCaisseCommandeQuery);
            $updateCaisseCommandeStatement->bindParam(':nouveau_montant_caisse', $nouveau_montant_caisse, PDO::PARAM_INT);
            $updateCaisseCommandeStatement->bindParam(':reference_caisse', $reference_caisse, PDO::PARAM_STR);
            $updateCaisseCommandeStatement->execute();

            // Pour la MISE À JOUR de la commande
            $update_cmd_paie = $bdd->query("UPDATE commande_client SET paie=$new_paie WHERE id_cmd_client=$id_commande_client");

            if ($paie && $update_cmd_paie) {
                header('location:liste_commande_client.php');
            }
        } else {
            afficher_message('Montant à payer doit être inférieur ou égal au montant restant');
        }
    }
}
?>

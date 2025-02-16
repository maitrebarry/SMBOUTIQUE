<?php
    require_once('partials/database.php');
    require_once('function/function.php');
    

    if (isset($_POST['enregistrer'])) {
        if (!empty($_POST['ref_caisse']) && !empty($_POST['libelle']) && isset($_POST['montant']) && !empty($_POST['date']) ) {
            extract($_POST);
            $reference_caisse = $_POST['ref_caisse'];
            $libelle=$_POST['libelle'];
            $montant=$_POST['montant'];
            $date=$_POST['date'];
             $note = !empty($_POST['note']) ? $_POST['note'] : '';
            
           
                 // Récupérer la somme actuelle dans la caisse
            $caisse_query = "SELECT Montant_total_caisse FROM caisse WHERE reference_caisse = :reference_caisse AND statut = 'on'";
            $caisse_statement = $bdd->prepare($caisse_query);
            $caisse_statement->bindParam(':reference_caisse', $reference_caisse, PDO::PARAM_STR);
            $caisse_statement->execute();
            $caisse_result = $caisse_statement->fetch(PDO::FETCH_ASSOC);
            $montant_caisse_actuel = $caisse_result['Montant_total_caisse'];

            // Vérifier si le montant alloué à la dépense est supérieur au montant actuel dans la caisse
            if ($montant > $montant_caisse_actuel) {
                afficher_message('Le montant alloué à la dépense ne peut pas être supérieur au montant actuel dans la caisse', 'danger');
            } else {
                // Ajouter le montant total de la vente à la somme actuelle dans la caisse
                $nouveau_montant_caisse = $montant_caisse_actuel - $montant;
                 // Préparer la requête d'insertion pour les depenses
                $insert_vente = 'INSERT INTO depense(reference_caisse,libelle,montant,date,note) VALUES(?,?,?,?,?)';
                //executer la fonction d'insertion
                $lastid = Insertion_and_update($insert_vente, [$reference_caisse, $libelle, $montant, $date,$note], true);
                 // Obtenir l'ID de la dernière vente insérée
                //  $id_vente = $bdd->lastInsertId();
            // Mettre à jour la somme dans la caisse
                $updateCaisseCommandeQuery = "UPDATE caisse SET Montant_total_caisse = :nouveau_montant_caisse WHERE reference_caisse = :reference_caisse AND statut = 'on'";
                $updateCaisseCommandeStatement = $bdd->prepare($updateCaisseCommandeQuery);
                $updateCaisseCommandeStatement->bindParam(':nouveau_montant_caisse', $nouveau_montant_caisse, PDO::PARAM_INT);
                $updateCaisseCommandeStatement->bindParam(':reference_caisse', $reference_caisse, PDO::PARAM_STR);
                $updateCaisseCommandeStatement->execute();
            if ($updateCaisseCommandeStatement) {
                afficher_message('Dépense créée avec succès', 'success');
                header('Location: depense.php');
                exit;
            }
        }
    }
}
    
?>
<?php require_once('view/depense.view.php')?>
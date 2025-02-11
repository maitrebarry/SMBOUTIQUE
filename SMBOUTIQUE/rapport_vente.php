<?php
    require_once('rentrer_anormal.php') ;
    require_once('partials/database.php');
    require_once('function/function.php');

function genererRapportJournalier() {
    global $bdd;

    // Exemple : Récupérer les ventes journalières de la base de données
    $query = "SELECT date_vente, montant_total FROM vente WHERE DATE(date_vente) = CURDATE()";
    $result = $bdd->query($query);
    $ventes = $result->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les données dans le HTML
    echo "<h2>Rapport Journalier</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Date</th><th>Montant Total</th></tr>";

    foreach ($ventes as $vente) {
        echo "<tr><td>{$vente['date_vente']}</td><td>{$vente['montant_total']} F CFA</td></tr>";
    }

    echo "</table>";
}

function genererRapportMensuel() {
    global $bdd;

    // Exemple : Récupérer les ventes mensuelles de la base de données
    $query = "SELECT DATE_FORMAT(date_vente, '%Y-%m') AS mois, SUM(montant_total) AS total_mensuel FROM vente GROUP BY mois";
    $result = $bdd->query($query);
    $ventes = $result->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les données dans le HTML
    echo "<h2>Rapport Mensuel</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Mois</th><th>Montant Total Mensuel</th></tr>";

    foreach ($ventes as $vente) {
        echo "<tr><td>{$vente['mois']}</td><td>{$vente['total_mensuel']} F CFA</td></tr>";
    }

    echo "</table>";
}

function genererRapportAnnuel() {
    global $bdd;

    // Exemple : Récupérer les ventes annuelles de la base de données
    $query = "SELECT YEAR(date_vente) AS annee, SUM(montant_total) AS total_annuel FROM vente GROUP BY annee";
    $result = $bdd->query($query);
    $ventes = $result->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les données dans le HTML
    echo "<h2>Rapport Annuel</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Année</th><th>Montant Total Annuel</th></tr>";

    foreach ($ventes as $vente) {
        echo "<tr><td>{$vente['annee']}</td><td>{$vente['total_annuel']} F CFA</td></tr>";
    }

    echo "</table>";
}

// Vérifier si le paramètre 'type' est défini dans l'URL
if (isset($_GET['type'])) {
    switch ($_GET['type']) {
        case 'journaliere':
            genererRapportJournalier();
            break;
        case 'mensuelle':
            genererRapportMensuel();
            break;
        case 'annuelle':
            genererRapportAnnuel();
            break;
        default:
            header('Location: page_d_erreur.php');
            //  Le type de rapport spécifié est invalide
            exit;
    }
} else {
    header('Location: page_d_erreur.php');
    exit;
}
?>

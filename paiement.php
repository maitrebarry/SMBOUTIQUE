<?php 
    require_once('partials/database.php'); ?>

<?php  
    // Vérifier si 'paiement' est défini dans les paramètres d'URL
    if (isset($_GET['paiement'])) {
        $paiement = $_GET['paiement'];
        
        // Récupérer les détails de la commande depuis la base de données 
        $commande = $bdd->query("SELECT * FROM commande_fournisseur INNER JOIN fournisseur 
            ON fournisseur.id_fournisseur = commande_fournisseur.id_fournisseur 
            WHERE id_commande_fournisseur = $paiement LIMIT 1");
        
        // Récupérer le résultat
        $commandeinfo = $commande->fetch();
    }
?>

<?php require_once('envoie_paiement.php'); ?>

<!-- En-tête -->
<?php require_once('partials/header.php'); ?>

<body>
    <!-- Barre latérale -->
    <?php require_once('partials/sidebar.php'); ?>

    <!-- Barre de navigation -->
    <?php require_once('partials/navbar.php'); ?>

    <!-- Contenu principal -->
     <?php $errors = []; $button_name='valider'?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                <li class="breadcrumb-item">Paiement fournisseur</li>
                <li class="breadcrumb-item active">paiement actuel</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Carte pour les informations de paiement -->
        <div class="card info-card sales-card">
            <?php require_once('partials/afficher_message.php'); ?>

            <div class="card-header">
                <div class="row">
                    <div class="col-4">
                        <h5 class="card-title">&emsp; Commande N° <?=$commandeinfo['reference']?></h5>
                    </div>
                    <div class="col-4">
                        <h5 class="card-title">&emsp; Fournisseur:
                            <?=$commandeinfo['nom_fournisseur'].' '.$commandeinfo['prenom_fournisseur']?>
                        </h5>
                    </div>
                    <div class="col-4">
                        <h5 class="card-title">&emsp; Fait le:
                            <?=date_format(date_create($commandeinfo['date_de_commande']), 'd-m-Y H:i:s') ?>
                        </h5>
                    </div>
                </div>
            </div>
            <!-- Formulaire de paiement -->
            <form action="" method="post">
                <section class="section mt-5">
                    <div class="row">
                        <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                   
                                    <table class="col-md-12 table table-bordered table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th>MONTANT TOTAL/CMD</th>
                                                <th>MONTANT PAYÉ</th>
                                                <th>MONTANT RESTANT</th>
                                                <th>MONTANT À PAYER</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="hidden" name="id_commande_four"
                                                value="<?=$commandeinfo['id_commande_fournisseur']?>">
                                            <tr>
                                                <div class="form-group">
                                                    <td>
                                                        <input class="form-control" type="text" name="mt"
                                                            value="<?=$commandeinfo['total']?>" readOnly>
                                                    </td>
                                                    <td><input class="form-control" type="texte" name="mp"
                                                            value="<?=$commandeinfo['paie']?>" readOnly></td>
                                                    <td><input class="form-control" type="number" name="mr"
                                                            value="<?=$commandeinfo['total']-$commandeinfo['paie']?>"
                                                            readOnly></td>
                                                    <td><input class="form-control" type="number" name="map"
                                                            value="<?=$commandeinfo['total']-$commandeinfo['paie']?>"
                                                            min="0">
                                                    </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Détails du paiement -->
                        <div class="col-xl-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Référence </label>
                                        <?php 
                                            // Génération d'un numéro de référence
                                            $nbr_paiement = "SELECT * FROM paiement";
                                            $nbr_paie = $bdd->query($nbr_paiement);
                                            $ressul = $nbr_paie->rowCount();
                                        ?>
                                        <input type="text" name="ref" class="form-control" id=""
                                            value="P-CF-<?=date(date('dmY'))?>-0<?=$ressul+1?>" readOnly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Date </label>
                                        <input type="datetime-local" name="dat" class="form-control" id="currentDateTime">
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-xl-4 col-md-10 col-xs-12 mt-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal" data-bs-target="#basicModal">Valider </button>
                                    <?php require_once('partials/confirmerEnregistrement.php');?>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-10 col-xs-12 mt-3">
                                <div class="form-group">
                                        <a href="liste_paiement_client.php" class="btn btn-info form-control"> Liste des paiements</a> 
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-10 col-xs-12 mt-3">
                                <div class="form-group">
                                    <a href="liste_commande_four.php"class="btn btn-success form-control">Liste des commandes</a>
                                </div>
                            </div>
                        </div>
                </section>
            </form>
        </div>
    </main><!-- Fin du #main -->

    <!-- Pied de page -->
    <?php require_once('partials/foot.php'); ?>
    <?php require_once('partials/footer.php'); ?>
            <script>
                // Obtenez la date et l'heure actuelles
                var currentDate = new Date();
                // Formatage de la date et l'heure en chaîne compatible avec datetime-local
                var formattedDateTime = currentDate.toISOString().slice(0, 16);
                // Définition de la valeur de l'élément datetime-local
                document.getElementById('currentDateTime').value = formattedDateTime;
            </script>
</body>

</html>

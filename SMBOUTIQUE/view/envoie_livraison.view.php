<?php
// Récupération des données de livraison si le paramètre 'livraison' est défini
if (isset($_GET['livraison'])) {
    $reception = $_GET['livraison'];
    $commande = $bdd->query("SELECT * FROM commande_client WHERE id_cmd_client=$reception LIMIT 1");
    $commandeinfo = $commande->fetch();
    // Afficher la ligne de commande
    $ligen_commande = $bdd->query("SELECT * FROM ligne_commande_client INNER JOIN tbl_product
    ON tbl_product.id=ligne_commande_client.id_produit WHERE ligne_commande_client.quantite>ligne_commande_client.qte_livre AND ligne_commande_client.id_cmd_client=$reception");
    $countLigne = $ligen_commande->rowCount();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <style>
        /* body.dark-theme {
            background-color: #2c3e50;
            color: #ecf0f1;
        }

       
        .card {
            background-color: #34495e;
            color: #ecf0f1;
        } */

        /* Styles spécifiques à la classe dark-theme */
        /* .dark-theme .card.info-card.sales-card {
            background-color: #2c3e50;
        }

        .dark-theme .card.text-left {
            background-color: #2c3e50;
        }

        .dark-theme .form-group label {
            color: #ecf0f1;
        }

        .dark-theme .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .dark-theme .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
            pour le card :style="background-color: #e6f7ff;"
        } */
    </style>
    <title>Envoie livraison</title>
</head>

<body class="dark-theme">
    <!-- Header -->
    <?php 
    require_once('partials/header.php') ?>

    <!-- Sidebar -->
    <?php require_once('partials/sidebar.php') ?>

    <!-- Navbar -->
    <?php require_once('partials/navbar.php') ?>

   <?php $errors = []; $button_name='valider'?>

    <!-- Contenu principal -->
    <main id="main" class="main" >
       <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                <li class="breadcrumb-item">Livraison</li>
                <li class="breadcrumb-item active">acquisition de la livraison</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Carte principale -->
        <div class="card info-card sales-card" >
            <?php require_once('partials/afficher_message.php') ?>
            <div class="card-header">
                <div class="row">
                    <div class="col-4">
                        <h5 class="card-title">&emsp;Info sur la commande N° <?=$commandeinfo['reference']?></h5>
                    </div>
                    <div class="col-4">
                        <h5 class="card-title">&emsp;Client:
                            <?=$commandeinfo['client']?>
                        </h5>
                    </div>
                    <div class="col-4">
                        <h5 class="card-title">&emsp;Fait le:
                            <?=date_format(date_create($commandeinfo['date_cmd_client']), 'd-m-Y H:i:s') ?>
                        </h5>
                    </div>
                </div>
            </div>

            <!-- Formulaire de livraison -->
            <form action="" method="post">
                <section class="section mt-5">
                    <div class="row">
                        <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Tableau des lignes de commande -->
                                    <table class="col-md-12 table table-bordered table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th>DESIGNATION</th>
                                                <th>STOCK</th>
                                                <th>QTE COMMANDE</th>
                                                <th>QTE RECUE</th>
                                                <th>RECEPTION ACTUELLE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="hidden" name="id_commande_client"
                                                value="<?=$commandeinfo['id_cmd_client']?>">
                                            <?php
                                                $datashow = $ligen_commande->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($datashow as $affiche):
                                                    if (($affiche->quantite - $affiche->qte_livre) > 0):
                                            ?>
                                            <tr>
                                                <div class="form-group">
                                                    <td>
                                                        <input class="form-control" type="text" name="designation[]"
                                                            value="<?=$affiche->name;?>" readOnly>
                                                        <input class="form-control" type="hidden" name="id_produit[]"
                                                            value="<?=$affiche->id;?>" readOnly>
                                                        <input class="form-control" type="hidden" name="id_ligne[]"
                                                            value="<?=$affiche->id_ligne_cl;?>" readOnly>
                                                             <input class="form-control" type="hidden"  name="price[]"
                                                            value="<?=$affiche->price;?>" readOnly>
                                                    </td>
                                                    <td><input class="form-control" type="number" name="stock[]"
                                                            value="<?=$affiche->stock;?>" readOnly></td>
                                                    <td><input class="form-control" type="number" name="qte_com[]"
                                                            value="<?=$affiche->quantite;?>" readOnly></td>
                                                    <td><input class="form-control" type="number" name="qte_recu[]"
                                                            value="<?=$affiche->qte_livre;?>" readOnly></td>
                                                    <td><input class="form-control" type="number" name="recep_act[]"
                                                            value="<?=$affiche->quantite - $affiche->qte_livre;?>"></td>
                                            </tr>
                                            <?php
                                                    endif;
                                                endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Carte latérale -->
                        <div class="col-xl-4">
                            <div class="card text-left">   
                                    <div class="card-body">
                                        <div class="form-group mt-2">
                                            <label>Référence </label>
                                            <?php
                                            $nbr_reception = "SELECT * FROM livraison";
                                            $nbr_recepti = $bdd->query($nbr_reception);
                                            $ressul = $nbr_recepti->rowCount();
                                            ?>
                                            <input type="text" name="ref" class="form-control" id=""
                                                value="L-CC-<?=date(date('dmY'))?>-0<?=$ressul+1?>" readOnly>
                                        </div>
                                            <div class="form-group mt-3">
                                                <label>Date </label>
                                                <input type="datetime-local" name="dat" class="form-control" id="currentDateTime">
                                            </div>
                                    </div>                
                            </div>
                        </div>
                    </div>                       
                         <div class="row">
                            <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                                <?php if ($countLigne > 0): ?>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal" data-bs-target="#basicModal">Valider </button>
                                    <?php require_once('partials/confirmerEnregistrement.php');?>
                                <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                                <div class="form-group">
                                    <a href="liste_commande_client.php" class="btn btn-info form-control "> Liste des commandes clients</a>
                                </div>
                            </div>
                        </div>
                </section>
            </form>
        </div>
    </main><!-- End #main -->

    <!-- Pied de page et bas de page -->
    <?php require_once('partials/foot.php')?>
    <?php require_once('partials/footer.php')?>
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

<?php require_once('partials/header.php') ?>
<body>
    <!-- Sidebar -->
    <?php require_once('partials/sidebar.php') ?>
    <!-- Navbar -->
    <?php require_once('partials/navbar.php') ?>
    <!-- Contenu -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Paiement client</li>
                    <li class="breadcrumb-item active">Détail du paiement</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section mt-5">
            <!-- Card principale englobant tout -->
            <div class="card info-card sales-card">
                <?php require_once('partials/afficher_message.php') ?>
                <div class="card-header">
                    <div class="row">
                        <div class="col-4">
                            <h5 class="card-title">Commande N° <?= $dpaie['reference'] ?></h5>
                        </div>
                        <div class="col-4">
                            <h5 class="card-title">Client : <?= $dpaie['nom_client_grossiste'] . ' ' . $dpaie['prenom_du_client_grossiste'] ?></h5>
                        </div>
                        <div class="col-4">
                            <h5 class="card-title">Fait le : <?= date_format(date_create($dpaie['date_cmd_client']), 'd-m-Y H:i:s') ?></h5>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="id_commande_client" value="<?= $dpaie['id_cmd_client'] ?>">

                        <div class="row">
                            <!-- Informations Montants -->
                            <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th>MONTANT TOTAL/CMD</th>
                                                <th>MONTANT PAYE</th>
                                                <th>MONTANT RESTANT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input class="form-control" type="text" name="mt" value="<?= $dpaie['total'] ?>" readonly>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="mp" value="<?= $dpaie['montant_paye'] ?>" readonly>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="number" name="mr" value="<?= $dpaie['total'] - $dpaie['paie'] ?>" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Informations Référence et Date -->
                            <div class="col-xl-4">
                                <div class="form-group mt-3">
                                    <label>Référence du paiement</label>
                                    <input type="text" name="ref" class="form-control" value="<?= $dpaie['paie_reference'] ?>" readonly>
                                </div>
                                <div class="form-group mt-3">
                                    <label>Date du paiement</label>
                                    <input type="datetime-local" name="dat" class="form-control" value="<?= $dpaie['date_paie'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Boutons de navigation -->
                    <div class="row mt-4">
                        <div class="col-xl-6 col-md-6 col-xs-12">
                            <a href="liste_paiement_client.php" class="btn btn-info w-100">Liste des paiements</a>
                        </div>
                        <div class="col-xl-6 col-md-6 col-xs-12 mt-2 mt-md-0">
                            <a href="liste_commande_client.php" class="btn btn-primary w-100">Liste des commandes</a>
                        </div>
                    </div>

                </div> <!-- End card-body -->
            </div> <!-- End card -->
        </section>
    </main><!-- End #main -->

    <?php require_once('partials/foot.php') ?>
    <?php require_once('partials/footer.php') ?>
</body>
</html>

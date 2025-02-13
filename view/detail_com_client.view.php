<?php 
require_once('partials/header.php') ?>
<body>
    <?php require_once('partials/sidebar.php') ?>
    <?php require_once('partials/navbar.php') ?>
     <style>
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                height: 50px; /* Hauteur du pied de page */
                background-color: #f5f5f5; /* Ajoutez la couleur de fond souhaitée */
            }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                <li class="breadcrumb-item">Commande client</li>
                <li class="breadcrumb-item active">Aperçu de la commande</li>
                </ol>
            </nav>
            </div><!-- End Page Title -->
        <div class="card info-card sales-card">
            <form action="" method="post">
                <section class="section mt-5">
                    <div class="row">
                        <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                   <table class="col-md-12 table table-bordered table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Désignation</th>
                                            <th>Quantité</th>
                                            <th>Prix</th>
                                            <th>Montant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $datashow = $ligen_commande->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($datashow as $affiche) :
                                        ?>
                                            <tr>
                                                <div class="form-group">
                                                    <td><?php echo htmlspecialchars($affiche->name); ?></td>
                                                    <td><?php echo htmlspecialchars($affiche->quantite); ?></td>
                                                    <td>
                                                        <?php 
                                                        // Afficher le prix détail s'il n'a pas été modifié
                                                        if (empty($affiche->new_price_cmndClient)) {
                                                            echo htmlspecialchars($affiche->prix_detail); 
                                                        } else {
                                                            // Afficher le nouveau prix s'il a été modifié
                                                            echo htmlspecialchars($affiche->new_price_cmndClient); 
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        // Calculer le montant en fonction du prix applicable
                                                        $prix_applicable = empty($affiche->new_price_cmndClient) ? $affiche->prix_detail : $affiche->new_price_cmndClient;
                                                        echo htmlspecialchars($affiche->quantite * $prix_applicable);
                                                        ?>
                                                    </td>
                                                </div>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="3" align="right" class="text-danger"><strong>Total</strong></td>
                                            <td align="right">
                                                <input class="form-control" type="number" name="total" value="<?= htmlspecialchars($commandeinfo['total']) ?>" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Référence </label>
                                        <input type="text" name="ref" class="form-control" id="" value="<?= $commandeinfo['reference'] ?>" readOnly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Date </label>
                                        <input type="datetime-local" name="dat" class="form-control" value="<?= $commandeinfo['date_cmd_client'] ?>" readOnly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="">Client</label>
                                        <select name="four" id="" class="form-control" required>
                                            <option value="">
                                                <?= $commandeinfo['client'] ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-5">
                                        <a href="liste_commande_client.php" class="btn btn-primary">
                                            Liste des commandes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </main><!-- End #main -->
 
  <!-- Footer -->
<footer class="footer">
    <?php require_once('partials/foot.php') ?>
    <?php require_once('partials/footer.php') ?>
</footer>
</body>

</html>

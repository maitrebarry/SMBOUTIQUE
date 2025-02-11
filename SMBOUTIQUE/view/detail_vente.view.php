<?php 
require_once('partials/database.php');
require_once('partials/header.php');
?>
<body>
    <?php require_once('partials/sidebar.php'); ?>
    <?php require_once('partials/navbar.php'); ?>
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
                    <li class="breadcrumb-item">Espace de vente</li>
                    <li class="breadcrumb-item active">Aperçu de la vente</li>
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
                                                <th>Prix de l'article</th>
                                                <th>Montant</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($venteinfo as $affiche): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($affiche->name); ?></td>
                                                    <td><?= htmlspecialchars($affiche->quantite); ?></td>
                                                    
                                                    <!-- Utiliser new_price_vente s'il existe, sinon prix_detail -->
                                                    <td>
                                                        <?= htmlspecialchars($affiche->new_price_vente ?? $affiche->prix_detail); ?>
                                                    </td>
                                                    
                                                    <!-- Calculer le montant en utilisant new_price_vente s'il existe, sinon prix_detail -->
                                                    <td>
                                                        <?php
                                                            $prix = $affiche->new_price_vente ?? $affiche->prix_detail;
                                                            echo number_format($affiche->quantite * $prix, 0, ',', ' ');
                                                        ?> FCFA
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="3" align="right" class="text-danger"><strong>Montant total</strong></td>
                                                <td align="right">
                                                    <input class="form-control" type="number" name="total" value="<?= htmlspecialchars($lignes['montant_total']); ?>" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                              <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-3 col-md-10 col-xs-12">
                                                <div class="form-group mt-3">
                                                <label for="">Rémise</label>
                                                    <input  class="form-control" value="<?=$lignes['remise']?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-10 col-xs-12">
                                                <div class="form-group mt-3">
                                                    <label for="">Net à payer</label>
                                                    <input type="number" value="<?= $lignes['net_a_payer'] ?>" class="form-control " readOnly>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-10 col-xs-12">
                                                <div class="form-group mt-3">
                                                    <label for="">Montant reçu</label>
                                                    <input type="number" name="montantrecu" class="form-control montantrecu" value="<?= $lignes['montant_recu'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-10 col-xs-12">
                                                <div class="form-group mt-3">
                                                    <label for="">Monnaie à rembourser</label>
                                                    <input type="number" name="monnaierembourser" class="form-control monnaierembourser" value="<?=$lignes['monnaie_rembourse']?>"readOnly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                         </div>
                        <div class="col-xl-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="form-group mt-3">
                                        <label>Date </label>
                                        <input type="datetime-local" name="dat" class="form-control" value="<?= $lignes['date_vente'] ?>" readOnly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="">Client</label>
                                        <select name="four" id="" class="form-control" required>
                                            <option value="<?= $lignes['nom_client'] ?>">
                                                <?= $lignes['nom_client'] ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-xl-12 col-md-10 col-xs-12 mt-3">
                        <div class="form-group">
                            <a href="liste_vente.php" class="btn btn-info form-control ">Liste des ventes réalisées</a>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </main><!-- End #main -->

    <!-- Footer -->
    <footer class="footer">
        <?php require_once('partials/foot.php'); ?>
        <?php require_once('partials/footer.php'); ?>
    </footer>
</body>
</html>

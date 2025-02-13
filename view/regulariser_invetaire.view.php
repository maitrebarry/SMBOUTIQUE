<!--------header------->
<?php require_once ('partials/header.php') ?>
<body>
    <!-------------sidebare----------->
    <?php require_once ('partials/sidebar.php')?>
    <!-------------navebare----------->
    <?php require_once ('partials/navbar.php')?>
    <style>
.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 50px;
    /* Hauteur du pied de page */
    background-color: #f5f5f5;
    /* Ajoutez la couleur de fond souhaitée */
}

.btn-light {
    float: right;
}
</style>
    <!-------------contenu----------->
     <?php $errors = []; $button_name='valider'?>
    <main id="main" class="main">
         <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                <li class="breadcrumb-item"> Inventaire </li>
                <li class="breadcrumb-item active">Régulariser Inventaire</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="card info-card sales-card">
            <?php require_once('partials/afficher_message.php')?>
           
            <form action="regulariser_inventaire.php" method="post">
                <input type="hidden" name="regulariser_id" value="<?= $inventaire['id_inventaire']; ?>">
                <section class="section mt-5">
                    <div class="row">
                        <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Table with stripped rows -->
                                    <table class="col-md-12 table table-bordered table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th>DESIGNATION</th>
                                                <th>QTE VIRTUELLE</th>
                                                <th>QTE PHYSIQUE</th>
                                                <th>MONTANT</th>
                                                <th>ECART STOCK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                                                                                      
                                            $datashow = $ligne_inventaire->fetchAll(PDO::FETCH_OBJ);
                                            foreach($datashow as $affiche): ?>
                                                <tr>
                                                    <td>
                                                        <input class="form-control" type="text" name="designation[]"
                                                            value="<?= $affiche->name; ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="number" name="stock[]"
                                                            value="<?= $affiche->stock; ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="number" name="qte_physique[]"
                                                            value="<?= $affiche->quantite_physique; ?>">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name=""
                                                            value="<?= number_format($affiche->quantite_physique * $affiche->price, 2, ',', ' ') . ' F CFA'; ?>" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="number" name="ecart_stock[]"
                                                            value="<?= abs($affiche->quantite_physique - $affiche->stock); ?>" readonly>
                                                    </td>
                                                    <input type="hidden" name="id_produit[]" value="<?= $affiche->id; ?>">
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <!-- <div class="form-group">
                                        <label>Boutique* </label>
                                        <input type="text" name="ref" class="form-control" value="<?= $inventaire['boutique']; ?>" readOnly>
                                    </div> -->
                                    <div class="form-group mt-3">
                                        <input type="datetime-local" name="dat" class="form-control" value="<?= $inventaire['date_inventaire']; ?>" readOnly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal" data-bs-target="#basicModal">Valider</button>
                                <?php require_once('partials/confirmerEnregistrement.php');?>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                            <div class="form-group">
                                <a href="liste_inventaire.php" class="btn btn-info form-control">Liste des Inventaires</a>
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

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
                <li class="breadcrumb-item">Inventaire </li>
                <li class="breadcrumb-item active">Detail Inventaire</li>
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
                                    <!-- Table with stripped rows -->
                                    <table class="col-md-12  table table-bordered table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th>DESIGNATION</th>
                                                <th>QTE VIRTUELLE</th>
                                                <th>QTE PHYSIQUE</th>
                                                <th>ECART STOCK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $datashow=$ligne_inventaire->fetchAll(PDO::FETCH_OBJ);
                                            foreach( $datashow as $affiche ):?>
                                            <tr>
                                                <div class="form-group">
                                                    <td><?php echo $affiche->name; ?></td>
                                                    <td><?php echo $affiche->stock; ?></td>
                                                    <td><?php echo $affiche->quantite_physique; ?></td>
                                                    <td><?php echo $affiche->ecart_stock;?></td>
                                            </tr>
                                            <?php endforeach ?>
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
                                        <input type="text" name="ref" class="form-control" id=""
                                            value="<?=$inventaire['reference_inventaire']?>" readOnly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Boutique </label>
                                        <input  class="form-control"
                                            value="<?= $inventaire['boutique']?>" readOnly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Date </label>
                                        <input type="datetime-local" name="dat" class="form-control"
                                            value="<?=$inventaire['date_inventaire']?>" readOnly>
                                    </div>
                                    <div class="form-group  mt-5">
                                        <a href="liste_inventaire.php" class="btn btn-primary">
                                            Liste des Inventaires
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
        </div>
    </main><!-- End #main -->
 
  <!-- Footer -->
<footer class="footer">
    <?php require_once('partials/foot.php') ?>
    <?php require_once('partials/footer.php') ?>
</footer>
</body>

</html>
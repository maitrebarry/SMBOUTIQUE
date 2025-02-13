
<?php require_once ('partials/header.php') ?>
<body>
    <!-------------sidebare----------->
    <?php require_once ('partials/sidebar.php')?>
    <!-------------navebare----------->
    <?php require_once ('partials/navbar.php')?>
    <!-------------contenu----------->
    <main id="main" class="main">
          <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                <li class="breadcrumb-item">Paiement client</li>
                <li class="breadcrumb-item active">detail du paiement</li>
                </ol>
            </nav>
            </div><!-- End Page Title -->
        <section class="section mt-5">
            <div class="card info-card sales-card">
                 <?php require_once('partials/afficher_message.php')?>
                <div class="card-header">
                    <div class="row">
                        <div class="col-4">
                            <h5 class="card-title">&emsp; Commande N°
                                <?=$dpaie['reference']?></h5>
                        </div>
                        <div class="col-4">
                            <h5 class="card-title">&emsp; Client:
                                <?=$dpaie['client']?>
                        </div>
                        <div class="col-4">
                            <h5 class="card-title">&emsp; fait le:
                                <?=date_format(date_create($dpaie['date_cmd_client']), 'd-m-Y H:i:s') ?>
                        </div>
                    </div>
                </div>
                <form action="" method="post">

                    <div class="row">
                        <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Table with stripped rows -->
                                    <table class="col-md-12  table table-bordered table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th>MONTANT TOTAL/CMD</th>
                                                <th>MONTANT PAYE</th>
                                                <th>MONTANT RESTANT</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="hidden" name="id_commande_client"
                                                value="<?=$dpaie['id_cmd_client']?>">
                                            <tr>
                                                <div class="form-group">
                                                    <td>
                                                        <input class="form-control" type="text" name="mt"
                                                            value="<?=$dpaie['total']?>" readOnly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="texte" name="mp"
                                                            value="<?=$dpaie['montant_paye']?>" readOnly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="number" name="mr"
                                                            value="<?=$dpaie['total']-$dpaie['paie']?>" readOnly>
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
                                        <?php 
                  ?>
                                        <div class="form-group mt-3">
                                            <label>Référence du paiement</label>
                                            <input type="text" name="ref" class="form-control" id=""
                                                value="<?=$dpaie['paie_reference']?>" readOnly>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label>Date du paiement</label>
                                            <input type="datetime-local" name="dat" class="form-control"
                                                value="<?=$dpaie['date_paie']?>" readOnly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                </form>
            </div>
            <div class="form-group ml-5" style="text-align:center">
                <a href="liste_paiement_client.php" class="btn btn-primary"> Liste des paiements</a>&emsp;
                <a href="liste_commande_client.php" class="btn btn-primary">Liste des commandes</a>
            </div>
        </section>
    </main><!-- End #main -->
    <?php require_once ('partials/foot.php')?>
    <?php require_once ('partials/footer.php')?>
</body>

</html>
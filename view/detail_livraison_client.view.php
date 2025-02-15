<!--------header------->
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
          <li class="breadcrumb-item">Livraisons</li>
          <li class="breadcrumb-item active">Detail sur la livraison</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
        <div class="card info-card sales-card">
            <div class="card-header">
                <div class="row">
                    <div class="col-4">
                        <h5 class="card-title">info sur la commande N° <?=  $livraisoninfo['reference']?></h5>
                    </div>
                    <div class="col-4">
                        <h5 class="card-title"> Client:
                            <?=$livraisoninfo['prenom_du_client_grossiste'].' '.$livraisoninfo['nom_client_grossiste']?>
                    </div>
                    <div class="col-4">
                        <h5 class="card-title"> Date de commande:
                            <?=date_format(date_create(  $livraisoninfo['date_cmd_client']), 'd-m-Y H:i:s') ?>
                    </div>
                </div>
            </div>
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
                                                <th>QTE COMMANDE</th>
                                                <th>QTE RECUE</th>
                                                <th>QTE RESTANTE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                                                        
                                                $datashow=$ligen_livrai->fetchAll(PDO::FETCH_OBJ);
                                                $dat=$ligen_commande->fetchAll(PDO::FETCH_OBJ);
                                                foreach( $datashow as $affich ):           
                                                foreach( $dat as $affiche ):
                                                    if($affich->id_produit==$affiche->id){
                                                ?>
                                            <tr>
                                                <div class="form-group">
                                                    <td><?=$affich->name;?></td>
                                                    <td><input class="form-control" type="number" name="qte_recu[]"
                                                            value="<?=$affiche->quantite;?>" readOnly></td>
                                                    <td><input class="form-control" type="number" name="qte_recu[]"
                                                            value="<?=$affich->quantite_recu;?>" readOnly></td>
                                                    <td><input class="form-control" type="number" name="recep_act[]"
                                                            value="<?=$affiche->quantite-$affich->quantite_recu;?>"readOnly>
                                                    </td>
                                            </tr>
                                            <?php } endforeach ?>
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
                                        <label>Référence de la livraison </label>
                                        <input type="text" name="ref" class="form-control" id=""
                                            value="<?=  $livraisoninfo['livraison_refer']?>" readOnly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Date de la reception </label>
                                        <input type="datetime-local" name="dat" class="form-control"
                                            value="<?=  $livraisoninfo['date_livraison']?>" readOnly>
                                    </div>
                                    <div class="form-group  mt-5">
                                        <a href="liste_livraison.php" class="btn btn-primary">
                                            Liste Des livraisons
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
            </form>
            <!-- </div> -->
        </div>



        <?php require_once ('partials/foot.php')?>
        <?php require_once ('partials/footer.php')?>
</body>

</html>
<!--------header------->
<?php require_once ('partials/header.php') ?>
<!-------------sidebare----------->
<?php require_once ('partials/sidebar.php')?>
<!-------------navebare----------->
<?php require_once ('partials/navbar.php')?>
<!DOCTYPE html>
<html lang="en">
   <style>
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                height: 50px; /* Hauteur du pied de page */
                background-color: #f5f5f5; /* Ajoutez la couleur de fond souhaitée */
            }
    </style>
  <body>
    <main id="main" class="main">
            <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <li class="breadcrumb-item">Mouvement</li>
          <li class="breadcrumb-item active">Liste du mouvement</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                             <?php require_once('partials/afficher_message.php')?>
                            <!-- Table with stripped rows -->
                            <table class="table datatable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Designation</th>
                                        <th>Quantité</th>
                                        <th>Montant</th>
                                        <th width='1%'>type de <br> mouvement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php  foreach ($recuperer_afficher_mvent as $liste_mvnt):?>
                                        <tr>
                                            <td><?=date_format(date_create($liste_mvnt->date_mov), 'd-m-Y H:i:s')?></td>
                                            <td><?= $liste_mvnt->name?></td>
                                            <td><?= $liste_mvnt-> quantite?></td> 
                                            <td><?= number_format($liste_mvnt-> montant, 2, ',', ' ') ?> F CFA</td>
                                            <td>
                                              <?php
                                            if ($liste_mvnt->type_mvnt=='reception') {
                                              echo " <span class='badge bg-success'>Réception</span>";
                                            }elseif($liste_mvnt->type_mvnt=='livraison') {
                                               echo " <span class='badge bg-primary'>Livraison</span>";
                                            }else{
                                               echo " <span class='badge bg-info'>vente_direct</span>";
                                            }
                                               ?>
                                            </td>
                                        </tr>
                                    <?php endforeach?>
                                </tbody>
                          </table>
                        </div>
                     </div>
                </div>
            </div>
        </section>
    </main>  
     <!-- Footer -->
        <footer class="footer">
            <?php require_once('partials/foot.php') ?>
            <?php require_once('partials/footer.php') ?>
        </footer>
        <?php require_once ('partials/footer.php')?> 
        <?php require_once ('partials/foot.php')?> 
         <!-- Script pour la boîte de dialogue de confirmation de suppression -->
  </body>
</html>


    

	
	
	
	
	
   
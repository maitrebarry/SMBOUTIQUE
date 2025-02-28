<?php require_once ('partials/database.php') ?>
<!--------header------->
<?php require_once ('partials/header.php') ?>
<!-------------sidebare----------->
<?php require_once ('partials/sidebar.php')?>
<!-------------navebare----------->
<?php require_once ('partials/navbar.php')?>
<html>
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
                <li class="breadcrumb-item">Commande fournisseur</li>
                <li class="breadcrumb-item active">liste des receptions</li>
                </ol>
            </nav>
            </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Table with stripped rows   -->
                        <div class="table-responsive">
                            <table class="table datatable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>DATE-RECEPTION</th>
                                        <th>REFERENCE-RECEPTION</th>
                                        <th>REFERENCE-COMMANDE</th>
                                        <th>FOURNISSEUR</th>
                                        <th>OPERATION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <!-- Boucle sur les receptions -->
                                        <?php   
                                    foreach( $recuperer_liste_recep as $liste_recep )
                                    {  
                                         ?>  
                                        <tr>
                                            <!-- Affichage des données de reception -->
                                            <td><?=date_format(date_create($liste_recep->date_reception), 'd-m-Y H:i:s') ?></td>
                                            <td><?=$liste_recep->recept_ref?></td>
                                            <td><?= $liste_recep->reference?></td>
                                            <td><?= $liste_recep->nom_fournisseur?> <?= $liste_recep->prenom_fournisseur?></td>
                                            <td>
                                        <!-- Bouton de détail -->
                                                <a href="detail_reception_four.php?detail=<?=$liste_recep->id_reception?>"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="ri-eye-fill"></i>
                                                </a>&emsp;
                                                  <!-- Bouton pour le pdf -->
                                                <a href="pdf_reception_four.php?detail=<?=$liste_recep->id_reception?>"
                                                    class="btn btn-danger btn-sm" target="_blank">
                                                   <i class="bi bi-printer-fill"></i>
                                                </a>&emsp;
                                                    <!-- Bouton de suppression -->
                                                    <a href="" 
                                                        class="btn btn-danger btn-sm delete-button"
                                                        data-reception-id="<?= $liste_recep->id_reception ?>">
                                                        <i class="ri-delete-bin-5-fill "></i>
                                                    </a>
                                            </td>
                                        </tr>
                             <?php } ?>
                            </table>
                         </div>   
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->



   <!-- Footer -->
        <footer class="footer">
            <?php require_once('partials/foot.php') ?>
            <?php require_once('partials/footer.php') ?>
        </footer>
        
        <?php
        // Affichage de l'icône de suppression dans SweetAlert après une suppression réussie

            if (isset($_SESSION['success_message'])) {
                echo '<script>Swal.fire("'.$_SESSION['success_message'].'", "", "success");</script>';
                unset($_SESSION['success_message']); 
            }
        ?>

         <!-- Script pour la boîte de dialogue de confirmation de suppression -->
    <script>
       document.addEventListener("DOMContentLoaded", function () {
      var deleteButtons = document.querySelectorAll('.delete-button');

      deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            // Obtenez l'ID à partir de l'attribut "id" du bouton
            var receptionId = button.getAttribute('data-reception-id');

            // Boîte de dialogue de confirmation avec SweetAlert
            Swal.fire({
                title: "Êtes-vous sûr?",
                text: "Une fois supprimé, vous ne pourrez pas récupérer ces données!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Annuler"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirige vers la page supprimer_reception.php 
                    window.location.href = 'supprimer_reception.php?id=' + receptionId + '&confirm=true';
                } else {
                    // Si l'utilisateur annule
                    console.log("Suppression annulée");
                    }
                });
            });
            });
        });

    </script>
</body>

</html>
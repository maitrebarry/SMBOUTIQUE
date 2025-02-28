<?php require_once ('partials/database.php') ?>
<!DOCTYPE html>
<html lang="en">
<!-- header -->
    <?php require_once('partials/header.php') ?>
<body>
   

    <!-- sidebar -->
    <?php require_once('partials/sidebar.php') ?>

    <!-- navbar -->
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
          <li class="breadcrumb-item">Paiement fournisseur</li>
          <li class="breadcrumb-item active">Liste des paiements</li>
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
                                            <th>Date-paiement</th>
                                            <th>Référence-paiement</th>
                                            <th>Référence-Commande</th>
                                            <th>Client</th>
                                            <th>Montant payé</th>
                                            <th>Action</th>   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php foreach( $recuperer_afficher_list_paie as $affiche )
                                            {?>
                                            <td><?=date_format(date_create($affiche->date_paie), 'd-m-Y H:i:s') ?></td>
                                            <td><?=$affiche->paie_referrence?></td>
                                            <td><?= $affiche->reference?></td>
                                            <td><?= $affiche->nom_fournisseur?> <?= $affiche->prenom_fournisseur?></td>
                                            <td><?= number_format($affiche->montant_paye, 2, ',', ' ') ?> F CFA</td>                                 
                                            <td>
                                                <a href="detail_paiement_four.php?detail=<?=$affiche->id_paiement ?>"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="ri-eye-fill"></i>
                                                </a>&emsp;
                                                <!-- Bouton pour le pdf -->
                                                    <a href="pdf_paiement_four.php?detail=<?=$affiche->id_paiement?>"
                                                        class="btn btn-danger btn-sm"target="_blank">
                                                    <i class="bi bi-printer-fill"></i>
                                                    </a>&emsp;
                                                <!-- Bouton de suppression -->
                                                <a class="btn btn-danger btn-sm delete-button" 
                                                        data-paiefour-id="<?= $affiche->id_paiement ?>">
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
                     var paiementId = button.getAttribute('data-paiefour-id');

                    //  console.log(paiementId); // Vérifiez dans la console du navigateur

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
                            // Redirige vers la page supprimer_livraison.php avec l'ID de la livraison
                            window.location.href = 'supprimer_paiement_four.php?id=' + paiementId + '&confirm=true';
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>

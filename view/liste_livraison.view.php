<!DOCTYPE html>
<html lang="en">
<?php require_once ('partials/database.php') ?>
<<!-- header -->
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
          <li class="breadcrumb-item">Livraison</li>
          <li class="breadcrumb-item active">Liste des livraisons</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Table with stripped rows -->
                             <div class="table-responsive">
                                <table class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date-Livraison</th>
                                            <th>Référence-Livraison</th>
                                            <th>Référence-Commande</th>
                                            <th>Client</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Boucle sur les livraisons -->
                                        <?php foreach ($recuperer_afficher as $liste_livrai) { ?>
                                            <tr>
                                                <!-- Affichage des données de livraison -->
                                                <td><?= date_format(date_create($liste_livrai->date_livraison), 'd-m-Y H:i:s') ?></td>
                                                <td><?= $liste_livrai->livraison_refer ?></td>
                                                <td><?= $liste_livrai->reference ?></td>
                                                <td><?= $liste_livrai->prenom_du_client_grossiste.' '.$liste_livrai->nom_client_grossiste ?></td>
                                                <td>
                                                    <!-- Bouton de détail -->
                                                    <a href="detail_livraison_client.php?detail=<?= $liste_livrai->id_livraison ?>"
                                                        class="btn btn-primary btn-sm" >
                                                        <i class="ri-eye-fill"></i>
                                                    </a>&emsp;
                                                    <!-- Bouton pour le pdf -->
                                                    <a href="pdf_livraison.php?detail=<?=$liste_livrai->id_livraison?>"
                                                        class="btn btn-danger btn-sm" target="_blank">
                                                    <i class="bi bi-printer-fill"></i>
                                                    </a>&emsp;
                                                    <!-- Bouton de suppression -->
                                                    <a href=""
                                                        class="btn btn-danger btn-sm delete-button"
                                                        data-livraison-id="<?= $liste_livrai->id_livraison ?>">
                                                        <i class="ri-delete-bin-5-fill "></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
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
                    var livraisonId = button.getAttribute('data-livraison-id');

                    // console.log(livraisonId); // Vérifiez dans la console du navigateur

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
                            window.location.href = 'supprimer_livraison.php?id=' + livraisonId + '&confirm=true';
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>

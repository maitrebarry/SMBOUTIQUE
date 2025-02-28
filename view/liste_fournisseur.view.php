<?php require_once ('partials/database.php') ?>
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
    height: 50px;
    /* Hauteur du pied de page */
    background-color: #f5f5f5;
    /* Ajoutez la couleur de fond souhaitée */
}

.btn-primary {
    float: right;
}
</style>

<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Fournisseur</li>
                    <li class="breadcrumb-item active">Liste des fournisseurs</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                          <a class="btn btn-primary mb-2" href="fournisseur.php" style="font-size: 18px;" title="Plus de fournisseur"><span>+ FOURNISSEUR</span></a>
                        </div>
                       
                        <div class="card-body">
                            <?php require_once('partials/afficher_message.php')?>
                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Prénom</th>
                                            <th>Nom</th>
                                            <th>Contact <br>fournisseur</th>
                                            <th>Ville ou<br>Quartier</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($recuperer_afficher as $liste_four) {
                                            // Ajouter des espaces après chaque paire de chiffres
                                            $formatted_contact = preg_replace("/(\d{2})(?=\d)/", "$1 ", $liste_four->contact_fournisseur);
                                        ?>
                                        <tr>
                                            <td><?= $liste_four->prenom_fournisseur ?></td>
                                            <td><?= $liste_four->nom_fournisseur ?></td>
                                            <td><?= $formatted_contact ?></td>
                                            <td><?= $liste_four->ville_fournisseur ?></td>
                                            <td>
                                                <a href="modifier_fournisseur.php?id=<?= $liste_four->id_fournisseur ?>" class="btn btn-info btn-sm">
                                                    <i class="bx bxs-edit"></i>
                                                </a>&emsp;
                                                <!-- Bouton de suppression -->
                                                <a class="btn btn-danger btn-sm delete-button" href="id=<?= $liste_four->id_fournisseur ?>" data-listfour-id="<?= $liste_four->id_fournisseur ?>">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
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

    <?php
        // Affichage de l'icône de suppression dans SweetAlert après une suppression réussie

            if (isset($_SESSION['success_message'])) {
                echo '<script>Swal.fire("'.$_SESSION['success_message'].'", "", "success");</script>';
                unset($_SESSION['success_message']); 
            }
        ?>
    <!-- Script pour la boîte de dialogue de confirmation de suppression -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                // Obtenez l'ID à partir de l'attribut "id" du bouton
                var listfourniId = button.getAttribute('data-listfour-id');

                //  console.log(listfourniId); // Vérifiez dans la console du navigateur

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
                        // Redirige vers la page supprimer_fournisseur.php
                        window.location.href = 'supprimer_fournisseur.php?id=' +
                            listfourniId + '&confirm=true';
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
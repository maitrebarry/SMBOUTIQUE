<!--------header------->
<?php require_once ('partials/header.php') ?>
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

.btn-primary {
    float: right;
}
</style>
<!DOCTYPE html>
<html lang="en">

<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Client</li>
                    <li class="breadcrumb-item active">Liste des clients</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                             <a class="btn btn-primary mb-2" href="client.php" style="font-size: 18px;" title="Plus de client">+</a>
                        </div>
                        <div class="card-body">
                            <?php require_once('partials/afficher_message.php')?>
                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>

                                            <th>Prénom</th>
                                            <th>Nom </th>
                                            <th>Contact </th>
                                            <th>Ville ou<br>Quartier</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  foreach ($recuperer_afficher as $liste_cli):?>
                                        <tr>

                                            <td><?= $liste_cli-> prenom_du_client_grossiste?></td>
                                            <td><?= $liste_cli-> nom_client_grossiste?></td>
                                            <td><?= $liste_cli->contact_client_grossiste ?></td>
                                            <td><?= $liste_cli->ville_client_grossiste ?></td>

                                            <td>
                                                <a href="modifier_client.php?id=<?=$liste_cli->id_client_gr?>"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bx bxs-edit"></i></a>&emsp;

                                                <!-- Bouton de suppression -->
                                                <a class="btn btn-danger btn-sm delete-button"
                                                    href="supprimer_client.php?id=<?= $liste_cli->id_client_gr ?>"
                                                    data-listclient-id="<?= $liste_cli->id_client_gr ?>">
                                                    <i class="ri-delete-bin-5-fill "></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach?>
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
                var listclientId = button.getAttribute('data-listclient-id');

                //  console.log(listclientId); // Vérifiez dans la console du navigateur

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
                        window.location.href = 'supprimer_client.php?id=' +
                            listclientId + '&confirm=true';
                    }
                });
            });
        });
    });
    </script>
</body>

</html>
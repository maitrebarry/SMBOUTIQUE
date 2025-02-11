    <?php
    // Détermine quel bouton doit être actif en fonction de l'URL actuelle
    $current_page = basename($_SERVER['PHP_SELF']);

    $active_user = ($current_page == 'creer_utilisateur.php') ? 'active' : '';
    $active_unit = ($current_page == 'unite.php') ? 'active' : '';
    $active_unit = ($current_page == 'liste_unite.php') ? 'active' : '';
    // $active_boutique = ($current_page == 'boutique.php') ? 'active' : '';
    // $active_owner = ($current_page == 'proprietaire.php') ? 'active' : '';

    ?>

    <!--------header------->
    <?php require_once('partials/header.php'); ?>
<body>
    <!-------------sidebar----------->
    <?php require_once('partials/sidebar.php'); ?>
    <!-------------navbar----------->
    <?php require_once('partials/navbar.php'); ?>

    <!-------------content----------->
    <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px;
            background-color: #f5f5f5;
        }

        .btn-light {
            float: right;
        }

        .bi-exclamation-triangle {
            font-size: 90px;
        }
        .btn-block {
            width: 100%;
            margin-bottom: 10px;
            padding: 25px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-weight: bolder;
            color: black;
        }
        .card-body a.btn-outline-primary {
        position: relative;
        cursor: pointer;
        }
        
        .card-body a.btn-outline-primary.active {
        outline: 2px solid #007bff;
        outline-offset: 2px;
        }
    </style>

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
                    <li class="breadcrumb-item">Unité</li>
                    <li class="breadcrumb-item active">Liste des Unités</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                 <div class="col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <h6>MENU</h6>
                        </div>
                        <div class="card-body">
                            <a href="creer_utilisateur.php" class="btn btn-outline-primary btn-block <?= $active_user; ?>">Compte utilisateur</a>
                            <a href="unite.php" class="btn btn-outline-primary btn-block <?= $active_unit; ?>">Unités</a>
                            <!-- <a href="boutique.php" class="btn btn-outline-primary btn-block <?= $active_boutique?>">Supermarchés</a>
                            <a href="proprietaire.php" class="btn btn-outline-primary btn-block <?= $active_owner; ?>">Proprietaire</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-10 col-xm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-primary btn-lg " href="unite.php">+</a>
                        </div>
                        <div class="card-body">
                            <table class="table datatable table-bordered">
                                <thead>
                                    <tr>

                                        <th>Libellé</th>
                                        <th>Symbole </th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  foreach ($recuperer_afficher_unite as $liste_unite):?>
                                    <tr>

                                        <td><?= $liste_unite-> libelle?></td>
                                        <td><?= $liste_unite-> symbole?></td>
                                        <td>
                                            <a href="modifier_unite.php?id=<?=$liste_unite->id_unite?>"
                                                class="btn btn-info btn-sm">
                                                <i class="bx bxs-edit"></i></a>&emsp;

                                            <!-- Bouton de suppression -->
                                            <a class="btn btn-danger btn-sm delete-button"
                                                href="supprimer_unite.php?id=<?= $liste_unite->id_unite ?>"
                                                data-listclient-id="<?= $liste_unite->id_unite ?>">
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
        </section>
    </main>
    <!-- Footer -->
    <footer class="footer">
        <?php require_once('partials/foot.php') ?>
        <?php require_once('partials/footer.php') ?>
    </footer>
    <script>
        document.querySelectorAll('.card-body .btn-outline-primary').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.card-body .btn-outline-primary').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>
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
                        // Redirige vers la page supprimer_unite.php 
                        window.location.href = 'supprimer_unite.php?id=' +
                            listclientId + '&confirm=true';
                    }
                });
            });
        });
    });
    </script>
</body>

</html>
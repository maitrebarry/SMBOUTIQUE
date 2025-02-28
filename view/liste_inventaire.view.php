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

.btn-outline-primary {
    float: right;
}

.card-header span {
    font-family: 'Times New Roman', Times, serif;
    font-weight: bolder;

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
                        <div class="card-header">
                            <a class="btn btn-outline-primary" href="nouveau_inventaire.php"><span>NOUVEAU
                                    INVENTAIRE</span></a>
                        </div>
                        <div class="card-body">
                            <?php require_once('partials/afficher_message.php')?>
                            <!-- Table with stripped rows -->
                            <div class="table-responsive">
                                <table class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>Ref INVENTAIRE</th>
                                            <!-- <th>BOUTIQUE</th> -->
                                            <th>RESPONSABLE</th>
                                            <th>STATUT</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  foreach($recuperer_afficher_liste_inventaire as $liste_inventaire):?>
                                        <td><?=date_format(date_create($liste_inventaire->date_inventaire), 'd-m-Y à H:i')?></td>
                                        <td><?= $liste_inventaire->reference_inventaire?></td>
                                        <!-- <td><?= $liste_inventaire->boutique?></td> -->
                                        <td><?= $liste_inventaire->prenom_utilisateur .' '. $liste_inventaire->nom_utilisateur ?></td>
                                        <td>
                                            <?php
                                                if ($liste_inventaire->regulariser=='non') {
                                                echo " <span class='badge bg-danger'>Non Régulariser</span>";
                                                }else{
                                                echo " <span class='badge bg-success'>Régulariser</span>";
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <!-- Actions disponibles dans un menu déroulant -->
                                            <div class="dropdown">
                                                <button class="btn btn-dark dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="bi bi-three-dots text-center"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <h6 class="dropdown-header">Veuillez faire un choix</h6>
                                                    <?php if ($liste_inventaire->regulariser=='non') { ?>
                                                    <a class="dropdown-item"href="regulariser_inventaire.php?regulariser=<?= $liste_inventaire->id_inventaire?>">Régulariser</a>
                                                    <?php } ?>
                                                    <a class="dropdown-item" href="detail_inventaire.php?detail=<?= $liste_inventaire->id_inventaire?>">Detail</a>
                                                </div>
                                            </div>
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
    <?php require_once ('partials/footer.php')?>
    <?php require_once ('partials/foot.php')?>
    <!-- Script pour la boîte de dialogue de confirmation de suppression -->
</body>

</html>
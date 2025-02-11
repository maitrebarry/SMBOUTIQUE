
    <?php require_once ('partials/database.php') ?>
    <!--------header------->
    <?php require_once ('partials/header.php') ?>
    <!-------------sidebare----------->
    <?php require_once ('partials/sidebar.php')?>
    <!-------------navebare----------->
    <?php require_once ('partials/navbar.php')?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <!-- Ajoutez vos balises meta, link, et autres balises head nécessaires ici -->
            <style>
                .footer {
                    position: fixed;
                    bottom: 0;
                    width: 100%;
                    height: 50px; /* Hauteur du pied de page */
                    background-color: #f5f5f5; /* Ajoutez la couleur de fond souhaitée */
                }
                .btn-dark{
                    float:right;
                }
            </style>
        </head>
        <body>
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Dashboard</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                            <li class="breadcrumb-item">Caisse</li>
                            <li class="breadcrumb-item active">Liste des Caisses</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="btn btn-dark btn-sm " href="caisse.php">+caisse</a>
                                </div>
                                <div class="card-body">
                                    <?php require_once('partials/afficher_message.php')?>
                                    <!-- Table with stripped rows -->
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>DATE</th>
                                                <th>N° DE LA CAISSE</th>
                                                <th>MONTANT INITIAL</th>
                                                <th>CAISSE</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recuperer_afficher as $liste_caisse): ?>
                                                <?php if ($liste_caisse->statut=='on') : ?>
                                            <tr class="table-success">
                                                <!-- Ajout de la classe de couleur en fonction de la condition -->
                                                <td><?= date_format(date_create($liste_caisse->date_caisse),'d-m-Y') ?></td>
                                                <td><?= $liste_caisse->reference_caisse ?></td>
                                                <td><?= number_format($liste_caisse->montant_initial, 2, ',', ' ') ?> F CFA</td>
                                                <td><?= number_format($liste_caisse->Montant_total_caisse, 2, ',', ' ') ?> F CFA</td>
                                                <td>
                                                      

                                                        <a href="modifier_caisse.php?id=<?=$liste_caisse->id_caisse?>" class="btn btn-info btn-sm">
                                                            <i class="bx bxs-edit"></i>
                                                        </a>&emsp;
                                                        
                                                        <!-- Bouton de suppression -->
                                                        <?php if ($liste_caisse->statut=='on'AND $liste_caisse->Montant_total_caisse==0) :?>
                                                           <a class="btn btn-danger btn-sm delete-button" href="supprimer_caisse.php?id=<?= $liste_caisse->id_caisse ?>"
                                                                data-listfour-id="<?= $liste_caisse->id_caisse ?>">
                                                                    <i class="ri-delete-bin-5-fill "></i>
                                                            </a>
                                                        <?php endif ;?>
                                                    
                                                </td>
                                            </tr>
                                        <?php else : ?>
                                            <tr class="table-danger">
                                                <!-- Ajout de la classe de couleur en fonction de la condition -->
                                                <td><?= date_format(date_create($liste_caisse->date_caisse),'d-m-Y') ?></td>
                                                <td><?= $liste_caisse->reference_caisse ?></td>
                                                <td><?= number_format($liste_caisse->montant_initial, 2, ',', ' ') ?> F CFA</td>
                                                <td><?= number_format($liste_caisse->Montant_total_caisse, 2, ',', ' ') ?> F CFA</td>
                                                <td>
                                                        
                                                        <a href="modifier_caisse.php?id=<?=$liste_caisse->id_caisse?>" class="btn btn-info btn-sm">
                                                            <i class="bx bxs-edit"></i>
                                                        </a>&emsp;
                                                        
                                                        <!-- Bouton de suppression -->
                                                       <?php if ($liste_caisse->statut=='on'AND $liste_caisse->Montant_total_caisse==0) :?>
                                                           <a class="btn btn-danger btn-sm delete-button" href="supprimer_caisse.php?id=<?= $liste_caisse->id_caisse ?>"
                                                                data-listfour-id="<?= $liste_caisse->id_caisse ?>">
                                                                    <i class="ri-delete-bin-5-fill "></i>
                                                            </a>
                                                        <?php endif ;?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                            <?php endforeach ?>
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
            <!-- Script pour la boîte de dialogue de confirmation de suppression -->
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var deleteButtons = document.querySelectorAll('.delete-button');

                    deleteButtons.forEach(function (button) {
                        button.addEventListener('click', function (event) {
                            event.preventDefault();

                            // Obtenez l'ID à partir de l'attribut "id" du bouton
                            var listfourniId = button.getAttribute('data-listfour-id');

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
                                    window.location.href = 'supprimer_caisse.php?id=' + listfourniId + '&confirm=true';
                                }else {
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



    
   
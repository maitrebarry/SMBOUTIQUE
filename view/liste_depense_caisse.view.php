 
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
          <li class="breadcrumb-item">dépenses</li>
          <li class="breadcrumb-item active">Liste des dépenses</li>
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
                            <div class="table-responsive">
                                <table class="table datatable table-bordered table-striped">      
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>RÉFÉRENCE CAISSE</th>
                                            <th>LIBELLÉ</th>
                                            <th>MONTANT</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  foreach($recuperer_afficher_depense as $liste_depense):?>
                                            <tr>
                                                <td><?= date_format(date_create($liste_depense->date),'d-m-Y') ?></td>
                                                <td><?= $liste_depense->reference_caisse ?></td>
                                                <td><?= $liste_depense->libelle ?></td>
                                                <td><?= $liste_depense->montant ?></td>
                                                <td>
                                                    <!-- Bouton de détail -->
                                                    <a href="detail_depense.php?detail=<?= $liste_depense->id_depense ?>"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="ri-eye-fill"></i>
                                                    </a>&emsp;
                                                    <a href="modifier_depense.php?id=<?=$liste_depense->id_depense?>" 
                                                        class="btn btn-info btn-sm">
                                                        <i class="bx bxs-edit"></i>
                                                    </a>&emsp;
                                                    
                                                    <!-- Bouton de suppression -->
                                                <a class="btn btn-danger btn-sm delete-button" href="id=<?= $liste_depense->id_depense ?>"
                                                    data-depense-id="<?= $liste_depense->id_depense ?>">
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
        document.addEventListener("DOMContentLoaded", function () {
            var deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    // Obtenez l'ID à partir de l'attribut "id" du bouton
                     var liste_depenseniId = button.getAttribute('data-depense-id');

                    //  console.log(liste_depenseniId); // Vérifiez dans la console du navigateur

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
                            window.location.href = 'supprimer_lsite_depense.php?id=' + liste_depenseniId + '&confirm=true';
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


    
   
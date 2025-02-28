<!DOCTYPE html>
<html lang="en">
<?php require_once ('partials/database.php') ?>
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
  
  .table-bordered .selectable-row.selected td {
    background-color: #d3f9d8 !important;
}
        </style>
        
    <main id="main" class="main">
         <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <li class="breadcrumb-item">Espace de vente</li>
          <li class="breadcrumb-item active">Liste des ventes réalisées</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                              <!-- Ajout du formulaire de recherche -->
                            <form action="" method="POST" class="mb-3" onsubmit="hideMainTable(event)">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Rechercher par référence ou date de commande..." onclick="hideMainTableOnFocus()">
                                    <button type="submit" class="btn btn-primary">Rechercher</button>
                                </div>
                            </form>
                          <!-- Table principale -->
                            <div class="table-responsive">
                            <table class="table  table-bordered table-striped search-table" id="main-table">
                                <thead>
                                    <tr>
                                        <th>Date de la vente</th>
                                        <th>Client</th>
                                        <th>Montant total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Boucle sur les ventes -->
                                  
                                    <?php   $total_ventes = 0; 
                                    foreach ($recuperer_afficher_vente as $liste_vente_reali) { 
                                        $total_ventes += $liste_vente_reali->montant_total; // Ajout au total
                                        ?>
                                        <tr class="selectable-row">
                                            <!-- Affichage des données de vente -->
                                            <td><?= date_format(date_create($liste_vente_reali->date_vente), 'd-m-Y à H:i') ?></td>
                                            <td><?= $liste_vente_reali->nom_client ?></td>
                                            <td class="montant_total"><?= number_format($liste_vente_reali->montant_total, 0, ',', ' ') ?> F CFA</td> 
                                            <td>
                                                <!-- Bouton de détail -->
                                                <a href="detail_vente.php?detail=<?= $liste_vente_reali->id_vente?>" class="btn btn-primary btn-sm">
                                                    <i class="ri-eye-fill"></i>
                                                </a>&emsp;
                                                    <!-- Bouton pour le pdf -->
                                                <a href="pdf_cmnd_ventedirect.php?detail=<?=$liste_vente_reali->id_vente?>"
                                                    class="btn btn-danger btn-sm" target="_blank">
                                                    <i class="bi bi-printer-fill"></i>
                                                </a>&emsp;
                                                <!-- Bouton de suppression -->
                                                <a href="" class="btn btn-danger btn-sm delete-button" data-livraison-id="<?= $liste_vente_reali->id_vente ?>">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-left">Total Sélectionné :</th>
                                        <th id="selected-total" class="text-right">0 F CFA</th>
                                    </tr>
                                </tfoot>
                             
                            </table>
                            </div>
                        <!-- End Table with stripped rows -->
                            <?php
                                if (isset($_POST['search']) && !empty($_POST['search'])) {
                                    $search = htmlspecialchars($_POST['search']);
                                    $articles = $bdd->query('SELECT * FROM vente  
                                        WHERE nom_client LIKE "%'.$search.'%"  OR date_vente LIKE "%'.$search.'%"
                                        ORDER BY id_vente DESC');
                                    if ($articles->rowCount() > 0) {
                            ?>
                            <!-- Table des résultats de recherche -->
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>DATE</th>
                                                <th>ClIENTS</th>
                                                <th>MONTANT TOTAL</th>
                                                <th>REMISE</th>
                                                <th>NET À PAYER</th>
                                                <th>MONTANT REÇU</th>
                                                <th>MONNAIE REMBOURSÉE</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($a = $articles->fetch()) {?>
                                                <tr>
                                                    <td><?= date_format(date_create($a['date_vente']), 'd-m-Y H:i:s') ?></td>
                                                    <td><?= $a['nom_client'] ?></td>
                                                    <td><?= $a['montant_total'] ?>F CFA</td>
                                                    <td><?= $a['remise']?>F CFA</td>
                                                    <td><?= $a['net_a_payer']?>F CFA</td>
                                                    <td><?= $a['montant_recu']?>F CFA</td>
                                                    <td><?= $a['monnaie_rembourse']?>F CFA</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p class="text-danger">Aucun résultat pour <?= $search ?>...</p>
                                <?php } ?>
                            <?php } ?>
                     
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
                            // Redirige vers la page supprimer_listeVente.php 
                            window.location.href = 'supprimer_listeVente.php?id=' + livraisonId + '&confirm=true';
                        }
                    });
                });
            });
        });
    </script>
        <script>
            function hideMainTableOnFocus() {
                var mainTable = document.getElementById("main-table");
                // Cache la table principale lorsqu'on clique sur le champ de recherche
                mainTable.style.display = "none"; 
            }     
        </script>
         <script>
            let isMouseDown = false; // Pour détecter un appui long
            let selectedRows = []; // Tableau pour stocker les lignes sélectionnées

            $(document).ready(function () {
                // Détection de l'appui long sur une ligne
                $('.selectable-row').on('mousedown', function () {
                    isMouseDown = true; // Active la sélection
                    toggleRowSelection($(this)); // Sélectionner ou désélectionner
                });

                // Arrêter la sélection lors du relâchement du clic
                $(document).on('mouseup', function () {
                    isMouseDown = false; // Désactive la sélection
                    calculateSum(); // Calcule la somme après sélection
                });

                // Permet de glisser pour sélectionner plusieurs lignes
                $('.selectable-row').on('mouseover', function () {
                    if (isMouseDown) {
                        toggleRowSelection($(this)); // Sélectionne la ligne survolée
                    }
                });

                // Fonction pour basculer l'état de sélection d'une ligne
                function toggleRowSelection(row) {
                    row.toggleClass('selected'); // Ajoute ou enlève la classe 'selected'
                }

                // Calculer la somme des lignes sélectionnées
                function calculateSum() {
                    let totalSum = 0;
                   
                    $('.selected').each(function () {
                        // Récupérer les valeurs des colonnes sélectionnées
                        let total = parseFloat($(this).find('.montant_total').text().replace(/[^0-9,.]/g, '').replace(',', '.'));
                        
                        totalSum += total;
                       
                    });

                    // Afficher les résultats formatés
                    let formattedTotal = new Intl.NumberFormat('fr-FR', {
                        style: 'currency',
                        currency: 'XOF'
                    }).format(totalSum);

                 

                    // Mise à jour du pied de page
                    $('#selected-total').text(formattedTotal);
                   
                }
            });
            
</script>
</body>

</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('partials/header.php');?>
</head>
<body>
    <?php require_once('partials/sidebar.php');?>
    <?php require_once('partials/navbar.php');?>
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
        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
            text-transform: uppercase;
            font-size: xx-small;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
    </style>




    <main id="main" class="main">
        <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <li class="breadcrumb-item">Commande client</li>
          <li class="breadcrumb-item active">Liste de la commande</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
        <section class="section">
               <?php require_once('partials/afficher_message.php')?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                         <div class="ms-auto mb-3 mr-2 mt-2">
    						<div class="btn-group">
    							<div class="">
									<a href="commande_client.php" class="btn btn-dark mb-3 mb-lg-0">
										<i class='bx bxs-plus-square'></i> Commande
									</a>
								</div>
    						</div>
    					</div>
                        <div class="card-body">
                             <!-- Ajout du formulaire de recherche -->
                            <form action="" method="POST" class="mb-3" onsubmit="hideMainTable(event)">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Rechercher par référence ou date de commande ou nom et prenom client..." onclick="hideMainTableOnFocus()">
                                    <button type="submit" class="btn btn-primary">Rechercher</button>
                                </div>
                            </form>
                            <!-- Table principale -->
                            <div class="table-responsive">                         
                                <table class="table  table-bordered table-striped search-table" id="main-table">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>REFERENCES</th>
                                            <th>Client</th>
                                            <th>RESPONSBLE</th>
                                            <th>TOTAL</th>
                                            <th>PAYER</th>
                                            <th>STATUT</th>
                                            <th width='3%'>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_ventes =0;
                                        $total_paie =0;
                                        foreach ($liste_commandes_recentes as $affiche) {
                                            // Calcul des sommes des quantités
                                            $total_ventes += $affiche->total;
                                            $total_paie += $affiche->paie;
                                            $somme_qte = $bdd->prepare("SELECT SUM(quantite) as qte FROM ligne_commande_client 
                                            WHERE id_cmd_client=$affiche->id_cmd_client");
                                            $somme_qte->execute();
                                            $ro = $somme_qte->fetch(PDO::FETCH_ASSOC);
                                            $somme = $ro['qte'];
                                            $somme_qte_liv = $bdd->prepare("SELECT SUM(qte_livre) as qli FROM ligne_commande_client 
                                            WHERE id_cmd_client=$affiche->id_cmd_client");
                                            $somme_qte_liv->execute();
                                            $row = $somme_qte_liv->fetch(PDO::FETCH_ASSOC);
                                            $som = $row['qli'];
                                        ?>
                                            <tr class="selectable-row">
                                                <td><?= date_format(date_create($affiche->date_cmd_client), 'd-m-Y à H:i') ?></td>
                                                <td><?= $affiche->reference ?></td>                                             
                                                <td><span class='badge badge-dark' style="font-size: xx-small; font-weight: bold; font-style: italic;"><?= strtoupper($affiche->prenom_du_client_grossiste) ?> <?= strtoupper($affiche->nom_client_grossiste) ?></span></td>
                                                <td><span class='badge badge-success' style="font-size: xx-small; font-weight: bold; font-style: italic;"><?= strtoupper($affiche->nom_utilisateur) ?> <?= strtoupper($affiche->prenom_utilisateur) ?></span></td>
                                                <td class="total"><?= number_format($affiche->total, 0, ',', ' ') ?> F CFA</td>
                                                <td class="paie"><?= number_format($affiche->paie, 0, ',', ' ') ?> F CFA</td>
                                               <td>
                                                    <?php
                                                    // Affichage du statut de livraison et de paiement
                                                    if ($som == 0) {
                                                        echo "<span class='badge badge-danger'>Non livré</span>";
                                                    } elseif ($somme > $som && $som > 0) {
                                                        echo "<span class='badge badge-info'>Livraison partielle</span>";
                                                    } else {
                                                        echo "<span class='badge badge-success'>Livré</span>";
                                                    }
                                                    echo " | ";
                                                    if ($affiche->paie == 0) {
                                                        echo "<span class='badge badge-danger'>Non payé</span>";
                                                    } elseif ($affiche->total > $affiche->paie && $affiche->paie > 0) {
                                                        echo "<span class='badge badge-info'>Payé partiellement</span>";
                                                    } else {
                                                        echo "<span class='badge badge-success'>Payé</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td scope="col">
                                                    <!-- Actions disponibles dans un menu déroulant -->
                                                <div class="dropdown">
                                                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bi bi-three-dots text-center"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <h6 class="dropdown-header">Veuillez faire un choix</h6>
                                                        <a class="dropdown-item" href="detail_com_client.php?detail=<?= $affiche->id_cmd_client ?>">Voir la commande</a>
                                                        <a class="dropdown-item" href="pdf_cmnd_client.php?detail=<?= $affiche->id_cmd_client ?>" target="_blank">imprimer</a>
                                                        <?php if ($affiche->total > $affiche->paie) { ?>
                                                            <a class="dropdown-item" href="paiement_client.php?paiement=<?= $affiche->id_cmd_client ?>">Paiement</a>
                                                        <?php } ?>
                                                        <?php if ($somme > $som) { ?>
                                                            <a class="dropdown-item" href="envoie_livraison.php?livraison=<?= $affiche->id_cmd_client ?>">Livraison</a>
                                                            <?php if ($som == 0 && $affiche->paie == 0) { ?>
                                                                <a class="dropdown-item" href="modifier_commande_client.php?modifi=<?= $affiche->id_cmd_client ?>">Modification</a>
                                                                <a class="dropdown-item delete-button" href="#" data-liste-id="<?= $affiche->id_cmd_client ?>">Suppression</a>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-left">Total Sélectionné :</th>
                                            <th id="selected-total" class="text-right">0 F CFA</th>
                                            <th id="selected-paie" class="text-right">0 F CFA</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                             <?php
                           if (isset($_POST['search']) && !empty($_POST['search'])) {
                                    $search = htmlspecialchars($_POST['search']);
                                    $articles = $bdd->query('SELECT * FROM commande_client 
                                                            JOIN client_grossiste ON client_grossiste.id_client_gr = commande_client.id_client_gr
                                                            WHERE reference LIKE "%' . $search . '%" 
                                                            OR date_cmd_client LIKE "%' . $search . '%" 
                                                            OR nom_client_grossiste LIKE "%' . $search . '%"
                                                            OR prenom_du_client_grossiste LIKE "%' . $search . '%"
                                                            ORDER BY id_cmd_client DESC');
                                    if ($articles->rowCount() > 0) {
                                ?>
                                    <!-- Table des résultats de recherche -->
                                    <table class="table table-bordered table-striped datatable">
                                        <thead>
                                            <tr>
                                                <th>DATE</th>
                                                <th>REFERENCE</th>
                                                <th>CLIENT</th>
                                                <th>TOTAL</th>
                                                <th>PAYER</th>
                                                <th>STATUT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($a = $articles->fetch()) {
                                                // Calcul des sommes des quantités
                                                $somme_qte = $bdd->prepare("SELECT SUM(quantite) as qte FROM ligne_commande_client 
                                                                            WHERE id_cmd_client = ?");
                                                $somme_qte->execute([$a['id_cmd_client']]);
                                                $ro = $somme_qte->fetch(PDO::FETCH_ASSOC);
                                                $somme = $ro['qte'];
                                                $somme_qte_liv = $bdd->prepare("SELECT SUM(qte_livre) as qli FROM ligne_commande_client 
                                                                                WHERE id_cmd_client = ?");
                                                $somme_qte_liv->execute([$a['id_cmd_client']]);
                                                $row = $somme_qte_liv->fetch(PDO::FETCH_ASSOC);
                                                $som = $row['qli'];
                                            ?>
                                                <tr>
                                                    <td><?= date_format(date_create($a['date_cmd_client']), 'd-m-Y H:i:s') ?></td>
                                                    <td><?= $a['reference'] ?></td>
                                                    <td><?= $a['nom_client_grossiste'] ?> <?= $a['prenom_du_client_grossiste'] ?></td>
                                                    <td><?= $a['total'] ?> F CFA</td>
                                                    <td><?= $a['paie'] ?> F CFA</td>
                                                    <td>
                                                        <?php
                                                        // Affichage du statut de livraison et de paiement
                                                        if ($som == 0) {
                                                            echo " <span class='badge badge-danger'> Non Livré </span>";
                                                        } elseif ($somme > $som && $som > 0) {
                                                            echo " <span class='badge badge-info'> Livraison partielle </span>";
                                                        } else {
                                                            echo "<span class='badge badge-success'> Livré </span>";
                                                        }
                                                        echo "|";
                                                        if ($a['paie'] == 0) {
                                                            echo "<span class='badge badge-danger'> Non payé </span>";
                                                        } elseif ($a['total'] > $a['paie'] && $a['paie'] > 0) {
                                                            echo "<span class='badge badge-info'> Payé partiellement </span>";
                                                        } else {
                                                            echo "<span class='badge badge-success'> Payé </span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    
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

                    // Obtenir l'ID à partir de l'attribut "id" du bouton
                    var liste_cmnd_clientId = button.getAttribute('data-liste-id');

                     console.log(liste_cmnd_clientId); // Vérifiez dans la console du navigateur

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
                            // Redirige vers la page supprimer_commande_client.php avec l'ID de la commande_client
                            window.location.href = 'supprimer_Listcommande_client.php?id=' + liste_cmnd_clientId + '&confirm=true';
                        }
                    });
                });
            });
        });
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
                    let totalPaie = 0;

                    $('.selected').each(function () {
                        // Récupérer les valeurs des colonnes sélectionnées
                        let total = parseFloat($(this).find('.total').text().replace(/[^0-9,.]/g, '').replace(',', '.'));
                        let paie = parseFloat($(this).find('.paie').text().replace(/[^0-9,.]/g, '').replace(',', '.'));

                        totalSum += total;
                        totalPaie += paie;
                    });

                    // Afficher les résultats formatés
                    let formattedTotal = new Intl.NumberFormat('fr-FR', {
                        style: 'currency',
                        currency: 'XOF'
                    }).format(totalSum);

                    let formattedPaie = new Intl.NumberFormat('fr-FR', {
                        style: 'currency',
                        currency: 'XOF'
                    }).format(totalPaie);

                    // Mise à jour du pied de page
                    $('#selected-total').text(formattedTotal);
                    $('#selected-paie').text(formattedPaie);
                }
            });
            
    </script>
     <script>
        function hideMainTableOnFocus() {
            var mainTable = document.getElementById("main-table");
            // Cache la table principale lorsqu'on clique sur le champ de recherche
            mainTable.style.display = "none"; 
        }     
    </script>
</body>

</html>

<?php require_once('function/function.php');?>
<!--------header------->
<?php require_once('partials/header.php') ?>
<!-------------sidebar----------->
<?php require_once('partials/sidebar.php')?>
<!-------------navbar----------->
<?php require_once('partials/navbar.php')?>

<html>
<body>
    <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px; /* Hauteur du pied de page */
            background-color: #f5f5f5; /* Ajoutez la couleur de fond souhaitée */
        }
    </style>
      <style>
  
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
                    <li class="breadcrumb-item">Commande fournisseur</li>
                    <li class="breadcrumb-item active">liste des commandes</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
             <?php require_once('partials/afficher_message.php')?>
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
                            <table class="table  table-bordered table-striped search-table" id="main-table">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>REFERENCES</th>
                                        <th>FOURNISSEUR</th>
                                        <th>TOTAL</th>
                                        <th>PAYER</th>
                                        <th>STATUT</th>
                                        <th width='3%'>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($liste_commandes_recentes as $affiche) {
                                        // Calcul des sommes des quantités
                                        $somme_qte = $bdd->prepare("SELECT SUM(quantite) as qte FROM ligne_commande 
                                            WHERE id_commande_fournisseur=?");
                                        $somme_qte->execute([$affiche->id_commande_fournisseur]);
                                        $ro = $somme_qte->fetch(PDO::FETCH_ASSOC);
                                        $somme = $ro['qte'];
                                        
                                        $somme_qte_liv = $bdd->prepare("SELECT SUM(qte_livre) as qli FROM ligne_commande 
                                            WHERE id_commande_fournisseur=?");
                                        $somme_qte_liv->execute([$affiche->id_commande_fournisseur]);
                                        $row = $somme_qte_liv->fetch(PDO::FETCH_ASSOC);
                                        $som = $row['qli'];
                                    ?>
                                        <tr class="selectable-row">
                                            <td><?= date_format(date_create($affiche->date_de_commande), 'd-m-Y à H:i') ?></td>
                                            <td><?= $affiche->reference ?></td>
                                            <td><?= $affiche->nom_fournisseur ?> <?= $affiche->prenom_fournisseur ?></td>
                                            <td class="total"><?= number_format($affiche->total, 0, ',', ' ') ?> F CFA</td>
                                            <td class="paie"><?= number_format($affiche->paie, 0, ',', ' ') ?> F CFA</td>
                                            <td>
                                                <?php
                                                // Affichage du statut de livraison et de paiement
                                                if ($som == 0) {
                                                    echo " <span class='text-danger'> Non reçue </span>";
                                                } elseif ($somme > $som && $som > 0) {
                                                    echo " <span class='text-info'> Reception partielle </span>";
                                                } else {
                                                    echo "<span class='text-success'> reçue </span>";
                                                }
                                                echo "|";
                                                if ($affiche->paie == 0) {
                                                    echo "<span class='text-danger'> Non payé </span>";
                                                } elseif ($affiche->total > $affiche->paie && $affiche->paie > 0) {
                                                    echo "<span class='text-info'> Payé partiellement </span>";
                                                } else {
                                                    echo "<span class='text-success'> Payé </span>";
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
                                                        <a class="dropdown-item" href="detail_com_four.php?detail=<?= $affiche->id_commande_fournisseur ?>">Voir la commande</a>
                                                        <a class="dropdown-item" href="pdf_cmnd_four.php?detail=<?= $affiche->id_commande_fournisseur ?>" target="_blank">imprimer</a>
                                                        <?php if ($affiche->total > $affiche->paie) { ?>
                                                            <a class="dropdown-item" href="paiement.php?paiement=<?= $affiche->id_commande_fournisseur ?>">Paiement</a>
                                                        <?php } ?>
                                                        <?php if ($somme > $som) { ?>
                                                            <a class="dropdown-item" href="envoie_reception.php?reception=<?= $affiche->id_commande_fournisseur ?>">Reception</a>
                                                            <?php if ($som == 0 && $affiche->paie == 0) { ?>
                                                                <a class="dropdown-item" href="modifier_commande_four.php?modifi=<?= $affiche->id_commande_fournisseur ?>">Modification</a>
                                                                
                                                                <a class="dropdown-item delete-button" href="#" data-liste-id="<?= $affiche->id_commande_fournisseur ?>">Suppression</a>
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
                                        <th colspan="3" class="text-left">Total Sélectionné :</th>
                                        <th id="selected-total" class="text-right">0 F CFA</th>
                                        <th id="selected-paie" class="text-right">0 F CFA</th>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php
                            if (isset($_POST['search']) && !empty($_POST['search'])) {
                                $search = htmlspecialchars($_POST['search']);
                                $articles = $bdd->query('SELECT * FROM commande_fournisseur 
                                    JOIN fournisseur ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur 
                                    WHERE reference LIKE "%'.$search.'%" OR date_de_commande LIKE "%'.$search.'%" 
                                    ORDER BY id_commande_fournisseur DESC');
                                if ($articles->rowCount() > 0) {
                            ?>
                                    <!-- Table des résultats de recherche -->
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>DATE</th>
                                                <th>REFERENCES</th>
                                                <th>FOURNISSEUR</th>
                                                <th>TOTAL</th>
                                                <th>PAYER</th>
                                                <th>STATUT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($a = $articles->fetch()) {
                                                // Calcul des sommes des quantités
                                                $somme_qte = $bdd->prepare("SELECT SUM(quantite) as qte FROM ligne_commande 
                                                WHERE id_commande_fournisseur=?");
                                                $somme_qte->execute([$a['id_commande_fournisseur']]);
                                                $ro = $somme_qte->fetch(PDO::FETCH_ASSOC);
                                                $somme = $ro['qte'];
                                                $somme_qte_liv = $bdd->prepare("SELECT SUM(qte_livre) as qli FROM ligne_commande 
                                                WHERE id_commande_fournisseur=?");
                                                $somme_qte_liv->execute([$a['id_commande_fournisseur']]);
                                                $row = $somme_qte_liv->fetch(PDO::FETCH_ASSOC);
                                                $som = $row['qli'];
                                            ?>
                                                <tr>
                                                    <td><?= date_format(date_create($a['date_de_commande']), 'd-m-Y H:i:s') ?></td>
                                                    <td><?= $a['reference'] ?></td>
                                                    <td><?= $a['nom_fournisseur'] ?> <?= $a['prenom_fournisseur'] ?></td>
                                                    <td><?= $a['total'] ?>F CFA</td>
                                                    <td><?= $a['paie'] ?>F CFA</td>
                                                    <td>
                                                        <?php
                                                        // Affichage du statut de livraison et de paiement
                                                        if ($som == 0) {
                                                            echo " <span class='text-danger'> Non reçue </span>";
                                                        } elseif ($somme > $som && $som > 0) {
                                                            echo " <span class='text-info'> Reception partielle </span>";
                                                        } else {
                                                            echo "<span class='text-success'> reçue </span>";
                                                        }
                                                        echo "|";
                                                        if ($a['paie'] == 0) {
                                                            echo "<span class='text-danger'> Non payé </span>";
                                                        } elseif ($a['total'] > $a['paie'] && $a['paie'] > 0) {
                                                            echo "<span class='text-info'> Payé partiellement </span>";
                                                        } else {
                                                            echo "<span class='text-success'> Payé </span>";
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
        <script>
            function hideMainTableOnFocus() {
                var mainTable = document.getElementById("main-table");
                // Cache la table principale lorsqu'on clique sur le champ de recherche
                mainTable.style.display = "none"; 
            }     
        </script>
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
                    var liste_cmnd_fourId = button.getAttribute('data-liste-id');

                    console.log(liste_cmnd_fourId); // Vérifiez dans la console du navigateur

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
                            window.location.href = 'supprimer_Listcommande_four.php?id=' + liste_cmnd_fourId + '&confirm=true';
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
</body>

</html>
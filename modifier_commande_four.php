    <?php
    require_once('rentrer_anormal.php') ;
    require_once('partials/database.php');
    require_once('function/function.php');
    $produits = recuperation_fonction('*', 'fournisseur', [], "ALL");
    $produit=recuperation_fonction('*','tbl_product',[],"ALL");
    // Initialiser la variable de succès
    $modificationReussie = false;

   if (isset($_GET['modifi'])) {
    $modifi = $_GET['modifi'];
    $commande = $bdd->prepare("SELECT * FROM commande_fournisseur INNER JOIN fournisseur 
        ON fournisseur.id_fournisseur = commande_fournisseur.id_fournisseur WHERE id_commande_fournisseur = :id LIMIT 1");
    $commande->execute([':id' => $modifi]);
    $commandeinfo = $commande->fetch();

    // Afficher la ligne de commande
    $ligen_commande = $bdd->prepare("SELECT * FROM ligne_commande INNER JOIN tbl_product
        ON tbl_product.id = ligne_commande.id WHERE ligne_commande.id_commande_fournisseur = :id");
    $ligen_commande->execute([':id' => $modifi]);
    }

    // Si le formulaire est soumis
    if (isset($_POST['modifier'])) {
        $quantites = $_POST['quantite'];

        // Mettez à jour les quantités dans la base de données et le total
        $nouveauTotal = 0;
        foreach ($quantites as $idProduit => $nouvelleQuantite) {
            $updateQuantite = $bdd->prepare("UPDATE ligne_commande SET quantite = :quantite WHERE id_commande_fournisseur = :idCommande AND id = :idProduit");
            $updateQuantite->execute([':quantite' => $nouvelleQuantite, ':idCommande' => $modifi, ':idProduit' => $idProduit]);

            // Calculer le nouveau montant pour mettre à jour le total
            $produitInfo = $bdd->prepare("SELECT price FROM tbl_product WHERE id = :idProduit");
            $produitInfo->execute([':idProduit' => $idProduit]);
            $prixProduit = $produitInfo->fetchColumn();
            $nouveauTotal += $nouvelleQuantite * $prixProduit;
        }

        // Ajouter un nouveau produit à la commande
        if (!empty($_POST['nouveau_produit']) && !empty($_POST['nouvelle_quantite'])) {
            $nouveauProduitId = $_POST['nouveau_produit'];
            $nouvelleQuantite = $_POST['nouvelle_quantite'];

            $produitInfo = $bdd->prepare("SELECT price FROM tbl_product WHERE id = :idProduit");
            $produitInfo->execute([':idProduit' => $nouveauProduitId]);
            $prixProduit = $produitInfo->fetchColumn();

            $insertLigneCommande = $bdd->prepare("INSERT INTO ligne_commande (id_commande_fournisseur, id, quantite) VALUES (:idCommande, :idProduit, :quantite)");
            $insertLigneCommande->execute([':idCommande' => $modifi, ':idProduit' => $nouveauProduitId, ':quantite' => $nouvelleQuantite]);

            $nouveauTotal += $nouvelleQuantite * $prixProduit;
        }

        // Mettez à jour le total dans la commande_fournisseur
        $updateTotal = $bdd->prepare("UPDATE commande_fournisseur SET total = :total WHERE id_commande_fournisseur = :idCommande");
        $updateTotal->execute([':total' => $nouveauTotal, ':idCommande' => $modifi]);

        // Mettre à jour le fournisseur
        $updateFournisseur = $bdd->prepare("UPDATE commande_fournisseur SET id_fournisseur = :id_fournisseur WHERE id_commande_fournisseur = :idCommande");
        $updateFournisseur->execute([':id_fournisseur' => $_POST['id_fournisseur'], ':idCommande' => $modifi]);

        // Mettre à jour la date
        $updateDate = $bdd->prepare("UPDATE commande_fournisseur SET date_de_commande = :date_de_commande WHERE id_commande_fournisseur = :idCommande");
        $updateDate->execute([':date_de_commande' => $_POST['date_de_commande'], ':idCommande' => $modifi]);

        // Mettre à jour la variable de succès
        $modificationReussie = true;
    }

    ?>
<!--------header------->
<?php require_once('partials/header.php') ?>
<body>
<!-------------sidebare----------->
<?php require_once('partials/sidebar.php') ?>
<!-------------navebare----------->
<?php require_once('partials/navbar.php') ?>
<!-------------contenu----------->
<main id="main" class="main">
    <div class="card info-card sales-card">
        <div class="container-fluid">
            <div class="content">
               <div class="container col">
                    <div class="form-group">
                        <div class="card info-card sales-card">
                            <select class="form-select produit p-2" name="nouveau_produit" id="nouveau_produit">
                                <option value="#">Veuillez sélectionner un produit</option>
                                <?php foreach ($produit as $value) : ?>
                                    <option value="<?= $value->id ?>">
                                        <?= $value->name ?>&emsp;| Stock: <?= $value->stock ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                           <input type="hidden" id="nouvelle_quantite" value="1">

                        </div>
                    </div>
                    <form action="" method="post">
                        <section class="section mt-1">
                            <div class="row">
                                <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="col-md-12 table table-bordered table-striped table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>DESIGNATION</th>
                                                        <th>QUANTITE</th>
                                                        <th>PRIX D'ACHAT</th>
                                                        <th>Montant</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="ajout_tbody">
                                                    <?php
                                                    if (isset($ligen_commande)) {
                                                        $datashow = $ligen_commande->fetchAll(PDO::FETCH_OBJ);
                                                        foreach ($datashow as $affiche): ?>
                                                            <tr class="ligne-commande">
                                                                <div class="form-group">
                                                                    <td><input class="form-control" type="text" name="designation[]"
                                                                            value="<?= $affiche->name; ?>" readOnly></td>
                                                                    <td><input class="form-control quantite-input" type="number"
                                                                            name="quantite[<?= $affiche->id; ?>]"
                                                                            value="<?= $affiche->quantite; ?>"></td>
                                                                    <td><input class="form-control prix-input" type="number" name="prix[]"
                                                                            value="<?= $affiche->price; ?>" readOnly></td>
                                                                    <td class="montant"><?php echo $affiche->quantite * $affiche->price; ?></td>
                                                                    <td><button type="button" class="btn btn-danger remove-ligne" data-id="<?= $affiche->id; ?>">Supprimer</button></td>
                                                                </div>
                                                            </tr>
                                                        <?php endforeach; 
                                                    } ?>
                                                </tbody>
                                                <tr>
                                                    <td colspan="3" align="right"> Total </td>
                                                    <td align="right">
                                                        <input class="form-control total" type="number" name="total" value="<?= $commandeinfo['total'] ?>" readOnly>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card text-left">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Référence </label>
                                                <input type="text" name="ref" class="form-control" value="<?= $commandeinfo['reference'] ?>" readOnly>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label>Date</label>
                                                <input type="datetime-local" name="date_de_commande" class="form-control" id="date_input">
                                            </div>
                                            <div class="form-group mt-3">
                                                <label>Fournisseur</label>
                                                <select class="form-control produit form-select" name="id_fournisseur">
                                                    <?php foreach ($produits as $fournisseur) : ?>
                                                        <option value="<?= $fournisseur->id_fournisseur ?>" <?= ($fournisseur->id_fournisseur == $commandeinfo['id_fournisseur']) ? 'selected' : '' ?>>
                                                            <?= $fournisseur->nom_fournisseur . ' ' . $fournisseur->prenom_fournisseur ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group mt-5">
                                                <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>                                        
        </div>
    </div>
</main>
 <!-- Footer -->
    <footer class="footer">
        <?php require_once('partials/foot.php') ?>
        <?php require_once('partials/footer.php') ?>
    </footer>

    <script>
        // Obtenez la date et l'heure actuelles
        var date_input = new Date();
        // Formatage de la date et l'heure en chaîne compatible avec datetime-local
        var formattedDateTime = date_input.toISOString().slice(0, 16);
        // Définition de la valeur de l'élément datetime-local
        document.getElementById('date_input').value = formattedDateTime;
    </script>
    <script>
        // Récupérer l'élément input
        var input = document.getElementById('date_input');

        // Obtenir la date et l'heure actuelles
        var dateActuelle = new Date();
        var dateActuelleISO = dateActuelle.toISOString().slice(0, 16); // Format ISO sans les secondes et les millisecondes

        // Définir la valeur minimale pour l'input en utilisant la date actuelle
        input.min = dateActuelleISO;

        // Fonction de validation de la date
        function validateDate() {
            var selectedDate = new Date(input.value);
            if (selectedDate < dateActuelle) {
                // alert("Veuillez sélectionner une date et une heure actuelle ou future.");
                input.value = dateActuelleISO; // Réinitialiser à la date actuelle si une date passée est sélectionnée
            }
        }

        // Ajouter un écouteur d'événements pour la validation lorsqu'une nouvelle date est sélectionnée
        input.addEventListener('change', validateDate);
    </script>
    <script>
        $(document).ready(function () {
    $('#nouveau_produit').change(function () {
        var produit_id = $(this).val();
        var quantite = $('#nouvelle_quantite').val();

        if (produit_id !== '#' && quantite > 0) {
            $.ajax({
                url: 'ajax_modifier_cmnd_four.php',
                method: 'POST',
                data: { mon_id: produit_id, quantite: quantite, ajout: true },
                dataType: 'html',
                success: function (data) {
                    $('#ajout_tbody').html(data);
                    updateMontantTotal();
                    $('#nouvelle_quantite').val(1);
                },
                error: function (xhr, status, error) {
                    console.error('Erreur Ajax :', status, error);
                }
            });
        } else {
            alert('Veuillez sélectionner un produit et une quantité valide.');
        }
    });

    // Met à jour le montant total
    function updateMontantTotal() {
        var total = 0;
        $('#ajout_tbody tr').each(function () {
            var quantite = parseFloat($(this).find('.quantite-input').val());
            var prix = parseFloat($(this).find('.prix-input').val());
            var montant = quantite * prix;
            total += isNaN(montant) ? 0 : montant;

            $(this).find('.montant').text(montant.toFixed(2));
        });
        $('.total').val(total.toFixed(2));
    }

    // Suppression d'une ligne
    $(document).on('click', '.remove-ligne', function () {
        var produit_id = $(this).data('id');

        $.ajax({
            url: 'ajax_modifier_cmnd_four.php',
            method: 'POST',
            data: { mon_id: produit_id, supprimer: true },
            dataType: 'html',
            success: function (data) {
                $('#ajout_tbody').html(data);
                updateMontantTotal();
            },
            error: function (xhr, status, error) {
                console.error('Erreur Ajax :', status, error);
            }
        });
    });

    // Mise à jour de la quantité
    $(document).on('change', '.quantite-input', function () {
        var produit_id = $(this).data('id');
        var nouvelle_quantite = $(this).val();

        if (nouvelle_quantite > 0) {
            $.ajax({
                url: 'ajax_modifier_cmnd_four.php',
                method: 'POST',
                data: { mon_id: produit_id, quantite: nouvelle_quantite, maj_quantite: true },
                dataType: 'html',
                success: function (data) {
                    $('#ajout_tbody').html(data);
                    updateMontantTotal();
                },
                error: function (xhr, status, error) {
                    console.error('Erreur Ajax :', status, error);
                }
            });
        } else {
            alert('La quantité doit être supérieure à 0');
        }
    });

    // Initialisation de la date
    document.getElementById('date_input').value = new Date().toISOString().slice(0, 16);
});

    </script>

<!-- pour le champ select -->
    <script>
    $(document).ready(function() {
        $('#nouveau_produit').select2();
        $('#nouveau_produit').on('select2:select', function (e) {
            var data = e.params.data;
            $("#nouveau_produit option[value='" + data.id + "']").remove();
        });
    });
    </script>
    <script>
        $(document).ready(function() {
            $('#nouveau_produit').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
</body>
</html>

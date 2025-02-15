<?php
require_once('rentrer_anormal.php') ;
require_once('partials/database.php');
require_once('function/function.php');
$produits = recuperation_fonction('*', 'fournisseur', [], "ALL");
// Initialiser la variable de succès
$modificationReussie = false;

if (isset($_GET['modifi'])) {
    $modifi = $_GET['modifi'];
    $commande = $bdd->prepare("SELECT * FROM commande_fournisseur INNER JOIN fournisseur 
        ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur WHERE id_commande_fournisseur=:id LIMIT 1");
    $commande->execute([':id' => $modifi]);
    $commandeinfo = $commande->fetch();

    // Afficher la ligne de commande
    $ligen_commande = $bdd->prepare("SELECT * FROM ligne_commande INNER JOIN tbl_product
        ON tbl_product.id=ligne_commande.id WHERE ligne_commande.id_commande_fournisseur=:id");
    $ligen_commande->execute([':id' => $modifi]);
}

// Si le formulaire est soumis
if (isset($_POST['modifier'])) {
    $quantites = $_POST['quantite'];

    // Mettez à jour les quantités dans la base de données et le total
    $nouveauTotal = 0;
    foreach ($quantites as $idProduit => $nouvelleQuantite) {
        $updateQuantite = $bdd->prepare("UPDATE ligne_commande SET quantite=:quantite WHERE id_commande_fournisseur=:idCommande AND id=:idProduit");
        $updateQuantite->execute([':quantite' => $nouvelleQuantite, ':idCommande' => $modifi, ':idProduit' => $idProduit]);

        // Calculer le nouveau montant pour mettre à jour le total
        $produitInfo = $bdd->prepare("SELECT price FROM tbl_product WHERE id=:idProduit");
        $produitInfo->execute([':idProduit' => $idProduit]);
        $prixProduit = $produitInfo->fetchColumn();
        $nouveauTotal += $nouvelleQuantite * $prixProduit;
    }

    // Mettez à jour le total dans la commande_fournisseur
    $updateTotal = $bdd->prepare("UPDATE commande_fournisseur SET total=:total WHERE id_commande_fournisseur=:idCommande");
    $updateTotal->execute([':total' => $nouveauTotal, ':idCommande' => $modifi]);
    //mettre a jour le fournisseur
    $updateFournisseur = $bdd->prepare("UPDATE commande_fournisseur SET id_fournisseur=:id_fournisseur WHERE id_commande_fournisseur=:idCommande");
    $updateFournisseur->execute([':id_fournisseur' => $_POST['id_fournisseur'], ':idCommande' => $modifi]);
    //mettre a jour la date
        $updateDate = $bdd->prepare("UPDATE commande_fournisseur SET date_de_commande=:date_de_commande WHERE id_commande_fournisseur=:idCommande");
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
            <form action="" method="post">
                <section class="section mt-5">
                    <div class="row">
                        <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- Table with stripped rows -->
                                    <table class="col-md-12 table table-bordered table-striped table-condensed">
                                        <thead>
                                        <tr>
                                            <th>DESIGNATION</th>
                                            <th>QUANTITE</th>
                                            <th>PRIX D'ACHAT</th>
                                            <th>Montant</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $datashow = $ligen_commande->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($datashow as $affiche): ?>
                                            <tr class="ligne-commande">
                                                <div class="form-group">
                                                    <td><input class="form-control" type="text" name="designation"
                                                               value="<?= $affiche->name; ?>" readOnly></td>
                                                    <td><input class="form-control quantite-input" type="number"
                                                               name="quantite[<?= $affiche->id; ?>]"
                                                               value="<?= $affiche->quantite; ?>"></td>
                                                    <td><input class="form-control prix-input" type="number" name="prix"
                                                               value="<?= $affiche->price; ?>" readOnly></td>
                                                    <td class="montant"><?php echo $affiche->quantite * $affiche->price; ?></td>
                                                </div>
                                            </tr>
                                        <?php endforeach ?>
                                        <tr>
                                            <td colspan="3" align="right"> Total </td>
                                            <td align="right">
                                                <input class="form-control total" type="number" name="total"
                                                value="<?= $commandeinfo['total'] ?>" readOnly>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Référence </label>
                                        <input type="text" name="ref" class="form-control" id=""
                                        value="<?= $commandeinfo['reference'] ?>" readOnly>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Date</label>
                                        <input type="datetime-local" name="date_de_commande" class="form-control" id="date_input">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Fournisseur</label>
                                        <!-- Code HTML pour le champ de sélection -->
                                        <select class="form-control produit form-select" name="id_fournisseur" id="produit">
                                            <?php foreach ($produits as $fournisseur) : ?>
                                                <option value="<?= $fournisseur->id_fournisseur ?>" <?= ($fournisseur->id_fournisseur == $commandeinfo['id_fournisseur']) ? 'selected' : '' ?>>
                                                    <?= $fournisseur->nom_fournisseur . ' ' . $fournisseur->prenom_fournisseur ?>
                                                </option>
                                            <?php endforeach ?>
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
</main>
<?php require_once('partials/footer.php') ?>
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
    // Fonction pour mettre à jour le montant en temps réel
    function updateMontant(quantite, prix, montantElement, totalElement) {
        // Récupérer la quantité et le prix
        var quantiteValue = quantite.value;
        var prixValue = prix.value;

        // Calculer le nouveau montant
        var nouveauMontant = quantiteValue * prixValue;

        // Mettre à jour l'élément HTML avec le nouveau montant
        montantElement.innerHTML = nouveauMontant;

        // Mettre à jour le total
        updateMontantTotal();
    }

    function updateMontantTotal() {
        // Mettre à jour le total
        var lignesCommande = document.querySelectorAll('.ligne-commande');
        var nouveauTotal = 0;

        lignesCommande.forEach(function (ligne) {
            var montant = ligne.querySelector('.montant');
            nouveauTotal += parseFloat(montant.innerHTML);
        });

        // Mettre à jour le champ total
        var totalElement = document.querySelector('.total');
        totalElement.value = nouveauTotal;
    }

    // Ajouter un écouteur d'événements pour chaque ligne de commande
    document.addEventListener("DOMContentLoaded", function () {
        var lignesCommande = document.querySelectorAll('.ligne-commande');

        lignesCommande.forEach(function (ligne) {
            var quantiteInput = ligne.querySelector('.quantite-input');
            var prixInput = ligne.querySelector('.prix-input');
            var montantElement = ligne.querySelector('.montant');

            // Ajouter des écouteurs d'événements pour détecter les changements dans les champs de quantité
            quantiteInput.addEventListener('input', function () {
                updateMontant(quantiteInput, prixInput, montantElement);
            });
        });
    });

    // Affichage du SweetAlert après la modification réussie
    <?php if ($modificationReussie): ?>
    document.addEventListener("DOMContentLoaded", function () {
        Swal.fire("Modification effectuée avec succès!", "", "success").then(() => {
            window.location.href = "liste_commande_four.php";
        });
    });
    <?php endif; ?>
</script>
</body>
</html>

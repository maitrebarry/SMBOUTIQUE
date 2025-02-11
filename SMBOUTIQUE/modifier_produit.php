<!-- lien du base de donnees -->
<?php
// ob_start();
// session_start();

require_once('rentrer_anormal.php');
require_once('autoload.php');
require_once('function/function.php');

// Initialisation de la classe CommandeClient
$update = new CommandeClient();

// Récupération des données dans les champs
$recuperer = $update->recuperation_fonction("*", "tbl_product WHERE id=:id", ['id' => $_GET['id']]);
$boutique = $update->recuperation_fonction('*', 'boutique', [], 'ALL');
$unite = $update->recuperation_fonction('*', 'unite', [], 'ALL');

if (isset($_POST['modifier'])) {
    extract($_POST);

    // Valider et traiter les données
    if (empty($nom) || empty($marque)) {
        $update->errors[] = "Veuillez remplir tous les champs obligatoires.";
    }  else {
                // Mise à jour des données
                $update->update_data("
                    UPDATE tbl_product
                    SET 
                        name = :name,
                        marque_produit = :marque_produit,
                        prix_detail = :prix_detail,
                        alerte_article = :alerte_article,
                        id_boutique = :boutique,
                        id_unite = :unite
                    WHERE id = :id  ",
                    [
                        ":name" => $nom,
                        ":marque_produit" => $marque,
                        ":prix_detail" => $prix_d,
                        ":alerte_article" => $alerte,
                        ":boutique" => $boutique,
                        ":unite" => $unite,
                        ":id" => $_GET['id']
                    ]);

            // Affichage de SweetAlert après la modification réussie
            echo '<script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire("Modification effectuée avec succès!", "", "success").then(() => {
                        window.location.href = "liste_produit.php";
                    });
                });
            </script>';
        }
}
?>


<!--------header------->
<?php require_once('partials/header.php') ?>
<body>
<!-------------sidebar----------->
<?php require_once('partials/sidebar.php') ?>
<!-------------navbar----------->
<?php require_once('partials/navbar.php') ?>
<!-------------contenu----------->
<main id="main" class="main">
    <div class="card info-card sales-card">
        <div class="container-fluid">
            <form action="" method="post" class="form_content" id="form_content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9 col-md-10 col-xm-12 col-xs-12">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="">Nom</label> <br><br>
                                    <input type="text" name="nom" class="form-control" 
                                    value="<?php echo isset($recuperer->name) ? htmlspecialchars($recuperer->name) : ''; ?>">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Marque</label> <br><br>
                                    <input type="text" name="marque" class="form-control" 
                                    value="<?php echo isset($recuperer->marque_produit) ? htmlspecialchars($recuperer->marque_produit) : ''; ?>">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Prix détaillant</label> <br><br>
                                    <input type="number" name="prix_d" class="form-control" 
                                    value="<?php echo isset($recuperer->prix_detail) ? htmlspecialchars($recuperer->prix_detail) : ''; ?>">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Alerte de sécurité</label> <br><br>
                                    <input type="number" name="alerte" class="form-control" 
                                    value="<?php echo isset($recuperer->alerte_article) ? htmlspecialchars($recuperer->alerte_article) : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-xs-8 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mt-3">
                                        <label for=""> <span class="text-danger">*</span> Supermarché</label>
                                        <select name="boutique" class="form-control">
                                            <?php foreach ($boutique as $update_boutiq) : ?>
                                                <option value="<?= htmlspecialchars($update_boutiq->id_boutique) ?>" 
                                                    <?= (isset($recuperer->id_boutique) && $recuperer->id_boutique == $update_boutiq->id_boutique) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($update_boutiq->nom) ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for=""> <span class="text-danger">*</span> Unité</label>
                                        <select name="unite" class="form-control">
                                            <?php foreach ($unite as $value_unite) : ?>
                                                <option value="<?= htmlspecialchars($value_unite->id_unite) ?>" 
                                                    <?= (isset($recuperer->id_unite) && $recuperer->id_unite == $value_unite->id_unite) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($value_unite->symbole) ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="" align="right">
                        <input type="submit" name="modifier" value="Modifier" class="btn btn-info btn-bg">
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once('partials/footer.php'); ob_end_flush(); ?>
</body>
</html>

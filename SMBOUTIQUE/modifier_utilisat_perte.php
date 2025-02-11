<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
require_once('function/function.php');

// Initialisation de la classe CommandeClient
$update = new CommandeFour();

// Récupération des données dans les champs
$recuperer = $update->recuperation_fonction("*", "utilisation_pertes JOIN tbl_product ON tbl_product.id=utilisation_pertes.id_article WHERE id_utili_perte=:id", [':id' => $_GET['id']]);
$produits = recuperation_fonction('*', 'tbl_product', [], "ALL");

// Initialisation des variables
$typeUtilisationChecked = '';
$typePerteChecked = '';

// Récupération de la valeur de la case à cocher "type" depuis la base de données
$recupererType = $recuperer->type ?? '';

// Vérifiez la valeur récupérée et cochez la case appropriée
if ($recupererType === 'utilisation') {
    $typeUtilisationChecked = 'checked';
} elseif ($recupererType === 'perte') {
    $typePerteChecked = 'checked';
}

if (isset($_POST['modifier'])) {
    extract($_POST);

    // Récupération de l'ancienne quantité
    $ancienneQuantite = $recuperer->quantite;

    // Récupération de la nouvelle quantité
    $nouvelleQuantite = $quantite;

    // Calcul de la différence entre l'ancienne et la nouvelle quantité
    $differenceQuantite = $nouvelleQuantite - $ancienneQuantite;

    // Récupération de l'ancien stock 
    $ancienstock = $recuperer->stock;

    // Récupération de la valeur de la case à cocher "type"
    $type = isset($_POST['type']) ? $_POST['type'] : '';

    // Modification
    $update->update_data(
        "UPDATE utilisation_pertes
        SET 
            motif = :motif,
            quantite = :quantite,
            date = :date,
            type = :type,
            id_article = :id_article
        WHERE id_utili_perte = :id",
        [
            ":motif" => $motif,
            ":quantite" => $quantite,
            ":date" => $date,
            ":type" => $type,
            ":id_article" => $produit,
            ":id" => $_GET['id']
        ]
    );

    // Mise à jour du stock en fonction de l'augmentation ou de la diminution de la quantité
    $update->update_data(
        "UPDATE tbl_product
        SET 
            stock = stock - :differenceQuantite
        WHERE id = :id_article",
        [
            ":differenceQuantite" => $differenceQuantite,
            ":id_article" => $produit,
        ]
    );




    // affichage du SweetAlert après la modification réussie
    echo '<script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire("Modification effectuée avec succès!", "", "success").then(() => {
                window.location.href = "lsiteUtilisat_pert.php";
            });
        });
    </script>';
}
?>

 <title>Modifier Utilisation/pertes</title>
</head>
<body>
    <!-- Header -->
    <?php require_once('partials/header.php') ?>
    <!-- Sidebar -->
    <?php require_once('partials/sidebar.php') ?>
    <!-- Navbar -->
    <?php require_once('partials/navbar.php') ?>
     <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px; /* Hauteur du pied de page */
            background-color: #f5f5f5; /* Ajoutez la couleur de fond souhaitée */
        }
    </style>
    <!-- Contenu principal -->

<section class="section">
    <main id="main" class="main" >
        <div class="pagetitle">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Utilisation/pertes des articles</li>
                    <li class="breadcrumb-item active">Modifier Utilisations/pertes</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
        <div class="row">
            <!-- <div class="col-lg-1">
            </div> -->
                <div class="col-lg-12">
                    <div class="card">
                        <?php require_once('partials/afficher_message.php') ?>
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <!-- General Form Elements -->
                            <form method="POST" >
                                <div class="row mb-4">
                                    <label for="inputText" class="col-sm-2 col-form-label">Article</label>
                                    <div class="col-sm-4">
                                            <select class="form-control produit form-select" name="produit" id="produit">
                                                <?php foreach ($produits as $values) : ?>
                                                    <option value="<?= $values->id ?>" <?= ($values->id == $recuperer->id_article) ? 'selected' : '' ?>>
                                                        <?= $values->name ?>&emsp;| Stock: <?= $values->stock ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                    </div>
                                    <label for="inputNumber" class="col-sm-2 col-form-label">Quantité</label>
                                    <div class="col-sm-4">
                                        <input type="Number" name="quantite" class="form-control"
                                        value="<?=$recuperer->quantite?>">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="inputText" class="col-sm-2 col-form-label">Motif</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="motif" class="form-control" value="<?=$recuperer->motif?>">

                                    </div>
                                    <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-4">
                                        <input type="date"name="date" class="form-control"value="<?=$recuperer->date?>">
                                    </div>
                                </div>
                             <div class="row mb-4">
                                <label for="inputText" class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-4">
                                    <!-- Utilisation -->
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="type_utilisation" name="type" value="utilisation" <?= ($recupererType === 'utilisation') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="type_utilisation">Utilisation</label>
                                    </div>

                                    <!-- Perte -->
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="type_perte" name="type" value="perte" <?= ($recupererType === 'perte') ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="type_perte">Perte</label>
                                    </div>
                                </div>
                            </div>
                                 <div class="text-center">
                                    <button type="submit" class="btn btn-info"  name="modifier">Modifier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </main>
</section>
<!-- Footer -->
<footer class="footer">
    <?php require_once('partials/foot.php') ?>
    <?php require_once('partials/footer.php') ?>
</footer>
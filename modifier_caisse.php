<?php
require_once('autoload.php');

// Initialisation de la classe CommandeClient
$update = new CommandeClient();

// Récupération des données dans les champs
$recuperer = $update->recuperation_fonction("*", "caisse WHERE id_caisse=:id", [':id' => $_GET['id']]);

if (isset($_POST['modifier'])) {
    // Récupérer la valeur de la case à cocher
    $statut = isset($_POST['statut']) ? 'on' : 'off';

    // Modification
    $update->update_data(
        "UPDATE caisse
        SET 
            statut = :statut
        WHERE id_caisse=:id",
        [
            ':statut' => $statut,
            ':id' => $_GET['id']
        ]
    );

    // Affichage du SweetAlert après la modification réussie
    echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire("Modification effectuée avec succès!", "", "success").then(() => {
                    window.location.href = "liste_caisse.php";
                });
            });
        </script>';
}

?>

<?php require_once('partials/header.php'); ?>
<!-- Sidebar -->
<?php require_once('partials/sidebar.php') ?>

<!-- Navbar -->
<?php require_once('partials/navbar.php') ?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                <li class="breadcrumb-item">Caisse</li>
                <li class="breadcrumb-item active">Modifier caisse</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <?php require_once('partials/afficher_message.php'); ?>
        <form action="" method="post">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>

                            <!-- Rangée pour les champs d'entrée -->
                            <div class="row mb-3">
                                <label for="date" class="col-sm-1 col-form-label">Date<span class="text-danger">*</span></label>
                                <div class="col-sm-2">
                                    <input type="date" id="currentDate" class="form-control" name="date"
                                        value="<?php if (isset($_GET['id'])) {
                                                    echo $recuperer->date_caisse;
                                                } ?>">
                                </div>

                                <label for="reference" class="col-sm-1 col-form-label">Référence<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="reference" name="reference"
                                        value="<?php if (isset($_GET['id'])) {
                                                    echo $recuperer->reference_caisse;
                                                } ?>" readonly>
                                </div>

                                <label for="montant" class="col-sm-1 col-form-label">Montant Initial<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" id="montant" name="montant"
                                        value="<?php if (isset($_GET['id'])) {
                                                    echo $recuperer->montant_initial;
                                                } ?>" placeholder="montant initial">
                                </div>

                                <label for="statut" class="col-sm-1 col-form-label">Statut actif</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="form-check-input" id="statut" name="statut"
                                        <?php echo ($recuperer->statut == 'on') ? 'checked' : ''; ?>>
                                    <label for="statut" class="form-check-label"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <input type="submit" name="modifier" value="modifier" class="btn btn-info btn-bg">
                <a href="liste_caisse.php" class="btn btn-primary btn ">Liste caisse</a>
            </div>
        </form>
    </section>
</main><!-- End #main -->
<!-- Footer -->
<footer class="footer">
    <?php require_once('partials/foot.php') ?>
    <?php require_once('partials/footer.php') ?>
</footer>

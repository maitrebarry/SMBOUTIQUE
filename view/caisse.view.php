<!DOCTYPE html>
<html lang="en">
    <?php
    require_once('partials/database.php');
    $nbr_comde = "SELECT * FROM caisse";
    $nbr_comdes = $bdd->query($nbr_comde);
    $resultat = $nbr_comdes->rowCount();
    require_once('partials/header.php');
    ?>
<!-- Content -->
<body>

    <!-- Sidebar -->
    <?php require_once('partials/sidebar.php') ?>

    <!-- Navbar -->
    <?php require_once('partials/navbar.php') ?>

    <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px;
            background-color: #f5f5f5;
        }
    </style>

    <?php
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty($_POST["date"])) {
            $errors["date"] = "Le champ Date est requis.";
        }

        if (empty($_POST["reference"])) {
            $errors["reference"] = "Le champ Référence est requis.";
        }

        if (empty($_POST["montant"])) {
            $errors["montant"] = "Le champ Montant Initial est requis.";
        }
    }
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Caisse</li>
                    <li class="breadcrumb-item active">Registre de caisse</li>
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
                                        <input type="date" id="currentDate" class="form-control <?php echo isset($errors["date"]) ? 'is-invalid' : ''; ?>" name="date" value="">
                                        <div class="invalid-feedback"><?php echo isset($errors["date"]) ? $errors["date"] : ""; ?></div>
                                    </div>
                                    <label for="reference" class="col-sm-1 col-form-label">Référence<span class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control <?php echo isset($errors["reference"]) ? 'is-invalid' : ''; ?>" id="reference" name="reference"
                                            value="CAISSE-<?= date('m-Y-') ?>N°<?= $resultat + 1 ?>" readonly>
                                        <div class="invalid-feedback"><?php echo isset($errors["reference"]) ? $errors["reference"] : ""; ?></div>
                                    </div>

                                    <label for="montant" class="col-sm-1 col-form-label">Montant Initial<span class="text-danger">*</span></label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control <?php echo isset($errors["montant_initial"]) ? 'is-invalid' : ''; ?>" id="montant" name="montant_initial" value=""
                                            placeholder="montant initial">
                                        <div class="invalid-feedback"><?php echo isset($errors["montant_initial"]) ? $errors["montant_initial"] : ""; ?></div>
                                    </div>
                                    <label for="statut" class="col-sm-1 col-form-label">Statut</label>
                                    <div class="col-sm-1">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="statut" name="statut" checked>
                                            <label class="form-check-label" for="statut"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success" value="Sauvegarder" name="Sauvegarder">Sauvegarder</button>
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

    <script>
        // Fonction pour mettre à jour la date
        function updateDate() {
            var currentDate = new Date();
            var day = currentDate.getDate();
            var month = currentDate.getMonth() + 1;
            var year = currentDate.getFullYear();
            var formattedDate = year + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
            document.getElementById('currentDate').value = formattedDate;
        }

        // Événement de chargement de la fenêtre
        window.onload = function () {
            // Appel de la fonction pour mettre à jour la date
            updateDate();
        };
    </script>

</body>
</html>

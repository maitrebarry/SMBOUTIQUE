    <?php
    // Détermine quel bouton doit être actif en fonction de l'URL actuelle
    $current_page = basename($_SERVER['PHP_SELF']);

    $active_user = ($current_page == 'creer_utilisateur.php') ? 'active' : '';
    $active_unit = ($current_page == 'unite.php') ? 'active' : '';
    // $active_boutique = ($current_page == 'boutique.php') ? 'active' : '';
    // $active_owner = ($current_page == 'proprietaire.php') ? 'active' : '';
    ?>

    <!--------header------->
    <?php require_once('partials/header.php'); ?>
<body>
    <!-------------sidebar----------->
    <?php require_once('partials/sidebar.php'); ?>
    <!-------------navbar----------->
    <?php require_once('partials/navbar.php'); ?>

    <!-------------content----------->
    <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px;
            background-color: #f5f5f5;
        }

        .btn-light {
            float: right;
        }

        .bi-exclamation-triangle {
            font-size: 90px;
        }
        .btn-block {
            width: 100%;
            margin-bottom: 10px;
            padding: 25px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-weight: bolder;
            color: black;
        }
        .card-body a.btn-outline-primary {
        position: relative;
        cursor: pointer;
        }
        
        .card-body a.btn-outline-primary.active {
        outline: 2px solid #007bff;
        outline-offset: 2px;
        }
    </style>
        <?php $errors = []; $button_name='enregistrer'?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Configuration</li>
                    <li class="breadcrumb-item active">Création d'unité</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <?php require_once('partials/afficher_message.php'); ?>
            <div class="row">
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-header">
                            <h6>MENU</h6>
                        </div>
                        <div class="card-body">
                            <a href="creer_utilisateur.php" class="btn btn-outline-primary btn-block <?= $active_user; ?>">Compte utilisateur</a>
                            <a href="unite.php" class="btn btn-outline-primary btn-block <?= $active_unit; ?>">Unités</a>
                            <!-- <a href="boutique.php" class="btn btn-outline-primary btn-block <?= $active_boutique?>">Supermarchés</a>
                            <a href="proprietaire.php" class="btn btn-outline-primary btn-block <?= $active_owner; ?>">Proprietaire</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-10 col-xm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>UNITÉ</h6>
                        </div>
                        <div class="card-body">
                                <?php if (isset($unite->errors) and !empty($unite->errors)) : ?>
                                    <div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <?php foreach ($unite->errors as $error) : ?>
                                            <?= $error ?> <br>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label><span class="text-danger">*</span> Libellé</label>
                                        <input type="text" name="libelle" value="<?=$unite->get_valeur_input('libelle') ?>" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label><span class="text-danger">*</span> Symbole</label>
                                        <input type="text" name="symbole" value="<?= $unite->get_valeur_input('symbole') ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-xl-6 col-md-10 col-xs-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary form-control" name="enregistrer" data-bs-toggle="modal" data-bs-target="#basicModal">Enregistrer</button>
                                            <?php require_once('partials/confirmerEnregistrement.php'); ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-10 col-xs-12">
                                        <div class="form-group">
                                            <a href="liste_unite.php" class="btn btn-info form-control">Liste des unités</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <?php require_once('partials/foot.php'); ?>
        <?php require_once('partials/footer.php'); ?>
    </footer>
    <script>
        document.querySelectorAll('.card-body .btn-outline-primary').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.card-body .btn-outline-primary').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>
</body>
</html>

    <?php
    // Détermine quel bouton doit être actif en fonction de l'URL actuelle
    $current_page = basename($_SERVER['PHP_SELF']);

    $active_user = ($current_page == 'creer_utilisateur.php') ? 'active' : '';
    $active_unit = ($current_page == 'unite.php') ? 'active' : '';
    // $active_boutique = ($current_page == 'boutique.php') ? 'active' : '';
    // $active_owner = ($current_page == 'proprietaire.php') ? 'active' : '';
    ?>
<!--------header------->
<?php require_once('partials/header.php') ?>

<body>
    <!-------------sidebar----------->
    <?php require_once('partials/sidebar.php') ?>
    <!-------------navbar----------->
    <?php require_once('partials/navbar.php') ?>
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
    <?php $errors = [];
    $button_name = 'enregistrer' ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Configuration</li>
                    <li class="breadcrumb-item active">création de l'utilisateur</li>
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
                        <a href="creer_utilisateur.php" class="btn btn-outline-primary btn-block <?= $active_user; ?>">Ajouter utilisateur</a>
                        <a href="unite.php" class="btn btn-outline-primary btn-block <?= $active_unit; ?>">Unités</a>
                         <!-- <a href="boutique.php" class="btn btn-outline-primary btn-block <?= $active_boutique?>">Supermarchés</a>
                        <a href="proprietaire.php" class="btn btn-outline-primary btn-block <?= $active_owner; ?>">Proprietaire</a> -->
                    </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-10 col-xm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>ENREGISTREMENT D'UTILISATEUR</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <?php
                                if (isset($utilisateur->errors) and !empty($utilisateur->errors)) : ?>
                                    <div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <?php foreach ($utilisateur->errors as $error) : ?>
                                            <?= $error ?> <br>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label><span class="text-danger ">*</span> Nom</label>
                                        <input type="text" name="nom_utilisateur" value="<?= get_valeur_input('nom_utilisateur') ?>" class="form-control ">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label><span class="text-danger">*</span> prénom </label>
                                        <input type="text" name="prenom_utilisateur" value="<?= get_valeur_input('prenom_utilisateur') ?>" class="form-control ">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label> <span class="text-danger">*</span> contact </label>
                                        <input type="text" name="Contact_utilisateur" value="<?= get_valeur_input('Contact_utilisateur') ?> " oninput="formatPhoneNumber(this)" class="form-control " >
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label> <span class="text-danger">*</span> Email </label>
                                        <input type="email" name="email" value="<?= get_valeur_input('email') ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label><span class="text-danger">*</span> Mot_de_passe </label>
                                        <input type="password" name="mot_de_passe_utilisateur" class="form-control " value="<?= get_valeur_input('mot_de_passe_utilisateur') ?>">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label for="mot_de_passe_confirm"><span class="text-danger">*</span> confirmer mot de passe</label>
                                        <input type="password" value="<?= get_valeur_input('mot_de_passe_confirm') ?>" name="mot_de_passe_confirm" class="form-control" id="mot_de_passe_confirm">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label> <span class="text-danger">*</span> psedeau </label>
                                        <input type="usernamey" name="psedeau_utilisateur" value="<?= get_valeur_input('psedeau_utilisateur') ?>" class="form-control ">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label><span class="text-danger">*</span> Adresse </label>
                                        <input type="text" name="adress" value="<?= get_valeur_input('adress') ?>" class="form-control " id="exampleInputPassword1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label for=""> <span class="text-danger">*</span> type_utilisateur</label>
                                        <select class="custom-select" name="type_utilisateur" id="" required>
                                            <option selected>Veuillez sélectionner votre rôle</option>
                                            <?php if ($_SESSION['type_utilisateur'] === 'Superadmin') { ?>
                                                <option value="Administrateur">Administrateur</option>
                                            <?php } ?>
                                            <option value="utilisateur">utilisateur</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label><span class="text-danger">*</span> Photo </label>
                                        <input type="file" name="avatar" value="<?= get_valeur_input('avatar') ?>" class="form-control ">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" name="enregistrer" data-bs-toggle="modal" data-bs-target="#basicModal">Enregistrer </button>
                                    <?php require_once('partials/confirmerEnregistrement.php'); ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="footer">
        <?php require_once('partials/foot.php') ?>
        <?php require_once('partials/footer.php') ?>
    </footer>

    <script>
        document.querySelectorAll('.card-body .btn-outline-primary').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.card-body .btn-outline-primary').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
    </script>
   

<script>
    function formatPhoneNumber(input) {
        // Retirer tous les caractères non numériques
        let cleaned = input.value.replace(/\D/g, '');
        // Ajouter des espaces après chaque paire de chiffres
        let formatted = cleaned.replace(/(\d{2})(?=\d)/g, '$1 ');
        // Mettre à jour le champ de saisie avec le numéro formaté
        input.value = formatted;
    }
</script>

</body>
</html>
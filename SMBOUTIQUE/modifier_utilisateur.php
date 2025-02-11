<?php 
require_once('rentrer_anormal.php') ;
require_once('autoload.php');
// Initialisation de la classe
$update = new CommandeFour();
// Récupération des données dans les champs
$modifier = $update->recuperation_fonction("*", "utilisateur WHERE id_utilisateur=:id", [':id' => $_GET['id']]);
// var_dump($modifier);exit;
if (isset($_POST['modification'])) {
        extract($_POST);
        if ($update->user_verify("psedeau_utilisateur", "utilisateur", $psedeau_utilisateur)) {
                  $update->errors[]="Ce pseudo existe déjà";
                  $update->garder_valeur_input();
            }
         // Vérification du numéro de téléphone
    $resultat_verification=$update->telephone_numero_verification($Contact_utilisateur);
    if ($resultat_verification !== "Numéro de téléphone valide "){
         $update->errors[] = $resultat_verification;
    }else{
        // Vérification si le nouveau numéro de téléphone est différent de l'ancien et s'il existe déjà dans la base de données
        $ancien_contact = $modifier->Contact_utilisateur;
        if ($Contact_utilisateur != $ancien_contact && $update->user_verify("Contact_utilisateur", "utilisateur", $Contact_utilisateur, $_GET['id'])) {
            // Le nouveau numéro de téléphone existe déjà dans la base de données
            $update->errors[] = "Ce contact existe déjà, veuillez choisir un autre.";
        } else {
            // Le nouveau numéro de téléphone est valide, procéder à la modification
            // Modification
                $update->update_data('UPDATE utilisateur 
                    SET nom_utilisateur=:nom_utilisateur,
                        prenom_utilisateur=:prenom_utilisateur,
                        psedeau_utilisateur=:psedeau_utilisateur,
                        adresse=:adresse,
                        Contact_utilisateur=:Contact_utilisateur,
                        email=:email,
                        type_utilisateur=:type_utilisateur
                    WHERE id_utilisateur=:id',
                    [
                        ':nom_utilisateur' => $nom_utilisateur,
                        ":prenom_utilisateur" => $prenom_utilisateur,
                        ":psedeau_utilisateur" => $psedeau_utilisateur,
                        ":adresse" => $adresse,
                        ":Contact_utilisateur" => $Contact_utilisateur,
                        ":email" => $email,
                        "type_utilisateur"=>$type_utilisateur,
                        ':id' => $_GET['id']
                    ]);
            // affichage du SweetAlert après la modification réussie
            echo '<script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire("Modification effectuée avec succès!", "", "success").then(() => {
                        window.location.href = "liste_utilisateur.php";
                    });
                });
            </script>';
            }
        }
}

// Affichage des erreurs s'il y en a
if (!empty($update->errors)) {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    text: "'.implode("<br>", $update->errors).'"
                });
            });
          </script>';
}
?>
<!--------header------->
<?php require_once ('partials/header.php') ?>

<body>
    <!-------------sidebar----------->
    <?php require_once ('partials/sidebar.php')?>
    <!-------------navbar----------->
    <?php require_once ('partials/navbar.php')?>
    <!-------------content----------->
    <style>
        html {
            height: 100vh;
        }

        body {
            height: 100%;
        }

        .global-container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        form {
            padding-top: 10px;
            font-size: 14px;
            margin-top: 10px;
        }

        .card-title {
            font-weight: 300;
        }

        .btn {
            font-size: 14px;
            margin-top: 20px;
        }

        .login-form {
            width: 330px;
        }

        .sign-up {
            text-align: center;
            padding: 20px 0 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px; /* Height of the footer */
            background-color: #f5f5f5; /* Add the desired background color */
        }
    </style>
<?php $errors = []; $button_name='modification'?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">utilisateur</li>
                    <li class="breadcrumb-item active">modifier utilisateur</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="card info-card sales-card">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-xm-12 col-xs-12">
                    <div class="card-body bg-white">
                        <div class="card-text bg-white">
                            <form method="POST">
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label><span class="text-danger ">*</span> Nom</label>
                                        <input type="text" name="nom_utilisateur" value="<?=$modifier->nom_utilisateur?>" class="form-control ">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label><span class="text-danger">*</span> prénom </label>
                                        <input type="text" name="prenom_utilisateur" value="<?=$modifier->prenom_utilisateur?>" class="form-control ">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label> <span class="text-danger">*</span> contact </label>
                                        <input type="number" name="Contact_utilisateur" value="<?=$modifier->Contact_utilisateur?>" class="form-control ">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label> <span class="text-danger">*</span> Email </label>
                                        <input type="email" name="email" value="<?=$modifier->email?>" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label> <span class="text-danger">*</span> psedeau </label>
                                        <input type="usernamey" name="psedeau_utilisateur" value="<?=$modifier->psedeau_utilisateur?>" class="form-control ">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                        <label><span class="text-danger">*</span> Adresse </label>
                                        <input type="text" name="adresse" value="<?=$modifier->adresse?>" class="form-control " id="exampleInputPassword1">
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-xs-8 col-sm-12">
                                            <label for="type_utilisateur"> <span class="text-danger">*</span> Type d'utilisateur</label>
                                            <select class="custom-select" name="type_utilisateur" id="type_utilisateur" required>
                                                <?php 
                                                $liste_roles = ["Superadmin","Administrateur", "utilisateur"];
                                                if (isset($_SESSION['type_utilisateur'])) {
                                                    if ($_SESSION['type_utilisateur'] === 'Superadmin') {
                                                        $liste_roles = ["Administrateur", "utilisateur"];
                                                    } elseif ($_SESSION['type_utilisateur'] === 'Administrateur') {
                                                        $liste_roles = [ "Administrateur","utilisateur"];
                                                        // echo $modifier->type_utilisateur;exit;

                                                    }
                                                }
                                                    foreach ($liste_roles as $role) {
                                                        ?>
                                                        <option value="<?= $role ?>" <?= ($role == $modifier->type_utilisateur) ? 'selected' : '' ?>>
                                                            <?= $role ?>
                                                        </option>
                                                        <?php

                                                        } // fin du foreach 
                                                        ?>
                                            </select>
                                        </div>
                                    </div>
                                 <div class="text-center">
                                    <button type="submit" class="btn btn-info"  name="modification">Modifier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            <?php require_once('partials/foot.php') ?>
            <?php require_once('partials/footer.php') ?>
        </footer>
    </main>
</body>
</html>

<!--------header------->
<?php require_once ('partials/header.php') ?>
<!-------------sidebare----------->
<?php require_once ('partials/sidebar.php')?>
<!-------------navebare----------->
<?php require_once ('partials/navbar.php')?>

<body>
                <style>
                .profile-picture {
                    width: 80px; /* ou la largeur désirée */
                    height: 80px; /* ou la hauteur désirée */
                    object-fit: cover; /* pour ajuster la taille tout en conservant le ratio d'aspect */
                    border: 1px solid #ffffff; /* couleur de la bordure */
                }
            </style>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Acceuil</a></li>
                    <li class="breadcrumb-item">Utilisateur</li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>
        </div>
         <?php require_once('partials/afficher_message.php');?>
        <section class="section profile">
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php foreach ($errors as $error): ?>
                            <?= $error ?><br>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        
                       <div class=" profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="user/<?=$modifier->avatar?>" alt="Profile" class="rounded-circle profile-picture">

                            <div class="social-links mt-2">
                                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class=" pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Apperçu</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-edit">Modifier Image</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Modifier mot de passe</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <form action="" method="post">
                                        <h5 class="card-title">Profile Details</h5>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Nom et prénom
                                            </div>
                                            <div class="col-lg-9 col-md-8">
                                                <?= $modifier->nom_utilisateur.' '. $modifier->prenom_utilisateur?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Contact</div>
                                            <div class="col-lg-9 col-md-8">
                                                <?=$modifier->Contact_utilisateur?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Email</div>
                                            <div class="col-lg-9 col-md-8">
                                                <?= $modifier->email ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Addresse</div>
                                            <div class="col-lg-9 col-md-8">
                                                <?= $modifier->adresse ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Pseudo</div>
                                            <div class="col-lg-9 col-md-8">
                                                <?= $modifier->psedeau_utilisateur ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label ">Role</div>
                                            <div class="col-lg-9 col-md-8">
                                                <?= $modifier->type_utilisateur ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>                        
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <form action="upload_image.php" method="post" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="user/<?=$modifier->avatar?>" alt="Profile" class="rounded-circle profile-picture">
                                                <div class="pt-2">
                                                    <input type="file" name="newAvatar" id="newAvatar" class="form-control-file" style="display: none;">
                                                    &emsp;&ensp;<a href="#" class="btn btn-info btn-sm upload-profile-image"
                                                        title="Modifier l'image du profil" onclick="document.getElementById('newAvatar').click(); return false;">
                                                        <i class="bi bi-upload"></i> 
                                                    </a>
                                                    <!-- <a href="#" class="btn btn-danger btn-sm" title="Supprimer l'image du profil">
                                                        <i class="bi bi-trash"></i> 
                                                    </a> -->
                                                   
                                                </div><br>
                                                 <!-- <button type="submit" name="enregistrer" class="btn btn-primary btn-block">Enregistrer </button> -->
                                                <button type="button"class="btn btn-primary" name="modifier" data-bs-toggle="modal" data-bs-target="#basicModal">modifier </button>
                                                <?php require_once('partials/confirmerEnregistrement.php');?>
                                                 <!-- <button type="submit" name="modifier" class="btn btn-primary">modifier</button>  -->
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- End profile Edit -->
                               <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form method="post" action="">
                                          
                                        <div class="row mb-3">
                                            <label for="currentPassword"
                                                class="col-md-4 col-lg-3 col-form-label">Anciens mot de passe</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="ancien_motdepasse" type="password" class="form-control"
                                                    id="mot_de_passe" >
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveaux
                                                mot de passe</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="new_mot_de_passe" type="password" class="form-control"
                                                    id="new_mot_de_passe" >
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="confirm_mot_de_passe"
                                                class="col-md-4 col-lg-3 col-form-label">Confirmer le mot de
                                                passe</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="confirm_mot_de_passe" type="password" class="form-control"
                                                    id="confirm_mot_de_passe" >
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" name="change" class="btn btn-primary"> Confirmer</button>
                                        </div>
                                    </form><!-- End Change Password Form -->
                                </div><!-- End password Tabs -->
                              </div><!-- End Bordered Tabs -->
        </section>
        <div class="card mb-4">
            <h5 class="card-header">La liste de mes activités</h5>
            <div class="">
                <form id="formAccountSettings" method="post" action="modifier_password.php">
                    <!--end row-->
                    <div class="row col-12">
                        <div class="col">
                            <div class="card radius-10">
                                <div class="">
                                    <div class="">
                                        <div class="text-primary mb-3">
                                            <center>Journalier</center>
                                        </div>

                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Commandes fournisseurs :</span>
                                            <span class="rounded-circle bg-light-primary text-primary"><?= $commandesFournisseur ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Ventes en crédit :</span>
                                            <span class="rounded-circle bg-light-primary text-primary"><?= $ventesCredit ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Ventes en direct :</span>
                                            <span class="rounded-circle bg-light-primary text-primary"><?= $ventesDirect ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Inventaire :</span>
                                            <span class="rounded-circle bg-light-primary text-primary"><?= $inventaire ?></span>
                                        </p>
                                        <!-- <p style="display:flex;justify-content:space-between;">
                                            <span>Enregistrements de produits :</span>
                                            <span class="rounded-circle bg-light-primary text-primary"><?= $enregistrementProduits ?></span>
                                        </p> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card radius-10">
                                <div class="">
                                    <div class="text-center">
                                        <div class="text-info mb-3">
                                            <center>Hebdomadaire</center>
                                        </div>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Commandes fournisseurs :</span>
                                            <span class="rounded-circle bg-light-primary text-info"><?= $commandesFournisseur ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Ventes en crédit :</span>
                                            <span class="rounded-circle bg-light-primary text-info"><?= $ventesCredit ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Ventes en direct :</span>
                                            <span class="rounded-circle bg-light-primary text-info"><?= $ventesDirect ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Inventaire :</span>
                                            <span class="rounded-circle bg-light-primary text-info"><?= $inventaire ?></span>
                                        </p>
                                        <!-- <p style="display:flex;justify-content:space-between;">
                                            <span>Enregistrements de produits :</span>
                                            <span class="rounded-circle bg-light-primary text-info"><?= $enregistrementProduits ?></span>
                                        </p> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card radius-10">
                                <div class="">
                                    <div class="text-center">
                                        <div class="text-success mb-3">
                                            <center>Mensuelle</center>
                                        </div>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Commandes fournisseurs :</span>
                                            <span class="rounded-circle bg-light-primary text-success"><?= $commandesFournisseur ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Ventes en crédit :</span>
                                            <span class="rounded-circle bg-light-primary text-success"><?= $ventesCredit ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Ventes en direct :</span>
                                            <span class="rounded-circle bg-light-primary text-success"><?= $ventesDirect ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Inventaire :</span>
                                            <span class="rounded-circle bg-light-primary text-success"><?= $inventaire ?></span>
                                        </p>
                                        <!-- <p style="display:flex;justify-content:space-between;">
                                            <span>Enregistrements de produits :</span>
                                            <span class="rounded-circle bg-light-primary text-success"><?= $enregistrementProduits ?></span>
                                        </p> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card radius-10">
                                <div class="">
                                    <div class="text-center">
                                        <div class="text-warning mb-3">
                                            <center>Annuelle</center>
                                        </div>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Commandes fournisseurs :</span>
                                            <span class="rounded-circle bg-light-primary text-warning"><?= $commandesFournisseur ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Ventes en crédit :</span>
                                            <span class="rounded-circle bg-light-primary text-warning"><?= $ventesCredit ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Ventes en direct :</span>
                                            <span class="rounded-circle bg-light-primary text-warning"><?= $ventesDirect ?></span>
                                        </p>
                                        <p style="display:flex;justify-content:space-between;">
                                            <span>Inventaire :</span>
                                            <span class="rounded-circle bg-light-primary text-warning"><?= $inventaire ?></span>
                                        </p>
                                        <!-- <p style="display:flex;justify-content:space-between;">
                                            <span>Enregistrements de produits :</span>
                                            <span class="rounded-circle bg-light-primary text-warning"><?= $enregistrementProduits ?></span>
                                        </p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </form>
            </div>
        </div>

    </main><!-- End #main -->
    <?php require_once ('partials/foot.php')?>
    <?php require_once ('partials/footer.php')?>
    <script>
        document.querySelector('.upload-profile-image').addEventListener('click', function(e) {
            e.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload_image.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText === 'success') {
                        alert('Profile image uploaded successfully');
                        // Actualiser la page ou faire d'autres manipulations nécessaires
                        location.reload();
                    } else {
                        alert('Failed to upload profile image');
                    }
                } else {
                    alert('Error uploading profile image');
                }
            };
            var formData = new FormData();
            formData.append('new_avatar', document.querySelector('#file-input').files[0]);
            xhr.send(formData);
        });
    </script>
</body>

</html>
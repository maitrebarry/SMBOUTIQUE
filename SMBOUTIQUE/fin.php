<?php
  require_once ('partials/database.php');
  require_once ('function/function.php') ;  
    $produits=recuperation_fonction('*','tbl_product',[],"ALL");
 ?>
<!DOCTYPE html>
<html lang="en">


<?php 
require_once('partials/header.php') ?>
<!-- Styles -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />



<body>
    <!-- Sidebar -->
    <?php
    require_once('partials/sidebar.php') ?>
    <!-- Navbar -->
    <?php require_once('partials/navbar.php') ?>

    <!-- Content -->
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Form Layouts</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Forms</li>
                    <li class="breadcrumb-item active">Layouts</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="form-group">
            <select class="form-control produit form-select p-4" name="produit" id="produit">
                <option value="">Veuillez sélectionner un produit</option>
                <?php foreach ($produits as $value) : ?>
                    <option value="<?= $value->id ?>">
                    <?= $value->name ?>&emsp;| Stock: <?= $value->stock ?>&emsp;| Code barre: <?= $value->code ?>
                </option>
                <?php endforeach ?>
            </select>
        </div>

                                    <!-- Profile Edit Form -->
                                    <form action="" class="" method="post" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile  Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="user/<?=$modifier->avatar?>" alt="Profile"
                                                    class="rounded-circle width:40">
                                                <div class="pt-2">
                                                    <a href="#" class="btn btn-primary btn-sm"
                                                        title="Upload new profile image">
                                                        <i class="bi bi-upload"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm"
                                                        title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nom_utilisateur" type="text" class="form-control" id=""
                                                    value="<?=$modifier->nom_utilisateur?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Prénom</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="prenom_utilisateur" type="text" class="form-control"
                                                    id="company" value=" <?=$modifier->prenom_utilisateur?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="company" class="col-md-4 col-lg-3 col-form-label">Photo</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="avatar" type="file" class="form-control" id="company"
                                                    value="<?=$modifier->avatar?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="company"
                                                class="col-md-4 col-lg-3 col-form-label">Contact</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="Contact_utilisateur" type="number" class="form-control"
                                                    id="" value="<?=$modifier->Contact_utilisateur?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="Country" class="col-md-4 col-lg-3 col-form-label">Pseudo</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="psedeau_utilisateur" type="text" class="form-control" id=""
                                                    value="<?=$modifier->psedeau_utilisateur?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="Address"
                                                class="col-md-4 col-lg-3 col-form-label">Addresse</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="adress" type="text" class="form-control" id=""
                                                    value="<?=$modifier->adresse?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Type
                                                d'utilisateur</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="type_utilisateur" type="text" class="form-control"
                                                    id="Address" value="<?=$modifier->type_utilisateur?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email"
                                                    value="<?=$modifier->email?>">
                                            </div>
                                        </div>&emsp;

                                        <input type="submit" name="modification" class="btn btn-primary"
                                            class="form-control" value="Modifier">
                                    </form>
                    <?php
                    if(isset($_POST['modification'])){
                        $avatar=$_FILES['avatar']['name'];
                        $chemins= "user/".$avatar;
                        $resultat= move_uploaded_file($_FILES['avatar']['tmp_name'], $chemins);
                        if(verification(['nom_utilisateur','prenom_utilisateur','psedeau_utilisateur',
                            'adress','Contact_utilisateur','type_utilisateur'])){
                                extract($_POST);
                                $modification=Insertion_and_update('UPDATE utilisateur 
                                SET nom_utilisateur=:nom_utilisateur,
                                prenom_utilisateur=:prenom_utilisateur,
                                psedeau_utilisateur=:psedeau_utilisateur,
                                Contact_utilisateur=:Contact_utilisateur,
                                avatar=:avatar,
                                type_utilisateur=:type_utilisateur
                                WHERE id_utilisateur=:id',
                            [
                            ':nom_utilisateur'=>$nom_utilisateur,
                            ":prenom_utilisateur"=>$prenom_utilisateur,
                            ":psedeau_utilisateur"=>$psedeau_utilisateur,
                            // ":role"=>$role,
                            ":Contact_utilisateur"=>$Contact_utilisateur,
                            ':avatar'=>$avatar,
                            ':type_utilisateur' => $type_utilisateur,
                            ':id'=>$_SESSION['id_utilisateur']]);
                            if($modification){
                                afficher_message("La modification faite avec succès","success");
                            
                            }
                            }
                        
                    }
                    ?>
    </main><!-- End #main -->
    <!-- Footer -->
    <?php require_once('partials/foot.php') ?>
    <?php require_once('partials/footer.php') ?>
    <script>
            
            //function pour cacher une table
                // function hideMainTable(event) {
        //     var mainTable = document.getElementById("main-table");
             // Cache la table principale lorsqu'on soumet le formulaire
        //     mainTable.style.display = "none";
        // }
    </script>







 <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

<script>
    $(document).ready(function() {
        $('#produit').select2({
            theme: 'bootstrap-5'
        });
    });
</script>
 
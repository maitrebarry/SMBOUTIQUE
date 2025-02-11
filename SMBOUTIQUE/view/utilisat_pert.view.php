<?php require_once ('partials/database.php');?>
 <title>Utilisation/pertes</title>
</head>
<body>
    <!-- Header -->
    <?php require_once('partials/header.php') ?>
    <!-- Sidebar -->
    <?php require_once('partials/sidebar.php') ?>
    <!-- Navbar -->
    <?php require_once('partials/navbar.php') ?>
   <?php $errors = []; $button_name='ajouter'?>
     <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px; /* Hauteur du pied de page */
            background-color: #f5f5f5; /* Ajoutez la couleur de fond souhaitée */
        }
        /* Styles pour agrandir les boutons radios */
            .custom-radio {
                width: 1.5em; /* Ajustez la largeur selon vos besoins */
                height: 1.5em; /* Ajustez la hauteur selon vos besoins */
            }
            
    </style>
    <!-- Contenu principal -->
     <?php
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //  if (empty($_POST["ref_caisse"])) {
        //     $errors["ref_caisse"] = "Le champ Référence est obligatoire.";
        // }
        if (empty($_POST["quantite"])) {
                    $errors["quantite"] = "Le champ quantite est obligatoire.";
        }
        if (empty($_POST["motif"])) {
            $errors["motif"] = "Le champ motif  est obligatoire.";
        }
         if (empty($_POST["date"])) {
            $errors["date"] = "Le champ Date est obligatoire.";
        }
        if (empty($_POST["type"])&& empty($_POST["type"])) {
             $errors['type'] = 'Veuillez sélectionner au moins un type (Utilisation ou Perte)';
        }
       
    }
    ?>
<section class="section">
    <main id="main" class="main" >
        <div class="pagetitle">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Utilisation/pertes des articles</li>
                    <li class="breadcrumb-item active">Liste des Utilisations/pertes</li>
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
                                    <label for="inputText" class="col-sm-2 col-form-label">Article<span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                         <select class="form-control produit form-select" name="produit" id="produit">
                                            <option value="">Veuillez sélectionner un produit</option>
                                            <?php foreach ($produits as $value) : ?>
                                                <option value="<?= $value->id ?>">
                                                <?= $value->name ?>&emsp;| Stock: <?= $value->stock ?>
                                            </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <label for="inputNumber" class="col-sm-2 col-form-label">Quantité<span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="Number" name="quantite" class="form-control">
                                        <?php if(isset($errors["quantite"])) { ?>
                                            <span class="text-danger"><?php echo $errors["quantite"]; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="inputText" class="col-sm-2 col-form-label">Motif<span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="motif" class="form-control">
                                            <?php if(isset($errors["motif"])) { ?>
                                            <span class="text-danger"><?php echo $errors["motif"]; ?></span>
                                            <?php } ?>
                                    </div>
                                    <label for="inputDate" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="date"name="date" class="form-control">
                                            <?php if(isset($errors["date"])) { ?>
                                                <span class="text-danger"><?php echo $errors["date"]; ?></span>
                                            <?php } ?>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="inputText" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <label for="type" class="col-sm-3 col-form-label">Utilisation</label>
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input custom-radio" id="type_utilisation" name="type_utilisation" value="utilisation">
                                                <label class="form-check-label" for="type"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="type_perte" class="col-sm-3 col-form-label">Perte</label>
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input custom-radio" id="type_perte" name="type_perte" value="perte">
                                                <label class="form-check-label" for="type_perte"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Afficher l'erreur liée à la case "type" -->
                                    <?php if (isset($errors['type'])) : ?>
                                        <div class="row mb-4">
                                            <div class="col-sm-4 offset-sm-2">
                                                <span class="text-danger"><?php echo $errors['type']; ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>


                                <div class="text-center">
                                    <!-- <button type="submit" class="btn btn-info"  name="enregistrer">Enregistrer</button> -->
                                    <button type="button"class="btn btn-info"  data-bs-toggle="modal" data-bs-target="#basicModal">Ajouter </button>
                                    <?php require_once('partials/confirmerEnregistrement.php');?>
                                    <a href="lsiteUtilisat_pert.php" class="btn btn-primary btn ">Liste des Utilisations/pertes </a>
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
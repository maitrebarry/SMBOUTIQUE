<?php require_once('partials/header.php') ?>
<body>
    <!-------------sidebare----------->
    <?php require_once('partials/sidebar.php')?>
    <!-------------navebare----------->
    <?php require_once('partials/navbar.php')?>

    <?php require_once ('function/function.php') ;
     $boutique=recuperation_fonction('*','boutique',[],"ALL");
     $unite=recuperation_fonction('*','unite',[],"ALL");?>
    <style>
       
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px; 
            background-color: #f5f5f5; 
        }
</style>
    <!-------------contenu----------->
    <?php $errors = []; $button_name='enregistrer'?>
    <main id="main" class="main">

        <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <li class="breadcrumb-item">Produits</li>
          <li class="breadcrumb-item active">Nouveau article</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
        <div class="card info-card sales-card">
            <?php require_once('partials/afficher_message.php');?>
            <div class="card-header">
            </div>
            <form action="" method="post">
                <div class="row">
                    <div class="col-xl-9 col-md-10 col-xm-12 col-xs-12">
                        <div class="card">
                            <div class="card-body mt-3">
                                <?php if (isset($produit->errors) and !empty($produit->errors)) : ?>
                                    <div class='alert alert-danger'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <?php foreach ($produit->errors as $error) : ?>
                                            <?= $error ?> <br>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                                <div class="row pl-3">
                                    <div class="col-xl-6 ">
                                        <div class="form-group">
                                            <label for=""><span class="text-danger">*</span>Nom produit <br><br></label>
                                            <input type="text" class="form-control" id="form_nom" placeholder="Nom produit" name="nom"
                                                value="<?=$produit->get_valeur_input('nom') ?>">
                                        </div>
                                    </div>
                                   
                                    <div class="col-xl-6 ">
                                        <div class="form-group">
                                            <label for=""><span class="text-danger">*</span>Marque produit<br><br></label>
                                            <input type="text" class="form-control" placeholder="Marque produit" name="marque"
                                                value="<?=$produit->get_valeur_input('marque') ?>">
                                        </div>
                                    </div>
                                
                                </div><br>
                                <div class="row pl-3">
                                    
                                    <div class="col-xl-4 ">
                                        <div class="form-group">
                                            <label for=""><span class="text-danger">*</span>Prix en detail<br><br></label>
                                            <input type="number" class="form-control" placeholder="Prix en detail"
                                                name="prix_detail" value="<?=$produit->get_valeur_input('prix_detail') ?>">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 ">
                                        <div class="form-group">
                                            <label><span class="text-danger">*</span>Prix d'achat<br><br></label>
                                            <input type="number" class="form-control" placeholder="Prix d'achat"
                                                name="prix_achat" value="<?=$produit->get_valeur_input('prix_achat') ?>">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 ">
                                        <div class="form-group">
                                            <label><span class="text-danger">*</span>Alerte Stock<br><br></label>
                                            <input type="text" class="form-control" placeholder="Alerte article" name="alerte"
                                                value="<?=$produit->get_valeur_input('alerte') ?>">
                                        </div>
                                    </div>
                                    
                                        <button type="button"class="btn btn-primary" name="enregistrer" data-bs-toggle="modal" data-bs-target="#basicModal">Enregistrer </button>
                                        <?php require_once('partials/confirmerEnregistrement.php');?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-xs-8 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group mt-3">
                                    <label for=""> <span class="text-danger">*</span> Boutique</label>
                                   <select name="boutique" id="" class="form-control">
                                        <option value="">Sélectionner votre boutique</option>
                                        <?php foreach ($boutique as $value_for) : ?>
                                            <option value="<?= $value_for->id_boutique ?>">
                                                <?= $value_for->nom ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label for=""> <span class="text-danger">*</span> Unité</label>
                                    <select name="unite" id="" class="form-control">
                                        <option value="">Sélectionner l'unité</option>
                                        <?php foreach ($unite as $value_unite) : ?>
                                            <option value="<?= $value_unite->id_unite ?>">
                                                <?= $value_unite->symbole ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
     <!-- Footer -->
<footer class="footer">
    <?php require_once('partials/foot.php') ?>
    <?php require_once('partials/footer.php') ?>
</footer>
</body>

</html>

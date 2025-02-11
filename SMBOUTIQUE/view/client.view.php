
</html>
 <!DOCTYPE html>
<html lang="en">


<!-- Header -->
<?php require_once('partials/header.php') ?>

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
                height: 50px; /* Hauteur du pied de page */
                background-color: #f5f5f5; /* Ajoutez la couleur de fond souhaitée */
            }
    </style>
 <?php $errors = []; $button_name='Sauvegarder'?>
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <li class="breadcrumb-item">Client</li>
          <li class="breadcrumb-item active">Nouveau client</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
       <?php require_once('partials/afficher_message.php'); ?>
      <form action="" method="post">
          <div class="row">
            <?php
                if (isset($client->errors) and !empty($client->errors)) : ?>
                    <div class='alert alert-danger'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <?php foreach ($client->errors as $error) : ?>
                            <?= $error ?> <br>
                        <?php endforeach ?>
                    </div>
              <?php endif ?>
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Client</h5>
                      <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Prenom<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputText"name="prenom"value="<?= $client->get_valeur_input('prenom') ?>">
                        </div>
                      </div> 
                      <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nom <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputText"name="nom"value="<?= $client->get_valeur_input('nom') ?>">
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Adresse</h5>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">ville <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputEmail"name="ville_ou_quartier"value="<?= $client->get_valeur_input('ville_ou_quartier') ?>">
                        </div>
                      </div> 
                      <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Contact<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputText"name="contact" value="<?= $client->get_valeur_input('contact') ?>">
                        </div>
                      </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="text-center">
          <button type="button"class="btn btn-primary" name="Sauvegarder" data-bs-toggle="modal" data-bs-target="#basicModal">Sauvegarder </button>
             <?php require_once('partials/confirmerEnregistrement.php');?>
          </div>
    </form>
  </section>
</main><!-- End #main -->



  
  <!-- Footer -->
<footer class="footer">
    <?php require_once('partials/foot.php') ?>
    <?php require_once('partials/footer.php') ?>
</footer>

</body>

</html>
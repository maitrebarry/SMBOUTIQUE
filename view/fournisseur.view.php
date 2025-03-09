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
          <li class="breadcrumb-item">Fournisseur</li>
          <li class="breadcrumb-item active">Nouveau fournisseur</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
       <?php require_once('partials/afficher_message.php'); ?>
     <form action="" method="post">
  <div class="row">
    <?php if (isset($fournisseur->errors) and !empty($fournisseur->errors)) : ?>
      <div class='alert alert-danger'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <?php foreach ($fournisseur->errors as $error) : ?>
          <?= $error ?> <br>
        <?php endforeach ?>
      </div>
    <?php endif ?>

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Fournisseur</h5>
          <div class="row">
            <div class="col-lg-6 mb-3">
              <label for="inputNom" class="col-sm-4 col-form-label">Prénom<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="inputNom" name="nom" value="<?= $fournisseur->get_valeur_input('nom') ?>">
            </div>
            <div class="col-lg-6 mb-3">
              <label for="inputPrenom" class="col-sm-4 col-form-label">Nom<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="inputPrenom" name="prenom" value="<?= $fournisseur->get_valeur_input('prenom') ?>">
            </div>
          </div>

          <h5 class="card-title">Adresse</h5>
          <div class="row">
            <div class="col-lg-6 mb-3">
              <label for="inputContact" class="col-sm-4 col-form-label">Contact<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="inputContact" name="contact" value="<?= $fournisseur->get_valeur_input('contact') ?>" oninput="formatPhoneNumber(this)">
            </div>
            <div class="col-lg-6 mb-3">
              <label for="inputVille" class="col-sm-4 col-form-label">Ville<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="inputVille" name="ville_ou_quartier" value="<?= $fournisseur->get_valeur_input('ville_ou_quartier') ?>">
            </div>
          </div>

          <div class="text-end mt-3">
            <button type="button" class="btn btn-primary" name="Sauvegarder" data-bs-toggle="modal" data-bs-target="#basicModal">Sauvegarder</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('partials/confirmerEnregistrement.php'); ?>
</form>

  </section>
</main><!-- End #main -->



  
  <!-- Footer -->
<footer class="footer">
    <?php require_once('partials/foot.php') ?>
    <?php require_once('partials/footer.php') ?>
</footer>
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
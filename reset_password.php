<?php

require_once('partials/database.php');
require_once('function/function.php');

if (isset($_GET['email'], $_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $query = $bdd->prepare("SELECT * FROM utilisateur WHERE email = ? AND reset_token = ?");
    $query->execute([$email, $token]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user || strtotime($user['reset_token_expire']) < time()) {
        afficher_message('Lien invalide ou expiré.');
        exit;
    }

    if (isset($_POST['submit'])) {
        $new_password = $_POST['password'];
        $erreurs = [];

        // Vérification de la longueur du mot de passe
        if (strlen($new_password) < 8) {
            $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
        }

        // Vérification de la présence de majuscules
        if (!preg_match('/[A-Z]/', $new_password)) {
            $erreurs[] = "Le mot de passe doit contenir au moins une majuscule.";
        }

        // Vérification de la présence de chiffres
        if (!preg_match('/[0-9]/', $new_password)) {
            $erreurs[] = "Le mot de passe doit contenir au moins un chiffre.";
        }

        // Vérification des caractères spéciaux
        if (!preg_match('/[^A-Za-z0-9]/', $new_password)) {
            $erreurs[] = "Le mot de passe doit contenir au moins un caractère spécial.";
        }

        if (!empty($erreurs)) {
            foreach ($erreurs as $erreur) {
                afficher_message($erreur);
            }
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = $bdd->prepare("UPDATE utilisateur SET mot_de_passe_utilisateur = ?, reset_token = NULL, reset_token_expire = NULL WHERE email = ?");
            $update_query->execute([$hashed_password, $email]);

            afficher_message('Mot de passe mis à jour avec succès. Vous pouvez vous connecter.', 'success');

            // Pause to let the message display
            sleep(3);

            header('Location: index.php');
            exit;
        }
    }
} else {
    afficher_message('Lien invalide.');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Réinitialiser le mot de passe - Zaramarket</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link rel="stylesheet" href="bootstrap-4.6.2/css/bootstrap.min.css">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Aug 30 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">SMBOUTIQUE</span>
                </a>
              </div><!-- End Logo -->
                <?php require_once('partials/afficher_message.php'); ?>
              <div class="card mb-3">

                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Réinitialiser le mot de passe</h5>
                    <p class="text-center small">Entrez votre nouveau mot de passe</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post" action="" novalidate>

                    <div class="col-12">
                      <label for="password" class="form-label">Nouveau mot de passe</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Veuillez entrer votre nouveau mot de passe.</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Mettre à jour</button>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="bootstrap-4.6.2/js/jquery.3.2.1.min.js"></script>
  <script src="bootstrap-4.6.2/js/bootstrap.min.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

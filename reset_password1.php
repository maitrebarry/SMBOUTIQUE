<?php
require_once('partials/database.php');
require_once('function/function.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $query = $bdd->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $token = bin2hex(random_bytes(16));
        $expire_time = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $query = $bdd->prepare("UPDATE utilisateur SET reset_token = ?, reset_token_expire = ? WHERE email = ?");
        $query->execute([$token, $expire_time, $email]);

        $reset_link = "http://localhost/SMBOUTIQUE/reset_password.php?email=$email&token=$token";
        
        $to = $email;
        $subject = "Réinitialisation du mot de passe";
        $message = "Bonjour,\n\nVous avez demandé une réinitialisation de mot de passe. Cliquez sur le lien suivant pour réinitialiser votre mot de passe (valide pendant 1 heure) :\n\n$reset_link\n\nCordialement,\nZaramarket";
        $headers = "From: barrymoustapha908@gmail.com";
        mail($to, $subject, $message, $headers);

        afficher_message('Un e-mail de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.');
    } else {
        afficher_message('Aucun compte trouvé avec cet e-mail.');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Réinitialisation de mot de passe - Zaramarket</title>
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
                    <p class="text-center small">Entrez votre e-mail pour recevoir un lien de réinitialisation</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post" action="reset_password1.php" novalidate>

                    <div class="col-12">
                      <label for="email" class="form-label">Adresse e-mail</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">Veuillez entrer votre adresse e-mail.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Envoyer</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Vous vous souvenez de votre mot de passe ? <a href="index.php">Se connecter</a></p>
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


 <?php
    require_once('autoload.php');
    $utilisateur=new Fournisseur();
    require_once('function/function.php');
    if (isset($_POST['envoyer'])) {
        if (!empty($_POST['user_pseudo']) && !empty($_POST['user_password'])) {
            $identifiant = htmlspecialchars($_POST['user_pseudo']);
            $mot_de_passe = $_POST['user_password'];
            
            $erreurs = [];
            
            // Vérification de la longueur du mot de passe
            if (strlen($mot_de_passe) < 8) {
                $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
            }
            
            // Vérification de la présence de majuscules
            if (!preg_match('/[A-Z]/', $mot_de_passe)) {
                $erreurs[] = "Le mot de passe doit contenir au moins une majuscule.";
            }

            // Vérification de la présence de chiffres
            if (!preg_match('/[0-9]/', $mot_de_passe)) {
                $erreurs[] = "Le mot de passe doit contenir au moins un chiffre.";
            }

            // Vérification des caractères spéciaux
            if (!preg_match('/[^A-Za-z0-9]/', $mot_de_passe)) {
                $erreurs[] = "Le mot de passe doit contenir au moins un caractère spécial.";
            }
            
            if (!empty($erreurs)) {
                foreach ($erreurs as $erreur) {
                    afficher_message($erreur);
                }
                $utilisateur->garder_valeur_input();
            } else {
                $recepUsers = $bdd->prepare('SELECT * FROM utilisateur WHERE psedeau_utilisateur = ? OR email = ?');
                $recepUsers->execute(array($identifiant, $identifiant));

                if ($recepUsers->rowCount() > 0) {
                    $recup = $recepUsers->fetch();

                    if (password_verify($mot_de_passe, $recup['mot_de_passe_utilisateur'])) {
                        if ($recup['statut'] == "off") {
                            afficher_message('Votre compte est désactivé. Veuillez contacter l\'administrateur.');
                        } else {
                            $_SESSION['is_logged_in'] = true;
                            $_SESSION['id_utilisateur'] = $recup['id_utilisateur'];
                            $_SESSION['nom_utilisateur'] = $recup['nom_utilisateur'];
                            $_SESSION['prenom_utilisateur'] = $recup['prenom_utilisateur'];
                            $_SESSION['Contact_utilisateur'] = $recup['Contact_utilisateur'];
                            $_SESSION['psedeau_utilisateur'] = $recup['psedeau_utilisateur'];
                            $_SESSION['email'] = $recup['email'];
                            $_SESSION['mot_de_passe_utilisateur'] = $recup['mot_de_passe_utilisateur'];
                            $_SESSION['type_utilisateur'] = $recup['type_utilisateur'];
                            $_SESSION['adresse'] = $recup['adresse'];
                            $_SESSION['avatar'] = $recup['avatar'];

                            header("Location: index1.php");
                        }
                    } else {
                        afficher_message('Pseudo ou email ou mot de passe incorrect');
                    }
                } else {
                    afficher_message('Pseudo ou email ou mot de passe incorrect');
                }
            }
        } else {
            afficher_message('Veuillez remplir tous les champs');
        }
    } 
?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
     <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <link rel="stylesheet" href="bootstrap-4.6.2/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <title>Veuillez-vous identifier</title>
 </head>
    <style>
            body {
                background-color: #DCDCDC; /* Couleur de fond si l'image ne charge pas */
                margin-top: 60px;
                background-image: url('assets/img/maiga.jpg'); /* URL de l'image */
                background-size: cover; /* Ajuste l'image pour couvrir toute la zone */
                background-repeat: no-repeat; /* Évite la répétition de l'image */
                background-position: center center; /* Centre l'image */
            }
            .card {
                margin-bottom: 1.5rem;
                box-shadow: 0 1px 15px 1px rgba(52, 40, 104, .08);
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 1px solid #e5e9f2;
                border-radius: .2rem;
            }

            .login-heading {
                color: #28a745;
                /* Couleur bleue primaire (changez-la selon vos besoins) */
                font-size: 44px;
                /* Taille de police (ajustez selon vos préférences) */
                font-weight: bold;
                /* Gras (ajustez selon vos préférences) */
                margin-bottom: 20px;
                /* Marge en bas (ajustez selon vos préférences) */
            }
            .strength-meter {
                height: 10px;
                width: 100%;
                background-color: #e0e0e0;
                margin-top: 5px;
                border-radius: 5px;
            }
            .strength-meter-fill {
                height: 100%;
                width: 0;
                background-color: green;
                border-radius: 5px;
            }
            .input-group {
                position: relative;
            }
            .card {
                border-right: 5px solid green;
                border-bottom: 5px solid green;
                border-radius: 25px;
            }
    </style>
 <body>
    <div class="container h-100" style="float:right"> 
        <div class="row h-100" >
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="card">
                    <?php require_once('partials/afficher_message.php');?>
                    <div class="text-center mt-5">
                        <h1 class="text-success login-heading">Veuillez-vous identifier</h1>
                    </div>
                    <div class="card-body">
                        <div class="m-sm-4">
                            <div class="text-center">
                                <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Andrew Jones"
                                    class="img-fluid rounded-circle" width="132" height="132">
                            </div>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label>Pseudo ou Email</label>
                                    <input class="form-control form-control-lg" name="user_pseudo" type="text" placeholder="Entrer votre pseudo ou email">
                                </div>

                                <div class="form-group">
                                    <label>Mot de passe</label>
                                    <div class="input-group">
                                        <input id="password" class="form-control form-control-lg" name="user_password" type="password" placeholder="Entrer votre mot de passe" oninput="checkPasswordStrength()">
                                        <div class="input-group-append">
                                            <button id="togglePassword" class="btn btn-outline-secondary" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="strength-meter">
                                        <div class="strength-meter-fill" id="strengthMeterFill"></div>
                                           <div class="strength-text" id="strengthText"></div>
                                    </div>
                                    <small>
                                        <a href="reset_password1.php">Mot de passe oublié?</a>
                                    </small>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit" name="envoyer" class="btn btn-lg btn-success" style="width:100%">Se Connecter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            // Bascule entre 'password' et 'text'
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Bascule entre l'icône de l'œil ouvert et l'icône de l'œil fermé
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        function checkPasswordStrength() {
            const password = passwordField.value;
            const strengthMeterFill = document.getElementById('strengthMeterFill');
            const strengthMeterText = document.getElementById('strengthMeterText');
            const strength = getPasswordStrength(password);

            strengthMeterFill.style.width = strength + '%';

            if (strength <= 25) {
                strengthMeterFill.style.backgroundColor = 'red';
                // strengthMeterText.textContent = 'Faible';
            } else if (strength <= 50) {
                strengthMeterFill.style.backgroundColor = 'orange';
                // strengthMeterText.textContent = 'Moyen';
            } else if (strength <= 75) {
                strengthMeterFill.style.backgroundColor = 'yellow';
                // strengthMeterText.textContent = 'Bon';
            } else {
                strengthMeterFill.style.backgroundColor = 'green';
                // strengthMeterText.textContent = 'Fort';
            }
        }

        function getPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            if (/[^A-Za-z0-9]/.test(password)) strength += 25;

            return strength;
        }
    </script>
     <script src="bootstrap-4.6.2/js/jquery.3.2.1.min.js"></script>
     <script src="bootstrap-4.6.2/js/bootstrap.min.js"></script>
 </body>
 </html>







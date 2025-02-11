 <?php
require_once ('partials/database.php');
require_once('function/function.php');

if (isset($_POST['envoyer'])) {
    if (!empty($_POST['email']) && !empty($_POST['user_password'])) {
        $email = htmlspecialchars($_POST['email']);
        $mot_de_passe = ($_POST['user_password']);

        $recepUsers = $bdd->prepare('SELECT * FROM utilisateur WHERE email = ? AND mot_de_passe_utilisateur = ?');
        $recepUsers->execute(array($email, $mot_de_passe));

        if ($recepUsers->rowCount() > 0) {
            $recup = $recepUsers->fetch();
            if ($recup['statut'] == "off") {
                afficher_message('Votre compte est désactivé. Veuillez contacter l\'administrateur.');
            } else {
                // Connecter l'utilisateur
                $_SESSION['id_utilisateur'] = $recup['id_utilisateur'];
                $_SESSION['nom_utilisateur'] = $recup['nom_utilisateur'];
                $_SESSION['prenom_utilisateur'] = $recup['prenom_utilisateur'];
                $_SESSION['Contact_utilisateur'] = $recup['Contact_utilisateur'];
                $_SESSION['psedeau_utilisateur'] = $recup['psedeau_utilisateur'];
                $_SESSION['email'] = $recup['email'];
                $_SESSION['mot_de_passe_utilisateur'] = $recup['mot_de_passe_utilisateur'];
                $_SESSION['type_utilisateur'] = $recup['type_utilisateur'];
                $_SESSION['adresse'] = $recup['adresse'];
                $_SESSION['avatar'] = get_gravatar_url($email); // Obtient l'URL Gravatar de l'utilisateur

                header("Location:index1.php");
            }
        } else {
            afficher_message('Email ou mot de passe incorrect');
        }
    } else {
        afficher_message('Veuillez remplir tous les champs');
    }
}

// Fonction pour obtenir l'URL Gravatar à partir de l'email
function get_gravatar_url($email) {
    $gravatar_url = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?s=200';
    return $gravatar_url;
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
     <title>Veuillez-vous identifier</title>
     <style>
     body {
         background-color: #DCDCDC;
         margin-top: 80px;
         background-image: url('assets/img/dpk.webp');
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
     </style>
 </head>

 <body>

     <div class="container h-100">
         <div class="row h-100">
             <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                 <div class="card">
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
                                 <!-- <div class="form-group">
                                     <label>Username</label>
                                     <input class="form-control form-control-lg" name="user_pseudo" type="text"
                                         placeholder="Entrer votre pseudo">
                                 </div> -->
                                 <div class="form-group">
                                     <label>Email</label>
                                     <input class="form-control form-control-lg" name="email" type="email"
                                         placeholder="Entrer votre email">
                                 </div>
                                 <div class="form-group">
                                     <label>Mot de passe</label>
                                     <input class="form-control form-control-lg" name="user_password" type="password"
                                         placeholder="Entrer votre mot de passe">
                                     <small>
                                         <a href="#">Mot de passe oublié?</a>
                                     </small>
                                 </div>
                                 <?php require_once('partials/afficher_message.php');?>

                                 <div class="text-center mt-3">
                                     <button type="submit" name="envoyer" class="btn btn-lg btn-success"
                                         style="width:100%">Se Connecter</button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>

             </div>
         </div>
     </div>
     </div>

     <script src="bootstrap-4.6.2/js/jquery.3.2.1.min.js"></script>
     <script src="bootstrap-4.6.2/js/bootstrap.min.js"></script>
 </body>

 </html>
 BARRY 	            Moustapha 	67205736 	NULL 	maitrebarry 	1958 	lafiabougou 	
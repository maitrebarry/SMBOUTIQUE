<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');

// Initialisation de la classe Client
$update = new Client();

// Récupération des données dans les champs
$recuperer = $update->recuperation_fonction("*", "client_grossiste WHERE id_client_gr=:id", [':id' => $_GET['id']]);

if (isset($_POST['modifier'])) {
    extract($_POST);

    // Vérification du numéro de téléphone
    $resultat_verification=$update->telephone_numero_verification($contact);
    if ($resultat_verification !== "Numéro de téléphone valide <br>"){
         $update->errors[] = $resultat_verification;
    } else {
        // Vérification si le nouveau numéro de téléphone est différent de l'ancien et s'il existe déjà dans la base de données
        $ancien_contact = $recuperer->contact_client_grossiste;
        if ($contact != $ancien_contact && $update->user_verify("contact_client_grossiste", "client_grossiste", $contact, $_GET['id'])) {
            // Le nouveau numéro de téléphone existe déjà dans la base de données
            $update->errors[] = "Ce contact existe déjà, veuillez choisir un autre.";
        } else {
            // Le nouveau numéro de téléphone est valide, procéder à la modification
            // Modification
            $update->update_data(
                "UPDATE client_grossiste
                SET 
                    nom_client_grossiste=:nom_client_grossiste,
                    prenom_du_client_grossiste=:prenom_du_client_grossiste,
                    contact_client_grossiste=:contact_client_grossiste,
                    ville_client_grossiste=:ville_client_grossiste
                WHERE id_client_gr=:id",
                [
                    ":nom_client_grossiste" => $nom,
                    ":prenom_du_client_grossiste" => $prenom,
                    ":contact_client_grossiste" => $contact,
                    ":ville_client_grossiste" => $ville_ou_quartier,
                    ':id' => $_GET['id']
                ]
            );

            // Affichage du SweetAlert après la modification réussie
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire("Modification effectuée avec succès!", "", "success").then(() => {
                            window.location.href = "liste_client_gr.php";
                        });
                    });
                  </script>';
        }
    }
}

// Affichage des erreurs s'il y en a
if (!empty($update->errors)) {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    html: "'.implode("<br>", $update->errors).'"
                });
            });
          </script>';
}

 ?>
 <!--------header------->
   <?php require_once ('partials/header.php') ?>
      <body>
   <!-------------sidebare----------->
    <?php require_once ('partials/sidebar.php')?>
 <!-------------navebare----------->
 <?php require_once ('partials/navbar.php')?>
    <!-------------contenu----------->
    <main id="main" class="main">
    <div class="card info-card sales-card">
    <div class="container-fluid">
        <form action=""  method="post" class="form_content" id="form_content">
            <div class="row">
                    <div class="form-group col-3">
                        <label for="">Prenom </label> <br><br>
                        <input type="text" name="prenom"  class="form-control" 
                        value="<?php if(isset($_GET['id'])){echo $recuperer->prenom_du_client_grossiste;}?>">
                    </div>
                    <div class="form-group col-3">
                        <label for="">Nom </label> <br><br>
                        <input type="text" name="nom" class="form-control" 
                        value="<?php if(isset($_GET['id'])){echo $recuperer->nom_client_grossiste;}?>">
                    </div>
                   
                    <div  class="form-group col-3">
                        <label for="">Contact </label> <br><br>
                        <input type="text" name="contact" class="form-control" 
                        value="<?php if(isset($_GET['id'])){echo $recuperer->contact_client_grossiste;}?>">
                    </div>
                     <div class="form-group col-3">
                        <label for="">Ville ou quartier </label> <br><br>
                        <input type="text" name="ville_ou_quartier" class="form-control" 
                         value="<?php if(isset($_GET['id'])){echo $recuperer->ville_client_grossiste;}?>">
                        
                    </div>

            </div>

           
             <div class="" align="right">
                    <input type="submit" name="modifier" value="modifier" class="btn  btn-info btn-bg">
                </div>

            </form>
        </div> 
    </div>
</main>

<?php require_once ('partials/footer.php')?>
</body>
</html>
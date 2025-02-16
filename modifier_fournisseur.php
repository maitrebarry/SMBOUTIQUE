<?php
require_once('autoload.php');

// Initialisation de la classe Fournisseur
$update = new Fournisseur();

// Récupération des données dans les champs
$recuperer = $update->recuperation_fonction("*", "fournisseur WHERE id_fournisseur=:id", [':id' => $_GET['id']]);

if (isset($_POST['modifier'])) {
    extract($_POST);
    // Vérification du numéro de téléphone
    $resultat_verification=$update->telephone_numero_verification($contact);
    if ($resultat_verification !== "Numéro de téléphone valide"){
         $update->errors[] = $resultat_verification;
    } else {
        // Vérification si le nouveau numéro de téléphone est différent de l'ancien et s'il existe déjà dans la base de données
        $ancien_contact = $recuperer->contact_fournisseur;
        if ($contact != $ancien_contact && $update->user_verify("contact_fournisseur", "fournisseur", $contact, $_GET['id'])) {
            // Le nouveau numéro de téléphone existe déjà dans la base de données
            $update->errors[] = "Ce contact existe déjà, veuillez choisir un autre.";
        } else {
            // Le nouveau numéro de téléphone est valide, procéder à la modification
            // Modification
            $update->update_data(
                "UPDATE fournisseur
                SET 
                    nom_fournisseur=:nom_fournisseur,
                    prenom_fournisseur=:prenom_fournisseur,
                    contact_fournisseur=:contact_fournisseur,
                    ville_fournisseur=:ville_fournisseur
                WHERE id_fournisseur=:id",
                [
                    ":nom_fournisseur" => $nom,
                    ":prenom_fournisseur" => $prenom,
                    ":contact_fournisseur" => $contact,
                    ":ville_fournisseur" => $ville_ou_quartier,
                    ':id' => $_GET['id']
                ]
            );

            // affichage du SweetAlert après la modification réussie
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire("Modification effectuée avec succès!", "", "success").then(() => {
                            window.location.href = "liste_fournisseur.php";
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
                    text: "'.implode("<br>", $update->errors).'"
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
                        value="<?php if(isset($_GET['id'])){echo $recuperer->prenom_fournisseur;}?>">
                    </div>
                    <div class="form-group col-3">
                        <label for="">Nom </label> <br><br>
                        <input type="text" name="nom" class="form-control" 
                        value="<?php if(isset($_GET['id'])){echo $recuperer->nom_fournisseur;}?>">
                    </div>
                    <div class="form-group col-3">
                        <label for="">Ville ou quartier </label> <br><br>
                        <input type="text" name="ville_ou_quartier" class="form-control" 
                         value="<?php if(isset($_GET['id'])){echo $recuperer->ville_fournisseur;}?>">
                        
                    </div>
                    <div  class="form-group col-3">
                        <label for="">Contact </label> <br><br>
                        <input type="text" name="contact" class="form-control" 
                        value="<?php if(isset($_GET['id'])){echo $recuperer->contact_fournisseur;}?>">
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
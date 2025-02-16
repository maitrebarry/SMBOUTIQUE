<?php
require_once('autoload.php');

// Initialisation de la classe Fournisseur
$update = new Fournisseur();

// Récupération des données dans les champs
$recuperer = $update->recuperation_fonction("*", "boutique WHERE id_boutique=:id", [':id' => $_GET['id']]);

if (isset($_POST['modifier'])) {
         extract($_POST);
         $nom=$_POST['nom'];
        // Vérification si le nouveau nom est différent de l'ancien et s'il existe déjà dans la base de données
            $ancien_nom = $recuperer->nom;
        if ($nom != $ancien_nom && $update->user_verify("nom", "boutique", $nom, $_GET['id'])) {
            // Le nouveau nom existe déjà dans la base de données
            $update->errors[] = "Ce nom existe déjà, veuillez choisir un autre.";
        } else {
            // Le nouveau nom est valide, procéder à la modification
            // Modification
            $update->update_data(
                "UPDATE boutique
                SET 
                    quartier=:quartier,
                    nom=:nom
                WHERE id_boutique=:id",
                [
                    ":quartier" => $quartier,
                    ":nom" => $nom,
                    ':id' => $_GET['id']
                ]
            );


            
            // affichage du SweetAlert après la modification réussie
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire("Modification effectuée avec succès!", "", "success").then(() => {
                            window.location.href = "liste_boutique.php";
                        });
                    });
                  </script>';
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
            <div class="card-body">
                <div class="row">                      
                        <div class="form-group col-6 mt-3">
                            <label for="">nom </label> <br><br>
                            <input type="text" name="nom" class="form-control" 
                            value="<?php if(isset($_GET['id'])){echo $recuperer->nom;}?>">
                        </div>
                        <div class="form-group col-6 mt-3">
                            <label for="">quartier </label> <br><br>
                            <input type="text" name="quartier"  class="form-control" 
                            value="<?php if(isset($_GET['id'])){echo $recuperer->quartier;}?>">
                        </div>
                </div>

            
                    <div class="" align ="right">
                        <input type="submit" name="modifier" value="modifier" class="btn  btn-info btn-bg">
                    </div>
            </div>
        </form>
        
        </div> 
    </div>
</main>

<?php require_once ('partials/footer.php')?>
</body>
</html>
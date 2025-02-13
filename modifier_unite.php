<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php');

// Initialisation de la classe Fournisseur
$update = new Fournisseur();

// Récupération des données dans les champs
$recuperer = $update->recuperation_fonction("*", "unite WHERE id_unite=:id", [':id' => $_GET['id']]);

if (isset($_POST['modifier'])) {
         extract($_POST);
         $symbole=$_POST['symbole'];
        // Vérification si le nouveau symbole est différent de l'ancien et s'il existe déjà dans la base de données
            $ancien_symbole = $recuperer->symbole;
        if ($symbole != $ancien_symbole && $update->user_verify("symbole", "unite", $symbole, $_GET['id'])) {
            // Le nouveau symbole existe déjà dans la base de données
            $update->errors[] = "Ce symbole existe déjà, veuillez choisir un autre.";
        } else {
            // Le nouveau numéro de téléphone est valide, procéder à la modification
            // Modification
            $update->update_data(
                "UPDATE unite
                SET 
                    libelle=:libelle,
                    symbole=:symbole
                WHERE id_unite=:id",
                [
                    ":libelle" => $libelle,
                    ":symbole" => $symbole,
                    ':id' => $_GET['id']
                ]
            );

            
            // affichage du SweetAlert après la modification réussie
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire("Modification effectuée avec succès!", "", "success").then(() => {
                            window.location.href = "liste_unite.php";
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
                            <label for="">Libelle </label> <br><br>
                            <input type="text" name="libelle"  class="form-control" 
                            value="<?php if(isset($_GET['id'])){echo $recuperer->libelle;}?>">
                        </div>
                        <div class="form-group col-6 mt-3">
                            <label for="">Symbole </label> <br><br>
                            <input type="text" name="symbole" class="form-control" 
                            value="<?php if(isset($_GET['id'])){echo $recuperer->symbole;}?>">
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
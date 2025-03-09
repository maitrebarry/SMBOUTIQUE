<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
// require('config.php');
session_start();

if (isset($_POST['username'])){
  $username = stripslashes($_REQUEST['username']);
  $username = mysqli_real_escape_string($conn, $username);
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($conn, $password);
    $query = "SELECT * FROM `users` WHERE username='$username' and password='".hash('sha256', $password)."'";
  $result = mysqli_query($conn,$query) or die(mysql_error());
  $rows = mysqli_num_rows($result);
  if($rows==1){
      $_SESSION['username'] = $username;
      header("Location: index.php");
  }else{
    $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
  }
}
?>
<form class="box" action="" method="post" name="login">
<h1 class="box-logo box-title"><a href="https://waytolearnx.com/">WayToLearnX.com</a></h1>
<h1 class="box-title">Connexion</h1>
<input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur">
<input type="password" class="box-input" name="password" placeholder="Mot de passe">
<input type="submit" value="Connexion " name="submit" class="box-button">
<p class="box-register">Vous êtes nouveau ici? <a href="register.php">S'inscrire</a></p>
<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>
</body>
</html>
 <div class="col-xl-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-xl-3 col-md-10 col-xs-12">
                                        <div class="form-group mt-3">
                                            <label for="">Montant total</label>
                                            <input type="number" class="form-control montant_total" id="montant_total" value="<?= $lignes['montant_total'] ?>" readOnly>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-10 col-xs-12">
                                        <div class="form-group mt-3">
                                            <label for="">Rémise</label>
                                            <input type="number" name="remise" class="form-control remise" id="remise">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-10 col-xs-12">
                                        <div class="form-group mt-3">
                                            <label for="">Net à payer</label>
                                            <input type="number" value="" class="form-control netpayer" readOnly>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-10 col-xs-12">
                                        <div class="form-group mt-3">
                                            <label for="">Montant reçu</label>
                                            <input type="number" name="montantrecu" class="form-control montantrecu" id="montantrecu">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-10 col-xs-12">
                                        <div class="form-group mt-3">
                                            <label for="">Monnaie à rembourser</label>
                                            <input type="number" name="monnaierembourser" class="form-control monnaierembourser text-danger" id="monnaierembourser" readOnly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  	 	 	
	
                         <div class="col-xxl-4 col-md-6">
    <div class="card info-card revenue-card">
      
    <div class="card-header bg-primary text-white text-center">
        <h5>Bilan des ventes</h5>
    </div>
    <div class="card-body d-flex justify-content-around mt-3">
        <div class="text-center">
            <p>Ventes journalières</p>
            <i class="bi bi-camera"></i>
            <p><a href="#" class="text-primary">Vente totale</a></p>
            <p>0,00</p>
            <p><a href="#" class="text-primary">Créance total</a></p>
            <p>0,00</p>
            <p><a href="#" class="text-primary">Montant en caisse</a></p>
            <p>0,00</p>
            <p>(F CFA)</p>
            <p>09/03/2024</p>
        </div>
        <div class="text-center">
            <p>Ventes mensuelles</p>
            <i class="bi bi-camera"></i>
            <p><a href="#" class="text-primary">Vente totale</a></p>
            <p>0,00</p>
            <p><a href="#" class="text-primary">Créance total</a></p>
            <p>0,00</p>
            <p><a href="#" class="text-primary">Montant en caisse</a></p>
            <p>0,00</p>
            <p>(F CFA)</p>
            <p>03/2024</p>
        </div>
        <div class="text-center">
            <p>Ventes annuelles</p>
            <i class="bi bi-camera"></i>
            <p><a href="#" class="text-primary">Vente totale</a></p>
            <p>0,00</p>
            <p><a href="#" class="text-primary">Créance total</a></p>
            <p>0,00</p>
            <p><a href="#" class="text-primary">Montant en caisse</a></p>
            <p>0,00</p>
            <p>(F CFA)</p>
            <p>2024</p>
        </div>
    </div>

    </div>
    </div>

    maintenant attaquons le back-end voici par exemple un code pour l'un de mon backend: <?php
                // Requête pour calculer la somme des montants payés dans la table paiement_client
                $sumMontantPayeQuery = "SELECT SUM(montant_paye) AS total_montant_paye FROM paiement_client";
                $sumMontantPayeResult = $bdd->query($sumMontantPayeQuery);
                $sumMontantPaye = $sumMontantPayeResult->fetch(PDO::FETCH_OBJ);
                // Requête pour calculer la somme des montants total dans la table vente
                $sumMontantPayeQuery1 = "SELECT SUM(montant_total) AS total_montant FROM vente";
                $sumMontantPayeResult1 = $bdd->query($sumMontantPayeQuery1);
                $sumMontantPaye1 = $sumMontantPayeResult1->fetch(PDO::FETCH_OBJ);
                // Totaux des montants payés
                $totalMontantPaye = $sumMontantPaye->total_montant_paye;
                $totalMontantVente = $sumMontantPaye1->total_montant;
                $totaux = $totalMontantPaye + $totalMontantVente;
                // Calcul du pourcentage d'augmentation
                $pourcentageAugmentation = 0;
                if ($totalMontantPaye !== 0 && $totalMontantPaye !== null) {
                    $pourcentageAugmentation = (($totalMontantVente - $totalMontantPaye) / abs($totalMontantPaye)) * 100;
                }
                ?>
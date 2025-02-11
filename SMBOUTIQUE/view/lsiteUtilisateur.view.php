<?php
require_once('autoload.php');
$update = new Fournisseur();
if (isset($_POST['valider'])) {
    $Id_users = $_POST['Id_users'];
    $statut = $_POST['statut'];
    $modifier = $update->update_utilisateur(
        'UPDATE utilisateur SET statut=:statut where id_utilisateur=:Id_users',
        [
            ':Id_users' => $Id_users,
            ':statut' => $statut
        ]
    );
}

if (!$_SESSION['type_utilisateur']) {
    header("Location: index.php");
    exit();
}
$typ_utilisateur = $_SESSION['type_utilisateur'];
?>
<!--------header------->
<?php require_once ('partials/header.php') ?>
<!-------------sidebare----------->
<?php require_once ('partials/sidebar.php')?>
<!-------------navebare----------->
<?php require_once ('partials/navbar.php')?>
<style>
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 50px;
        background-color: #f5f5f5;
    }
    .btn-light {
        float: right;
    }
    .bi-exclamation-triangle {
        font-size: 90px;
    }
    .btn-block {
        width: 100%;
        margin-bottom: 10px;
        padding: 25px;
        text-align: center;        
        font-family: 'Times New Roman', Times, serif;
        font-weight: bolder;
        color : black;

    }
</style>
<!DOCTYPE html>
<html lang="en">
<body>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                <li class="breadcrumb-item">Utilisateur</li>
                <li class="breadcrumb-item active">Liste Utilisateur</li>
            </ol>
        </nav>
        
        <section class="section">
            
            <div class="row">              
                <div class="col-xl-3">
                    <div class="card ">
                         <div class="card-header">                                             
                          <h6>GENERAL</h6>
                        </div>
                        <div class="card-body">
                            <a href="creer_utilisateur.php" class="btn btn-outline-primary btn-block">Ajouter utilisateur</a>
                            <a href="unite.php" class="btn btn-outline-primary btn-block">Unités</a>
                             <!-- <a href="boutique.php" class="btn btn-outline-primary btn-block">Supermarchés</a>
                            <a href="proprietaire.php" class="btn btn-outline-primary btn-block">Proprietaire</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-10 col-xm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">                                             
                            <h6>LISTE UTILISATEUR</h6>
                        </div>                                                              
                     <div class="card-body">
                        <table class="table datatable table-bordered">
                            <thead>
                                <tr> 
                                    <th>NOM et PRENOM</th>
                                    <th>IDENTIFIANT</th>
                                    <th>TYPE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php  
                                if($typ_utilisateur=="Superadmin"){
                                foreach ($recuperer_superadmin as $liste_utilisateur):?>
                                    <tr>
                                        <td><?= $liste_utilisateur->nom_utilisateur ?> <?= $liste_utilisateur->prenom_utilisateur ?></td>
                                        <td><?= $liste_utilisateur->psedeau_utilisateur?></td>
                                        <td><?= $liste_utilisateur->type_utilisateur ?></td>
                                        <td>    
                                            <?php if ($liste_utilisateur->statut == 'on') { ?>
                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#basicModal<?= $liste_utilisateur->id_utilisateur ?>">
                                                    <i class="bi bi-person-check"></i>
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#basicModal<?= $liste_utilisateur->id_utilisateur ?>">
                                                    <i class="bi bi-person-x"></i>
                                                </button>
                                            <?php } ?>
                                            <a href="modifier_utilisateur.php?id=<?=$liste_utilisateur->id_utilisateur?>" 
                                                class="btn btn-info btn-sm" title="modifier">
                                                <i class="bx bxs-edit"></i>
                                            </a>&emsp;
                                            <div class="modal fade" id="basicModal<?= $liste_utilisateur->id_utilisateur ?>" tabindex="-1">  
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="" method="post">
                                                            <div class="modal-body">
                                                                <p class="text-center"><i class="bi bi-exclamation-triangle text-danger"></i></p>
                                                                <h5 class="text-center text-danger"> Avertissement !</h5>
                                                                <p class="text-center"> Voulez-vous vraiment <?php if ($liste_utilisateur->statut == 'on') { ?>désactiver<?php } else { ?> activer <?php } ?> <?= $liste_utilisateur->nom_utilisateur ?> <?= $liste_utilisateur->prenom_utilisateur ?> ?</p>
                                                            </div>
                                                            <input type="hidden" value=" <?= $liste_utilisateur->id_utilisateur ?>" name="Id_users">
                                                            <?php if ($liste_utilisateur->statut == 'on') { ?>
                                                                <input type="hidden" value="off" name="statut">
                                                            <?php } else { ?>
                                                                <input type="hidden" value="on" name="statut">
                                                            <?php } ?>
                                                            <div class="modal-footer d-flex justify-content-center">
                                                                <button type="button" class="btn btn-info" data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit" class="btn btn-primary" name="valider"><?php if ($liste_utilisateur->statut == 'on') { ?> Oui Désactiver<?php } else { ?>Oui Activer <?php } ?></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; }?>
                                                                    
                                <?php if($typ_utilisateur=="Administrateur"){
                                foreach ($recuperer_admin as $liste_utilisateur):?>
                                    <tr>
                                        <td><?= $liste_utilisateur->nom_utilisateur ?> <?= $liste_utilisateur->prenom_utilisateur ?></td>
                                        <td><?= $liste_utilisateur->psedeau_utilisateur?></td>
                                        <td><?= $liste_utilisateur->type_utilisateur ?></td>
                                        <td>       
                                            <?php if($liste_utilisateur->type_utilisateur != 'Administrateur') { ?>
                                                <?php if ($liste_utilisateur->statut == 'on') { ?>
                                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#basicModal<?= $liste_utilisateur->id_utilisateur ?>">
                                                        <i class="bi bi-person-check"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#basicModal<?= $liste_utilisateur->id_utilisateur ?>">
                                                        <i class="bi bi-person-check"></i>
                                                    </button>
                                                <?php } ?>
                                                <a href="modifier_utilisateur.php?id=<?=$liste_utilisateur->id_utilisateur?>" 
                                                    class="btn btn-info btn-sm">
                                                    <i class="bx bxs-edit"></i>
                                                </a>&emsp;
                                            <?php } ?>
                                            <div class="modal fade" id="basicModal<?= $liste_utilisateur->id_utilisateur ?>" tabindex="-1">  
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="" method="post">
                                                            <div class="modal-body">
                                                                <p class="text-center"><i class="bi bi-exclamation-triangle text-primary"></i></p>
                                                                <h5 class="text-center text-primary"> Avertissement !</h5>
                                                                <p class="text-center"> Voulez-vous vraiment <?php if ($liste_utilisateur->statut == 'on') { ?>désactiver<?php } else { ?> activer <?php } ?> <?= $liste_utilisateur->nom_utilisateur ?> <?= $liste_utilisateur->prenom_utilisateur ?> ?</p>
                                                            </div>
                                                            <input type="hidden" value=" <?= $liste_utilisateur->id_utilisateur ?>" name="Id_users">
                                                            <?php if ($liste_utilisateur->statut == 'on') { ?>
                                                                <input type="hidden" value="off" name="statut">
                                                            <?php } else { ?>
                                                                <input type="hidden" value="on" name="statut">
                                                            <?php } ?>
                                                            <div class="modal-footer d-flex justify-content-center">
                                                                <button type="button" class="btn btn-info" data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit" class="btn btn-primary" name="valider"><?php if ($liste_utilisateur->statut == 'on') { ?> Oui Désactiver<?php } else { ?>Oui Activer <?php } ?></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; }?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    
                </div>
            </div>  
                                      
        </section>
    </main>  
    <footer class="footer">
        <?php require_once('partials/foot.php') ?>
        <?php require_once('partials/footer.php') ?>
    </footer>
</body>
</html>
<?php
    require_once('partials/database.php');
    require_once('function/function.php');
    if (isset($_POST['valider'])) {
        if(!empty($_POST['id_commande_four']) and !empty($_POST['ref']) and !empty($_POST['map']) and !empty($_POST['dat']) and !empty($_POST['mr'])){
           extract($_POST);
        //    echo $id_commande_four;
        //    echo $ref;
        //    echo $map;
        //    echo $mr;
        //    echo "$dat <br>";
        //    exit;
        $mont_a_paye=$_POST['map'];
        $mont_rest=$_POST['mr'];
        if ($mont_a_paye<=$mont_rest) {
           $paie= $commandeinfo['paie'];
           $new_paie=$paie + $map;      
             $paie=$bdd->prepare('INSERT INTO paiement(id_commande_fournisseur,montant_paye,date_paie,paie_referrence)
            VALUES(?,?,?,?)');
            $paie->execute(array($id_commande_four,$map,$dat,$ref)); 
            //pour la MISE EN JOUR
             $update_cmd_paie=$bdd->query("UPDATE commande_fournisseur SET paie=$new_paie WHERE id_commande_fournisseur=$id_commande_four");
             if($paie){ 
                  header('location:liste_commande_four.php');
             }
        }else{
            afficher_message('Montant a payé doit être inférieur ou égal au montant restant ');
        }
          
        }
    }
?>
<?php
    require_once('rentrer_anormal.php') ;
    require_once('partials/database.php');
  require_once('function/function.php');
if (isset($_POST['valider'])) {
    if (!empty($_POST['id_commande_client']) and !empty($_POST['ref']) and !empty($_POST['dat'])) {
        $id_cf = $_POST['id_commande_client'];
        $ref = $_POST['ref'];
        $dat = $_POST['dat'];

        $bdd->beginTransaction();  // Début de la transaction

        try {
            $req = $bdd->prepare('INSERT INTO livraison(id_commande_client, date_livraison, livraison_refer) VALUES(?,?,?)');
            $req->execute(array($id_cf, $dat, $ref));
            $lastid = $bdd->lastInsertId();

            for ($i = 0; $i < count($_POST['id_ligne']); $i++) {
                $id_ligne = $_POST['id_ligne'][$i];
                $id_produit = $_POST['id_produit'][$i];
                $recep_act = $_POST['recep_act'][$i];
                $quantite = $_POST['qte_com'][$i];
                $stockt =$_POST['stock'][$i];
                $rest_stock=($stockt-$recep_act);
                $prix_article=$_POST['price'][$i];
                $montant=$quantite*$prix_article;
                //  var_dump($rest_stock);
                //     exit;
                if ($rest_stock>=0) {
                     if ($recep_act > 0) {
                        if ($quantite >= $recep_act) {
                            $res = $bdd->prepare('INSERT INTO ligne_livraison(id_livraison, quantite_recu, id_produit) VALUES(?,?,?)');
                            $res->execute(array($lastid, $recep_act, $id_produit));
                             $lastid_ligne = $bdd->lastInsertId();
                            // Mise à jour du stock
                            $new_stock = $stockt - $recep_act;
                            $update_prod_stock = $bdd->prepare("UPDATE tbl_product SET stock=? WHERE id=?");
                            $update_prod_stock->execute(array($new_stock, $id_produit));

                            // Mise à jour de la quantité livrée
                            $update_lign_qte_liv = $bdd->prepare("UPDATE ligne_commande_client SET qte_livre=qte_livre+? WHERE id_ligne_cl=?");
                            $update_lign_qte_liv->execute(array($recep_act, $id_ligne));
                            // Insérer l'id_ligne_reception dans la table "mouvement"
                            $insert_mouvement = $bdd->prepare('INSERT INTO mouvement(id_ligne_livraison,id_ligne_reception,id_ligne_vente,id_produit,quantite, type_mvnt, montant,date_mov) VALUES(?,?,?,?,?,?,?,NOW())');
                            $insert_mouvement->execute(array($lastid_ligne, null,null,$id_produit ,$quantite, 'livraison', $montant));
                            header('location:liste_commande_client.php');
                            afficher_message('Livraison effectuée avec succès' , 'success');

                        }else {
                            afficher_message('La reception actuelle doit être inférieure ou égale à la quantité Commandée  ');
                        }
                     }
                }else{
                    afficher_message('Stock insuffisant!');
                }
            }

            $bdd->commit(); // Commit si tout s'est bien déroulé
        } catch (Exception $e) {
            $bdd->rollBack(); // En cas d'erreur, annulation de la transaction
            echo "Failed: " . $e->getMessage();
        }
    }
}
?>

<?php require_once('view/envoie_livraison.view.php'); ?>

























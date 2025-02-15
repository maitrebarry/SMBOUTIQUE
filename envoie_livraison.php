<?php
require_once('rentrer_anormal.php');
require_once('partials/database.php');
require_once('function/function.php');

if (isset($_POST['valider'])) {
    if (!empty($_POST['id_commande_client']) && !empty($_POST['ref']) && !empty($_POST['dat'])) {
        $id_cf = $_POST['id_commande_client'];
        $ref = $_POST['ref'];
        $dat = $_POST['dat'];

        $bdd->beginTransaction();

        try {
            $req = $bdd->prepare('INSERT INTO livraison(id_commande_client, date_livraison, livraison_refer) VALUES(?,?,?)');
            $req->execute(array($id_cf, $dat, $ref));
            $lastid = $bdd->lastInsertId();

            $livraison_effectuee = false;

            for ($i = 0; $i < count($_POST['id_ligne']); $i++) {
                $id_ligne = $_POST['id_ligne'][$i];
                $id_produit = $_POST['id_produit'][$i];
                $recep_act = $_POST['recep_act'][$i];
                $quantite = $_POST['qte_com'][$i];
                $stockt = $_POST['stock'][$i];
                $rest_stock = ($stockt - $recep_act);
                $prix_article = $_POST['price'][$i];
                $montant = $quantite * $prix_article;

                if ($rest_stock >= 0) {
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
                            $insert_mouvement->execute(array($lastid_ligne, null, null, $id_produit, $quantite, 'livraison', $montant));

                            $livraison_effectuee = true;
                        } else {
                            afficher_message('La livraison actuelle doit être inférieure ou égale à la quantité commandée.');
                        }
                    }
                } else {
                    afficher_message('Stock insuffisant!');
                }
            }

            $bdd->commit();

           
            if ($livraison_effectuee) {
                $_SESSION['notification'] = [
                    'message' => 'Livraison effectuée avec succès',
                    'type' => 'success'
                ];
                header('location:liste_commande_client.php');
                exit();
            }

        } catch (Exception $e) {
            $bdd->rollBack();
            echo "Erreur lors de la livraison : " . $e->getMessage();
        }
    }
}
?>
<?php require_once('view/envoie_livraison.view.php'); ?>

<?php
require_once('rentrer_anormal.php') ;
// Inclusion des fichiers nécessaires
require_once('partials/database.php');
require_once('function/function.php');
?>

<?php
// Vérification si le formulaire est soumis
if (isset($_POST['valider'])) {
    // Vérification des champs obligatoires
    if (!empty($_POST['id_commande_four']) && !empty($_POST['ref']) && !empty($_POST['dat'])) {
        // Extraction des données du formulaire
        $id_cf = $_POST['id_commande_four'];
        $ref = $_POST['ref'];
        $dat = $_POST['dat'];

        // Préparation et exécution de la requête d'insertion dans la table "reception"
        $req = $bdd->prepare('INSERT INTO reception(id_commande_fournisseur, date_reception, recept_ref) VALUES(?,?,?)');
        $req->execute(array($id_cf, $dat, $ref));
        $lastid = $bdd->lastInsertId();

        // Boucle sur les lignes du formulaire
        for ($i = 0; $i < (count($_POST['id_ligne'])); $i++) {
            $id_ligne = $_POST['id_ligne'][$i];
            $id_produit = $_POST['id_produit'][$i];
            $recep_act = $_POST['recep_act'][$i];
            $quantite = $_POST['qte_com'][$i];
            $prix_article=$_POST['price'][$i];
            $montant=$quantite*$prix_article;

            // Vérification si la quantité reçue est valide
            if ($recep_act > 0 && $recep_act <= $quantite) {
                // Préparation et exécution de la requête d'insertion dans la table "ligne_reception"
                $res = $bdd->prepare('INSERT INTO ligne_reception(id_reception, quantite_recu, id_produit) VALUES(?,?,?)');
                $res->execute(array($lastid, $recep_act, $id_produit));
                 $lastid_ligne = $bdd->lastInsertId();
                // Mise à jour du stock dans la table "tbl_product"
                $prod = $bdd->query("SELECT * FROM tbl_product WHERE id=$id_produit LIMIT 1");
                $fecth_prod = $prod->fetch();
                $stock = $fecth_prod['stock'];
                $new_stock = $stock + $recep_act;
                $update_prod_stock = $bdd->query("UPDATE tbl_product SET stock=$new_stock WHERE id=$id_produit");

                // Mise à jour de la quantité livrée dans la table "ligne_commande"
                $ligen_cd = $bdd->query("SELECT * FROM ligne_commande WHERE id_ligne=$id_ligne LIMIT 1");
                $fecth_li = $ligen_cd->fetch();
                $qte_livrer = $fecth_li['qte_livre'];
                $new_qte = $qte_livrer + $recep_act;
                $update_lign_qte_liv = $bdd->query("UPDATE ligne_commande SET qte_livre=$new_qte WHERE id_ligne=$id_ligne");

                // Insértion dans la table "mouvement"
                $insert_mouvement = $bdd->prepare('INSERT INTO mouvement(id_ligne_reception,id_ligne_livraison,id_ligne_vente,id_produit,quantite,type_mvnt,montant,date_mov)
                 VALUES(?,?,?,?,?,?,?,NOW())');
                $insert_mouvement->execute(array($lastid_ligne,null,null,$id_produit,$quantite, 'reception', $montant));
                   $_SESSION['notification'] = [
                            'message' => 'Reception effectuée avec succès',
                            'type' => 'success'
                        ];

                        header('location:liste_commande_four.php');
                        exit();
                    } else {
                // Affichage d'un message d'erreur si la quantité reçue n'est pas valide
                afficher_message('La reception actuelle doit être inférieure ou égale à la quantité Commandée ');
            }
        }
    }
}
?>

<?php require_once('view/envoie_reception.view.php') ?>

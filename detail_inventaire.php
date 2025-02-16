 
  <?php 
    require_once('partials/database.php');
    if (isset($_GET['detail'])) {
        $detail=$_GET['detail'];
        $commande=$bdd->query("SELECT * FROM inventaire 
                               INNER JOIN utilisateur 
                               ON utilisateur.id_utilisateur = inventaire.id_utilisateur 
                               WHERE id_inventaire=$detail LIMIT 1");
        $inventaire=$commande->fetch();
        //afficher la ligne de commande
        $ligne_inventaire=$bdd->query("SELECT * FROM ligne_inventaire 
                                       INNER JOIN tbl_product 
                                       ON tbl_product.id = ligne_inventaire.id_produit 
                                       WHERE ligne_inventaire.id_inventaire=$detail" );
    }
        

require_once ('view/detail_inventaire.view.php');
?>

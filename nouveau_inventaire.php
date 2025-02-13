<?php
require_once('rentrer_anormal.php') ;
require_once('autoload.php'); 
$pdo = $bdd; 

$liste_produit = new Produit();
$recuperer_afficher = $liste_produit->list();
$recuperer_supermarche=$liste_produit->list3();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_utilisateur = 1; 
    $reference_inventaire = $_POST['ref'];
    $date_inventaire = $_POST['dat'];
    $regulariser = "non";

    // Insérer l'inventaire
    $sql_inventaire = "INSERT INTO inventaire (id_utilisateur, date_inventaire,  reference_inventaire, regulariser) 
                       VALUES (:id_utilisateur, :date_inventaire,  :reference_inventaire, :regulariser)";
    $stmt_inventaire = $pdo->prepare($sql_inventaire);
    $stmt_inventaire->execute([
        ':id_utilisateur' => $id_utilisateur,
        ':date_inventaire' => $date_inventaire,
        ':reference_inventaire' => $reference_inventaire,
        ':regulariser' => $regulariser
    ]);

    $id_inventaire = $pdo->lastInsertId();

    // Insérer les lignes d'inventaire
    $sql_ligne_inventaire = "INSERT INTO ligne_inventaire (id_produit, id_inventaire, quantite_physique, ecart_stock) 
                             VALUES (:id_produit, :id_inventaire, :quantite_physique, :ecart_stock)";
    $stmt_ligne_inventaire = $pdo->prepare($sql_ligne_inventaire);

    foreach ($recuperer_afficher as $prod) {
        $id_produit = $prod->id;
        $quantite_physique = isset($_POST['qte_physique_' . $id_produit]) && $_POST['qte_physique_' . $id_produit] !== '' ? (int)$_POST['qte_physique_' . $id_produit] : null;

        if ($quantite_physique !== null && $quantite_physique > 0) {
            // Récupérer la quantité virtuelle (stock) du produit
            $sql_stock = "SELECT stock FROM tbl_product WHERE id = :id_produit";
            $stmt_stock = $pdo->prepare($sql_stock);
            $stmt_stock->execute([':id_produit' => $id_produit]);
            $quantite_virtuelle = (int) $stmt_stock->fetchColumn();

            // Calculer l'écart de stock
            $ecart_stock = $quantite_physique - $quantite_virtuelle;
            // Insérer la ligne d'inventaire avec l'écart stock
            try {
                $stmt_ligne_inventaire->execute([
                    ':id_produit' => $id_produit,
                    ':id_inventaire' => $id_inventaire,
                    ':quantite_physique' => $quantite_physique,
                    ':ecart_stock' => abs($ecart_stock)
                ]);
            } catch (PDOException $e) {
                echo "Erreur SQL: " . $e->getMessage();
            }
        }
    }

    // affichage du SweetAlert après la modification réussie
    echo '<script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire("Inventaire fait avec succès!", "", "success").then(() => {
                    window.location.href = "liste_inventaire.php";
                });
            });
        </script>';
}


require_once('view/nouveau_inventaire.view.php');

?>

<?php require_once ('partials/database.php') ;
   // nobre de commande fournisseur
      $nbr_comde="SELECT * FROM commande_fournisseur";
      $nbr_comdes=$bdd->query($nbr_comde);
      $resultat=$nbr_comdes->rowCount();
      //nobre de commande reçue
      $nbr_recu="SELECT * FROM reception";
      $nbr_recus=$bdd->query($nbr_recu);
      $resultat_recu=$nbr_recus->rowCount();
     //nobre de commande non reçue
      $cmnd_non_recu=$resultat-$resultat_recu;

    // nobre de commande client
      $nbr_comde_cl="SELECT * FROM commande_client";
      $nbr_comdes_cl=$bdd->query($nbr_comde_cl);
      $resultat_cl=$nbr_comdes_cl->rowCount();
      
     //nobre de commande livree
      $nbr_liv="SELECT * FROM livraison";
      $nbr_livs=$bdd->query($nbr_liv);
      $resultat_liv=$nbr_livs->rowCount();
     //commande non livree
      $comnd_non_livree=$resultat_cl-$resultat_liv;
     // Nombre d'articles alertés
        $alerte_article = "SELECT * FROM tbl_product WHERE  stock<=alerte_article ";
        $alerte_articles = $bdd->query($alerte_article);
        $stock_alerte = $alerte_articles->rowCount();
        //nombre total articles
        $tt_article= "SELECT * FROM tbl_product ";
        $tt_articles=$bdd->query($tt_article) ;
        $total_article=$tt_articles->rowCount();
?>

<!--------header------->
<?php require_once ('partials/header.php') ?>
<!-------------sidebare----------->
<?php require_once ('partials/sidebar.php')?>
<!-------------navebare----------->
<?php require_once ('partials/navbar.php')?>
    <style>
        .bi.bi-cart {
        font-size: 50px; 
    }
       .ri-caravan-line{
         font-size: 50px;
       }
        .bi-cart-check{
             font-size: 50px;
        }
        .bi-cart-x-fill{
            font-size: 50px;
        }
        .bi-exclamation-triangle{
            font-size: 50px;
        }
        .bi-person-fill{
            font-size: 50px;
        }
</style>
<body>

    <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <!-- <li class="breadcrumb-item"></li> -->
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
        <!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <!-- <div class="col-lg-8">
          <div class="row"> -->

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <a href="liste_fournisseur.php" class="btn btn-outline-white">
                            <div class="card-body">
                                <h5 class="card-title">Etat <span>|Fournisseurs<span>|Clients</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                         <i class="bi bi-person-fill"></i></i>
                                    </div>
                                    <div class="ps-3">
                                        <?php
                                        // nobre de  fournisseur
                                        $nbre_four="SELECT * FROM fournisseur";
                                        $nbre_fours=$bdd->query($nbre_four);
                                        $resultat_four=$nbre_fours->rowCount();
                                        ?>
                                        <h6><?=$resultat_four?></h6>
                                        <span class="text-success small pt-1 fw-bold"></span>
                                        <span class="text-info small pt-2 ps-1">fournisseurs enregistrés</span>
                                    </div>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                    <div class="ps-5">
                                         <?php
                                        // nobre de  client
                                        $nbre_client="SELECT * FROM commande_client";
                                        $nbre_clients=$bdd->query($nbre_client);
                                        $resultat_client=$nbre_clients->rowCount();
                                        ?>
                                        <h6><?=$resultat_client?></h6>
                                        <span class="text-success small pt-1 fw-bold ps-5"></span>
                                        <span class="text-success small">clients enregistrés</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Sales Card -->

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <a href="liste_produit.php" class="btn btn-outline-white">
                            <div class="card-body">
                                <h5 class="card-title">Total <span>| articles</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-bricks"></i>
                                    </div>
                                    <div class="ps-3">
                                         <?php
                                           $total_attendu5 = 100; // a remplacer par la valeur totale du commande attendue

                                             $pourcentage5 = ($total_article / $total_attendu5) * 100;
                                          ?>
                                        <h6><?=$total_article?></h6>
                                        <span class="text-success small pt-1 fw-bold"><?= round($pourcentage5, 2) ?>%</span>
                                        <span class="text-muted small pt-2 ps-1">articles</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Sales Card -->

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <a href="liste_produit.php" class="btn btn-outline-white">
                             
                            <div class="card-body">
                                <h5 class="card-title">Alerte <span>| stock article</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-exclamation-triangle text-danger"></i>
                                    </div>
                                    <div class="ps-3">
                                        <?php
                                           $total_attendu6 = $total_article; // a remplacer par la valeur totale du commande attendue

                                             $pourcentage6 = ($stock_alerte / $total_attendu6) * 100;
                                          ?>
                                        <h6><?= $stock_alerte?></h6>
                                        <span class="text-danger small pt-1 fw-bold"><?= round($pourcentage6, 2) ?>%</span>
                                        <span class="text-danger small pt-2 ps-1"> d'article sont en rupture de stock</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Sales Card -->
                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <a href="liste_commande_four.php" class="btn btn-outline-white">
                            <div class="card-body">
                                <h5 class="card-title">Commande <span>| Fournisseur</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <?php
                                           $total_attendu = 100; // a remplacer par la valeur totale du commande attendue

                                             $pourcentage = ($resultat / $total_attendu) * 100;
                                          ?>
                                                        <h6><?= $resultat ?></h6>
                                        <span class="text-success small pt-1 fw-bold"><?= round($pourcentage, 2) ?>%</span>
                                        <span class="text-muted small pt-2 ps-1">commande</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Sales Card -->

               
                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <a href="liste_commande_client.php" class="btn btn-outline-white">
                            <div class="card-body">
                                <h5 class="card-title">Commande <span>| Client</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <?php
                                           $total_attendu3 = 100; // a remplacer par la valeur totale du commande attendue

                                             $pourcentage3 = ($resultat_cl / $total_attendu3) * 100;
                                          ?>
                                        <h6><h6><?= $resultat_cl ?></h6></h6>
                                        <span class="text-success small pt-1 fw-bold"><?= round($pourcentage3, 2) ?>%</span>
                                        <span class="text-muted small pt-2 ps-1">commande</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Sales Card -->

              
                <!-- Revenue Card -->
    <div class="col-xxl-4 col-md-6">
        <div class="card info-card revenue-card">
            <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown">
                    <!-- <i class="bi bi-three-dots"></i> -->
                </a>
                <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Bilan des Ventes</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">vente journalière </a></li>
                    <li><a class="dropdown-item" href="#">Vente Mensuelle</a></li>
                    <li><a class="dropdown-item" href="#">Vente annuelle</a></li>
                </ul> -->
            </div>
                <?php
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
            <div class="card-body">
                <h5 class="card-title">Bilan des Ventes</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                        <?php
                       echo "<h6>" . number_format($totaux, 2, ',', ' ') . " F CFA</h6>";

                        // if ($pourcentageAugmentation !== null) {
                        //     echo "<span class='text-success small pt-1 fw-bold'>" . number_format($pourcentageAugmentation, 2) . "%</span>";
                        // } else {
                        //     echo "<span class='text-muted small pt-1'>Pas de pourcentage d'augmentation disponible</span>";
                        // }
                        ?>
                        <span class="text-muted small pt-2 ps-1">Vendues</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- End Revenue Card -->
        <?php
        // Requête pour obtenir les ventes par produit (y compris la quantité reçue de la table ligne_livraison)
              $sql = "SELECT p.name as product_name, 
               COALESCE(SUM(lv.quantite), 0) as total_quantity_sold,
               COALESCE(SUM(ll.quantite_recu), 0) as total_quantity_received
                FROM tbl_product p
                LEFT JOIN ligne_vente lv ON p.id = lv.id_produit
                LEFT JOIN ligne_livraison ll ON p.id = ll.id_produit
                GROUP BY p.id, p.name
                ORDER BY total_quantity_sold DESC
                LIMIT 5";
                $stmt = $bdd->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // Création des tableaux pour les données ApexCharts
                $categories = [];
                $dataSales = [];
                $dataReceived = [];
                foreach ($result as $row) {
                    $categories[] = $row['product_name'];
                    $dataSales[] = $row['total_quantity_sold'];
                    $dataReceived[] = $row['total_quantity_received'];
                }
        ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top 5 des Produits les plus vendus</h5>

                    <!-- Bar Chart -->
                    <div id="topProductsChart"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const topProductsChart = new ApexCharts(document.querySelector("#topProductsChart"), {
                                series: [
                                    {
                                        name: 'Quantité Vendue',
                                        data: <?= json_encode($dataSales); ?>,
                                    },
                                    {
                                        name: 'Quantité Vendue par commande',
                                        data: <?= json_encode($dataReceived); ?>,
                                    }
                                ],
                                chart: {
                                    height: 350,
                                    type: 'bar',
                                    toolbar: {
                                        show: false
                                    },
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        columnWidth: '55%',
                                        endingShape: 'rounded'
                                    },
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                colors: ['#4154f1', '#2eca6a'], // Ajout de la deuxième couleur pour les données reçues
                                fill: {
                                    type: "gradient",
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: 0.7,
                                        opacityTo: 5,
                                        stops: [0, 90, 100]
                                    }
                                },
                                xaxis: {
                                    categories: <?= json_encode($categories); ?>
                                },
                                tooltip: {
                                    y: {
                                        formatter: function(val) {
                                            return val + " unités";
                                        }
                                    }
                                }
                            });

                            topProductsChart.render();
                        });
                    </script>
                    <!-- End Bar Chart -->
                </div>
            </div>
        </div>
  </section>
</main> <!-- End #main -->
    <?php require_once ('partials/foot.php')?> <?php require_once ('partials/footer.php')?>
</body>
</html>
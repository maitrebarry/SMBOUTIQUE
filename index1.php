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
    // Requête pour obtenir les articles en alerte
    $alerte_article_query = "SELECT * FROM tbl_product WHERE stock <= alerte_article";
    $alerte_articles = $bdd->query($alerte_article_query);
    $stock_alerte = $alerte_articles->rowCount();

    // Requête pour obtenir le nombre total d'articles
    $total_article_query = "SELECT * FROM tbl_product";
    $total_articles = $bdd->query($total_article_query);
    $total_article = $total_articles->rowCount();

    // Calcul du pourcentage d'articles en alerte
    $pourcentage_alerte = ($total_article > 0) ? ($stock_alerte / $total_article) * 100 : 0;
       



  

    // Ventes journalières
    $dailySalesCashQuery = "SELECT SUM(montant_total) AS total_ventes FROM vente WHERE DATE(date_vente) = CURDATE()";
    $dailySalesCashResult = $bdd->query($dailySalesCashQuery);
    $dailySalesCash = $dailySalesCashResult->fetch(PDO::FETCH_OBJ);

    $dailySalesCreditQuery = "SELECT SUM(total) AS total_ventes, SUM(total - paie) AS total_creance FROM commande_client WHERE DATE(date_cmd_client) = CURDATE()";
    $dailySalesCreditResult = $bdd->query($dailySalesCreditQuery);
    $dailySalesCredit = $dailySalesCreditResult->fetch(PDO::FETCH_OBJ);

    $dailyCashQuery = "SELECT SUM(Montant_total_caisse) AS total_caisse FROM caisse WHERE DATE(date_caisse) = CURDATE()";
    $dailyCashResult = $bdd->query($dailyCashQuery);
    $dailyCash = $dailyCashResult->fetch(PDO::FETCH_OBJ)->total_caisse;

    $dailyTotal = $dailySalesCash->total_ventes + $dailySalesCredit->total_ventes;
    $dailyCredit = $dailySalesCredit->total_creance;

    // Ventes mensuelles
    $monthlySalesCashQuery = "SELECT SUM(montant_total) AS total_ventes FROM vente WHERE MONTH(date_vente) = MONTH(CURDATE()) AND YEAR(date_vente) = YEAR(CURDATE())";
    $monthlySalesCashResult = $bdd->query($monthlySalesCashQuery);
    $monthlySalesCash = $monthlySalesCashResult->fetch(PDO::FETCH_OBJ);

    $monthlySalesCreditQuery = "SELECT SUM(total) AS total_ventes, SUM(total - paie) AS total_creance FROM commande_client WHERE MONTH(date_cmd_client) = MONTH(CURDATE()) AND YEAR(date_cmd_client) = YEAR(CURDATE())";
    $monthlySalesCreditResult = $bdd->query($monthlySalesCreditQuery);
    $monthlySalesCredit = $monthlySalesCreditResult->fetch(PDO::FETCH_OBJ);

    $monthlyCashQuery = "SELECT SUM(Montant_total_caisse) AS total_caisse FROM caisse WHERE MONTH(date_caisse) = MONTH(CURDATE()) AND YEAR(date_caisse) = YEAR(CURDATE())";
    $monthlyCashResult = $bdd->query($monthlyCashQuery);
    $monthlyCash = $monthlyCashResult->fetch(PDO::FETCH_OBJ)->total_caisse;

    $monthlyTotal = $monthlySalesCash->total_ventes + $monthlySalesCredit->total_ventes;
    $monthlyCredit = $monthlySalesCredit->total_creance;

    // Ventes annuelles
    $annualSalesCashQuery = "SELECT SUM(montant_total) AS total_ventes FROM vente WHERE YEAR(date_vente) = YEAR(CURDATE())";
    $annualSalesCashResult = $bdd->query($annualSalesCashQuery);
    $annualSalesCash = $annualSalesCashResult->fetch(PDO::FETCH_OBJ);

    $annualSalesCreditQuery = "SELECT SUM(total) AS total_ventes, SUM(total - paie) AS total_creance FROM commande_client WHERE YEAR(date_cmd_client) = YEAR(CURDATE())";
    $annualSalesCreditResult = $bdd->query($annualSalesCreditQuery);
    $annualSalesCredit = $annualSalesCreditResult->fetch(PDO::FETCH_OBJ);

    $annualCashQuery = "SELECT SUM(Montant_total_caisse) AS total_caisse FROM caisse WHERE YEAR(date_caisse) = YEAR(CURDATE())";
    $annualCashResult = $bdd->query($annualCashQuery);
    $annualCash = $annualCashResult->fetch(PDO::FETCH_OBJ)->total_caisse;

    $annualTotal = $annualSalesCash->total_ventes + $annualSalesCredit->total_ventes;
    $annualCredit = $annualSalesCredit->total_creance;

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
                                        <span class="text-success small pt-1 fw-bold"><?= round($pourcentage5, 0) ?>%</span>
                                        <span class="text-muted small pt-0 ps-1">articles</span>
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
                        <a href="liste_produit.php?rupture=1" class="btn btn-outline-white">
                            <div class="card-body">
                                <h5 class="card-title">Alerte <span>| stock article</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-exclamation-triangle text-danger"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $stock_alerte ?></h6>
                                        <span class="text-danger small pt-1 fw-bold"><?= round($pourcentage_alerte, 0) ?>%</span>
                                        <span class="text-danger small pt-0 ps-1"> d'article sont en rupture de stock</span>
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
                                        <span class="text-success small pt-1 fw-bold"><?= round($pourcentage, 0) ?>%</span>
                                        <span class="text-muted small pt-0 ps-1">commande</span>
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
                                <h5 class="card-title">Vente en <span>| Credit</span></h5>
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
                                        <span class="text-success small pt-1 fw-bold"><?= round($pourcentage3, 0) ?>%</span>
                                        <span class="text-muted small pt-0 ps-1">commande</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Sales Card -->

              
                <!-- Revenue Card -->
                <div class="col-lg col-md-6 col-sm-10">
                   <div class="card info-card revenue-card">
                        <div class="card-header bg-primary text-white text-center">
                            <h7>Bilan des ventes</h7>
                        </div>
                        <div class="card-body d-flex justify-content-around mt-3">
                            <div class="text-center">
                                <p>Ventes journalières</p>
                                <i class="bi bi-camera"></i>
                                <p><a href="#" class="text-primary">Vente totale</a></p>
                                <p><?php echo number_format($dailyTotal, 0, ',', ' ') . ' F CFA'; ?></p>
                                <p><a href="#" class="text-primary">Créance totale</a></p>
                                <p><?php echo number_format($dailyCredit, 0, ',', ' ') . ' F CFA'; ?></p>
                                <p><a href="#" class="text-primary">Montant en caisse</a></p>
                                <p><?php echo number_format($dailyCash, 0, ',', ' ') . ' F CFA'; ?></p>
                                
                                <p class="text-primary"><?php echo date('d/m/Y'); ?></p>
                            </div>
                            <div class="text-center">
                                <p>Ventes mensuelles</p>
                                <i class="bi bi-camera"></i>
                                <p><a href="#" class="text-primary">Vente totale</a></p>
                                <p><?php echo number_format($monthlyTotal, 0, ',', ' ') . ' F CFA'; ?></p>
                                <p><a href="#" class="text-primary">Créance totale</a></p>
                                <p><?php echo number_format($monthlyCredit, 0, ',', ' ') . ' F CFA'; ?></p>
                                <p><a href="#" class="text-primary">Montant en caisse</a></p>
                                <p><?php echo number_format($monthlyCash, 0, ',', ' ') . ' F CFA'; ?></p>
                                
                                <p class="text-primary"><?php echo date('m/Y'); ?></p>
                            </div>
                            <div class="text-center">
                                <p>Ventes annuelles</p>
                                <i class="bi bi-camera"></i>
                                <p><a href="#" class="text-primary">Vente totale</a></p>
                                <p><?php echo number_format($annualTotal, 0, ',', ' ') . ' F CFA'; ?></p>
                                <p><a href="#" class="text-primary">Créance totale</a></p>
                                <p><?php echo number_format($annualCredit, 0, ',', ' ') . ' F CFA'; ?></p>
                                <p><a href="#" class="text-primary">Montant en caisse</a></p>
                                <p><?php echo number_format($annualCash, 0, ',', ' ') . ' F CFA'; ?></p>
                                
                                <p class="text-primary"><?php echo date('Y'); ?></p>
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
                <div class="col-10">
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
                                        colors: ['#4154f1', '#0eca6a'], // Ajout de la deuxième couleur pour les données reçues
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
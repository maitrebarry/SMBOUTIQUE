  <?php 
  require_once ('partials/database.php');

    $alerte_article_query = "SELECT * FROM tbl_product WHERE stock <= alerte_article";
    $alerte_articles = $bdd->query($alerte_article_query);
    $stock_alerte = $alerte_articles->rowCount();
  ?>
<?php
require_once('database.php');


?>



 <!-- ======= Header ======= -->
 <style>
    .profile-picture {
        width: 40px; /* ou la largeur désirée */
        height: 40px; /* ou la hauteur désirée */
        object-fit: cover; /* pour ajuster la taille tout en conservant le ratio d'aspect */
        border: 2px solid #ffffff; /* couleur de la bordure */
    }

</style> 
 <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
       <a href="index.html" class="logo d-flex align-items-center">
          <!-- <img src="assets/img/supermarche.png" alt=""> -->
          <span class="d-none d-lg-block" style="font-size: 32px; font-weight: bold; font-family: 'Times New Roman', sans-serif; color: #007bff;">S M-BOUTIQUE</span>
      </a>

        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
<!-- End Logo -->


<!-- End Search Bar -->
<nav class="header-nav ms-auto">
  
  <ul class="d-flex align-items-center">
    
    <li class="nav-item dropdown">
      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-danger badge-number"><?= $stock_alerte ?></span>
      </a><!-- Fin de l'icône de notification -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
              Vous avez <?= $stock_alerte ?> nouvelles notifications
              <a href="liste_produit.php?rupture=1"><span class="badge rounded-pill bg-danger p-2 ms-2">Tout voir</span></a>
          </li>
          <li>
              <hr class="dropdown-divider">
          </li>

          <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                  <h4>Rupture de stock</h4>
                  <p>Vous avez <?= $stock_alerte ?> produits en rupture de stock.</p>
              </div>
          </li>

         
      </ul><!-- Fin des éléments du menu déroulant des notifications -->
    </li><!-- Fin de la navigation des notifications -->
    <li class="nav-item dropdown">

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
           
            <span class="badge bg-dark badge-number">Année</span>
          </a>

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li>
              <a href="#">
                <span>2023</span>
              </a>
            </li>
            <li>
              <a href="#">
                <span>2024</span>
              </a>
            </li>
      </ul>
      <!-- End Messages Dropdown annee -->

    </li> <!-- End anne -->
   
    
    <li class="nav-item dropdown pe-3">
    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <div class="d-flex align-items-center">
            <img src= "user/<?= $_SESSION['avatar']?>" alt="Profile" class="rounded-circle profile-picture">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?=$_SESSION['nom_utilisateur']?></span>
            <i class="bi bi-circle-fill text-success ms-2" title="En ligne"></i>
            <!-- Remplacez "bi bi-circle-fill" par la classe de l'icône que vous souhaitez utiliser pour la disponibilité en ligne -->
        </div>
    </a>


      <!-- End Profile Iamge Icon -->
      
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <!-- <li class="dropdown-header">
          <h6>Kevin Anderson</h6>
          <span>Web Designer</span>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li> -->

        <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
            <i class="bi bi-person"></i>
            <span>Mon Profile</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
            <i class="bi bi-gear"></i>
            <span>Paramètre</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li>
          <a class="dropdown-item d-flex align-items-center" href="deconnexion.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Deconnexion</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

          
        
</header><!-- End Header -->

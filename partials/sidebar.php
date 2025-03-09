<?php require_once ('partials/database.php') ?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="index1.php">
                <i class="bi bi-grid"></i>
                <span>Tableau de bord</span>
            </a>
        </li><!-- End Dashboard Nav -->

            <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav11" data-bs-toggle="collapse" href="#">
                 <i class="ri-bill-line"></i></i><span>Inventaire</span
                    class="bi bi-chevron-down ms-auto"></i>      
            </a>
            <ul id="forms-nav11" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="liste_inventaire.php">
                        <span>Liste des Inventaires</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-fill"></i><span>Fournisseur</span
                    class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="liste_fournisseur.php">
                        <span>Liste des fournisseurs</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-box"></i><span>Produits</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="liste_produit.php">
                        <span>Liste produits</span>
                    </a>
                </li>
                <li>
                    <a href="mouvement.php">
                        <span>Mouvement</span>
                    </a>
                </li>
                <li>
                    <a href="utilisat_pert.php">
                        <span>Utilisations/pertes</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Charts Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-currency-exchange"></i><span>Achats</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="commande_fournisseur.php">
                        <span>Commande</span>
                    </a>
                </li>
                <li>
                    <a href="liste_reception.php">
                        <span>Liste des receptions</span>
                    </a>
                </li>
                <li>
                    <a href="liste_paiement_four.php">
                        <span>Liste des paiements</span>
                    </a>
                </li>
            </ul>
        </li>
   


        <li class="nav-item">
           <a class="nav-link" href="vente.php">
                <i class="bi bi-cash-stack"></i>
                <span>Vente en Espèce</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#vente-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-credit-card-2-back"></i><span>Vente en Crédit</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="vente-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="commande_client.php">
                        <span>Ajouter Vente Crédit</span>
                    </a>
                </li>
                <li>
                    <a href="liste_livraison.php">
                        <span>Liste des Livraisons Crédits</span>
                    </a>
                </li>
                <li>
                    <a href="liste_paiement_client.php">
                        <span>Liste des Paiements Crédits</span>
                    </a>
                </li>

            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav1" data-bs-toggle="collapse" href="#">
                <i class="ri-bank-card-fill"></i><span>Caisse</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav1" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="liste_caisse.php">
                        <span>Régistre de caisse </span>
                    </a>
                </li>
                <li>
                    <a href="depense.php">

                        <span>Dépenses</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php if( $_SESSION['type_utilisateur']==='Administrateur' || $_SESSION['type_utilisateur']==='Superadmin'){?>
        <li class="nav-item">
            <a class="nav-link" href="liste_utilisateur.php">
                <i class="ri-settings-3-fill"></i><span>Configuration</span>
            </a>
        </li>
        <?php } ?>
        <!-- End Icons Nav -->

    </ul>

</aside>
<!-- End Sidebar-->
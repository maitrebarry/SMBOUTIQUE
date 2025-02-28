<?php require_once ('partials/database.php') ?>
<!--------header------->
<?php require_once ('partials/header.php') ?>
<!-------------sidebare----------->
<?php require_once ('partials/sidebar.php')?>
<!-------------navebare----------->
<?php require_once ('partials/navbar.php')?>
<style>
.footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 50px;
    /* Hauteur du pied de page */
    background-color: #f5f5f5;
    /* Ajoutez la couleur de fond souhaitée */
}

.btn-outline-primary {
    float: right;
}
.card-header span{
     font-family: 'Times New Roman', Times, serif;
      font-weight: bolder;
    
}

</style>
<!DOCTYPE html>
<html lang="en">

<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Produits</li>
                    <li class="breadcrumb-item active">Liste des produits</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-outline-primary" href="stock_produit.php"><span>+ ARTICLE</span></a>
                            <label class="form-check-label">
                                <input type="checkbox" id="ruptureCheck" onclick="filterRupture()"> Afficher uniquement les articles en rupture de stock
                            </label>
                        </div>
                        <div class="card-body">
                           <input type="text" id="searchInput" onkeyup="searchProduct()" placeholder="Rechercher un produit.." class="form-control mb-3" style="border: 2px solid #007bff;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="productTable">
                                    <thead>
                                        <tr>
                                            <th>NOM ARTICLE</th>
                                            <th >PRIX D'ACHAT</th>
                                            <th >PRIX DÉTAILLANT</th>
                                            <th>STOCK ARTICLE</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $total_achat = 0;
                                        $total_detail = 0;
                                        $total_stock = 0;
                                        foreach ($recuperer_afficher as $liste_prod): 
                                            $total_achat += $liste_prod->price * $liste_prod->stock;
                                            $total_detail += $liste_prod->prix_detail * $liste_prod->stock;
                                            $total_stock += $liste_prod->stock;
                                        ?>
                                        <tr class="<?= $liste_prod->stock <= $liste_prod->alerte_article ? 'rupture' : '' ?>">
                                            <td><?= $liste_prod->name ?></td>
                                            <td style="background-color: #007bff; color: white; border: 2px solid black;"><?= number_format($liste_prod->price, 0, ',', ' ') ?> F CFA</td>
                                            <td style="background-color: #17a2b8; color: white; border: 2px solid black;"><?= number_format($liste_prod->prix_detail, 0, ',', ' ') ?> F CFA</td>
                                            <td class="<?= $liste_prod->stock <= $liste_prod->alerte_article ? 'bg-danger' : '' ?>">
                                                <?= $liste_prod->stock ?>
                                            </td>
                                            <td>
                                                <a href="modifier_produit.php?id=<?= $liste_prod->id ?>" class="btn btn-info btn-sm">
                                                    <i class="bx bxs-edit"></i>
                                                </a>&emsp;
                                                <a class="btn btn-danger btn-sm delete-button" href="supprimer_produit.php?id=<?= $liste_prod->id ?>" data-listprod-id="<?= $liste_prod->id ?>">
                                                    <i class="ri-delete-bin-5-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background-color: #28a745; color: white; font-weight: bold;">
                                            <th style="background-color: #28a745; color: white; font-weight: bold;">Total</th>
                                            <td style="background-color: #28a745; color: white; font-weight: bold;"><?= number_format($total_achat, 0, ',', ' ') ?> F CFA</td>
                                            <td style="background-color: #28a745; color: white; font-weight: bold;"><?= number_format($total_detail, 0, ',', ' ') ?> F CFA</td>
                                            <td style="background-color: #28a745; color: white; font-weight: bold;" colspan="2"><?= number_format($total_stock, 0, ',', ' ') ?></td>
                                        </tr>
                                        <tr style="background-color: #28a745; color: white; font-weight: bold;">
                                            <th style="background-color: #28a745; color: white; font-weight: bold;">Bénéfice global</th>
                                            <td style="background-color: #28a745; color: white; font-weight: bold;" colspan="4"><?= number_format($total_detail - $total_achat, 0, ',', ' ') ?> F CFA</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <?php require_once('partials/foot.php') ?>
        <?php require_once('partials/footer.php') ?>
    </footer>
    <!-- CSS pour masquer le champ de recherche -->
    <style>
        .hidden {
            display: none;
        }
    </style>
    <!-- Script pour la boîte de dialogue de confirmation de suppression et la gestion du filtre de rupture -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    // Obtenez l'ID à partir de l'attribut "data-listprod-id" du bouton
                    var listproduitId = button.getAttribute('data-listprod-id');

                    // Boîte de dialogue de confirmation avec SweetAlert
                    Swal.fire({
                        title: "Êtes-vous sûr?",
                        text: "Une fois supprimé, vous ne pourrez pas récupérer ces données!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Oui, supprimer!",
                        cancelButtonText: "Annuler"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirige vers la page supprimer_produit.php avec l'ID de la livraison
                            window.location.href = 'supprimer_produit.php?id=' + listproduitId + '&confirm=true';
                        }
                    });
                });
            });

            // Vérifiez le paramètre dans l'URL et cochez automatiquement la case si nécessaire
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('rupture')) {
                document.getElementById('ruptureCheck').checked = true;
                filterRupture();
            }
        });

        function searchProduct() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("productTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td")[0]; // Suppose the product name is in the first column
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    }
                }
            }
        }

        function filterRupture() {
            var checkBox = document.getElementById("ruptureCheck");
            var searchInput = document.getElementById("searchInput");
            var table = document.getElementById("productTable");
            var tr = table.getElementsByTagName("tr");

            if (checkBox.checked) {
                // Masquer le champ de recherche
                searchInput.classList.add('hidden');
                // Afficher uniquement les articles en rupture de stock
                for (var i = 1; i < tr.length; i++) {
                    var stockTd = tr[i].getElementsByTagName("td")[3];
                    if (stockTd && stockTd.classList.contains('bg-danger')) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            } else {
                // Afficher tous les articles et réafficher le champ de recherche
                searchInput.classList.remove('hidden');
                for (var i = 1; i < tr.length; i++) {
                    tr[i].style.display = "";
                }
            }
        }
    </script>

</body>



</html>
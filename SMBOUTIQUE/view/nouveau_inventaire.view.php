    <!--------header------->
    <?php require_once ('partials/header.php') ?>
    <!-------------sidebare----------->
    <?php require_once ('partials/sidebar.php')?>
    <!-------------navebare----------->
    <?php require_once ('partials/navbar.php')

    ?>
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

    .btn-light {
        float: right;
    }
    </style>
    <!DOCTYPE html>
    <html lang="en">

    <body>
        <!-------------contenu----------->
        <?php $errors = []; $button_name='valider'?>
        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                        <li class="breadcrumb-item"> Inventaire </li>
                        <li class="breadcrumb-item active">Nouveau Inventaire</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            <div class="card info-card sales-card">
                <form action="" method="post">
                    <section class="section mt-5">
                        <div class="row">
                            <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Table with stripped rows -->
                                        <!-- <table class="table datatable table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>DESIGNATION</th>
                                                    <th>QTE VIRTUELLE</th>
                                                    <th>QTE PHYSIQUE</th>
                                                    <th>ECART STOCK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($recuperer_afficher as $index => $liste_prod): ?>
                                                    <tr>
                                                    <td><?= $liste_prod->name ?></td>
                                                    <td>
                                                        <input class="form-control" type="number"
                                                            name="stock_<?= $index ?>" id="stock_<?= $index ?>"
                                                            value="<?= $liste_prod->stock ?>" readOnly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="number"
                                                            name="qte_physique_<?= $index ?>"
                                                            id="qte_physique_<?= $index ?>" value=""
                                                            oninput="calculerEcart(<?= $index ?>)">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="number"
                                                            name="qte_recu_<?= $index ?>" id="qte_recu_<?= $index ?>"
                                                            value="" readOnly>
                                                    </td>
                                                </tr>

                                                <?php endforeach ?>
                                            </tbody>
                                        </table> -->
                                        <div class="mb-3">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un produit...">
                                        </div>

                                        <!-- Conteneur du tableau -->
                                        <div id="tableContainer"></div>
                                    </div>

                                        <script>// Exemple de données - Remplacez par vos données PHP
const products = <?= json_encode($recuperer_afficher) ?>;

const rowsPerPage = 1000; // Nombre de lignes par page
let currentPage = 1; // Page actuelle
let filteredProducts = [...products]; // Produits filtrés pour la recherche
let temporaryValues = {}; // Stock temporaire pour valeurs calculées

// Fonction pour afficher la table
function renderTable(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const items = filteredProducts.slice(start, end); // Produits pour cette page

    const tableHTML = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>DESIGNATION</th>
                    <th>QTE VIRTUELLE</th>
                    <th>QTE PHYSIQUE</th>
                    <th>ECART STOCK</th>
                </tr>
            </thead>
            <tbody>
                ${items.map((prod) => {
                    const cache = temporaryValues[prod.id] || {};
                    return `
                        <tr>
                            <td>${prod.name}</td>
                            <td><input class="form-control" type="number" name="stock_${prod.id}" id="stock_${prod.id}" value="${prod.stock}" readOnly></td>
                            <td>
                                <input class="form-control" type="number" name="qte_physique_${prod.id}" id="qte_physique_${prod.id}" 
                                    value="${cache.qte_physique || ''}" 
                                    oninput="calculerEcart(${prod.id})">
                            </td>
                            <td>
                                <input class="form-control" type="number" name="qte_recu_${prod.id}" id="qte_recu_${prod.id}" 
                                    value="${cache.ecart || ''}" readOnly>
                            </td>
                        </tr>
                    `;
                }).join('')}
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-between">
            <button class="btn btn-secondary" onclick="changePage(${page - 1})" ${page === 1 ? 'disabled' : ''}>
                Précédent
            </button>
            <span>Page ${page} de ${Math.ceil(filteredProducts.length / rowsPerPage)}</span>
            <button class="btn btn-secondary" onclick="changePage(${page + 1})" ${end >= filteredProducts.length ? 'disabled' : ''}>
                Suivant
            </button>
        </div>
    `;

    // Insérer le tableau dans le conteneur
    document.getElementById('tableContainer').innerHTML = tableHTML;
}
document.getElementById('searchInput').addEventListener('input', function () {
    const query = this.value.toLowerCase(); // Récupère la valeur saisie en minuscules
    filteredProducts = products.filter(prod => prod.name.toLowerCase().includes(query)); // Filtre les produits

    // Réinitialise la pagination et recharge la table avec les résultats filtrés
    currentPage = 1;
    renderTable(currentPage);
});

// Fonction pour calculer l'écart entre quantite physique et virtuelle
function calculerEcart(prodId) {
    const qtePhysique = parseInt(document.getElementById(`qte_physique_${prodId}`).value) || 0;
    const qteVirtuelle = parseInt(document.getElementById(`stock_${prodId}`).value) || 0;

    const ecart = qtePhysique - qteVirtuelle;
    document.getElementById(`qte_recu_${prodId}`).value = ecart;

    // Stocker la valeur temporairement
    temporaryValues[prodId] = {
        qte_physique: qtePhysique,
        ecart: ecart
    };
}

// Fonction pour changer de page
function changePage(page) {
    if (page < 1 || page > Math.ceil(filteredProducts.length / rowsPerPage)) return;
    currentPage = page;
    renderTable(page);
}

// Initialiser la table
renderTable(currentPage);
</script>

                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card text-left">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <?php 
                                                // pour la reference
                                                    $nbr_comde="SELECT * FROM inventaire";
                                                    $nbr_comdes=$bdd->query($nbr_comde);
                                                    $resultat=$nbr_comdes->rowCount();
                                            ?>
                                            <label>Référence Inventaire* </label>
                                            <input type="text" name="ref" class="form-control" id=""
                                                value="R-IV-N°0<?= $resultat + 1 ?>" readOnly>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Boutique* </label>
                                            <input type="text" name="boutique" class="form-control" id=""
                                                value="<?= $liste_prod->$index ?>" readOnly>
                                        </div> -->
                                        <div class="form-group mt-3">
                                            <label>Date* </label>
                                            <input type="datetime-local" name="dat" class="form-control"
                                                id="currentDateTime">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-md-10 col-xs-12 mt-3">

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                                        data-bs-target="#basicModal">Valider </button>
                                    <?php require_once('partials/confirmerEnregistrement.php');?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                                <div class="form-group">
                                    <a href="liste_inventaire.php" class="btn btn-info form-control "> Liste des
                                        Inventaires</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </main><!-- End #main -->
        <!-- Footer -->
        <footer class="footer">
            <?php require_once('partials/foot.php') ?>
            <?php require_once('partials/footer.php') ?>
        </footer>
        <script>
        // Obtenez la date et l'heure actuelles
        var currentDate = new Date();
        // Formatage de la date et l'heure en chaîne compatible avec datetime-local
        var formattedDateTime = currentDate.toISOString().slice(0, 16);
        // Définition de la valeur de l'élément datetime-local
        document.getElementById('currentDateTime').value = formattedDateTime;
        </script>
        <script>
        // function calculerEcart(index) {
        //     var stockVirtuel = parseFloat(document.getElementById('stock_' + index).value);
        //     var stockPhysique = parseFloat(document.getElementById('qte_physique_' + index).value);
        //     var ecart = Math.abs(stockPhysique - stockVirtuel);
        //     document.getElementById('qte_recu_' + index).value = ecart;
        // }
        //Temporaire
        let temporaryValues = {}; // Objet pour stocker les valeurs modifiées

    // Fonction pour calculer l'écart et mettre à jour le cache temporaire
    function calculerEcart(absoluteIndex) {
        const qtePhysiqueInput = document.getElementById(`qte_physique_${absoluteIndex}`);
        const stockVirtuelInput = document.querySelector(`input[name="stock_${absoluteIndex}"]`);
        const ecartInput = document.getElementById(`qte_recu_${absoluteIndex}`);

        if (qtePhysiqueInput && stockVirtuelInput && ecartInput) {
            const stockVirtuel = parseFloat(stockVirtuelInput.value) || 0;
            const qtePhysique = parseFloat(qtePhysiqueInput.value) || 0;
            const ecart = qtePhysique - stockVirtuel;

            ecartInput.value = ecart;

            // Stocker les valeurs modifiées dans le cache temporaire
            temporaryValues[absoluteIndex] = {
                qte_physique: qtePhysique,
                ecart: ecart,
            };
        }
    }

    // Fonction pour envoyer les données modifiées à la base de données
    function enregistrerModifications() {
        fetch('nouveau_inventaire.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(modifications)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Modifications enregistrées avec succès !');
            } else {
                alert('Erreur lors de l\'enregistrement des modifications.');
            }
        })
    }



        
        </script>

    </body>

    </html>
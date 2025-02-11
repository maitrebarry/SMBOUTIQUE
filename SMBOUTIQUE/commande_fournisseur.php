<?php
    require_once('rentrer_anormal.php') ;
    require_once ('partials/database.php');
// Vérifiez si l'utilisateur est connecté et 'id_utilisateur' est défini
if (!isset($_SESSION['id_utilisateur'])) {
    // Gérez le cas où 'id_utilisateur' n'est pas défini 
         header('Location:index.php');
}else{
   
      $utilisateur= $_SESSION['id_utilisateur'];
}
unset($_SESSION['shopping_cart']);
?>
<?php require_once ('function/function.php') ;
    $produits=recuperation_fonction('*','tbl_product',[],"ALL");
    $fournissuer=recuperation_fonction('*','fournisseur',[],"ALL");
     // pour la reference
      $nbr_comde="SELECT * FROM commande_fournisseur";
      $nbr_comdes=$bdd->query($nbr_comde);
      $resultat=$nbr_comdes->rowCount();
        // Récupérer les données du panier
        $dataPanier = [];  // Initialiser $dataPanier comme un tableau vide
        $ids = [];
        if (!empty($_SESSION['shopping_cart'])) {
            $ids = array_keys($_SESSION['shopping_cart']);

            if (!empty($ids)) {
                $sql = "SELECT * FROM tbl_product WHERE id IN (" . implode(',', $ids) . ")";
                $data = $bdd->prepare($sql);
                $data->execute();
                $dataPanier = $data->fetchAll(PDO::FETCH_OBJ);
            }
        }

        /// Calculer la somme totale
        $ValeurDuTotal = 0;

        foreach ($dataPanier as $panier) {
            $ValeurDuTotal += $_SESSION["shopping_cart"][$panier->id] * $panier->price;
        }

        // récupération pour la sélection des produits et pour le panier 
        if (isset($_POST['passe'])) {
            // Vérifier si les champs nécessaires ne sont pas vides
            if (!empty($_POST['ref']) && !empty($_POST['dat']) && !empty($_POST['four']) && isset($_POST['total']) && !empty($_POST['id_article'])) {
                // Extraire les valeurs des champs POST dans des variables distinctes
                extract($_POST);
                $reference = $_POST['ref'];
                $date = $_POST['dat'];
                $four = $_POST['four'];
                $total = isset($_POST['total']) ? $_POST['total'] : null;

                // Vérifier que la valeur de "total" n'est pas nulle
                if ($total !== null) {
                    // Convertir la valeur en entier
                    $total = intval($total);
                    // Préparer la requête d'insertion pour la commande fournisseur
                    $insertCommande = 'INSERT INTO commande_fournisseur(id_fournisseur, date_de_commande, reference, total, id_utilisateur) VALUES(?,?,?,?,?)';
                    // Exécuter la fonction d'insertion
                    $lastid = Insertion_and_update($insertCommande, [$four, $date, $reference, $total, $utilisateur], true);
                    // Parcourir les articles de la commande et les insérer dans la table ligne_commande
                    for ($i = 0; $i < count($_POST['id_article']); $i++) {
                        $articles = $_POST['id_article'][$i];
                        $quantite = $_POST['quantite'][$i];
                        $prix_saisi = $_POST['prix'][$i]; // Prix saisi par l'utilisateur

                        // Récupérer le prix existant depuis tbl_product
                        $sql = "SELECT price FROM tbl_product WHERE id = ?";
                        $stmt = $bdd->prepare($sql);
                        $stmt->execute([$articles]);
                        $prix_existant = $stmt->fetchColumn();

                        // Déterminer si le prix a été modifié
                        $new_price_cmndFour = ($prix_saisi != $prix_existant && !empty($prix_saisi)) ? $prix_saisi : null;

                        // Préparer la requête d'insertion pour les détails de la commande
                        $insertDetails = 'INSERT INTO ligne_commande(id, id_commande_fournisseur, quantite, new_price_cmndFour, qte_livre) VALUES(?,?,?,?,?)';

                        // Exécuter la fonction d'insertion
                        Insertion_and_update($insertDetails, [$articles, $lastid, $quantite, $new_price_cmndFour, 0]); // Ajout de qte_livre initialisé à 0
                    }

                    // Supprimer le panier après avoir traité la commande
                    if (isset($_SESSION["shopping_cart"])) {
                        unset($_SESSION["shopping_cart"]);
                    }

                    // Afficher un message de succès
                    afficher_message('Commande faite avec succès', 'success');
                    header('Location: commande_fournisseur.php');
                    exit; 
                } else {
                    // Gérer le cas où la valeur de "total" est nulle
                    afficher_message('Erreur: Total non défini ou nul');
                }
            } else {
                // Gérer le cas où certains champs sont vides
                afficher_message('Certains champs sont vides');
            }
        }
?>





<?php require_once ('partials/header.php') ?>

<!--------header------->


<body>
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
    </style>
    <?php $errors = []; $button_name='passe'?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                    <li class="breadcrumb-item">Commande fournisseur</li>
                    <li class="breadcrumb-item active">exécution de la commande</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="card info-card sales-card">
            <div class="container-fluid">
                <?php require_once('partials/afficher_message.php') ?>
                <div class="content">
                    <div class="container col">
                        <div class="form-group">
                            <div class="card info-card sales-card ">
                                <select class="form-select produit  p-4" name="produit" id="produit">
                                    <option value="#">Veuillez sélectionner un produit</option>
                                    <?php foreach ($produits as $value) : ?>
                                        <option value="<?= $value->id ?>">
                                        <?= $value->name ?>&emsp;| Stock: <?= $value->stock ?>
                                        </option>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>                    
                        <form action="" method="post">
                            <section class="section mt-5">
                                <div class="row">
                                    <div class="col-xl-8 col-md-10 col-xs-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Produits</th>
                                                            <th>Quantité</th>
                                                            <th>Prix</th>
                                                            <th>Montant</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ajout_tbody">
                                                    </tbody>


                                                     </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="card text-left">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Référence </label>
                                                    <input type="text" name="ref" class="form-control" id=""
                                                        value="CCF<?= date(date('dmY')) ?>0<?= $resultat + 1 ?>"
                                                        readOnly>
                                                </div>

                                                <div class="form-group mt-3">
                                                    <label>Date </label>
                                                    <input type="datetime-local" name="dat" class="form-control"
                                                        id="currentDateTime" required>
                                                </div>                                              
                                                <div class="form-group mt-3">
                                                    <label for="">Fournisseur</label>
                                                    <select name="four" id="" class="form-control">
                                                        <option value="">Sélectionner le fournisseur</option>
                                                        <?php foreach ($fournissuer as $value_for) : ?>
                                                        <option value="<?= $value_for->id_fournisseur ?>">
                                                            <?= $value_for->nom_fournisseur ?>
                                                            <?= $value_for->prenom_fournisseur ?>
                                                        </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary form-control"
                                                data-bs-toggle="modal" data-bs-target="#basicModal">Passer la commande
                                            </button>
                                            <?php require_once('partials/confirmerEnregistrement.php');?>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                                        <div class="form-group">
                                            <a href="liste_commande_four.php" class="btn btn-info form-control">Liste
                                                des commandes</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="footer">
        <?php require_once('partials/foot.php') ?>
        <?php require_once('partials/footer.php') ?>
    </footer>
    <script>
        var currentDate = new Date();
        var formattedDateTime = currentDate.toISOString().slice(0, 16);
        document.getElementById('currentDateTime').value = formattedDateTime;
    </script>
    <script>
    function validateNumber(input) {
        input.value = input.value.replace(/\D/g, ''); // Remplacer tout caractère non numérique
    }

    function updateMontant(input) {
        const row = input.closest('tr');
        const quantite = row.querySelector('input[name="quantite[]"]').value;
        const prix = row.querySelector('input[name="prix[]"]').value;
        const montant = row.querySelector('input[name="montant[]"]');
        montant.value = (quantite * prix).toFixed(2); // Mettre à jour le montant avec le nouveau prix
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('input[name="montant[]"]').forEach((input) => {
            total += parseFloat(input.value);
        });
        document.getElementById('total').value = total.toFixed(2);
    }

    function load_panier_data(html) {
        console.log('Mise à jour du panier avec la réponse HTML :', html);
        $('#ajout_tbody').html(html);
    }

    $('#produit').change(function() {
        var produit_id = $(this).val();
        // Effectuer une requête Ajax pour ajouter le produit au panier
        $.ajax({
            url: 'ajax_four.php',
            method: 'post',
            data: {
                mon_id: produit_id
            },
            dataType: 'html', // Changé de 'json' à 'html' car la réponse est du HTML
            success: function(data) {
                load_panier_data(data); // Appel de la fonction load_panier_data avec la réponse HTML
            },
            error: function(xhr, status, error) {
                console.error('Erreur Ajax :', status, error);
            }
        });
    });

    // Lorsqu'un champ de quantité ou de prix est modifié
    $(document).on('change', '.quantite, .prix', function () {
        var produit_id = $(this).closest('tr').find('input[name="id_article[]"]').val();
        var quantite = $(this).closest('tr').find('input[name="quantite[]"]').val();
        var prix = $(this).closest('tr').find('input[name="prix[]"]').val();

        // Effectuer une requête Ajax pour mettre à jour la quantité et le prix dans la session
        $.ajax({
            url: 'ajax_four.php',
            method: 'POST',
            data: {
                mon_id: produit_id,
                quantite: quantite,
                prix: prix
            },
            success: function(response) {
                // Mettre à jour le contenu du panier avec la nouvelle quantité et le prix
                $('#ajout_tbody').html(response); 
            },
            error: function(xhr, status, error) {
                console.error('Erreur Ajax :', status, error);
            }
        });
    });

    $(document).ready(function() {
        // Fonction pour recalculer le total
        function recalculerTotal() {
            var total = 0;
            $('.montant').each(function() {
                total += parseFloat($(this).val());
            });
            $('#total').val(total.toFixed(2));
        }

        $(document).on('keyup', '.quantite, .prix', function() {
            // récupération de la quantité et du prix saisis par l'utilisateur
            var quantite = $(this).closest('tr').find('input[name="quantite[]"]').val();
            var prix = $(this).closest('tr').find('input[name="prix[]"]').val();
            
            // Vérifiez si la quantité et le prix sont des nombres avant de faire le calcul
            if (!isNaN(quantite) && !isNaN(prix)) {
                var montant = quantite * prix;
                $(this).closest('tr').find('.montant').val(montant);
                recalculerTotal(); // Appel de la fonction pour recalculer le total
            }
        });
    });

    // Suppression dans le panier
    $(document).on('click', '.btn-supprimer', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        console.log("ID du produit à supprimer :", productId); // Ajout pour le débogage
        var currentButton = $(this);
        $.ajax({
            url: 'ajax_four.php?action=delete&id=' + productId,
            method: 'get',
            dataType: 'html',
            success: function(response) {
                // Suppression réussie côté serveur, on peut alors supprimer la ligne côté client
                currentButton.closest('tr').remove(); // Supprimer la ligne de tableau associée
                recalculerTotal(); // Mettre à jour le total après la suppression de la ligne
                console.log(response); // Afficher la réponse du serveur (pour le débogage)
                
                // Recharger les produits disponibles dans le champ select
                chargerProduits(); // Appeler la fonction pour charger les produits
            },
            error: function(xhr, status, error) {
                console.error('Erreur Ajax :', status, error);
            }
        });
    });

    // Fonction pour charger à nouveau les produits disponibles dans le champ select
    function chargerProduits() {
        $.ajax({
            url: 'charger_produits.php',
            method: 'get',
            dataType: 'html',
            success: function(response) {
                // Mettre à jour le contenu du champ select avec les produits chargés
                $('#produit').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Erreur de chargement des produits :', status, error);
            }
        });
    }
    </script>
    <script>
    $(document).ready(function() {
        // Écouter les changements dans le champ de saisie du code-barres
        $("#searchCodeInput").on("keydown", function(event) {
            // Vérifier si la touche appuyée est la touche "Entrée" (code 13)
            if (event.keyCode === 13) {
                // Obtenir la valeur saisie dans le champ de code-barres
                var searchCode = $(this).val().trim().toLowerCase();

                // Parcourir chaque option dans la liste déroulante
                $("#produit option").each(function() {
                    // Récupérer le code-barres associé à l'option 
                    var productCode = $(this).data("code").toLowerCase();

                    // Vérifier si le code-barres contient la recherche
                    if (productCode.includes(searchCode)) {
                        // Sélectionner l'option correspondante dans la liste déroulante
                        $(this).prop("selected", true);

                        // Mettre le produit dans le panier 
                        var selectedProductId = $(this).val();
                        var selectedProductName = $(this).text();

                        // Exemple : ajouter le produit au panier 
                        addToCart(selectedProductId, selectedProductName);

                        return false; // Sortir de la boucle une fois la correspondance trouvée
                    }
                });
            }
        });

        // Fonction pour ajouter le produit au panier 
        function addToCart(productId, productName) {
            // Ajoute du produit au panier 
            console.log("Produit ajouté au panier : " + productName + " (ID : " + productId + ")");
        }
    });
    </script>
<!-- pour le champ select -->
    <script>
    $(document).ready(function() {
        $('#produit').select2();
        $('#produit').on('select2:select', function (e) {
            var data = e.params.data;
            $("#produit option[value='" + data.id + "']").remove();
        });
    });
    </script>
    <script>
        $(document).ready(function() {
            $('#produit').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
     <script type="text/javascript">
        // Fonction pour effectuer une recherche de produit par code-barres
        function searchProductByBarcode() {
            var barcode = $('#searchCodeInput').val().trim();
            if (barcode !== "") {
                $.ajax({
                    url: 'ajax_four.php',
                    method: 'post',
                    data: {
                        mon_id: barcode
                    },
                    dataType: 'html',
                    success: function(data) {
                        // Mise à jour du panier avec la réponse HTML
                        load_panier_data(data);
                        // Réinitialiser la valeur du champ de code-barres après la recherche
                        $('#searchCodeInput').val('');
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur Ajax :', status, error);
                    }
                });
            }
        }
    </script>
    </body>
</html>
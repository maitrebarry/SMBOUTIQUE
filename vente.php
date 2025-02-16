<?php
    require_once('partials/database.php');
    // Vérifiez si l'utilisateur est connecté et 'id_utilisateur' est défini
    if (!isset($_SESSION['id_utilisateur'])) {
        // Gérez le cas où 'id_utilisateur' n'est pas défini 
            header('Location:index.php');
    }else{
    
        $utilisateur= $_SESSION['id_utilisateur'];
    }
    unset($_SESSION['shopping_cart']);
    require_once('function/function.php');
     $montant_total=null;
   // Récupérer la liste des produits
    $produits = recuperation_fonction('*', 'tbl_product', [], "ALL");
   

    $dataPanier = [];
    $ids = [];

    // Vérifier si la session shopping_cart n'est pas vide
    if (!empty($_SESSION['shopping_cart'])) {
        $ids = array_keys($_SESSION['shopping_cart']);

        // Vérifier si la liste des IDs n'est pas vide
        if (!empty($ids)) {
            // Récupérer les détails des produits dans la session shopping_cart
            $sql = "SELECT * FROM tbl_product WHERE id IN (" . implode(',', $ids) . ")";
            $data = $bdd->prepare($sql);
            $data->execute();
            $dataPanier = $data->fetchAll(PDO::FETCH_OBJ);
        }
    }

    $ValeurDuTotal = 0;

    // Calculer la valeur totale des produits dans le panier
    foreach ($dataPanier as $panier) {
        $ValeurDuTotal += $_SESSION["shopping_cart"][$panier->id] * $panier->prix_detail;
    }

//    // Traiter le formulaire de vente s'il est soumis
// if (isset($_POST['passe'])) {
//     // Vérifier si les champs requis sont fournis
//     if (!empty($_POST['dat']) && !empty($_POST['refe']) && isset($_POST['total']) && !empty($_POST['id_article']) 
//           && !empty($_POST['netpayer']) && !empty($_POST['montantrecu'])){
//         extract($_POST);
//         // var_dump($_POST);exit;
//         $reference_caisse = $_POST['refe'];
//         $date = $_POST['dat'];
//         $remise = !empty($_POST['remise']) ? $_POST['remise'] : 0;
//         $netpayer=$_POST['netpayer'];
//         $montantrecu=$_POST['montantrecu'];
//         $monnaierembourser=$_POST['monnaierembourser'];
//         $nom_client = !empty($_POST['nom_client']) ? $_POST['nom_client'] : 'clients divers';
//         $total = isset($_POST['total']) ? $_POST['total'] : null;
//         // Vérifier si le total est défini
//         if($total !== null) {
//             $montant_total.= intval($total);
//             // Préparer la requête d'insertion pour la vente
//             $insert_vente = 'INSERT INTO vente(date_vente, nom_client, montant_total, reference_caisse,id_utilisateur,remise,net_a_payer,montant_recu,monnaie_rembourse) VALUES(?,?,?,?,?,?,?,?,?)';
//             $lastid = Insertion_and_update($insert_vente, [$date, $nom_client, $total, $reference_caisse,$utilisateur,$remise,$netpayer,$montantrecu,$monnaierembourser], true);
//             // Obtenir l'ID de la dernière vente insérée
//             $id_vente = $bdd->lastInsertId();

//             // Récupérer la somme actuelle dans la caisse
//             $caisse_query = "SELECT Montant_total_caisse FROM caisse WHERE reference_caisse = :reference_caisse AND statut = 'on'";
//             $caisse_statement = $bdd->prepare($caisse_query);
//             $caisse_statement->bindParam(':reference_caisse', $reference_caisse, PDO::PARAM_STR);
//             $caisse_statement->execute();
//             $caisse_result = $caisse_statement->fetch(PDO::FETCH_ASSOC);
//             $montant_caisse_actuel = $caisse_result['Montant_total_caisse'];
            
//             // Ajouter le montant total de la vente à la somme actuelle dans la caisse
//             $nouveau_montant_caisse = $montant_caisse_actuel + $total;
//             // Mettre à jour la somme dans la caisse
//             $updateCaisseCommandeQuery = "UPDATE caisse SET Montant_total_caisse = :nouveau_montant_caisse WHERE reference_caisse = :reference_caisse AND statut = 'on'";
//             $updateCaisseCommandeStatement = $bdd->prepare($updateCaisseCommandeQuery);
//             $updateCaisseCommandeStatement->bindParam(':nouveau_montant_caisse', $nouveau_montant_caisse, PDO::PARAM_INT);
//             $updateCaisseCommandeStatement->bindParam(':reference_caisse', $reference_caisse, PDO::PARAM_STR);
//             $updateCaisseCommandeStatement->execute();
            
//             // Parcourir les articles de la commande, mettre à jour le prix et les insérer dans la table ligne_vente
//             for ($i = 0; $i < count($_POST['id_article']); $i++) {
//                 $articles = $_POST['id_article'][$i];
//                 $quantite = $_POST['quantite'][$i];
//                 $prix = $_POST['prix'][$i];
//                 $montant = $quantite * $prix;
//                 $stockt = isset($_POST['stock'][$i]) ? $_POST['stock'][$i] : 0;

//                 // Mettre à jour le prix dans la table tbl_product
//                 $update_price_query = 'UPDATE tbl_product SET prix_detail = ? WHERE id = ?';
//                 $update_price_stmt = $bdd->prepare($update_price_query);
//                 $update_price_stmt->execute([$prix, $articles]);

//                 // Préparer la requête d'insertion pour les détails de la commande
//                 $insertDetails = 'INSERT INTO ligne_vente(id_produit, id_vente, quantite ) VALUES(?,?,?)';

//                 // Exécuter la fonction d'insertion
//                 Insertion_and_update($insertDetails, [$articles, $lastid, $quantite]);
//                 $lastid_ligne = $bdd->lastInsertId();
           
//                 // Insérer l'id_ligne_reception dans la table "mouvement"
//                 $insert_mouvement = $bdd->prepare('INSERT INTO mouvement(id_ligne_vente,id_ligne_livraison,id_ligne_reception,id_produit,quantite, type_mvnt, montant,date_mov) VALUES(?,?,?,?,?,?,?,NOW())');
//                 $insert_mouvement->execute(array($lastid_ligne, null, null, $articles, $quantite, 'vente_direct', $montant));
//                 // Mise à jour du stock après avoir traité tous les articles de la commande
//                 $stock_suffisant = true;
//             }
//             for ($i = 0; $i < count($_POST['id_article']); $i++) {
//                 $articles = $_POST['id_article'][$i];
//                 $quantite = $_POST['quantite'][$i];

//                 // Récupérer le stock actuel du produit
//                 $sqlStock = "SELECT stock FROM tbl_product WHERE id=?";
//                 $stockStmt = $bdd->prepare($sqlStock);
//                 $stockStmt->execute([$articles]);
//                 $actuelStock = $stockStmt->fetchColumn();

//                 if ($actuelStock >= $quantite) {
//                     // Calculer le nouveau stock
//                     $new_stock = $actuelStock - $quantite;

//                     // Mettre à jour le stock
//                     $update_prod_stock = $bdd->prepare("UPDATE tbl_product SET stock=? WHERE id=?");
//                     $update_prod_stock->execute([$new_stock, $articles]);
//                 } else {
//                     $stock_suffisant = false;
//                     break; // Sortir de la boucle si le stock est insuffisant pour au moins un article
//                 }
//             }

//             // Afficher le message de succès ou d'erreur en fonction du stock
//             if ($stock_suffisant) {           
//                 afficher_message('Vente faite avec succès', 'success');
//                 header('Location: vente.php');
//                 exit;
//             } else {
//                 // Afficher le message d'erreur une seule fois après la boucle
//                 afficher_message('Stock insuffisant pour au moins un article', 'danger');
//             }
//         } else {
//             afficher_message('Erreur: Total non défini ou nul', 'danger');
//         }
//     } else {
//         afficher_message('certains champs sont vides', 'danger');
//     }
// }

if (isset($_POST['passe'])) {
    // Vérifier si les champs requis sont fournis
    if (!empty($_POST['dat']) && !empty($_POST['refe']) && isset($_POST['total']) && !empty($_POST['id_article']) 
          && !empty($_POST['netpayer']) && !empty($_POST['montantrecu'])){
        extract($_POST);
        $reference_caisse = $_POST['refe'];
        $date = $_POST['dat'];
        $remise = !empty($_POST['remise']) ? $_POST['remise'] : 0;
        $netpayer=$_POST['netpayer'];
        $montantrecu=$_POST['montantrecu'];
        $monnaierembourser=$_POST['monnaierembourser'];
        $nom_client = !empty($_POST['nom_client']) ? $_POST['nom_client'] : 'clients divers';
        $total = isset($_POST['total']) ? $_POST['total'] : null;

        if($total !== null) {
            $montant_total.= intval($total);
            $insert_vente = 'INSERT INTO vente(date_vente, nom_client, montant_total, reference_caisse,id_utilisateur,remise,net_a_payer,montant_recu,monnaie_rembourse) VALUES(?,?,?,?,?,?,?,?,?)';
            $lastid = Insertion_and_update($insert_vente, [$date, $nom_client, $total, $reference_caisse,$utilisateur,$remise,$netpayer,$montantrecu,$monnaierembourser], true);
            $id_vente = $bdd->lastInsertId();

            $caisse_query = "SELECT Montant_total_caisse FROM caisse WHERE reference_caisse = :reference_caisse AND statut = 'on'";
            $caisse_statement = $bdd->prepare($caisse_query);
            $caisse_statement->bindParam(':reference_caisse', $reference_caisse, PDO::PARAM_STR);
            $caisse_statement->execute();
            $caisse_result = $caisse_statement->fetch(PDO::FETCH_ASSOC);
            $montant_caisse_actuel = $caisse_result['Montant_total_caisse'];

            $nouveau_montant_caisse = $montant_caisse_actuel + $total;
            $updateCaisseCommandeQuery = "UPDATE caisse SET Montant_total_caisse = :nouveau_montant_caisse WHERE reference_caisse = :reference_caisse AND statut = 'on'";
            $updateCaisseCommandeStatement = $bdd->prepare($updateCaisseCommandeQuery);
            $updateCaisseCommandeStatement->bindParam(':nouveau_montant_caisse', $nouveau_montant_caisse, PDO::PARAM_INT);
            $updateCaisseCommandeStatement->bindParam(':reference_caisse', $reference_caisse, PDO::PARAM_STR);
            $updateCaisseCommandeStatement->execute();

            for ($i = 0; $i < count($_POST['id_article']); $i++) {
                $articles = $_POST['id_article'][$i];
                $quantite = $_POST['quantite'][$i];
                $prix = $_POST['prix'][$i];
                $montant = $quantite * $prix;
                $stockt = isset($_POST['stock'][$i]) ? $_POST['stock'][$i] : 0;

                // Insérer le nouveau prix dans la colonne new_price_vente de la table ligne_vente
                $insertDetails = 'INSERT INTO ligne_vente(id_produit, id_vente, quantite, new_price_vente) VALUES(?,?,?,?)';
                Insertion_and_update($insertDetails, [$articles, $lastid, $quantite, $prix]);
                $lastid_ligne = $bdd->lastInsertId();

                $insert_mouvement = $bdd->prepare('INSERT INTO mouvement(id_ligne_vente,id_ligne_livraison,id_ligne_reception,id_produit,quantite, type_mvnt, montant,date_mov) VALUES(?,?,?,?,?,?,?,NOW())');
                $insert_mouvement->execute(array($lastid_ligne, null, null, $articles, $quantite, 'vente_direct', $montant));
                $stock_suffisant = true;
            }
            for ($i = 0; $i < count($_POST['id_article']); $i++) {
                $articles = $_POST['id_article'][$i];
                $quantite = $_POST['quantite'][$i];

                $sqlStock = "SELECT stock FROM tbl_product WHERE id=?";
                $stockStmt = $bdd->prepare($sqlStock);
                $stockStmt->execute([$articles]);
                $actuelStock = $stockStmt->fetchColumn();

                if ($actuelStock >= $quantite) {
                    $new_stock = $actuelStock - $quantite;
                    $update_prod_stock = $bdd->prepare("UPDATE tbl_product SET stock=? WHERE id=?");
                    $update_prod_stock->execute([$new_stock, $articles]);
                } else {
                    $stock_suffisant = false;
                    break;
                }
            }

            if ($stock_suffisant) {           
                afficher_message('Vente faite avec succès', 'success');
                header('Location: vente.php');
                exit;
            } else {
                afficher_message('Stock insuffisant pour au moins un article', 'danger');
            }
        } else {
            afficher_message('Erreur: Total non défini ou nul', 'danger');
        }
    } else {
        afficher_message('certains champs sont vides', 'danger');
    }
}


    ?>

    <?php require_once('partials/header.php') ?>
    <!--------header------->
    <body>
        <?php require_once('partials/sidebar.php') ?>
        <?php require_once('partials/navbar.php') ?>
        <style>
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                height: 50px;
                background-color: #f5f5f5;
            }
        </style>
        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                        <li class="breadcrumb-item">Vente</li>
                        <li class="breadcrumb-item active">Espace de vente</li>
                    </ol>
                </nav>
            </div>

            <div class="card info-card sales-card ">
                <div class="container-fluid">
                    <?php require_once('partials/afficher_message.php') ?>
                    <div class="content">
                        <div class="container col">
                            <div class="form-group">
                                <div class="card info-card sales-card ">
                                    <select class="form-control produit form-select p-4" name="produit" id="produit">
                                        <option value="">Veuillez sélectionner un produit</option>
                                        <?php foreach ($produits as $value) : ?>
                                            <option value="<?= $value->id ?>">
                                            <?= $value->name ?>&emsp;| Stock: <?= $value->stock ?>
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
                                                <div class="card-body ">
                                                    <table class="table table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th>Produit</th>
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
                                                <div class="card-body ">
                                                    <div class="form-group">
                                                        <div class="form-group mt-3">
                                                            <label>Référence <span class="text-danger">*</span></label>
                                                            <?php
                                                            // Récupérer la référence de la caisse associée
                                                                $reference_caisse = recuperation_fonction('reference_caisse', "caisse WHERE statut = 'on'", [], "ONE");
                                                            ?>
                                                            <input type="text" name="refe" id="refe" class="form-control" value="<?php echo $reference_caisse->reference_caisse; ?>" readonly>
                                                        </div>

                                                        <div class="form-group mt-3">
                                                            <label>Date <span class="text-danger">*</span></label>
                                                            <input type="datetime-local" name="dat" class="form-control" id="currentDateTime" required>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="">Client</label>
                                                            <input type="text" name="nom_client" class="form-control" id="nom_client">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-md-10 col-xs-12">
                                                <div class="form-group mt-3">
                                                    <label for="">Montant total</label>
                                                    <input type="number" name="montant_total" class="form-control montant_total" id="montant_total"
                                                    value="<?=$montant_total ?>"readOnly>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-10 col-xs-12">
                                                <div class="form-group mt-3">
                                                    <label for="">Rémise</label>
                                                    <input type="number" value="" name="remise" class="form-control remise" id="remise">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-10 col-xs-12">
                                                <div class="form-group mt-3">
                                                    <label for="">Net à payer</label>
                                                    <input type="number" name="netpayer" class="form-control netpayer" id="netpayer"readOnly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-md-10 col-xs-12">
                                                <label for="">Montant reçu</label>
                                                <input type="number" name="montantrecu" class="form-control montantrecu" id="montantrecu">
                                            </div>
                                            <div class="col-xl-6 col-md-10 col-xs-12">
                                                <label for="">Monnaie à rembourser</label>
                                                <input type="number" name="monnaierembourser" class="form-control monnaierembourser text-danger" id="monnaierembourser"readOnly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                                            <div class="form-group">
                                                <button  type="submit" name="passe" class="btn btn-primary form-control submit-modal confirm-button" 
                                                    data-bs-toggle="modal" data-bs-target="#basicModal">Valider
                                                </button> 
                                                    <?php require_once('partials/confirmerEnregistrement.php');?>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                                            <div class="form-group">
                                                <a href="liste_vente.php" class="btn btn-info form-control ">Liste des ventes réalisées</a>
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
            // Fonction pour mettre à jour le panier avec les données HTML fournies
        function load_panier_data(html) {
            console.log('Mise à jour du panier avec la réponse HTML :', html);
            $('#ajout_tbody').html(html);
            $('#montant_total').val($('.totalcal').val());
            $('#remise').val('0');
            mettre_a_jour_net_payer();
        }

        // Fonction pour mettre à jour le net à payer
        function mettre_a_jour_net_payer() {
            var total = parseFloat($('#total').val()); // Utiliser la valeur de #total qui est constamment mise à jour
            var remise_client = parseFloat($('#remise').val()) || 0; // Utilise 0 si la remise est vide
            var mont_apre_remis = total - remise_client;
            $('.netpayer').val(mont_apre_remis);
        }

        // Fonction pour recalculer le total des montants
        function recalculerTotal() {
            var total = 0;
            $('.montant').each(function() {
                total += parseFloat($(this).val());
            });
            $('#total').val(total);
            $('#montant_total').val(total);
            mettre_a_jour_net_payer(); // Appeler la mise à jour du net à payer ici
        }

        // Gestionnaire d'événement pour la saisie dans l'élément #remise
        $("#remise").on('keyup', function () {
            var remise_client = parseFloat($(this).val()) || 0;
            if (remise_client < 0) {
                $('#basicModal2').modal('show');
                $('#annuler_button').on('click', function() {
                    $('#remise').val('');
                });
                return;
            }
            mettre_a_jour_net_payer();
        });

        // Gestionnaire d'événement pour la saisie dans l'élément #montantrecu
        $("#montantrecu").on('keyup', function () {
            var montantrecu = parseFloat($(this).val());
            var netapayer = parseFloat($('.netpayer').val());
            if (montantrecu < 0) {
                $('#basicModal1').modal('show');
                $('#annuler_button1').on('click', function() {
                    $('#montantrecu').val('');
                });
                return;
            }

            var montantRestant = montantrecu - netapayer;
            $('.monnaierembourser').val(montantRestant);
            $('.error-message').remove();

            if (montantRestant < 0) {
                $('.monnaierembourser').addClass('text-danger').after('<div class="error-message text-danger">Attention la monnaie ne doit pas être négative</div>');
                $('#montantrecu').after('<div class="error-message text-danger">Montant reçu insuffisant</div>');
                $('.submit-modal').hide();
            } else {
                $('#montantrecu, .monnaierembourser').removeClass('text-danger');
                $('.submit-modal').show();
            }
        });

        $("#montantrecu").on('input', function () {
            var montantrecu = parseFloat($(this).val());
            var netapayer = parseFloat($('.netpayer').val());
            var montantRestant = montantrecu - netapayer;

            $('.monnaierembourser').val(montantRestant);
            $('.error-message').remove();

            if (montantRestant < 0) {
                $('.monnaierembourser').addClass('text-danger').after('<div class="error-message text-danger">Attention la monnaie ne doit pas être négative</div>');
                $('#montantrecu').after('<div class="error-message text-danger">Montant reçu insuffisant</div>');
                $('.submit-modal').hide();
            } else {
                $('#montantrecu, .monnaierembourser').removeClass('text-danger');
                $('.submit-modal').show();
            }
        });

        // Ajout de la fonction updateMontant pour mettre à jour les montants quand le prix ou la quantité change
        function updateMontant(element) {
            var prix = parseFloat($(element).closest('tr').find('.prix').val());
            var quantite = parseInt($(element).closest('tr').find('.quantite').val());
            var montant = prix * quantite;
            $(element).closest('tr').find('.montant').val(montant);
            recalculerTotal();
        }

        $(document).on('keyup', '.prix, .quantite', function () {
            updateMontant(this);
        });

        // Gestionnaire d'événement pour le changement de sélection dans l'élément #produit
        $('#produit').change(function () {
            var produit_id = $(this).val();
            $.ajax({
                url: 'ajax_vente.php',
                method: 'post',
                data: { mon_id: produit_id },
                dataType: 'html',
                success: function (data) {
                    load_panier_data(data);
                },
                error: function (xhr, status, error) {
                    console.error('Erreur Ajax :', status, error);
                }
            });
        });

        // Lorsqu'un champ de quantité est modifié
        $(document).on('change', '.quantite', function () {
            var produit_id = $(this).closest('tr').find('input[name="id_article[]"]').val();
            var quantite = $(this).val();
            $.ajax({
                url: 'ajax_vente.php',
                method: 'POST',
                data: {
                    mon_id: produit_id,
                    quantite: quantite,
                },
                success: function(response) {
                    $('#ajout_tbody').html(response);
                    recalculerTotal();
                },
                error: function(xhr, status, error) {
                    console.error('Erreur Ajax :', status, error);
                }
            });
        });

        // Gestionnaire d'événement pour la saisie dans les éléments .quantite
        $(document).on('keyup', '.quantite', function () {
            var quantite = $(this).val(); 
            var prixEnGros = $(this).closest('tr').find('.prix').val(); 
            if (!isNaN(quantite)) {
                var montant = quantite * prixEnGros;
                $(this).closest('tr').find('.montant').val(montant);
                recalculerTotal();
            }
        });

        // Suppression dans le panier
        $(document).on('click', '.btn-supprimer', function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            var currentButton = $(this);
            $.ajax({
                url: 'ajax_four.php?action=delete&id=' + productId,
                method: 'get',
                dataType: 'html',
                success: function(response) {
                    currentButton.closest('tr').remove();
                    recalculerTotal();
                },
                error: function(xhr, status, error) {
                    console.log(error);
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
                    $('#produit').html(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        $(document).ready(function () {
            recalculerTotal();
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
    </body>
</html>
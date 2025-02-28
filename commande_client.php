
<?php 
    require_once ('partials/database.php');
// Vérifiez si l'utilisateur est connecté et 'id_utilisateur' est défini
if (!isset($_SESSION['id_utilisateur'])) {
    // Gérez le cas où 'id_utilisateur' n'est pas défini 
         header('Location:index.php');
}else{
    // echo 'Valeur de id_utilisateur avant insertion : ' . $_SESSION['id_utilisateur'];
      $utilisateur= $_SESSION['id_utilisateur'];
}
unset($_SESSION['shopping_cart']);
?>
<?php require_once ('function/function.php') ;
    $produits=recuperation_fonction('*','tbl_product',[],"ALL");
    $client_grossi=recuperation_fonction('*','client_grossiste',[],"ALL");
     // pour la reference
      $nbr_comde="SELECT * FROM commande_client";
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
        $ValeurDuTotal += $_SESSION["shopping_cart"][$panier->id] * $panier->prix_en_gros;
    }

    
    if (isset($_POST['passe'])) {
        // Vérifier si les champs nécessaires ne sont pas vides
        if (!empty($_POST['ref']) && !empty($_POST['dat']) && (!empty($_POST['client']) || (!empty($_POST['nom-client']) && !empty($_POST['prenom-client']) && !empty($_POST['contact-client']) && !empty($_POST['ville-client']))) && isset($_POST['total']) && !empty($_POST['id_article'])) {
            // Extraire les valeurs des champs POST dans des variables distinctes
            extract($_POST);
            $reference = $_POST['ref'];
            $date = $_POST['dat'];
            $total = isset($_POST['total']) ? $_POST['total'] : null;

            // Vérifier si un nouveau client doit être ajouté
            if (!empty($_POST['nom-client']) && !empty($_POST['prenom-client']) && !empty($_POST['contact-client']) && !empty($_POST['ville-client'])) {
                $nom = $_POST['nom-client'];
                $prenom = $_POST['prenom-client'];
                $contact = $_POST['contact-client'];
                $ville = $_POST['ville-client'];

                // Contrainte : Nom, Prénom et Ville doivent contenir uniquement des lettres et des espaces
                if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nom)) {
                    afficher_message('Le nom ne doit contenir que des lettres.', 'danger');
                    return;
                }

                if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $prenom)) {
                    afficher_message('Le prénom ne doit contenir que des lettres.', 'danger');
                    return;
                }

                if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $ville)) {
                    afficher_message('La ville ou le quartier ne doit contenir que des lettres.', 'danger');
                    return;
                }

                // Contrainte : Contact doit être un numéro de téléphone valide (par exemple, 10 chiffres)
                if (!preg_match("/^\d{8}$/", $contact)) {
                    afficher_message('Le contact doit être un numéro de téléphone valide de 8 chiffres.', 'danger');
                    return;
                }

                // Préparer la requête d'insertion pour le nouveau client
                $insertClient = 'INSERT INTO client_grossiste(nom_client_grossiste, prenom_du_client_grossiste, ville_client_grossiste, contact_client_grossiste) VALUES(?,?,?,?)';
                // Exécuter la fonction d'insertion
                $lastClientId = Insertion_and_update($insertClient, [$nom, $prenom, $ville, $contact], true);
                $client = $lastClientId;
            } else {
                $client = $_POST['client'];
            }

            // Vérifier que la valeur de "total" n'est pas nulle
            if ($total !== null) {
                // Convertir la valeur en entier
                $total = intval($total);

                // Préparer la requête d'insertion pour la commande client
                $insertCommande = 'INSERT INTO commande_client(id_client_gr, date_cmd_client, reference, total, id_utilisateur) VALUES(?,?,?,?,?)';

                // Exécuter la fonction d'insertion
                $lastid = Insertion_and_update($insertCommande, [$client, $date, $reference, $total, $utilisateur], true);

                // Parcourir les articles de la commande et les insérer dans la table ligne_commande_client
                for ($i = 0; $i < count($_POST['id_article']); $i++) {
                    $articles = $_POST['id_article'][$i];
                    $quantite = $_POST['quantite'][$i];
                    $prix = $_POST['prix'][$i];
                    $prix_detail = getPrixDetail($articles); // Récupérer le prix de détail pour comparaison

                    // Déterminer la valeur à insérer dans new_price_cmndClient
                    $new_price_cmndClient = ($prix != $prix_detail) ? $prix : null;

                    // Préparer la requête d'insertion pour les détails de la commande
                    $insertDetails = 'INSERT INTO ligne_commande_client(id_produit, id_cmd_client, quantite, new_price_cmndClient) VALUES(?,?,?,?)';

                    // Exécuter la fonction d'insertion
                    Insertion_and_update($insertDetails, [$articles, $lastid, $quantite, $new_price_cmndClient]);
                }

                // Supprimer le panier après avoir traité la commande
                if (isset($_SESSION["shopping_cart"])) {
                    unset($_SESSION["shopping_cart"]);
                }

                // Afficher un message de succès
                afficher_message('Commande faite avec succès', 'success');
                header('Location: commande_client.php');
                exit;
            } else {
                // Gérer le cas où la valeur de "total" est nulle
                afficher_message('Erreur: Total non défini ou nul', 'danger');
            }
        } else {
            // Gérer le cas où certains champs sont vides
            afficher_message('Certains champs sont vides', 'danger');
        }
    }


// Fonction pour récupérer le prix de détail du produit
function getPrixDetail($articleId) {
    global $bdd;
    $sql = "SELECT prix_detail FROM tbl_product WHERE id = ?";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$articleId]);
    return $stmt->fetchColumn();
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
                height: 50px; /* Hauteur du pied de page */
                background-color: #f5f5f5; /* Ajoutez la couleur de fond souhaitée */
            }
    </style>
     <?php $errors = []; $button_name='passe'?>
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
          <li class="breadcrumb-item">Commande client</li>
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
                            <select class="form-control produit form-select p-4" name="produit" id="produit">
                                <option value="">Veuillez sélectionner un produit</option>
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
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
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
                                    </div>                                    
                                    <div class="col-xl-4">
                                                <div class="card text-left">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                    <label>Référence </label>
                                                    <input type="text" name="ref" class="form-control" id=""
                                                        value="CCC<?= date(date('dmY')) ?>0<?= $resultat + 1 ?>"
                                                        readOnly>
                                                </div>
                                               <div class="form-group mt-3">
                                                    <label>Date </label>
                                                    <input type="datetime-local" name="dat" class="form-control" id="currentDateTime" required="required">
                                                </div>
                                                    <div class="form-group mt-3">
                                                        <label for="">Client</label>
                                                        <select name="client" id="client-select" class="form-control">
                                                            <option value="">Sélectionner le client</option>
                                                            <?php foreach ($client_grossi as $value_cl) : ?>
                                                                <option value="<?= $value_cl->id_client_gr ?>">
                                                                    <?= $value_cl->nom_client_grossiste ?>
                                                                    <?= $value_cl->prenom_du_client_grossiste ?>
                                                                </option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="radio" name="new-client" id="new-client-radio">
                                                        <label class="form-check-label" for="new-client-radio">
                                                            Nouveau client
                                                        </label>
                                                    </div>
                                                    <div id="new-client-form" style="display: none;" class="mt-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="nom-client">Nom</label>
                                                                    <input type="text" class="form-control" id="nom-client" name="nom-client" placeholder="Nom du client">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="prenom-client">Prénom</label>
                                                                    <input type="text" class="form-control" id="prenom-client" name="prenom-client" placeholder="Prénom du client">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="contact-client">Contact</label>
                                                                    <input type="text" class="form-control" id="contact-client" name="contact-client" placeholder="Contact du client">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="ville-client">Ville/Quartier</label>
                                                                    <input type="text" class="form-control" id="ville-client" name="ville-client" placeholder="Ville ou quartier">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                 <div class="row">
                                    <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal" data-bs-target="#basicModal">Effectuer la vente </button>
                                            <?php require_once('partials/confirmerEnregistrement.php');?>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-10 col-xs-12 mt-3">
                                        <div class="form-group">
                                             <a href="liste_commande_client.php" class="btn btn-info form-control">Liste des ventes</a>
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
    function load_panier_data(html) {
        console.log('Mise à jour du panier avec la réponse HTML :', html);
        $('#ajout_tbody').html(html);
    }

    $('#produit').change(function(){
        var produit_id = $(this).val();
        // Effectuer une requête Ajax pour ajouter le produit au panier
        $.ajax({
            url: 'ajax_php.php',
            method: 'post',
            data: { mon_id: produit_id },
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
            url: 'ajax_php.php',
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
            $('#total').val(total);
        }

        $(document).on('keyup', '.quantite, .prix', function () {
            // récupération de la quantité et du prix saisis par l'utilisateur
            var quantite = $(this).closest('tr').find('input[name="quantite[]"]').val();
            var prix = $(this).closest('tr').find('input[name="prix[]"]').val();
            
            // Gestion des événements pour la quantité et le prix 
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
        var currentButton = $(this);
        $.ajax({
            url: 'ajax_four.php?action=delete&id=' + productId,
            method: 'get',
            dataType: 'html',
            success: function(response) {
                // Suppression réussie côté serveur, on peut alors supprimer la ligne côté client
                currentButton.closest('tr').remove(); // Supprimer la ligne de tableau associée
                recalculerTotal(); // Mettre à jour le total après la suppression de la ligne
                
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
                console.log(error); 
            }
        });
    }

    // Fonction pour recalculer le total
    function recalculerTotal() {
        var total = 0;
        $('.montant').each(function() {
            total += parseFloat($(this).val());
        });
        $('#total').val(total);
    }
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let newClientRadio = document.getElementById('new-client-radio');
        let clientSelect = document.getElementById('client-select');
        let newClientForm = document.getElementById('new-client-form');

        // Lorsque le bouton radio "Nouveau client" est sélectionné
        newClientRadio.addEventListener('change', function() {
            if (this.checked) {
                newClientForm.style.display = 'block';
                clientSelect.value = ''; // Réinitialiser la sélection de client
            }
        });

        // Lorsque l'utilisateur choisit un client existant dans le <select>
        clientSelect.addEventListener('change', function() {
            if (this.value !== "") { // Si un client est sélectionné
                newClientForm.style.display = 'none';
                newClientRadio.checked = false; // Désélectionner le bouton radio
            }
        });

        // Si l'utilisateur clique à nouveau sur le bouton radio pour le décocher
        newClientRadio.addEventListener('click', function() {
            if (!this.checked) { // Si le bouton est décoché
                newClientForm.style.display = 'none';
            }
        });
    });
</script>


 </body>
</html>

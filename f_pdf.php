<?php
ob_start(); // Démarrage de la temporisation de sortie

require('TCPDF-main/tcpdf.php');
// require('fpdf186/fpdf.php');
require('partials/database.php');

class PDF extends TCPDF
{
    private $commandeinfo;
    private $datashow;

    public function __construct($detail)
    {
        parent::__construct();

        if (isset($detail) && !empty($detail)) {
            $this->fetchData($detail);
            $this->AddPage();
            $this->Header();
            $this->htmlTable();
            $this->Footer();
        } else {
            die("L'ID de la commande n'est pas spécifié.");
        }
    }

    private function fetchData($detail)
    {
        global $bdd;
        $commande = $bdd->prepare("SELECT * FROM commande_fournisseur INNER JOIN fournisseur 
            ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur WHERE id_commande_fournisseur = :detail LIMIT 1");
        $commande->bindParam(':detail', $detail, PDO::PARAM_INT);
        $commande->execute();
        $this->commandeinfo = $commande->fetch();

        $ligne_commande = $bdd->prepare("SELECT * FROM ligne_commande INNER JOIN tbl_product
            ON tbl_product.id = ligne_commande.id WHERE ligne_commande.id_commande_fournisseur = :detail");
        $ligne_commande->bindParam(':detail', $detail, PDO::PARAM_INT);
        $ligne_commande->execute();
        $this->datashow = $ligne_commande->fetchAll(PDO::FETCH_OBJ);
    }

    public function Header()
    {
        
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'SUPERMARCHE ZARAHOU', 0, 1, 'C');
        $this->Ln(5);
        $this->SetX(25);
        $this->Cell(62, 5, 'RUE:123', 0, 0, 'C');
        // ... Ajoutez d'autres lignes d'en-tête comme dans votre exemple
        $this->Ln(5);
        $this->SetX(25);
        $this->Image('assets/img/supermarche.png', 250, 10);
        $this->SetFont('Times', '', 12);
        $this->Ln(20);
        $this->Line(10, 40, 280, 40);
    }

    public function htmlTable()
    {
        $this->SetFont('helvetica', '', 12);

        $this->Ln(10);
        $this->Cell(0, 10, 'Référence: ' . $this->commandeinfo['reference'], 0, 1);
        // ... Ajoutez d'autres cellules d'en-tête comme dans votre exemple

        $this->Ln(10);
        $this->Cell(0, 10, 'Désignation', 1, 0, 'C');
        $this->Cell(0, 10, 'Quantité', 1, 0, 'C');
        $this->Cell(0, 10, 'Prix', 1, 0, 'C');
        $this->Cell(0, 10, 'Montant', 1, 1, 'C');

        foreach ($this->datashow as $affiche) {
            $this->Cell(0, 10, $affiche->name, 1, 0, 'C');
            $this->Cell(0, 10, $affiche->quantite, 1, 0, 'C');
            $this->Cell(0, 10, $affiche->price, 1, 0, 'C');
            $this->Cell(0, 10, $affiche->quantite * $affiche->price, 1, 1, 'C');
        }

        $this->Ln(10);
        $this->Cell(0, 10, 'Total: ' . $this->commandeinfo['total'], 0, 1, 'R');
    }

    // public function Footer()
    // {
    //     $this->SetY(-15);
    //     $this->SetFont('helvetica', 'I', 8);
    //     $this->Cell(0, 10, 'Page ' . $this->getPage(), 0, 0, 'C');
    // }
    public function Footer()
{
    $this->SetY(-15);
    $this->SetFont('helvetica', 'I', 8);
    $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage(), 0, 0, 'C');
}
//pour fpdf
        //     public function Footer()
        // {
        //     $this->SetY(-15);
        //     $this->SetFont('helvetica', 'I', 8);
        //     $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        // }

}

$detail = isset($_GET['detail']) ? $_GET['detail'] : null;
$pdf = new PDF($detail);
$pdf->SetFont('helvetica', '', 12); // Réinitialisation de la police par défaut
$pdf->Output();


ob_end_flush(); // Fin de la temporisation de sortie et envoi du tampon de sortie
?>

<?php
ob_start(); // Démarrage de la temporisation de sortie

// require('TCPDF-main/tcpdf.php');
require('fpdf186/fpdf.php');
require('partials/database.php');
class PDF extends FPDF
{
    function  header(){
        $this->SetFont('Arial','B',14);
        $this->SetX(25);
        $this->Image('assets/img/supermarche.png',210,1);
        $this->Ln();
        $this->Cell(75,5,'SUPERMARCHE ZARAHOU ',0,0,'C' );
        $this->Ln(5);
        $this->SetX(25);
        $this->Cell(1,5,'RUE:123',0,0,'C' );
        $this->Ln(5);
        $this->SetX(25);
        $this->Cell(5,5,'PROTE:34',0,0,'C' );
        $this->Ln(5);
        $this->SetX(25);
        $this->Cell(39,5,'QUARTIER:PELENGANA',0,0,'C' );
        $this->Ln(5);
        // $this->SetX(25);
        // $this->Cell(62,5,'SUPERMARCHE ZARAHOU ',0,0,'C' );
        // $this->Ln(10);
        $this->SetX(25);
        $this->SetFont('Times','',12);
        $this->Ln(8);
        // $this->Line(10,40,0,40);
         global $bdd;
        if (isset($_GET['detail'])) {
            $detail=$_GET['detail'];
            $date=$bdd->query("SELECT date_de_commande FROM commande_fournisseur WHERE id_commande_fournisseur=$detail LIMIT 1");
            $date_com=$date->fetch();
            $this->Cell(62,5,'SEGOU LE: '.$date_com['date_de_commande'], 0,0,'C' );
        }
    }
    function headerTable(){
        
        $this->SetFont('Times','B',16);
        // $this->Cell(275,0,'Liste',0,0,'C' );
        // $this->Line(140,54,140,54);
        $this->Ln(20);
        $this->SetX(40);
        $this->SetFont('Times','B',10);
        $this->SetFillcolor(192,192,192);
        $this->Rect(40, $this->GetY(),210,10, 'F');
        $this->Cell(60,10,'Designation',1,0,'C');
        $this->Cell(50,10,'Quantite',1,0,'C');
        $this->Cell(50,10,'Prix ',1,0,'C');
        $this->Cell(50,10,'Montant ',1,0,'C');
       
        // $this->Cell(30,10,'Patient conserner',1,0,'C');
        // $this->Cell(30,10,'Date Nssce patient',1,0,'C');
        // $this->Cell(40,10,'Lieu Nssce patient',1,0,'C');
        // $this->Cell(10,10,'Sexe',1,0,'C');
        // $this->Cell(30,10,'Contact patient',1,0,'C');
        // $this->Cell(30,10,'Medecin conserner',1,0,'C');
        // $this->Cell(50,10,'afficheat',1,0,'C');
        $this->Ln();

    }
    function viewTable(){
        global $bdd;
        if (isset($_GET['detail'])) {
            $detail=$_GET['detail'];
            $commande=$bdd->query("SELECT * FROM commande_fournisseur INNER JOIN fournisseur 
            ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur WHERE id_commande_fournisseur=$detail LIMIT 1");
            $commandeinfo=$commande->fetch();
            //afficher la ligne de commande
            $ligen_commande=$bdd->query("SELECT * FROM ligne_commande INNER JOIN tbl_product
            ON tbl_product.id=ligne_commande.id WHERE ligne_commande.id_commande_fournisseur=$detail" );
                            
                $datashow=$ligen_commande->fetchAll(PDO::FETCH_OBJ);
                foreach( $datashow as $affiche ){
                    $this->SetX(40);
                    $this->SetFont('Times','B',9);
                    $this->Cell(60,10,$affiche->name,1,0,'C');
                    $this->Cell(50,10,$affiche->quantite,1,0,'C');
                    $this->Cell(50,10,$affiche->price,1,0,'C');
                    $this->Cell(50,10,$affiche->quantite*$affiche->price,1,0,'C');
                    // $this->Cell(30,20,$affiche->prenom_pat.' '.$affiche->nom_pat,1,0,'C');
                    // $this->Cell(30,20,$affiche->date_naisse,1,0,'C');
                    // $this->Cell(40,20,$affiche->lieu_naisse,1,0,'C');
                    // $this->Cell(10,20,$affiche->sexes,1,0,'C');
                    // $this->Cell(30,20,$affiche->contacts,1,0,'C');
                    // $this->Cell(30,20,$affiche->prenom.' '.$affiche->nom,1,0,'C');
                    // $this->Cell(50,20,$affiche->afficheat,1,0,'C');

                    $this->Ln();

                }

        }
                function  footer(){
                    $this->SetY(-15);
                    $this->SetFont('Arial','',8);
                    $this->Cell(0,10,'Page'.$this->pageNo().'/{nb}',0,0,'C');
                }


    }
}
    $pdf = new PDF();
    // Titres des colonnes

    // Chargement des données
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','',14);
    $pdf->AddPage('L','A4','0');
    $pdf->headerTable();
    $pdf->viewTable();


    $pdf->Output();
    ob_end_flush(); // Fin de la temporisation de sortie et envoi du tampon de sortie
?>

<?php

require_once('partials/database.php');



$output = '';

// Récupérer les produits existants de la commande
if (isset($_GET['modifi'])) {
    $modifi = $_GET['modifi'];
    $ligen_commande = $bdd->prepare("SELECT * FROM ligne_commande INNER JOIN tbl_product ON tbl_product.id = ligne_commande.id WHERE ligne_commande.id_commande_fournisseur = :id");
    $ligen_commande->execute([':id' => $modifi]);
    $datashow = $ligen_commande->fetchAll(PDO::FETCH_OBJ);
}

// Générer le HTML pour les produits existants
$total = 0;
if (isset($datashow)) {
    foreach ($datashow as $affiche) {
        $total += $affiche->quantite * $affiche->price;
        $output .= "<tr class='existing-product'>
            <td>{$affiche->name}</td>
            <td><input type='number' name='quantite[]' class='form-control quantite-input' data-id='{$affiche->id}' value='{$affiche->quantite}'></td>
            <td><input type='number' name='prix[]' class='form-control prix-input' data-id='{$affiche->id}' value='{$affiche->price}'></td>
            <td class='montant'>" . intval($affiche->quantite * $affiche->price) . "</td>
            <td><button type='button' class='btn btn-danger btn-sm btn-supprimer remove-ligne' data-id='{$affiche->id}'><i class='bi bi-trash'></i></button></td>
        </tr>";
    }
}

// Ajouter le HTML des nouveaux produits sans écraser les existants
if (isset($_POST['mon_id'])) {
    $produit_id = intval($_POST['mon_id']);

    if (isset($_POST['ajout']) && $_POST['ajout'] === 'true') {
        $quantite = intval($_POST['quantite']);
        if (isset($_SESSION['shopping_cart'][$produit_id])) {
            $_SESSION['shopping_cart'][$produit_id] += $quantite;
        } else {
            $_SESSION['shopping_cart'][$produit_id] = $quantite;

            $stmt = $bdd->prepare("SELECT price FROM tbl_product WHERE id = ?");
            $stmt->execute([$produit_id]);
            $_SESSION['shopping_cart_prix'][$produit_id] = $stmt->fetchColumn() ?: 0;
        }
    }

    if (isset($_POST['quantite'], $_POST['prix'])) {
        $quantite = intval($_POST['quantite']);
        $prix = floatval($_POST['prix']);

        if ($quantite > 0) {
            $_SESSION['shopping_cart'][$produit_id] = $quantite;
            $_SESSION['shopping_cart_prix'][$produit_id] = $prix;
        } else {
            unset($_SESSION['shopping_cart'][$produit_id], $_SESSION['shopping_cart_prix'][$produit_id]);
        }
    }
}

if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
    $produit_id = intval($_GET["id"]);
    unset($_SESSION['shopping_cart'][$produit_id], $_SESSION['shopping_cart_prix'][$produit_id]);
}

// Calculer le total après suppression
$total = 0;
if (isset($datashow)) {
    foreach ($datashow as $affiche) {
        $total += $affiche->quantite * $affiche->price;
    }
}

if (!empty($_SESSION['shopping_cart'])) {
    $ids = array_keys($_SESSION['shopping_cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $bdd->prepare("SELECT * FROM tbl_product WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $dataPanier = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($dataPanier as $panier) {
        $quantite = $_SESSION['shopping_cart'][$panier->id];
        $prix = $_SESSION['shopping_cart_prix'][$panier->id];
        $montant = $quantite * $prix;
        $total += $montant;
        $output .= "<tr class='new-product'><td>{$panier->name}</td><td><input type='number' name='quantite[]' class='form-control quantite-input' data-id='{$panier->id}' value='{$quantite}'></td><td><input type='number' name='prix[]' class='form-control prix-input' data-id='{$panier->id}' value='{$prix}'></td><td class='montant'>" . intval($montant) . "</td><td><button type='button' class='btn btn-danger btn-sm btn-supprimer remove-ligne' data-id='{$panier->id}'><i class='bi bi-trash'></i></button></td></tr>";
    }
}

// Ajouter la ligne de total en dehors de la boucle
// $output .= "<script>document.getElementById('total_commande').value = '{$total}';</script>";

echo $output;
?>
<?php
require_once('rentrer_anormal.php');
require_once('partials/database.php');
require_once('function/function.php');

$produits = recuperation_fonction('*', 'fournisseur', [], "ALL");
$produit = recuperation_fonction('*', 'tbl_product', [], "ALL");

if (isset($_GET['modifi'])) {
    $modifi = $_GET['modifi'];
    $commande = $bdd->prepare("SELECT * FROM commande_fournisseur INNER JOIN fournisseur 
        ON fournisseur.id_fournisseur = commande_fournisseur.id_fournisseur WHERE id_commande_fournisseur = :id LIMIT 1");
    $commande->execute([':id' => $modifi]);
    $commandeinfo = $commande->fetch();

    $ligen_commande = $bdd->prepare("SELECT * FROM ligne_commande INNER JOIN tbl_product ON tbl_product.id = ligne_commande.id WHERE ligne_commande.id_commande_fournisseur = :id");
    $ligen_commande->execute([':id' => $modifi]);
    $datashow = $ligen_commande->fetchAll(PDO::FETCH_OBJ);
}

// Traiter la soumission du formulaire de mise à jour
if (isset($_POST['modifier'])) {
    $modifi = $_POST['modifi'];
    $quantites = $_POST['quantite'];
    $prixs = $_POST['prix'];
    $produit_ids = $_POST['produit_id'];

    // Mettre à jour chaque produit de la commande
    foreach ($produit_ids as $index => $produit_id) {
        $quantite = intval($quantites[$index]);
        $prix = floatval($prixs[$index]);

        // Récupérer le prix existant depuis tbl_product
        $stmt = $bdd->prepare("SELECT price FROM tbl_product WHERE id = ?");
        $stmt->execute([$produit_id]);
        $prix_existant = $stmt->fetchColumn();

        // Déterminer si le prix a été modifié
        $new_price_cmndFour = ($prix != $prix_existant && !empty($prix)) ? $prix : null;

        // Mettre à jour la base de données
        $stmt = $bdd->prepare("UPDATE ligne_commande SET quantite = :quantite, new_price_cmndFour = :new_price_cmndFour WHERE id_commande_fournisseur = :id_commande AND id = :id_produit");
        $stmt->execute([
            ':quantite' => $quantite,
            ':new_price_cmndFour' => $new_price_cmndFour,
            ':id_commande' => $modifi,
            ':id_produit' => $produit_id,
        ]);
    }

    // Gérer l'ajout de nouveaux produits
    if (isset($_POST['nouveau_produit']) && !empty($_POST['nouveau_produit']) && $_POST['nouveau_produit'] !== '#') {
        $nouveau_produit_id = intval($_POST['nouveau_produit']);
        $nouvelle_quantite = intval($_POST['nouvelle_quantite']);
        $stmt = $bdd->prepare("SELECT price FROM tbl_product WHERE id = ?");
        $stmt->execute([$nouveau_produit_id]);
        $prix = $stmt->fetchColumn();

        $stmt = $bdd->prepare("INSERT INTO ligne_commande (id_commande_fournisseur, id, quantite, new_price_cmndFour) VALUES (:id_commande, :id_produit, :quantite, :new_price_cmndFour)");
        $stmt->execute([
            ':id_commande' => $modifi,
            ':id_produit' => $nouveau_produit_id,
            ':quantite' => $nouvelle_quantite,
            ':new_price_cmndFour' => $prix,
        ]);
    }

    // Rediriger après la mise à jour
    header('Location: modifier_commande_four.php?modifi=' . $modifi);
    exit;
}
?>

<!--------header------->
<?php require_once('partials/header.php') ?>
<body>
<!-------------sidebare----------->
<?php require_once('partials/sidebar.php') ?>
<!-------------navebare----------->
<?php require_once('partials/navbar.php') ?>
<!-------------contenu----------->
<main id="main" class="main">
    <div class="card info-card sales-card">
        <div class="container-fluid">
            <div class="content">
               
                <div class="container col">
                    <div class="form-group">
                        <div class="card info-card sales-card">
                            <select class="form-select produit p-2" name="nouveau_produit" id="nouveau_produit">
                                <option value="#">Veuillez sélectionner un produit</option>
                                <?php foreach ($produit as $value) : ?>
                                    <option value="<?= $value->id ?>">
                                        <?= $value->name ?>&emsp;| Stock: <?= $value->stock ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <input type="hidden" id="nouvelle_quantite" value="1">
                        </div>
                    </div>
                    <form action="" method="post">
                        <section class="section mt-1">
                            <div class="row">
                                <div class="col-xl-8 col-md-10 col-xm-12 col-xs-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="col-md-12 table table-bordered table-striped table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>DESIGNATION</th>
                                                        <th>QUANTITE</th>
                                                        <th>PRIX D'ACHAT</th>
                                                        <th>Montant</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="ajout_tbody">
                                                    <!-- Les lignes de produits seront chargées via AJAX -->
                                                </tbody>
                                                <tr>
                                                    <td colspan="3" align="right"> Total </td>
                                                    <td align="right">
                                                        <input class="form-control total" id="total_commande" type="number" name="total" value="0" readonly>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card text-left">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Référence </label>
                                                <input type="text" name="ref" class="form-control" value="<?= $commandeinfo['reference'] ?>" readOnly>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label>Date</label>
                                                <input type="datetime-local" name="date_de_commande" class="form-control" id="date_input">
                                            </div>
                                            <div class="form-group mt-3">
                                                <label>Fournisseur</label>
                                                <select class="form-control produit form-select" name="id_fournisseur">
                                                    <?php foreach ($produits as $fournisseur) : ?>
                                                        <option value="<?= $fournisseur->id_fournisseur ?>" <?= ($fournisseur->id_fournisseur == $commandeinfo['id_fournisseur']) ? 'selected' : '' ?>>
                                                            <?= $fournisseur->nom_fournisseur . ' ' . $fournisseur->prenom_fournisseur ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group mt-5">
                                                <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                                            </div>
                                        </div>
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
        // Obtenez la date et l'heure actuelles
        var date_input = new Date();
        // Formatage de la date et l'heure en chaîne compatible avec datetime-local
        var formattedDateTime = date_input.toISOString().slice(0, 16);
        // Définition de la valeur de l'élément datetime-local
        document.getElementById('date_input').value = formattedDateTime;
    </script>
    <script>
        // Récupérer l'élément input
        var input = document.getElementById('date_input');

        // Obtenir la date et l'heure actuelles
        var dateActuelle = new Date();
        var dateActuelleISO = dateActuelle.toISOString().slice(0, 16); // Format ISO sans les secondes et les millisecondes

        // Définir la valeur minimale pour l'input en utilisant la date actuelle
        input.min = dateActuelleISO;

        // Fonction de validation de la date
        function validateDate() {
            var selectedDate = new Date(input.value);
            if (selectedDate < dateActuelle) {
                // alert("Veuillez sélectionner une date et une heure actuelle ou future.");
                input.value = dateActuelleISO; // Réinitialiser à la date actuelle si une date passée est sélectionnée
            }
        }

        // Ajouter un écouteur d'événements pour la validation lorsqu'une nouvelle date est sélectionnée
        input.addEventListener('change', validateDate);
    </script>
    <script>
        $(document).ready(function () {
        function updateMontantLigne(row) {
            var quantite = parseFloat(row.find('.quantite-input').val()) || 0;
            var prix = parseFloat(row.find('.prix-input').val()) || 0;
            var montant = quantite * prix;
            row.find('.montant').text(montant.toFixed(0));
            return montant;
        }

        function updateMontantTotal() {
            var total = 0;
            $('#ajout_tbody tr').each(function () {
                total += updateMontantLigne($(this));
            });
            $('#total_commande').val(total.toFixed(0));
        }

        // Charger les produits existants via AJAX
        $.ajax({
            url: 'ajax_modifier_cmnd_four.php',
            method: 'GET',
            data: { modifi: '<?php echo $modifi; ?>' },
            dataType: 'html',
            success: function (data) {
                $('#ajout_tbody').html(data);
                updateMontantTotal();
            },
            error: function (xhr, status, error) {
                console.error('Erreur Ajax :', status, error);
            }
        });

        // Ajout d'un nouveau produit
        $('#nouveau_produit').change(function () {
            var produit_id = $(this).val();
            var quantite = $('#nouvelle_quantite').val();

            if (produit_id !== '#' && quantite > 0) {
                $.ajax({
                    url: 'ajax_modifier_cmnd_four.php',
                    method: 'POST',
                    data: { mon_id: produit_id, quantite: quantite, ajout: true, modifi: '<?php echo $modifi; ?>' },
                    dataType: 'html',
                    success: function (data) {
                        $('#ajout_tbody').append(data);
                        $('#nouvelle_quantite').val(1);
                        updateMontantTotal();
                    },
                    error: function (xhr, status, error) {
                        console.error('Erreur Ajax :', status, error);
                    }
                });
            } else {
                alert('Veuillez sélectionner un produit et une quantité valide.');
            }
        });

        // Suppression d'une ligne
        $(document).on('click', '.remove-ligne', function () {
            var produit_id = $(this).data('id');
            var row = $(this).closest('tr');

            $.ajax({
                url: 'ajax_modifier_cmnd_four.php',
                method: 'GET',
                data: { action: 'delete', id: produit_id, modifi: '<?php echo $modifi; ?>' },
                dataType: 'html',
                success: function () {
                    row.remove();
                    updateMontantTotal();
                },
                error: function (xhr, status, error) {
                    console.error('Erreur Ajax :', status, error);
                }
            });
        });

        // Mise à jour quantité/prix localement + Ajax
        $(document).on('input', '.quantite-input, .prix-input', function () {
            var row = $(this).closest('tr');
            updateMontantLigne(row);
            updateMontantTotal();
        });

        $(document).on('change', '.quantite-input, .prix-input', function () {
            var row = $(this).closest('tr');
            var produit_id = row.find('.quantite-input').data('id');
            var nouvelle_quantite = row.find('.quantite-input').val();
            var nouveau_prix = row.find('.prix-input').val();

            if (nouvelle_quantite > 0 && nouveau_prix > 0) {
                $.ajax({
                    url: 'ajax_modifier_cmnd_four.php',
                    method: 'POST',
                    data: {
                        mon_id: produit_id,
                        quantite: nouvelle_quantite,
                        prix: nouveau_prix,
                        maj_quantite: true,
                        modifi: '<?php echo $modifi; ?>'
                    },
                    dataType: 'html',
                    success: function () {
                        // Rien à faire ici, la mise à jour est déjà locale
                    },
                    error: function (xhr, status, error) {
                        console.error('Erreur Ajax :', status, error);
                    }
                });
            } else {
                alert('Quantité et prix doivent être supérieurs à 0');
            }
        });

        // Initialiser la date
        document.getElementById('date_input').value = new Date().toISOString().slice(0, 16);
    });

    </script>
<!-- pour le champ select -->
    <script>
    $(document).ready(function() {
        $('#nouveau_produit').select2();
        $('#nouveau_produit').on('select2:select', function (e) {
            var data = e.params.data;
            $("#nouveau_produit option[value='" + data.id + "']").remove();
        });
    });
    </script>
    <script>
        $(document).ready(function() {
            $('#nouveau_produit').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
</body>
</html>

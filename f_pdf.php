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
<?php
ob_start(); // Démarrage de la temporisation de sortie
require('fpdf186/fpdf.php');
require('partials/database.php');

class PDF extends FPDF
{
    function header()
    {// Sauvegarde de la couleur actuelle
        // Sauvegarde de la couleur actuelle
        $currentColor = array(0, 0, 0); // Noir par défaut

        // Affichage de la première image avec une largeur de 38 et une hauteur de 0 
        $this->Image('assets/img/nido1.png', -3, -3, 38, 0);

        // Affichage de la deuxième image avec une largeur de 30 et une hauteur de 0 
        $this->Image('assets/img/nutrilac.png', 118, -1, 30, 0);

        // Décalage vers le haut de la page
        $this->SetY(0);

        // Affichage du texte "S M BOUTIQUE" 
        $this->SetTextColor(139, 69, 19); // Couleur maron
        $this->SetFont('Arial', 'B', 30);
        $textWidth1 = $this->GetStringWidth('SMBOUTIQUE  ' );

        // Déterminez la position Y du rectangle et ajustez-la en conséquence
        $rectangleY = $this->GetY() + 4; 

        // Dessinez le rectangle avec la nouvelle position Y
        $this->Rect(($this->w - 8 - $textWidth1) / 2, $rectangleY, $textWidth1 + 8, 10, 'D');

        // Déterminez la position Y du texte et ajustez-la en conséquence
        $textY = $rectangleY + 2; 

        // Affichez le texte à l'intérieur du rectangle avec la nouvelle position Y
        $this->SetXY(($this->w - $textWidth1) / 4, $textY);
        $this->Cell(0, 8, 'SMBOUTIQUE ', 0, 1, 'C');

        $this->SetTextColor(0, 0, 0); // Couleur noire
        $this->SetFont('Arial', 'B', 15); 
        $this->Cell(0, 10, 'COMMERCANT', 0, 1, 'C');

        $this->SetTextColor(139, 69, 19); // Couleur maron
        $this->SetFont('Arial', 'B', 10); 
        $this->Cell(0, 0, 'Sebougou ', 0, 1, 'C');

        $this->SetTextColor(0, 0, 0); // Couleur noire
        $this->SetFont('Helvetica', 'B', 10); 
        $this->Cell(0, 10, 'Tel:78760717', 0, 1, 'C');

        // Affichage du texte "lieu" en bas de "Cell"
        $this->Cell(0, 0, 'lieu:Segou', 0, 1, 'C');

        // Rétablissement de la couleur précédente
        $this->SetTextColor($currentColor[0], $currentColor[1], $currentColor[2]);
        global $bdd;
        if (isset($_GET['detail'])) {
            $detail = $_GET['detail'];
            $vente = $bdd->query("SELECT * FROM vente WHERE id_vente = $detail");
            $lignes = $vente->fetch();
            $formatted_date = date('d/m/Y \a H:i', strtotime($lignes['date_vente']));
            // Encadrement pour FACTURE DE COMMANDE N
            $this->SetY(15);
            $this->SetX(0);
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 15, '', 0, 1, 'C');
            $this->Ln(15);
            $textWidth = $this->GetStringWidth('FACTURE DE VENTE ');
            $this->Rect(($this->w-10 - $textWidth) / 2, $this->GetY(), $textWidth+10, 10, 'D');
            $this->Cell(0, 10, 'FACTURE DE  VENTE  ', 0, 1, 'C');
            $this->SetX(0);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, 'CLIENT: ' . $lignes['nom_client'] . '   SEGOU le: ' . $formatted_date, 0, 1, 'C');
        }
    }
    function headerTable() {       
        $this->SetFont('Times','B',16);
        $this->Ln(5);
        $this->SetX(10);
        $this->SetFont('Times','B',10);
        $this->SetFillColor(192,192,192);
        $this->Rect(10, $this->GetY(), 127, 10, 'F'); // Ajuster la largeur du rectangle
        $this->Cell(45, 10, 'DESIGNATION', 1, 0, 'C'); // Ajuster la largeur de la cellule
        $this->Cell(20, 10, 'QUANTITE', 1, 0, 'C'); // Ajuster la largeur de la cellule
        $this->Cell(22, 10, 'PRIX', 1, 0, 'C'); // Ajuster la largeur de la cellule
        $this->Cell(40, 10, 'MONTANT', 1, 0, 'C'); // Ajuster la largeur de la cellule
        $this->Ln();
    }

    function viewTable() {
        global $bdd;
        if (isset($_GET['detail'])) {
            $detail = $_GET['detail'];
            $ligne_vente = $bdd->query("SELECT * FROM ligne_vente INNER JOIN tbl_product ON tbl_product.id = ligne_vente.id_produit WHERE ligne_vente.id_vente = $detail");
            $venteinfo = $ligne_vente->fetchAll(PDO::FETCH_OBJ);
            $vente = $bdd->query("SELECT * FROM vente INNER JOIN utilisateur ON utilisateur.id_utilisateur = vente.id_utilisateur WHERE id_vente = $detail");
            $lignes = $vente->fetch();
            $total = $lignes['montant_total'];

         foreach ($venteinfo as $affiche) {
            $this->SetX(10); // Définir la position X pour la première cellule
            $this->SetFont('Times', 'B', 9);
            
            // Aligner le texte à gauche pour le nom du produit
            $this->Cell(45, 9, $affiche->name, 1, 0, 'L'); 
            
            // Aligner le texte au centre pour la quantité
            $this->Cell(20, 9, $affiche->quantite, 1, 0, 'C'); 
            
            // Utiliser new_price_vente s'il existe, sinon prix_detail
            $prix = $affiche->new_price_vente ?? $affiche->prix_detail;
            
            // Afficher le prix de l'article
            $this->Cell(22, 9, number_format($prix, 0, ',', ' ') . ' FCFA', 1, 0, 'C'); 
            
            // Calculer et afficher le montant
            $montant = $affiche->quantite * $prix;
            $this->Cell(40, 9, number_format($montant, 0, ',', ' ') . ' FCFA', 1, 0, 'C'); 
            
            // Passer à la ligne suivante
            $this->Ln(); 
        }

            $this->SetX(10);
            $this->SetFont('Times', 'B', 9);
            $this->Cell(87, 10, 'TOTAL', 1, 0, 'C');
            $this->Cell(40, 10, number_format($total, 0, ',', ' ') . ' FCFA', 1, 0, 'C');
            $this->Ln();
            $this->Ln();            
        }
    }
   function secondTable() {
        global $bdd;
        if (isset($_GET['detail'])) {
            $detail = $_GET['detail'];
            $vente = $bdd->query("SELECT * FROM vente INNER JOIN utilisateur ON utilisateur.id_utilisateur = vente.id_utilisateur WHERE id_vente = $detail");
            $lignes = $vente->fetch();
            $this->Ln(0); // Ajout d'un espacement avant le deuxième tableau           
            // Position X du deuxième tableau
            $x = 10;

            // Lignes du deuxième tableau avec les informations supplémentaires
            $this->SetX($x);
            $this->SetFont('Arial', '', 10);
            $this->Cell(63, 10, 'REMISE', 1, 0, 'L');
            $this->Cell(63, 10, number_format($lignes['remise'], 0, ',', ' ') . ' FCFA', 1, 0, 'L');
            $this->Ln();
            $this->SetX($x);
            $this->Cell(63, 10, 'Net A PAYER', 1, 0, 'L');
            $this->Cell(63, 10, number_format($lignes['net_a_payer'], 0, ',', ' ') . ' FCFA', 1, 0, 'L');
            
            $this->Ln();
            $this->SetX($x);
            $this->Cell(63, 10, 'MONTANT RECU', 1, 0, 'L');
            $this->Cell(63, 10, number_format($lignes['montant_recu'], 0, ',', ' ') . ' FCFA', 1, 0, 'L');
            $this->Ln();
            $this->SetX($x);
            $this->Cell(63, 10, 'MONNAIE A REMBOURSER', 1, 0, 'L');
            $this->Cell(63, 10, number_format($lignes['monnaie_rembourse'], 0, ',', ' ') . ' FCFA', 1, 0, 'L');
            $this->Ln(15);
            $this->SetX(220);    
            $this->SetFont('Times', 'B', 9);
            $this->Cell(0, 5, 'ETABLIT PAR: ' . trim($lignes['nom_utilisateur']) . ' ' . trim($lignes['prenom_utilisateur']), 0, 0, 'L');
        }
    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',14);
$pdf->AddPage('P','A5','0'); // Modification du format de page en A5
$pdf->headerTable();
$pdf->viewTable();
$pdf->secondTable(); // Ajout du deuxième tableau
$pdf->Output();
ob_end_flush();
?>

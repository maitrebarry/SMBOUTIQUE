<?php
ob_start(); // Démarrage de la temporisation de sortie
require('fpdf186/fpdf.php');
require('partials/database.php');

class PDF extends FPDF
{
    function header()
    {
         // Sauvegarde de la couleur actuelle
         $currentColor = array(0, 0, 0); // Noir par défaut

         // Affichage de la première image avec une largeur de 38 et une hauteur de 0 
         $this->Image('assets/img/nido1.png', -3, -3, 38, 0);
 
         // Affichage de la deuxième image avec une largeur de 30 et une hauteur de 0 
         $this->Image('assets/img/nutrilac.png', 118, -1, 30, 0);
 
         // Décalage vers le haut de la page
         $this->SetY(0);
 
         // Affichage du texte "S M MARKET" 
         $this->SetTextColor(139, 69, 19); // Couleur maron
         $this->SetFont('Arial', 'B', 30);
         $textWidth1 = $this->GetStringWidth('S M MARKET  ' );
 
         // Déterminez la position Y du rectangle et ajustez-la en conséquence
         $rectangleY = $this->GetY() + 4; 
 
         // Dessinez le rectangle avec la nouvelle position Y
         $this->Rect(($this->w - 8 - $textWidth1) / 2, $rectangleY, $textWidth1 + 8, 10, 'D');
 
         // Déterminez la position Y du texte et ajustez-la en conséquence
         $textY = $rectangleY + 2; 
 
         // Affichez le texte à l'intérieur du rectangle avec la nouvelle position Y
         $this->SetXY(($this->w - $textWidth1) / 4, $textY);
         $this->Cell(0, 8, 'S M MARKET ', 0, 1, 'C');
 
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
            $date = $bdd->query("SELECT * FROM reception INNER JOIN commande_fournisseur 
            ON commande_fournisseur.id_commande_fournisseur=reception.id_commande_fournisseur
            INNER JOIN fournisseur ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur 
            INNER JOIN utilisateur  ON utilisateur.id_utilisateur=commande_fournisseur.id_utilisateur
            WHERE id_reception=$detail LIMIT 1");
            $info_com = $date->fetch();
            $formatted_date = date('d/m/Y \a H:i', strtotime($info_com['date_de_commande']));
            
            $this->SetY(15);
            $this->SetX(10);
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 15, '', 0, 1, 'C');
              $this->Ln(15);
            $textWidth = $this->GetStringWidth('BON DE RECEPTION N : ' . strtoupper($info_com['recept_ref']));
            $this->Rect(($this->w-10 - $textWidth) / 2, $this->GetY(), $textWidth+10, 10, 'D');
            $this->Cell(0, 10, 'BON DE RECEPTION N : ' . strtoupper($info_com['recept_ref']), 0, 1, 'C');
            
            $this->SetX(0);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, 'FOURNISSEUR: ' . $info_com['nom_fournisseur'] . ' ' . $info_com['prenom_fournisseur'] . '   RECU le: ' . $formatted_date, 0, 1, 'C');
        }
    }

    function headerTable()
    {
        $this->SetFont('Times', 'B', 16);
        $this->Ln(5);
        $this->SetX(10);
        $this->SetFont('Times', 'B', 10);
        $this->SetFillcolor(192, 192, 192);
        $this->Rect(10, $this->GetY(), 130, 10, 'F');
        $this->Cell(40, 10, 'DESIGNATION', 1, 0, 'C');
        $this->Cell(35, 10, 'QTE COMMANDE', 1, 0, 'C');
        $this->Cell(25, 10, 'QTE RECUE ', 1, 0, 'C');
        $this->Cell(30, 10, 'QTE RESTANTE ', 1, 0, 'C');
        $this->Ln();
    }

    function viewTable()
    {
        global $bdd;
        if (isset($_GET['detail'])) {
            $detail=$_GET['detail'];
            $reception=$bdd->query("SELECT * FROM reception INNER JOIN commande_fournisseur 
            ON commande_fournisseur.id_commande_fournisseur=reception.id_commande_fournisseur
            INNER JOIN fournisseur ON fournisseur.id_fournisseur=commande_fournisseur.id_fournisseur 
            WHERE id_reception=$detail LIMIT 1");
            $receptioninfo=$reception->fetch();  
            $id_commande=$receptioninfo['id_commande_fournisseur'];
            
            $ligen_recept=$bdd->query("SELECT * FROM ligne_reception INNER JOIN tbl_product
            ON tbl_product.id=ligne_reception.id_produit WHERE ligne_reception.id_reception=$detail");
            $ligen_commande=$bdd->query("SELECT * FROM ligne_commande INNER JOIN tbl_product
            ON tbl_product.id=ligne_commande.id WHERE ligne_commande.id_commande_fournisseur=$id_commande");
            $datashow=$ligen_recept->fetchAll(PDO::FETCH_OBJ);
            $dat=$ligen_commande->fetchAll(PDO::FETCH_OBJ);
            foreach( $datashow as $affich ):           
            foreach( $dat as $affiche ):
                if($affich->id_produit==$affiche->id){
                    $this->SetX(10);
                    $this->SetFont('Times', 'B', 9);
                    $this->Cell(40, 10, $affich->name, 1, 0, 'C');
                    $this->Cell(35, 10, $affiche->quantite, 1, 0, 'C');
                    $this->Cell(25, 10, $affich->quantite_recu, 1, 0, 'C');
                    $this->Cell(30, 10, $affiche->quantite-$affich->quantite_recu, 1, 0, 'C');
                    $this->Ln(); 
                } 
            endforeach ;
            endforeach ;    
            $this->Ln();
            $this->SetX(85);    
            $this->SetFont('Times', 'B', 9);
            $formatted_date = date('d/m/Y \a H:i', strtotime($receptioninfo['date_reception']));
            $this->Cell(0, 10, '   RECU le: ' . $formatted_date, 0, 1, 'C');
        }
    }

    function  footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 14);
$pdf->AddPage('P', 'A5', '0');
$pdf->headerTable();
$pdf->viewTable();
$pdf->Output();
ob_end_flush();
?>


<?php
ob_start(); // Démarrage de la temporisation de sortie

// require('TCPDF-main/tcpdf.php');
require('fpdf186/fpdf.php');
require('partials/database.php');
class PDF extends FPDF
{
    // Fonction d'en-tête du PDF
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
        // Formater la date en utilisant la fonction date()
        if (isset($_GET['detail'])) {
            $detail = $_GET['detail'];
            $paiement = $bdd->query("SELECT * FROM paiement_client INNER JOIN commande_client
            ON commande_client.id_cmd_client=paiement_client.id_comnd_client
            INNER JOIN client_grossiste ON client_grossiste.id_client_gr=commande_client.id_client_gr 
            INNER JOIN utilisateur  ON utilisateur.id_utilisateur=commande_client.id_utilisateur
            WHERE id_paie_client=$detail LIMIT 1");
            $dpaie = $paiement->fetch();
            $formatted_date = date('d/m/Y \a H:i', strtotime($dpaie['date_paie']));
            // Encadrement pour FACTURE DE COMMANDE N
            $this->SetY(15); // Ajustez la position Y selon votre mise en page
            $this->SetX(0); // Réinitialisez la position X
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 15, '', 0, 1, 'C'); // Ligne vide pour créer de l'espace au-dessus du texte
            $this->Ln(15);
            $textWidth = $this->GetStringWidth('BON DE PAIEMENT N : ' . strtoupper($dpaie['paie_reference']));
            $this->Rect(($this->w - 10 - $textWidth) / 2, $this->GetY(), $textWidth + 10, 10, 'D'); // Encadrement centré autour du texte
            $this->Cell(0, 10, 'BON DE PAIEMENT N : ' . strtoupper($dpaie['paie_reference']), 0, 1, 'C'); // Centrer le texte
            // TABLEAU : COMMANDE FOURNISSEUR
            $this->Ln(3); // Ajout d'un espace
            $this->SetX(30);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(40, 5, 'COMMANDE N :', 0, 0, 'L');
            $this->SetFont('Arial', '', 10); // Remettre la police normale
            $this->Cell(0, 5, $dpaie['reference'], 0, 1, 'L');
            $this->Ln(2);
            // Mettre en gras le texte "ETABLIT LE:"
            $this->SetX(30);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(35, 5, 'ETABLIT LE:', 0, 0, 'L');
            $this->SetFont('Arial', '', 10); // Remettre la police normale
            $this->Cell(0, 5, $formatted_date, 0, 1, 'L');
            $this->Ln(2);
            // Mettre en gras le texte "PAR:"
            $this->Ln(2);
            $this->SetX(30);
            $this->SetFont('Arial', 'B', 0);
            $this->Cell(35, 1, 'PAR:', 0, 0, 'L');
            $this->SetFont('Arial', '', 10); // Remettre la police normale
            $this->Cell(0, 1, trim($dpaie['nom_utilisateur']) . ' ' . trim($dpaie['prenom_utilisateur']), 0, 0, 'L');
        }
    }

    // Fonction pour l'en-tête du tableau
    function headerTable()
    {
        $this->SetFont('Times', 'B', 16);
        // Lignes de titre du tableau
        $this->Ln(5);
        $this->SetX(10);
        $this->SetFont('Times', 'B', 10);
        $this->SetFillcolor(192, 192, 192);
        $this->Rect(10, $this->GetY(), 130, 10, 'F');
        $this->Cell(50, 10, 'MONTANT TOTAL/CMD', 1, 0, 'C');
        $this->Cell(40, 10, 'MONTANT PAYE', 1, 0, 'C');
        $this->Cell(40, 10, 'MONTANT RESTANT ', 1, 0, 'C');
        $this->Ln();
    }

    // Fonction pour afficher le contenu du tableau
    function viewTable()
    {
        global $bdd;
        if (isset($_GET['detail'])) {
            $detail = $_GET['detail'];
          $detail = $_GET['detail'];
            $paiement = $bdd->query("SELECT * FROM paiement_client INNER JOIN commande_client
            ON commande_client.id_cmd_client=paiement_client.id_comnd_client
            INNER JOIN client_grossiste ON client_grossiste.id_client_gr=commande_client.id_client_gr 
            INNER JOIN utilisateur  ON utilisateur.id_utilisateur=commande_client.id_utilisateur
            WHERE id_paie_client=$detail LIMIT 1");
            $dpaie = $paiement->fetch();
            $this->SetX(10);
            $this->SetFont('Times', 'B', 9);
            $this->Cell(50, 10, number_format($dpaie['total'], 2, ',', '') . ' FCFA', 1, 0, 'C');
            $this->Cell(40, 10, number_format($dpaie['montant_paye'], 2, ',', '') . ' FCFA', 1, 0, 'C');
            $this->Cell(40, 10, number_format($dpaie['total'] - $dpaie['paie'], 2, ',', '') . ' FCFA', 1, 0, 'C');

            $this->Ln();
            // Sortie du tableau
            $this->Ln();
            // Déplacez le pointeur vers la droite 
            $this->SetX(65);
            // Affichez le fournisseur en dehors du tableau
            $this->SetFont('Times', 'B', 9);
            $formatted_date = date('d/m/Y \a H:i', strtotime($dpaie['date_paie']));
            $this->Cell(0, 10, 'CLIENT: ' . $dpaie['nom_client_grossiste'] . ' ' . $dpaie['prenom_du_client_grossiste'] . '   PAYE le: ' . $formatted_date, 0, 1, 'C');
        }
    }

    // Fonction pour le pied de page
    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, 'Page' . $this->pageNo() . '/{nb}', 0, 0, 'C');
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
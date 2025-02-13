
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
            $livraison=$bdd->query("SELECT * FROM livraison INNER JOIN commande_client 
            ON commande_client.id_cmd_client=livraison.id_commande_client
            INNER JOIN utilisateur  ON utilisateur.id_utilisateur=commande_client.id_utilisateur
            WHERE id_livraison=$detail LIMIT 1");
            $livraisoninfo=$livraison->fetch();
            $formatted_date = date('d/m/Y \a H:i', strtotime($livraisoninfo['date_cmd_client']));
            // Encadrement pour FACTURE DE COMMANDE N
                $this->SetY(15); // Ajustez la position Y selon votre mise en page
                $this->SetX(10); // Réinitialisez la position X
                $this->SetFont('Arial', 'B', 14);
                $this->Cell(0, 15, '', 0, 1, 'C'); 
                $this->Ln(15);
                $textWidth = $this->GetStringWidth('LIVRAISON N : ' . strtoupper($livraisoninfo['livraison_refer']));
                $this->Rect(($this->w-10 - $textWidth) / 2, $this->GetY(), $textWidth+10, 10, 'D'); // Encadrement centré autour du texte
                $this->Cell(0, 10, 'LIVRAISON N : ' . strtoupper($livraisoninfo['livraison_refer']), 0, 1, 'C'); // Centrer le texte
                // TABLEAU : COMMANDE FOURNISSEUR
                $this->Ln(3); // Ajout d'un espace
                // Ligne pour FOURNISSEUR et DATE sur la même ligne
                // $this->SetX(0);
                // $this->SetFont('Arial', 'B', 10);
                // $this->Cell(0, 10, 'FOURNISSEUR: ' . $livraisoninfo['nom_fournisseur'] . ' ' . $livraisoninfo['prenom_fournisseur'] . '   SEGOU le: ' . $formatted_date, 0, 1, 'C');

            $this->SetX(30);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(40, 5, 'COMMANDE N :', 0, 0, 'L');
            $this->SetFont('Arial', '', 14); // Remettre la police normale
            $this->Cell(0, 5, $livraisoninfo['reference'], 0, 1, 'L');
            $this->Ln(2);
           // Mettre en gras le texte "ETABLIT LE:"
            $this->SetX(30);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(35, 5, 'ETABLIT LE:', 0, 0, 'L');
            $this->SetFont('Arial', '', 14); // Remettre la police normale
            $this->Cell(0, 5, $formatted_date, 0, 1, 'L');
            $this->Ln(2);
         // Mettre en gras le texte "PAR:"
            $this->Ln(2);
            $this->SetX(30);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(35, 1, 'PAR:', 0, 0, 'L');
            $this->SetFont('Arial', '', 14); // Remettre la police normale
            $this->Cell(0, 1, trim($livraisoninfo['nom_utilisateur']) . ' ' . trim($livraisoninfo['prenom_utilisateur']), 0, 0, 'L');
        }

        // $this->Ln(0);
    }
    // Fonction pour l'en-tête du tableau
    function headerTable(){
        
        $this->SetFont('Times','B',16);
         // Lignes de titre du tableau
        $this->Ln(5);
        $this->SetX(10);
        $this->SetFont('Times','B',10);
        $this->SetFillcolor(192,192,192);
        $this->Rect(10, $this->GetY(),130,10, 'F');
        $this->Cell(40,10,'DESIGNATION',1,0,'C');
        $this->Cell(35,10,'QTE COMMANDE',1,0,'C');
        $this->Cell(25,10,'QTE RECUE ',1,0,'C');
        $this->Cell(30,10,'QTE RESTANTE ',1,0,'C');
        $this->Ln();

    }
     // Fonction pour afficher le contenu du tableau
   function viewTable(){
    global $bdd;
    if (isset($_GET['detail'])) {
         $detail=$_GET['detail'];
        $livraison=$bdd->query("SELECT * FROM livraison INNER JOIN commande_client 
        ON commande_client.id_cmd_client=livraison.id_commande_client
        WHERE id_livraison=$detail LIMIT 1");
        $livraisoninfo=$livraison->fetch();
        $id_commande=$livraisoninfo['id_cmd_client'];
        //afficher la ligne de livraison
         $ligen_livrai=$bdd->query("SELECT * FROM ligne_livraison INNER JOIN tbl_product
         ON tbl_product.id=ligne_livraison.id_produit WHERE ligne_livraison.id_livraison=$detail");
        //afficher la ligne de commande
         $ligen_commande=$bdd->query("SELECT * FROM ligne_commande_client INNER JOIN tbl_product
         ON tbl_product.id=ligne_commande_client.id_produit WHERE ligne_commande_client.id_cmd_client=$id_commande");
                        
             $datashow=$ligen_livrai->fetchAll(PDO::FETCH_OBJ);
            $dat=$ligen_commande->fetchAll(PDO::FETCH_OBJ);
            foreach( $datashow as $affich ):           
            foreach( $dat as $affiche ):
                if($affich->id_produit==$affiche->id){
                $this->SetX(10);
                $this->SetFont('Times','B',9);
                $this->Cell(40,10,$affich->name,1,0,'C');
                $this->Cell(35,10,$affiche->quantite,1,0,'C');
                $this->Cell(25,10,$affich->quantite_recu,1,0,'C');
                $this->Cell(30,10,$affiche->quantite-$affich->quantite_recu,1,0,'C');
                $this->Ln(); 
            } 
        endforeach ;
        endforeach ;
        

        // Sortie du tableau
        $this->Ln();
        // Déplacez le pointeur vers la droite 
        $this->SetX(65);    
        // Affichez le fournisseur en dehors du tableau
        $this->SetFont('Times', 'B', 9);
        $formatted_date = date('d/m/Y \a H:i', strtotime($livraisoninfo['date_livraison']));
        // $this->Cell(0, 10, 'RECU LE  :  ' . $formatted_date, 0, 1, 'L');
        $this->Cell(0, 10, 'CLIENT: ' . $livraisoninfo['client'] .  '   LIVRE le: ' . $formatted_date, 0, 1, 'C');
    }
    // Fonction pour le pied de page
    function  footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page'.$this->pageNo().'/{nb}',0,0,'C');
    }
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
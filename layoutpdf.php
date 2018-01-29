<?php

require 'constants.php';
require 'fpdf.php';

class PDF extends FPDF
{
// Page header
function Header()
{

    // Arial bold 15
    $this->SetFont(ARIAL,B,QUINDICI);
    // Move to the right
    $this->Cell(OTTANTA);
    // Title
    $this->Cell(TRENTA,DIECI,LOGO,ZERO,ZERO,C);
    // Line break
    $this->Ln(VENTI);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(MENOQUINDICI);
    // Arial italic 8
    $this->SetFont(ARIAL,I,OTTO);
    // Page number
    $this->Cell(ZERO,DIECI,'Page '.$this->PageNo().'/{nb}',ZERO,ZERO,C);
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(DUECENTO55,ZERO,ZERO);
    $this->SetTextColor(DUECENTO55);
    $this->SetDrawColor(CENTO28,ZERO,ZERO);
    $this->SetLineWidth(PUNTO3);
    $this->SetFont(VUOTO,VUOTO,OTTO);
    // Header
    $count = count($header);
    for($i=0;$i<$count;$i++)
        $this->Cell(VENTIQUATTRO,SETTE,$header[$i],UNO,ZERO,C,true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(DUECENTO24,DUECENTO35,DUECENTO55);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell(VENTIQUATTRO,SEI,$row[ZERO],LR,ZERO,L,$fill);
        $this->Cell(VENTIQUATTRO,SEI,$row[UNO],LR,ZERO,L,$fill);
        $this->Cell(VENTIQUATTRO,SEI,$row[DUE],LR,ZERO,R,$fill);
        $this->Cell(VENTIQUATTRO,SEI,$row[TRE],LR,ZERO,R,$fill);
        $this->Cell(VENTIQUATTRO,SEI,$row[QUATTRO],LR,ZERO,R,$fill);
        $this->Cell(VENTIQUATTRO,SEI,$row[CINQUE],LR,ZERO,R,$fill);
        $this->Cell(VENTIQUATTRO,SEI,$row[SEI],LR,ZERO,R,$fill);
        $this->Cell(VENTIQUATTRO,SEI,$row[SETTE],LR,ZERO,R,$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}
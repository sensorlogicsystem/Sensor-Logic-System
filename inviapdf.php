<?php
	require 'config.php';
    session_start();
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    $query = sprintf("SELECT * FROM credenziale where email='".$email."' and password='".$password."'");
    $conn = new mysqli($servername, $user, $pass, $database);
    $result = $conn->query($query);
    if($result === false || $result->num_rows != 1){
    	    header('Location: http://sensorlogicsystemlogin.altervista.org/index.php');
    }
    $destinatario = $_SESSION['destinatario'];
    if(filter_var($destinatario, FILTER_VALIDATE_EMAIL)===false) {
    	header('Location: http://sensorlogicsystemlogin.altervista.org/visualizzaRilevazioni.php');
    }
?>
<?php

require 'PHPMailer.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->From      = 'sensorlogicsystem@gmail.com';
$mail->FromName  = 'SensorLogicSystem';
$mail->Subject   = 'Rilevazioni';
$mail->Body      = "In allegato è presente il pdf con le rilevazioni richieste";

require 'config.php';

session_start();
$email = $_SESSION['email'];
$destinatario = $_SESSION['destinatario'];
$mail->AddAddress($destinatario);
$impianto = $_SESSION['impianto'];
$idr = $_SESSION['idr'];
$date = $_SESSION['data'];
$ids = $_SESSION['ids'];
$tipo = $_SESSION['tipo'];
$marca = $_SESSION['marca'];
$nomeposizione = $_SESSION['nomeposizione'];
// dichiarare il percorso dei font
define('FPDF_FONTPATH','./font/');
 
//questo file e la cartella font si trovano nella stessa directory
require('fpdf.php');
ob_end_clean();
ob_start();
include_once "OperazioniPDF.php";
class PDF extends FPDF
{
// Page header
function Header()
{

    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Sensor Logic System',0,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','',8);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell(24,7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell(24,6,$row[0],'LR',0,'L',$fill);
        $this->Cell(24,6,$row[1],'LR',0,'L',$fill);
        $this->Cell(24,6,$row[2],'LR',0,'R',$fill);
        $this->Cell(24,6,$row[3],'LR',0,'R',$fill);
        $this->Cell(24,6,$row[4],'LR',0,'R',$fill);
        $this->Cell(24,6,$row[5],'LR',0,'R',$fill);
        $this->Cell(24,6,$row[6],'LR',0,'R',$fill);
        $this->Cell(24,6,$row[7],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}
// crea l'istanza del documento
$p = new PDF();
$p->AliasNbPages();

// aggiunge una pagina
$p->AddPage();

// Impostare le caratteristiche del carattere
$p->SetTextColor(0); 
$p->SetFont('Arial', '', 9);
 
$query=sprintf("SELECT utente.id, utente.nome, utente.cognome FROM credenziale inner join utente on credenziale.utente=utente.id where credenziale.email='".$email."'");
$conn = new mysqli($servername, $user, $pass, $database);
$result = $conn->query($query);
$row=mysqli_fetch_row($result);

$msg="Proprietario dell"."'"."impianto:".$row[1]." ".$row[2]." (id:".$row[0].")\n";
$p->Write(5, $msg);
$msg="Rilevazioni dell"."'"."impianto ".$impianto;
$p->Write(5, $msg);
$msg='';

$objmsg=new OperazioniPDF();
$msg = $objmsg->intestazionePdf($date, $idr, $ids, $tipo, $nomeposizione, $marca);

$p->Write(5, $msg);
$p->Write(5, "\n\n");
$header = array('ID Rilevazione', 'Data rilevazione', 'Orario rilevazione', 'Valore rilevazione', 'ID Sensore', 'Tipologia sensore', 'Marca sensore', 'Posizione');

$querypdf= new OperazioniPDF();
$query= $querypdf->queryPdf($idr, $ids, $tipo, $nomeposizione, $marca, $impianto, $email);
                      
$conn = new mysqli($servername, $user, $pass, $database);
$result = $conn->query($query);

$data = array();
for($i=0; $i<$result->num_rows; $i++) {
	$row=mysqli_fetch_row($result);
    if(empty($date)===false){
    	$data1=substr($date,0,4).substr($date,5,2).substr($date,8,2);
        $data2=substr($row[1],0,4).substr($row[1],4,2).substr($row[1],6,2);
        if($data1===$data2){
            $data[$i] = array($row[0], substr($row[1],0,4).'-'.substr($row[1],4,2).'-'.substr($row[1],6,2), substr($row[1],8,2).':'.substr($row[1],10,2), substr($row[1],12), $row[2], $row[3], $row[4], $row[5]);
        }
	} else {
    	$data[$i] = array($row[0], substr($row[1],0,4).'-'.substr($row[1],4,2).'-'.substr($row[1],6,2), substr($row[1],8,2).':'.substr($row[1],10,2), substr($row[1],12), $row[2], $row[3], $row[4], $row[5]);
    }
}
$p->FancyTable($header,$data);

$mailAttachment = $p->output('rilevazioni.pdf', 'S');

$mail->AddStringAttachment($mailAttachment, 'rilevazioni.pdf', 'base64', 'application/pdf');

$result = $mail->Send();

if($result === true) {
	header('Location: http://sensorlogicsystemlogin.altervista.org/visualizzaRilevazioni.php?msg=success');
} else {
	header('Location: http://sensorlogicsystemlogin.altervista.org/visualizzaRilevazioni.php?msg=failed');
}
?>

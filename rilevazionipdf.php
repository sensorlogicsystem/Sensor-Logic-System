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
?>
<?php
require 'config.php';

session_start();
$email = $_SESSION['email'];
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
 
// Le funzioni per scrivere il testo
$msg="Rilevazioni dell"."'"."impianto ".$impianto;
$p->Write(5, $msg);
$msg='';
if(empty($idr)===false || empty($data)===false || empty($ids)===false || empty($tipo)===false || empty($marca)===false || empty($nomeposizione)===false){
	$msg="\n".'Filtrate per:  ';  
}
if(empty($idr)===false){
	$msg=$msg.'  Id Rilevazione:'.$idr;
}
if(empty($date)===false){
	$msg=$msg.'  Data Rilevazione:'.$date;
}
if(empty($ids)===false){
	$msg=$msg.'  Id Sensore:'.$ids;
}
if(empty($tipo)===false){
	$msg=$msg.'  Tipo Sensore:'.$tipo;
}
if(empty($marca)===false){
	$msg=$msg.'  Marca Sensore:'.$marca;
}
if(empty($nomeposizione)===false){
	$msg=$msg.'  Nome Posizione:'.$nomeposizione;
}
$p->Write(5, $msg);
$p->Write(5, "\n\n");
$header = array('ID Rilevazione', 'Data rilevazione', 'Orario rilevazione', 'Valore rilevazione', 'ID Sensore', 'Tipologia sensore', 'Marca sensore', 'Posizione');

$query = sprintf("SELECT rilevazione.id, rilevazione.rilevazione, sensore.id, sensore.tipo, sensore.marca, posizione.nomeposizione FROM rilevazione inner join sensore on rilevazione.sensore=sensore.id inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario= utente.id inner join credenziale on utente.id=credenziale.utente where impianto.nomeimpianto ='".$impianto."' and credenziale.email='".$email."' ");
if(!empty($idr)) {
  $query = $query.sprintf(" and  rilevazione.id= ".$idr);
}
if(!empty($ids)) {
  $query = $query.sprintf(" and  sensore.id= '".$ids."'");
}
if(!empty($tipo)) {
  $query = $query.sprintf(" and  sensore.tipo= '".$tipo."'");
}
if(!empty($marca)) {
  $query = $query.sprintf(" and  sensore.marca= '".$marca."'");
}
if(!empty($nomeposizione)){
  $query = $query.sprintf(" and posizione.nomeposizione = '".$nomeposizione."'");
}
$query = $query.sprintf(" order by rilevazione.id");
                      
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

$p->output();
ob_end_flush();
?>
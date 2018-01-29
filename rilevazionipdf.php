<?php
require 'layoutpdf.php';
require 'config.php';
require 'constants.php';
include_once 'OperazioniPDF.php';
include_once 'Tablepdf.php';
$conn = '';
session_start();
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if(empty($conn) === true){
   	$conn = new mysqli($servername, $user, $pass, $database);
}
$query = sprintf("SELECT * FROM credenziale where email='%s' and password='%s'",mysqli_real_escape_string($conn, $email),mysqli_real_escape_string($conn, $password));
$result = $conn->query($query);
if($result === false || $result->num_rows !== 1){
    header('Location: http://sensorlogicsystemlogin.altervista.org/index.php');
}
?>
<?php

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

//questo file e la cartella font si trovano nella stessa directory

ob_end_clean();
ob_start();

$conn = '';
$query = '';

// crea l'istanza del documento
$p = new PDF();
$p->AliasNbPages();

// aggiunge una pagina
$p->AddPage();

// Impostare le caratteristiche del carattere
$p->SetTextColor(0);
$p->SetFont(ARIAL, VUOTO, NOVE);

// Le funzioni per scrivere il testo
$msg='Rilevazioni dell'."'".'impianto '.$impianto;
$p->Write(CINQUE, $msg);
$msg='';

$objmsg=new OperazioniPDF();
$msg = $objmsg->intestazionePdf($date, $idr, $ids, $tipo, $nomeposizione, $marca);

$p->Write(CINQUE, $msg);
$p->Write(CINQUE, "\n\n");
$header = array('ID Rilevazione', 'Data rilevazione', 'Orario rilevazione', 'Valore rilevazione', 'ID Sensore', 'Tipologia sensore', 'Marca sensore', 'Posizione');
if(empty($conn) === true){
   	$conn = new mysqli($servername, $user, $pass, $database);
}
$querypdf= new OperazioniPDF();
if(empty($query) === true){
	$query= $querypdf->queryPdf(mysqli_real_escape_string($conn, $idr), mysqli_real_escape_string($conn, $ids), mysqli_real_escape_string($conn, $tipo), mysqli_real_escape_string($conn, $nomeposizione), mysqli_real_escape_string($conn, $marca), mysqli_real_escape_string($conn, $impianto), mysqli_real_escape_string($conn, $email));
}

$result = $conn->query($query);

$data = array();

$tablepdf= new Tablepdf();
$data= $tablepdf-> table_pdf($query, $date);

$p->FancyTable($header,$data);

$p->output();
ob_end_flush();
?>

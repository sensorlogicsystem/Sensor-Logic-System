<?php
	require 'layoutpdf.php';
	require 'config.php';
    require 'constants.php';
    require 'PHPMailer.php';
	include_once 'OperazioniPDF.php';
	include_once 'Tablepdf.php';
    $conn = '';
    session_start();
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    if($conn === '') {
    	$conn = new mysqli($servername, $user, $pass, $database);
	}
    $query = sprintf("SELECT * FROM credenziale where email='%s' and password='%s'",mysqli_real_escape_string($conn, $email), mysqli_real_escape_string($conn, $password));
    $result = $conn->query($query);
    if($result === false || $result->num_rows !== 1){
    	    header('Location: http://sensorlogicsystemlogin.altervista.org/index.php');
    }
    $destinatario = $_SESSION['destinatario'];
    if(filter_var($destinatario, FILTER_VALIDATE_EMAIL)===false) {
    	header('Location: http://sensorlogicsystemlogin.altervista.org/visualizzaRilevazioni.php');
    }

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->From      = 'sensorlogicsystem@gmail.com';
$mail->FromName  = 'SensorLogicSystem';
$mail->Subject   = 'Rilevazioni';
$mail->Body      = 'In allegato è presente il pdf con le rilevazioni richieste';

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

 
//questo file e la cartella font si trovano nella stessa directory

ob_end_clean();
ob_start();

$conn = '';
// crea l'istanza del documento
$p = new PDF();
$p->AliasNbPages();

// aggiunge una pagina
$p->AddPage();

// Impostare le caratteristiche del carattere
$p->SetTextColor(0); 
$p->SetFont(ARIAL, VUOTO, NOVE);
if($conn === '') {
    $conn = new mysqli($servername, $user, $pass, $database);
}
$query=sprintf("SELECT utente.id, utente.nome, utente.cognome FROM credenziale inner join utente on credenziale.utente=utente.id where credenziale.email='%s'",mysqli_real_escape_string($conn, $email));

$result = $conn->query($query);
$row=mysqli_fetch_row($result);

$msg='Proprietario dell'."'".'impianto:'.$row[UNO].' '.$row[DUE].' (id:'.$row[ZERO].")\n";
$p->Write(CINQUE, $msg);
$msg='Rilevazioni dell'."'".'impianto '.$impianto;
$p->Write(CINQUE, $msg);
$msg='';
$conn = '';
$objmsg=new OperazioniPDF();
$msg = $objmsg->intestazionePdf($date, $idr, $ids, $tipo, $nomeposizione, $marca);

$p->Write(CINQUE, $msg);
$p->Write(CINQUE, "\n\n");
$header = array('ID Rilevazione', 'Data rilevazione', 'Orario rilevazione', 'Valore rilevazione', 'ID Sensore', 'Tipologia sensore', 'Marca sensore', 'Posizione');
    if($conn === '') {
    	$conn = new mysqli($servername, $user, $pass, $database);
	}
$querypdf= new OperazioniPDF();
$query= $querypdf->queryPdf(mysqli_real_escape_string($conn, $idr), mysqli_real_escape_string($conn, $ids), mysqli_real_escape_string($conn, $tipo), mysqli_real_escape_string($conn, $nomeposizione), mysqli_real_escape_string($conn, $marca), mysqli_real_escape_string($conn, $impianto), mysqli_real_escape_string($conn, $email));
                      

$tablepdf= new Tablepdf();
$data= $tablepdf-> table_pdf($query, $date);

$p->FancyTable($header,$data);

$mailAttachment = $p->output('rilevazioni.pdf', 'S');

$mail->AddStringAttachment($mailAttachment, 'rilevazioni.pdf', 'base64', 'application/pdf');

$result = $mail->Send();

if($result === true) {
	header('Location: http://sensorlogicsystemlogin.altervista.org/visualizzaRilevazioni.php?msg=success');
} else {
	header('Location: http://sensorlogicsystemlogin.altervista.org/visualizzaRilevazioni.php?msg=failed');
}
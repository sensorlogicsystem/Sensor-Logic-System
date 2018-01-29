<?php
	require 'config.php';
    include_once'QueryVisualizzaUtente.php';
    include_once 'Autenticazione.php';
    
	$autentica= new Autenticazione();
    $autentica-> autenticazione();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="generator" content="AlterVista - Editor HTML"/>
  <title></title>
  <link href="adminDesktop.css" media="only screen and (min-width: 401px)" rel="stylesheet" type="text/css">
  <link href="adminMobile.css" media="only screen and (max-width: 400px)" rel="stylesheet" type="text/css">
</head>
<body>
	<br />
	<span class="visClient">Visualizza Clienti</span>
    <br /><br />
      <div class="contenitoreFiltri">
      	<form class="form"  action="visualizzaClienti.php" method="post">
                <?php
        include_once 'Layout.php';
require 'config.php';
                        $conn='';
                        $query='';
                        if($conn === '') {
                            $conn = new mysqli($servername, $user, $pass, $database);
                        }
            			$viewcli= new QueryVisualizzaUtente();
                		$query=$viewcli->viewutente(mysqli_real_escape_string($conn, $_POST['id']),mysqli_real_escape_string($conn, $_POST['nome']),mysqli_real_escape_string($conn, $_POST['cognome']), mysqli_real_escape_string($conn, $_POST['email']),mysqli_real_escape_string($conn, $_POST['citta']), 'u');
                		
                        $visualcli= new QueryVisualizzaUtente();
                         $layoutS= new Layout();
                        $stampa = '';
                        if($stampa === '') {
                          $stampa = $layoutS->layoutSearch(htmlspecialchars($_POST['id']), htmlspecialchars($_POST['nome']), htmlspecialchars($_POST['cognome']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['citta']));
                        }
                        echo $stampa;
                        if(isset($query) === true) {
                        	$query= $visualcli-> visualizzaut($query, mysqli_real_escape_string($conn, $_POST['id']),mysqli_real_escape_string($conn, $_POST['nome']),mysqli_real_escape_string($conn, $_POST['cognome']), mysqli_real_escape_string($conn, $_POST['email']), mysqli_real_escape_string($conn, $_POST['citta']));
						}            
						
                        $result = '';
                        if(isset($_SESSION['email']) === true && isset($_SESSION['password']) === true ) {
                        	$result = $conn->query($query);
                        }  
                        
                        $tabquery= new QueryVisualizzaUtente();
                        $tabquery->tablequery($result);
                    ?>
         </form>
      </div>
</body>
</html>

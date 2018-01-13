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
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="generator" content="AlterVista - Editor HTML"/>
  <title></title>
  <link href="adminDesktop.css" media="only screen and (min-width: 401px)" rel="stylesheet" type="text/css">
  <link href="adminMobile.css" media="only screen and (max-width: 400px)" rel="stylesheet" type="text/css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>
<body>
	<?php
    	$impianto='';
        session_start();
        require 'config.php';
        $conn = new mysqli($servername, $user, $pass, $database);
        $email=$_SESSION['email'];

        if($_GET['impianto']==="Nessun impianto registrato") {
        	header('Location: http://sensorlogicsystemlogin.altervista.org/nessunImpianto.html');
        } elseif(empty($_GET['impianto'])===true){
        	$query=sprintf("SELECT nomeimpianto from credenziale inner join utente on credenziale.utente=utente.id inner join impianto on utente.id=impianto.proprietario where email='".$email."' order by nomeimpianto");
            $result=$conn->query($query);
            if($result === false || $result->num_rows===0){
            	header('Location: http://sensorlogicsystemlogin.altervista.org/nessunImpianto.html');
            } elseif($result->num_rows>0){
            	$row=mysqli_fetch_row($result);
                $impianto=$row[0];
            }
        }else{
        	$impianto=$_GET['impianto'];
        }
        session_start();
		$_SESSION['impianto'] = $impianto;
    ?>
     <br />
        	<div class="countStatistiche">
              <div class="stat">
                  <span class="titoloStatistiche">Totale Posizioni</span>
                  <br />
                  	<?php
                    	require 'config.php';
                    	$conn = new mysqli($servername, $user, $pass, $database);
                        $query = sprintf("select * from posizione inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where nomeimpianto='".$impianto."' and email='".$email."'");
                        $result = $conn->query($query);
                        echo '<span class="resstat">'.$result->num_rows.'</span>';
                    ?>
              </div>
              <div class="stat"> 
                  <span class="titoloStatistiche">Totale Sensori</span>
                  <br />
                  	<?php
                    	require 'config.php';
                    	$conn = new mysqli($servername, $user, $pass, $database);
                        $query = sprintf("select * from sensore inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where nomeimpianto='".$impianto."' and email='".$email."'");
                        $result = $conn->query($query);
                        echo '<span class="resstat">'.$result->num_rows.'</span>';
                    ?>
              </div>
              <div class="stat"> 
                  <span class="titoloStatistiche">Totale Rilevazioni</span>
                  <br />
                  	<?php
                    	require 'config.php';
                    	$conn = new mysqli($servername, $user, $pass, $database);
                        $query = sprintf("select * from rilevazione inner join sensore on rilevazione.sensore=sensore.id inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where nomeimpianto='".$impianto."' and email='".$email."'");
                        $result = $conn->query($query);
                        echo '<span class="resstat">'.$result->num_rows.'</span>';
                    ?>
              </div>
              <div class="stat"> 
                  <span class="titoloStatistiche">Totale Rilevazioni odierne</span>
                  <br />
                  	<?php
                    	require 'config.php';
                    	$conn = new mysqli($servername, $user, $pass, $database);
                        $today=getdate();
                        $date=$today['year'];
                        if($today['mon']<10){
                        	$date=$date."0".$today['mon'];
                        }else {
                        	$date=$date.$today['mon'];
                        }
                        if($today['mday']<10){
                        	$date=$date."0".$today['mday'];
                        }else{
                        	$date=$date.$today['mday'];
                        }
                        
                        $query = sprintf("select rilevazione from rilevazione inner join sensore on rilevazione.sensore=sensore.id inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where nomeimpianto='".$impianto."' and email='".$email."'");
                        $result = $conn->query($query);
                        $count=0;
                        for($i=0; $i<$result->num_rows; $i++){
                        	$row=mysqli_fetch_row($result);
                            $date2=substr($row[0],0,8);
                            if($date===$date2){
                            	$count++;
                            }
                        }
                        echo '<span class="resstat">'.$count.'</span>';
                    ?>
              </div>
            </div>
            <br /><br /><br /><br /><br /><br />
            <div class="contenitoreTipo";><canvas id="chartTipo" class="chartTipo"></canvas></div>
            <div class="contenitoreTipo";><canvas id="chartRilevazioni" class="chartRilevazioni"></canvas></div>
            
<script type="text/javascript">
    var tipo = <?php require 'chartTipo.php'; echo json_encode($tipo) ?>;
    var countTipo = <?php require 'chartTipo.php'; echo json_encode($countTipo) ?>;
                
    var myChart = new Chart(document.getElementById("chartTipo"), {
        type: 'doughnut',
        data: {
          labels: tipo,
          datasets: [
           {
             label: "",
             backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
             data: countTipo
            }
            ]
            },
            options: {
             title: {
               display: true,
               text: 'Tipi di sensori maggiormente installati'
              }
             }
      });
</script>
<script type="text/javascript">
 		var tipo = <?php require 'chartRilevazioni.php'; echo json_encode($tipo) ?>;
    	var rilevazioni = <?php require 'chartRilevazioni.php'; echo json_encode($rilevazioni) ?>;
   		var chart= new Chart(document.getElementById("chartRilevazioni"), {
        type: 'horizontalBar',
        data: {
          labels: tipo,
          datasets: [
            {
              label: "",
              backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
              data: rilevazioni
            }
          ]
        },
        options: {
          legend: { display: false },
          title: {
            display: true,
            text: 'Rilevazioni odierne per tipologia sensore'
          }
        }
    });
</script>
</body>
</html>
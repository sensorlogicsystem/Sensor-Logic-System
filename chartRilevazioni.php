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
    $email=$_SESSION['email'];
    $impianto=$_SESSION['impianto'];
    $tipo=array();
    $rilevazioni=array();
    $countTipo=0;
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
                        
                        
    $conn = new mysqli($servername, $user, $pass, $database);
    $query=sprintf("SELECT sensore.tipo, count(sensore.tipo) FROM sensore inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where impianto.nomeimpianto='".$impianto."' and email ='".$email."' group by sensore.tipo order by count(sensore.tipo) desc");
    $result=$conn->query($query);
    $countTipo=$result->num_rows;
    if($countTipo>=5){
    	for($i=0;$i<5;$i++){
        	$row=mysqli_fetch_row($result);
            $tipo[$i]= $row[0];
        }
    }else{
    	for($i=0;$i<$result->num_rows;$i++){
        	$row=mysqli_fetch_row($result);
            $tipo[$i]= $row[0];
        }
    }
    
    for($i=0;$i<$countTipo;$i++){
    	$query=sprintf("select rilevazione from rilevazione inner join sensore on rilevazione.sensore=sensore.id inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where nomeimpianto='".$impianto."' and email='".$email."' and sensore.tipo='".$tipo[$i]."'");
    	$result = $conn->query($query);
        $rilevazioni[$i]=0;
         for($l=0; $l<$result->num_rows; $l++){
            $row=mysqli_fetch_row($result);
            $date2=substr($row[0],0,8);
			if($date===$date2){
    			$rilevazioni[$i]++;
      		}
     	}   
    }
    
?>
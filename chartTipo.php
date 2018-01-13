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
    $countTipo=array();
    
    $conn = new mysqli($servername, $user, $pass, $database);
    $query=sprintf("SELECT sensore.tipo, count(sensore.tipo) FROM sensore inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where impianto.nomeimpianto='".$impianto."' and email ='".$email."' group by sensore.tipo order by count(sensore.tipo) desc");
    $result=$conn->query($query);
   
    if($result->num_rows>=5){
    	for($i=0;$i<5;$i++){
        	$row=mysqli_fetch_row($result);
            $tipo[$i]= $row[0];
            $countTipo[$i]=$row[1];
        }
    }else{
    	for($i=0;$i<$result->num_rows;$i++){
        	$row=mysqli_fetch_row($result);
            $tipo[$i]= $row[0];
            $countTipo[$i]=$row[1];
        }
    }
?>
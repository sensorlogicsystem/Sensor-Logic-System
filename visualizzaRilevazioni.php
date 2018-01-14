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
</head>
<body>
	<br />
	<span class="visClient">Visualizza Rilevazioni</span>
    <br /><br />
      <div class="contenitoreFiltri">
      	<form class="form"  action="visualizzaRilevazioni.php" method="post">
          <span class="filtra"> Filtra per:</span>
          <input class="inputfiltro" type="text" placeholder="Id Rilevazione" id="idr" name="idr" maxlength="11" value="<?php $idr=$_POST['idr']; if(isset($idr)===true){echo $idr;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" />
          <input class="inputfiltro" type="date" placeholder="Data Rilevazione" id="data" name="data"  value="<?php $data=$_POST['data']; if(isset($data)===true){echo $data;}?>"/>
          <input class="inputfiltro" type="text" placeholder="Id Sensore" id="ids" name="ids" maxlength="50" value="<?php $ids=$_POST['ids']; if(isset($ids)===true){echo $ids;}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <input class="inputfiltro" type="text" placeholder="Tipo Sensore" id="tipo" name="tipo" maxlength="50" value="<?php $tipo=$_POST['tipo']; if(isset($tipo)===true){echo $tipo;}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <input class="inputfiltro" type="text" placeholder="Marca Sensore" id="marca" name="marca" maxlength="50" value="<?php $marca=$_POST['marca']; if(isset($marca)===true){echo $marca;}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <input class="inputfiltro" type="text" placeholder="Nome Posizione" id="nomeposizione" name="nomeposizione" maxlength="50" value="<?php $nomeposizione=$_POST['nomeposizione']; if(isset($nomeposizione)===true){echo $nomeposizione;}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <br/><br/>
          <button class="buttfiltro" name="filtroRilevazioni" value="filtroRilevazioni" type="submit" id="filtroRilevazioni">Ricerca</button>
          <button class="buttfiltro" name="scaricare" value="scaricare" type="submit" id="scaricare">Scarica pdf</button>
          
          <div class="positiontable">
          <br/><br/>
           <table class="tabellaClienti">
                <thead>
                  <tr>
                    <th>Id Rilevazione</th>
                    <th>Data Rilevazione</th>
                    <th>Ora Rilevazione</th>
                    <th>Valore Rilevazione</th>
                    <th>Id Sensore</th>
                    <th>Tipo Sensore</th>
                    <th>Marca Sensore</th>
                    <th>Nome Posizione</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    	require 'config.php';
                        session_start();
                        $email=$_SESSION['email'];
                        $impianto=$_SESSION['impianto'];
                        $idr=$_POST['idr'];
                        $data=$_POST['data'];
                        $ids=$_POST['ids'];
                        $tipo=$_POST['tipo'];
                        $marca=$_POST['marca'];
                        $nomeposizione=$_POST['nomeposizione'];
                        
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
                      
                        for($i=0; $i<$result->num_rows; $i++) {
                        	$row=mysqli_fetch_row($result);
                            if(empty($data)===false){
                            	$data1=substr($data,0,4).substr($data,5,2).substr($data,8,2);
                                $data2=substr($row[1],0,4).substr($row[1],4,2).substr($row[1],6,2);
                                if($data1===$data2){
                                	echo '<tr>';
                                    echo '<td>'.$row[0].'</td>';
                                    echo '<td>'.substr($row[1],0,4).'-'.substr($row[1],4,2).'-'.substr($row[1],6,2).'</td>';
                                    echo '<td>'.substr($row[1],8,2).':'.substr($row[1],10,2).'</td>';
                                    echo '<td>'.substr($row[1],12).'</td>';
                                    echo '<td>'.$row[2].'</td>';
                                    echo '<td>'.$row[3].'</td>';
                                    echo '<td>'.$row[4].'</td>';
                                    echo '<td>'.$row[5].'</td>';
                                    echo '</tr>';
                                }
                            }else{
                                echo '<tr>';
                                echo '<td>'.$row[0].'</td>';
                                echo '<td>'.substr($row[1],0,4).'-'.substr($row[1],4,2).'-'.substr($row[1],6,2).'</td>';
                                echo '<td>'.substr($row[1],8,2).':'.substr($row[1],10,2).'</td>';
                                echo '<td>'.substr($row[1],12).'</td>';
                                echo '<td>'.$row[2].'</td>';
                                echo '<td>'.$row[3].'</td>';
                                echo '<td>'.$row[4].'</td>';
                                echo '<td>'.$row[5].'</td>';
                                echo '</tr>';
                            }
                        }
                    ?>                    
                </tbody>
            </table>
           </div>
           <br /><br />
           <hr class="separator">
           <br />
           <span class='filtra'>Inserisci l'indirizzo email a cui inviare il pdf con i dati delle rilevazioni</span>
           <input class="inputfiltro" type="text" placeholder="Email" id="email10" name="email10" maxlength="50" value="<?php $email10=$_POST['email10']; if(isset($email10)===true){echo $email10;}?>" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Deve rispettare il formato corretto" />
           <button class="buttfiltro" name="inviare" value="inviare" type="submit" id="inviare">Invia allegato</button>
         </form>
      </div>
                  	<?php
                $str = '<div id="error" class="filtra">Impossibile inviare l'."'".'email</div>';
                
                if (isset($_GET['msg']) === true && $_GET['msg'] === 'failed') {
                	echo $str;
				}
           		?>
                            	<?php
                $str = '<div id="error" class="filtra">E-mail con allegato inviata con successo</div>';
                
                if (isset($_GET['msg']) === true && $_GET['msg'] === 'success') {
                	echo $str;
				}
           		?>
      <?php
      	if(isset($_POST['scaricare'])===true){
        	$_SESSION['idr']=$_POST['idr'];
        	$_SESSION['data']=$_POST['data'];
            $_SESSION['ids']=$_POST['ids'];
            $_SESSION['tipo']=$_POST['tipo'];
            $_SESSION['marca']=$_POST['marca'];
            $_SESSION['nomeposizione']=$_POST['nomeposizione'];
            header("location:rilevazionipdf.php");
        }        
      ?>
      <?php
      	if(isset($_POST['inviare'])===true){
        	$_SESSION['idr']=$_POST['idr'];
        	$_SESSION['data']=$_POST['data'];
            $_SESSION['ids']=$_POST['ids'];
            $_SESSION['tipo']=$_POST['tipo'];
            $_SESSION['marca']=$_POST['marca'];
            $_SESSION['nomeposizione']=$_POST['nomeposizione'];
            $_SESSION['destinatario']=$_POST['email2'];
            header("location:inviapdf.php");
        }        
      ?>
</body>
</html>
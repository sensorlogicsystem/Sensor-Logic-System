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
	<span class="visClient">Visualizza Posizioni</span>
    <br /><br />
      <div class="contenitoreFiltri">
      	<form class="form"  action="visualizzaPosizioni.php" method="post">
          <span class="filtra"> Filtra per:</span>
          <input class="inputfiltro" type="text" placeholder="Id" id="id" name="id" maxlength="11" value="<?php $id=$_POST['id']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" />
          <input class="inputfiltro" type="text" placeholder="NomePosizione" id="nomeposizione" name="nomeposizione" maxlength="50" value="<?php $nomeposizione=$_POST['nomeposizione']; if(isset($nomeposizione)===true){echo $nomeposizione;}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <input class="inputfiltro" type="text" placeholder="ID_Impianto" id="impianto" name="impianto" maxlength="11" value="<?php $impianto=$_POST['impianto']; if(isset($impianto)===true){echo $impianto;}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" />
          <button class="buttfiltro" name="filtro" value="filtro" type="submit" id="filtro">Ricerca</button>
          <div class="positiontable">
           <table class="tabellaClienti">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>NomePosizione</th>
                    <th>Descrizione</th>
                    <th>ID_Impianto</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    	require 'config.php';
                        
                        $id=$_POST['id'];
                        $nomeposizione=$_POST['nomeposizione'];
                        $descrizione=$_POST['descrizione'];
                        $impianto=$_POST['impianto'];
                     
                        $query = sprintf("SELECT * FROM posizione inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario= utente.id inner join credenziale on utente.id=credenziale.utente where permesso='u'");
                        if(!empty($id)) {
                        	$query = $query.sprintf(" and posizione.id = ".$id);
                        }
                        if(!empty($nomeposizione)){
                           	$query = $query.sprintf(" and posizione.nomeposizione = '".$nomeposizione."'");
                        }
                        if(!empty($impianto)){
                           	$query = $query.sprintf(" and posizione.impianto = '".$impianto."'");
                        }
                       $query = $query.sprintf(" order by posizione.id");
                        $conn = new mysqli($servername, $user, $pass, $database);
                        $result = $conn->query($query);
                        
                        for($i=0; $i<$result->num_rows; $i++) {
                        	$row=mysqli_fetch_row($result);
                            
                        	echo '<tr>';
                            echo '<td>'.$row[0].'</td>';
                            echo '<td>'.$row[1].'</td>';
                            echo '<td>'.$row[2].'</td>';
                            echo '<td>'.$row[3].'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
           </div>
         </form>
      </div>
</body>
</html>

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
	<span class="visClient">Visualizza Impianti</span>
    <br /><br />
      <div class="contenitoreFiltri">
      	<form class="form"  action="visualizzaImpianti.php" method="post">
          <span class="filtra"> Filtra per:</span>
          <input class="inputfiltro" type="text" placeholder="IdImpianto" id="id" name="id" maxlength="11" value="<?php $id=$_POST['id']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" />
          <input class="inputfiltro" type="text" placeholder="NomeImpianto" id="nomeimpianto" name="nomeimpianto" maxlength="50" value="<?php $nomeimpianto=$_POST['nomeimpianto']; if(isset($nomeimpianto)===true){echo $nomeimpianto;}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" />
          <input class="inputfiltro" type="text" placeholder="IdProprietario" id="idproprietario" name="idproprietario" maxlength="11" value="<?php $idproprietario=$_POST['idproprietario']; if(isset($idproprietario)===true){echo $idproprietario;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" />
          <input class="inputfiltro" type="text" placeholder="Tipo" id="tipo" name="tipo" maxlength="50" value="<?php $tipo=$_POST['tipo']; if(isset($tipo)===true){echo $tipo;}?>"  pattern="[A-Za-z]{0,50}" title="Deve contenere solo lettere"/>
          <input class="inputfiltro" type="text" placeholder="Città" id="citta" name="citta" maxlength="50" value="<?php $citta=$_POST['citta']; if(isset($citta)===true){echo $citta;}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composta da sole lettere" />
          <button class="buttfiltro" name="filtro" value="filtro" type="submit" id="filtro">Ricerca</button>
          <div class="positiontable">
           <table class="tabellaClienti">
                <thead>
                  <tr>
                    <th>IdImpianto</th>
                    <th>NomeImpianto</th>
                    <th>IdProprietario</th>
                    <th>Città</th>
                    <th>Indirizzo</th>
                    <th>N°Civico</th>
                    <th>Provincia</th>
                    <th>CAP</th>
                    <th>Tipo</th>
                    <th>Descrizione</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    	require 'config.php';
                        
                        $id=$_POST['id'];
                        $nomeimpianto=$_POST['nomeimpianto'];
                        $idproprietario=$_POST['idproprietario'];
                        $tipo=$_POST['tipo'];
                        $citta=$_POST['citta'];
                        
                        $query = sprintf("SELECT * FROM impianto inner join utente on impianto.proprietario=utente.id inner join credenziale on utente.id=credenziale.utente where permesso='u'");
                        if(!empty($id)) {
                        	$query = $query.sprintf(" and impianto.id = ".$id);
                        }
                        if(!empty($nomeimpianto)){
                           	$query = $query.sprintf(" and nomeimpianto = '".$nomeimpianto."'");
                        }
                        if(!empty($idproprietario)){
                           	$query = $query.sprintf(" and utente.id = '".$idproprietario."'");
                        }
                        if(!empty($tipo)){
                           	$query = $query.sprintf(" and tipo = '".$tipo."'");
                        }
                        if(!empty($citta)){
                           	$query = $query.sprintf(" and impianto.citta = '".$citta."'");
                        }
                        $query=$query.sprintf("order by impianto.id");
                        
                        $conn = new mysqli($servername, $user, $pass, $database);
                        $result = $conn->query($query);
                       
                        for($i=0; $i<$result->num_rows; $i++) {
                        	$row=mysqli_fetch_row($result);
                            
                        	echo '<tr>';
                            echo '<td>'.$row[0].'</td>';
                            echo '<td>'.$row[2].'</td>';
                            echo '<td>'.$row[1].'</td>';
                            echo '<td>'.$row[3].'</td>';
                            echo '<td>'.$row[4].'</td>';
                            echo '<td>'.$row[5].'</td>';
                            echo '<td>'.$row[6].'</td>';
                            echo '<td>'.$row[7].'</td>';
                            echo '<td>'.$row[9].'</td>';
                            echo '<td>'.$row[8].'</td>';
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
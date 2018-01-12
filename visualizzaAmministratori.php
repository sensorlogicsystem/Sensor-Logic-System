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
	<span class="visClient">Visualizza Amministratori</span>
    <br /><br />
      <div class="contenitoreFiltri">
      	<form class="form"  action="visualizzaAmministratori.php" method="post">
          <span class="filtra"> Filtra per:</span>
          <input class="inputfiltro" type="text" placeholder="Id" id="id" name="id" maxlength="11" value="<?php $id=$_POST['id']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" />
          <input class="inputfiltro" type="text" placeholder="Nome" id="nome" name="nome" maxlength="50" value="<?php $nome=$_POST['nome']; if(isset($nome)===true){echo $nome;}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" />
          <input class="inputfiltro" type="text" placeholder="Cognome" id="cognome" name="cognome" maxlength="50" value="<?php $cognome=$_POST['cognome']; if(isset($cognome)===true){echo $cognome;}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" />
          <input class="inputfiltro" type="text" placeholder="Email" id="email" name="email" maxlength="50" value="<?php $email=$_POST['email']; if(isset($email)===true){echo $email;}?>"  pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Deve rispettare il formato: email@dominio.com"/>
          <input class="inputfiltro" type="text" placeholder="Città" id="città" name="città" maxlength="50" value="<?php $citta=$_POST['città']; if(isset($citta)===true){echo $citta;}?>" pattern= "[A-Za-z]{0,50}" title="Deve essere composta da sole lettere" />
          <button class="buttfiltro" name="filtro" value="filtro" type="submit" id="filtro">Ricerca</button>
          <div class="positiontable">
           <table class="tabellaClienti">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>CF</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Città</th>
                    <th>Indirizzo</th>
                    <th>N°Civico</th>
                    <th>CAP</th>
                    <th>Provincia</th>
                    <th>Data di nascita</th>
                    <th>Sesso</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    	require 'config.php';
                        
                        $id=$_POST['id'];
                        $nome=$_POST['nome'];
                        $cognome=$_POST['cognome'];
                        $email=$_POST['email'];
                        $citta=$_POST['città'];
                        
                        $query = sprintf("select * from utente inner join credenziale on id=utente where permesso='a'");
                        if(!empty($id)) {
                        	$query = $query.sprintf(" and id = ".$id);
                        }
                        if(!empty($nome)){
                           	$query = $query.sprintf(" and nome = '".$nome."'");
                        }
                        if(!empty($cognome)){
                           	$query = $query.sprintf(" and cognome = '".$cognome."'");
                        }
                        if(!empty($email)){
                           	$query = $query.sprintf(" and email = '".$email."'");
                        }
                        if(!empty($citta)){
                           	$query = $query.sprintf(" and citta = '".$citta."'");
                        }
                         $query=$query.sprintf(" order by utente.id");
                        
                        $conn = new mysqli($servername, $user, $pass, $database);
                        $result = $conn->query($query);
                        
                        for($i=0; $i<$result->num_rows; $i++) {
                        	$row=mysqli_fetch_row($result);
                            
                        	echo '<tr>';
                            echo '<td>'.$row[0].'</td>';
                            echo '<td>'.$row[1].'</td>';
                            echo '<td>'.$row[3].'</td>';
                            echo '<td>'.$row[2].'</td>';
                            echo '<td>'.$row[13].'</td>';
                            echo '<td>'.$row[5].'</td>';
                            echo '<td>'.$row[7].'</td>';
                            echo '<td>'.$row[8].'</td>';
                            echo '<td>'.$row[9].'</td>';
                            echo '<td>'.$row[11].'</td>';
                            echo '<td>'.$row[10].'</td>';
                            echo '<td>'.$row[6].'</td>';
                            echo '<td>'.$row[4].'</td>';
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
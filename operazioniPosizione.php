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
	<form class="form"  action="operazioniPosizione.php" method="post">
    	<br />
    	<span class="visClient">Registrare una nuova posizione</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
                <tr>
                	<td><span class="filtra2">ID Impianto</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Impianto" id="idimpianto" name="idimpianto" maxlength="11" value="<?php $id=$_POST['idimpianto']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class= "contenitorecolonna">
          <table  class="tabellacolonna">
              <tbody>
            	<tr>
                	<td><span class="filtra2">Nome posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Nome posizione" id="nomeposizione" name="nomeposizione" maxlength="50" value="<?php $nome=$_POST['nomeposizione']; if(isset($nome)===true){echo $nome;}?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                </tr>
              </tbody>
          </table>
        </div>
         <div class= "contenitorecolonna">
         	<table  class="tabellacolonna">
            	<tbody>
                    <tr>
                    	<td><span class="filtra2">Descrizione</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="Descrizione" id="descrizione" name="descrizione" maxlength="100" value="<?php $descrizione=$_POST['descrizione']; if(isset($descrizione)===true){echo $descrizione;}?>"/></td>
                  	</tr>
                </tbody>
            </table>
        </div>
        <br /><br />
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['aggiungere'])===true){
            	$idimpianto = $_POST['idimpianto'];
            	$query=sprintf("SELECT * from impianto WHERE id=".$idimpianto);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
            	if($result->num_rows === 0){
                	echo '<span class="filtra">Non è presente nessun impianto con ID: '.$idimpianto.'</span>';
                } else {
                    $nomeposizione= $_POST['nomeposizione'];
                    $descrizione= $_POST['descrizione'];
                	$query=sprintf("insert into posizione (nomeposizione, descrizione, impianto) values ('".$nomeposizione."','".$descrizione."',".$idimpianto.")");
                	$result = $conn->query($query);
                    if($result === false){
                    	echo '<span class="filtra">Registrazione non riuscita</span>';
                    } else {
                    	echo '<span class="filtra">Registrazione riuscita</span>';
                    }
                }
        	}
        ?>
       	<br />
    	<button class="buttfiltro" name="aggiungere" value="aggiungere" type="submit" id="aggiungere">Registra posizione</button>
	</form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniPosizione.php" method="post">
    	<br />
    	<span class="visClient">Rimuovere una posizione</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID Posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID posizione" id="id" name="id" maxlength="11" value="<?php $id=$_POST['id']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
        <br /><br/><br />
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['rimuovere'])===true){
            	$id = $_POST['id'];
                $query=sprintf("SELECT * FROM posizione WHERE id=".$id);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                if($result->num_rows === 1){
                	$query=sprintf("DELETE FROM posizione WHERE id=".$id);
                    $result = $conn->query($query);
                    if(!$result === false) {
                        echo '<span class="filtra">Posizione rimossa con successo</span>';
                    } else {
                    	echo '<span class="filtra">Posizione non rimossa, si è verifica un problema</span>';
                    }
                } else {
                	echo '<span class="filtra">Posizione non rimossa, nessuna posizione ha ID: '.$id.'</span>';
                }
            }
        ?>
    	<button class="buttfiltro" name="rimuovere" value="rimuovere" type="submit" id="rimuovere">Rimuovi posizione</button>
    </form>
    <br /><br /><br />
    <hr class="separator">
    <form class="form"  action="operazioniPosizione.php" method="post">
    	<br />
    	<span class="visClient">Modificare i dati della posizione</span><br /><br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
            	<tr>
                	<td><span class="filtra2">ID Posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Posizione" id="id2" name="id2" maxlength="11" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo $id;}?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
			</tbody>
		</table>
        </div>
    	<button class="buttfiltro" name="recuperare" value="recuperare" type="submit" id="recuperare">Recupera i dati della posizione</button>
    </form>
    <br /><br />
	<form class="form"  action="operazioniPosizione.php" method="post">
    	<br />
        <?php
        	require 'config.php';
            
            if(isset($_POST['recuperare'])===true){
            	$id = $_POST['id2'];
                $query=sprintf("SELECT * FROM posizione WHERE id=".$id);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                if($result->num_rows === 1){
                	echo '<span class="filtra">Recuperati i dati della posizione con ID: '.$id.'</span>';
                } else {
                	echo '<span class="filtra">Non è presente nessuna posizione con ID: '.$id.'</span>';
                }
            }
        ?>
        <br /><br />
        <div class= "contenitorecolonna">
        <table class="tabellacolonna">
        	<tbody>
                <tr>
                	<td><span class="filtra2">ID Impianto</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="ID Impianto" id="idimpianto2" name="idimpianto2" maxlength="11" 
                    	value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf("SELECT * FROM posizione WHERE id=".$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[3];
                                    }
                                } elseif(isset($_POST['salvare'])===true) {
                                	$idimpianto=$_POST['idimpianto2'];
                            		if(isset($idimpianto)===true){
                            			echo $idimpianto;
                           	 		}
                                }
                       		?>" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" required/></td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class= "contenitorecolonna">
          <table  class="tabellacolonna">
              <tbody>
            	<tr>
                	<td><span class="filtra2">Nome posizione</span></td>
                    <td><input class="inputfiltro2" type="text" placeholder="Nome posizione" id="nomeposizione2" name="nomeposizione2" maxlength="50" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf("SELECT * FROM posizione WHERE id=".$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[1];
                                    }
                                } elseif(isset($_POST['salvare'])===true) {
                                	$nome=$_POST['nomeposizione2'];
                            		if(isset($nome)===true){
                            			echo $nome;
                           	 		}
                                }
                       		?>" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>
                </tr>
              </tbody>
          </table>
        </div>
         <div class= "contenitorecolonna">
         	<table  class="tabellacolonna">
            	<tbody>
                    <tr>
                    	<td><span class="filtra2">Descrizione</span></td>
                    	<td><input class="inputfiltro2" type="text" placeholder="Descrizione" id="descrizione2" name="descrizione2" maxlength="100" 
                         value="<?php
                            	require 'config.php';
                                
                            	if(isset($_POST['recuperare'])===true){
                                	$query=sprintf("SELECT * FROM posizione WHERE id=".$_POST['id2']);
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo $row[2];
                                    }
                                } elseif(isset($_POST['salvare'])===true) {
                                	$descrizione=$_POST['descrizione2'];
                            		if(isset($descrizione)===true){
                            			echo $descrizione;
                           	 		}
                                }
                       		?>" /></td>
                  	</tr>
                </tbody>
            </table>
        </div>
        <?php
        	require 'config.php';
        	
        	if(isset($_POST['salvare'])===true){
                $idimpianto = $_POST['idimpianto2'];
                $nomeposizione= $_POST['nomeposizione2'];
                $descrizione= $_POST['descrizione2'];
                
            	$query=sprintf("UPDATE posizione SET nomeposizione='".$nomeposizione."', descrizione='".$descrizione."', impianto=".$idimpianto." WHERE id=".$_POST['id2']);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
				if($result === false) {
                	echo '<span class="filtra">Impossibile salvare, controllare le modifiche effettuate</span>';
                } else {
                	echo '<span class="filtra">Modifiche salvate con successo</span>';
                }
        	}
        ?>
       	<br /><br />
    	<button class="buttfiltro" name="salvare" value="salvare" type="submit" id="salvare" 
        	<?php 
           		require 'config.php';
        		$id=$_POST['id2']; 
                if(isset($id)===false){
                	echo ' disabled ';
                }
                $query=sprintf("SELECT * FROM posizione WHERE id=".$id);
                $conn = new mysqli($servername, $user, $pass, $database);
                $result = $conn->query($query);
                if($result->num_rows !== 1){
                	echo ' disabled ';
                }
        	?> 
        >Salva i dati della posizione</button>
        <input type="hidden" name="id2" id="id2" value="<?php $id=$_POST['id2']; if(isset($id)===true){echo $id;}?>">
	</form>
</body>
</html>
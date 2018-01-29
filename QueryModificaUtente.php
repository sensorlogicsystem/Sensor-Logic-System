<?php
class QueryModificaUtente{
	function modificaut($cf, $cognome, $nome, $sesso, $telefono, $datadinascita, $citta, $indirizzo, $numcivico,$provincia, $cap, $email,$id2){
    require 'config.php';
    $conn = new mysqli($servername, $user, $pass, $database);
       $query=sprintf("UPDATE utente SET cf='%s', cognome='%s', nome='%s', sesso='%s', telefono='%s', datadinascita='%s', citta='%s', indirizzo='%s', numcivico='%s', provincia='%s', cap='%s' WHERE id='%s'",mysqli_real_escape_string($conn, $cf),mysqli_real_escape_string($conn, $cognome),mysqli_real_escape_string($conn, $nome),mysqli_real_escape_string($conn, $sesso),mysqli_real_escape_string($conn, $telefono),mysqli_real_escape_string($conn, $datadinascita),mysqli_real_escape_string($conn, $citta),mysqli_real_escape_string($conn, $indirizzo),mysqli_real_escape_string($conn, $numcivico),mysqli_real_escape_string($conn, $provincia),mysqli_real_escape_string($conn, $cap),mysqli_real_escape_string($conn, $id2));
                
                $esec = $conn->query($query);
                $query=sprintf("UPDATE credenziale SET email='%s' WHERE utente='%s'",mysqli_real_escape_string($conn, $email),mysqli_real_escape_string($conn, $id2));
                $esec2 = $conn->query($query);
				if($esec === false || $esec2 === false) {
                	$str =  '<span class="filtra">Impossibile salvare, controllare le modifiche effettuate</span>';
                    echo $str;
                } else {
                	$str = '<span class="filtra">Modifiche salvate con successo</span>';
                    echo $str;
                }
	}
    
    function savedata($cf2, $cognome2, $nome2, $sesso2, $telefono2, $datadinascita2, $citta2, $indirizzo2, $numcivico2, $provincia2, $cap2, $email2){
    	
            	$cf = $cf2;
                $cognome= $cognome2;
                $nome= $nome2;
                $sesso= $sesso2;
                $telefono= $telefono2;
                $datadinascita= $datadinascita2;
                $citta=$citta2;
                $indirizzo=$indirizzo2;
                $numcivico= $numcivico2;
                $provincia= $provincia2;
                $cap= $cap2;
                $email= $email2;
                $modut= new QueryModificaUtente();
                $modut->modificaut($cf, $cognome, $nome, $sesso, $telefono, $datadinascita, $citta, $indirizzo, $numcivico,$provincia, $cap, $email, $_POST['id2']);
    }
}
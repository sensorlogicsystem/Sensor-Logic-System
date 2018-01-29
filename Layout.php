<?php
class Layout{
    function layoutop($nome, $cognome, $cf, $sesso, $telefono, $email, $datadinascita){
        $sessoM='';
        $sessoF='';
        if(isset($nome)===false){$nome='';}
        if(isset($cognome)===false){$cognome='';}
        if(isset($cf)===false){$cf='';}
        if(isset($sesso)===false){$sesso='m';}
        if(isset($sesso)===true && $sesso==='m'){$sessoM= ' selected="selected" ';}
        if(isset($sesso)===true && $sesso==='f'){$sessoF= ' selected="selected" ';}
        if(isset($telefono)===false){$telefono='';}
        if(isset($email)===false){$email='';}
        if(isset($datadinascita)===false){$datadinascita= '';}
        
        $var='';
        $var=$var.'<div class= "contenitorecolonna">';
        $var=$var.'<table class="tabellacolonna">';
        $var=$var.'<tbody>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">Nome</span></td>';
        $var=$var.'<td><input class="inputfiltro2" type="text" placeholder="Nome" id="nome" name="nome" maxlength="50" value="'.$nome.'" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required/></td>';
        $var=$var.'</tr>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">Cognome</span></td>';
        $var=$var.'<td><input class="inputfiltro2" type="text" placeholder="Cognome" id="cognome" name="cognome" maxlength="50" value="'.$cognome.'" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" required/></td>';
        $var=$var.'</tr>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">CF</span></td>';
        $var=$var.'<td><input class="inputfiltro2" type="text" placeholder="CF" id="cf" name="cf" maxlength="16" value="'.$cf.'" pattern= "^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$" title="Deve essere composto da 16 valori, seguendo il formato del cofice fiscale" required/></td>';
        $var=$var.'</tr>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">Sesso</span></td>';
        $var=$var.'<td>';
        $var=$var.'<select name="sesso" id="sesso" class="sesso" title="Selezionare il sesso" required>';
        $var=$var.'<option value="m"'.$sessoM.'>M</option>';
        $var=$var.'<option value="f" '.$sessoF.'>F</option>';
        $var=$var.'</select>';
        $var=$var.'</td>';
        $var=$var.'</tr>';
        $var=$var.'</tbody>';
        $var=$var.'</table>';
        $var=$var.'</div>';
        $var=$var.'<div class= "contenitorecolonna">';
        $var=$var.'<table  class="tabellacolonna">';
        $var=$var.'<tbody>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">Telefono</span></td>';
        $var=$var.'<td> <input class="inputfiltro2" type="text" placeholder="Telefono" id="telefono" name="telefono" maxlength="10" value="'.$telefono.'" pattern= "[0-9]{0,10}" title="Deve essere composto da soli 10 numeri" required/></td>';
        $var=$var.'</tr>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">Email</span></td>';
        $var=$var.'<td><input class="inputfiltro2" type="text" placeholder="Email" id="email" name="email" maxlength="50" value="'.$email.'" pattern= "[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Deve rispettare il formato: email@dominio.com" required/></td>';
        $var=$var.'</tr>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">Data di nascita</span></td>';
        $var=$var.'<td> <input class="inputfiltro2" type="date" placeholder="Data di nascita" id="datadinascita" name="datadinascita" value="'.$datadinascita.'" title="Deve contenere una data valida" min="1900-01-01" max="2000-01-01" required/></td>';
        $var=$var.'</tr>';
        
        return $var;
    }
    function layoubot($cap, $citta, $indirizzo, $numcivico, $provincia){
    	if(isset($cap)===false){$cap='';}
        if(isset($citta)===false){$citta='';}
        if(isset($indirizzo)===false){$indirizzo='';}
        if(isset($numcivico)===false){$numcivico='';}
        if(isset($provincia)===false){$provincia='';}
    	
        $var='';
        
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">CAP</span></td>';
        $var=$var.'<td>  <input class="inputfiltro2" type="text" placeholder="CAP" id="cap" name="cap" maxlength="5" value="'.$cap.'" pattern= "[0-9]{0,5}" title="Deve essere composto da soli 5 numeri" required/></td>';
        $var=$var.'</tr>';
        $var=$var.'</tbody>';
        $var=$var.'</table>';
        $var=$var.'</div>';

        $var=$var.'<div class= "contenitorecolonna">';
        $var=$var.'<table  class="tabellacolonna">';
        $var=$var.'<tbody>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">Città</span></td>';
        $var=$var.'<td> <input class="inputfiltro2" type="text" placeholder="citta" id="citta" name="citta" maxlength="50" value="'.$citta.'" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere"  required/></td>';
        $var=$var.'</tr>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">Indirizzo</span></td>';
        $var=$var.'<td><input class="inputfiltro2" type="text" placeholder="indirizzo" id="indirizzo" name="indirizzo" maxlength="50" value="'.$indirizzo.'" pattern= "[a-zA-Z0-9]+{0,50}" title="Deve essere composta da lettere e/o numeri" required/></td>';
        $var=$var.'</tr>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">N°Civico</span></td>';
        $var=$var.'<td><input class="inputfiltro2" type="text" placeholder="numcivico" id="numcivico" name="numcivico" maxlength="50" value="'.$numcivico.'" pattern="[a-zA-Z0-9]+{0,50}"title="Deve essere composta da lettere e/o numeri" required/></td>';
        $var=$var.'</tr>';
        $var=$var.'<tr>';
        $var=$var.'<td><span class="filtra2">Provincia</span></td>';
        $var=$var.'<td><input class="inputfiltro2" type="text" placeholder="Provincia" id="provincia" name="provincia" maxlength="2" value="'.$provincia.'" pattern= "[A-Za-z]{0,2}" title="Deve contenere 2 lettere" required/></td>';
        $var=$var.'</tr>';
        $var=$var.'</tbody>';
        $var=$var.'</table>';
        $var=$var.' </div>';
        
        return $var;    
    }
    
    function layoutSearch($id, $nome, $cognome, $email, $citta){
    	if(isset($id)===false){$id='';}
        if(isset($nome)===false){$nome='';}
        if(isset($cognome)===false){$cognome='';}
        if(isset($email)===true){$email='' ;}
        if(isset($citta)===false){$citta='';}
          $var='';
          $var=$var.'<span class="filtra"> Filtra per:</span>';
          $var=$var.'<input class="inputfiltro" type="text" placeholder="Id" id="id" name="id" maxlength="11" value="'.$id.'" pattern= "[0-9]{0,11}" title="Deve essere composto da soli numeri" />';
          $var=$var.'<input class="inputfiltro" type="text" placeholder="Nome" id="nome" name="nome" maxlength="50" value="'.$nome.'" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" />';
          $var=$var.'<input class="inputfiltro" type="text" placeholder="Cognome" id="cognome" name="cognome" maxlength="50" value="'.$cognome.'" pattern= "[A-Za-z]{0,50}" title="Deve essere composto da sole lettere" />';
          $var=$var.'<input class="inputfiltro" type="text" placeholder="Email" id="email" name="email" maxlength="50" value="'.$email.'"  pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" title="Deve rispettare il formato: email@dominio.com"/>';
          $var=$var.'<input class="inputfiltro" type="text" placeholder="Città" id="citta" name="citta" maxlength="50" value="'.$citta.'" pattern= "[A-Za-z]{0,50}" title="Deve essere composta da sole lettere" />';
          $var=$var.'<button class="buttfiltro" name="filtro" value="filtro" type="submit" id="filtro">Ricerca</button>';
          $var=$var.'<div class="positiontable">';
           $var=$var.'<table class="tabellaClienti">';
                $var=$var.'<thead>';
                  $var=$var.'<tr>';
                    $var=$var.'<th>Id</th>';
                    $var=$var.'<th>CF</th>';
                    $var=$var.'<th>Nome</th>';
                    $var=$var.'<th>Cognome</th>';
                    $var=$var.'<th>Email</th>';
                    $var=$var.'<th>Telefono</th>';
                    $var=$var.'<th>Città</th>';
                    $var=$var.'<th>Indirizzo</th>';
                    $var=$var.'<th>N°Civico</th>';
                    $var=$var.'<th>CAP</th>';
                    $var=$var.'<th>Provincia</th>';
                    $var=$var.'<th>Data di nascita</th>';
                    $var=$var.'<th>Sesso</th>';
                    $var=$var.'<th></th>';
                  $var=$var.'</tr>';
                $var=$var.'</thead>';
                
                return $var;
    }
    
}
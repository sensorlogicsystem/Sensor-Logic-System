<?php
class OperazioniPDF{
    function intestazionePdf($date, $idr, $ids, $tipo, $nomeposizione, $marca){
        $msg='';

        if(empty($idr)===false || empty($data)===false || empty($ids)===false || empty($tipo)===false || empty($marca)===false || empty($nomeposizione)===false){
            $msg="\n".'Filtrate per:  ';
        }
        if(empty($idr)===false){
            $msg=$msg.'  Id Rilevazione:'.$idr;
        }
        if(empty($date)===false){
            $msg=$msg.'  Data Rilevazione:'.$date;
        }
        if(empty($ids)===false){
            $msg=$msg.'  Id Sensore:'.$ids;
        }
        if(empty($tipo)===false){
            $msg=$msg.'  Tipo Sensore:'.$tipo;
        }
        if(empty($marca)===false){
            $msg=$msg.'  Marca Sensore:'.$marca;
        }
        if(empty($nomeposizione)===false){
            $msg=$msg.'  Nome Posizione:'.$nomeposizione;
        }
    return $msg;
    }

    function queryPdf($idr, $ids, $tipo, $nomeposizione, $marca, $impianto, $email){

        $query = sprintf("SELECT rilevazione.id, rilevazione.rilevazione, sensore.id, sensore.tipo, sensore.marca, posizione.nomeposizione FROM rilevazione inner join sensore on rilevazione.sensore=sensore.id inner join posizione on sensore.posizione=posizione.id inner join impianto on posizione.impianto=impianto.id inner join utente on impianto.proprietario= utente.id inner join credenziale on utente.id=credenziale.utente WHERE impianto.nomeimpianto ='%s' and credenziale.email='%s'", $impianto, $email);
        if(!empty($idr) === true) {
            $query = $query.sprintf(" and  rilevazione.id= '%s'",$idr);
        }
        if(!empty($ids) === true) {
            $query = $query.sprintf(" and  sensore.id= '%s'",$ids);
        }
        if(!empty($tipo) === true) {
            $query = $query.sprintf(" and  sensore.tipo= '%s'",$tipo);
        }
        if(!empty($marca) === true) {
            $query = $query.sprintf(" and  sensore.marca= '%s'",$marca);
        }
        if(!empty($nomeposizione) === true){
            $query = $query.sprintf(" and posizione.nomeposizione = '%s'",$nomeposizione);
        }
        $query = $query.sprintf(' order by rilevazione.id');
        return $query;
    }
}
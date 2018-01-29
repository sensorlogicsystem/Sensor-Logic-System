<?php 
class Rilevazioni{
	function view($row){
    	$str = '<tr>';
        $str = $str.'<td>'.htmlspecialchars($row[ZERO]).'</td>';
        $str = $str.'<td>'.substr(htmlspecialchars($row[UNO]),ZERO,QUATTRO).'-'.substr(htmlspecialchars($row[UNO]),QUATTRO,DUE).'-'.substr(htmlspecialchars($row[UNO]),SEI,DUE).'</td>';
        $str = $str.'<td>'.substr(htmlspecialchars($row[UNO]),OTTO,DUE).':'.substr(htmlspecialchars($row[UNO]),DIECI,DUE).'</td>';
        $str = $str.'<td>'.substr(htmlspecialchars($row[UNO]),DODICI).'</td>';
        $str = $str.'<td>'.htmlspecialchars($row[DUE]).'</td>';
        $str = $str.'<td>'.htmlspecialchars($row[TRE]).'</td>';
        $str = $str.'<td>'.htmlspecialchars($row[QUATTRO]).'</td>';
        $str = $str.'<td>'.htmlspecialchars($row[CINQUE]).'</td>';
        $str = $str.'</tr>';
        echo $str;
    }
}
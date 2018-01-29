<?php
class Recuperare{
	function recovery($query,$salvare, $provincia ,$recuperare){
    if(isset($recuperare)===true){
                                	require 'config.php';
                                    require 'constants.php';
                					$conn = new mysqli($servername, $user, $pass, $database);
                					$result = $conn->query($query);
                                    if($result->num_rows === 1) {
                                    	$row = mysqli_fetch_row($result);
                   						echo htmlspecialchars($row[DIECI]);
                                    }
                                } else{if(isset($salvare)===true) {
                            		if(isset($provincia)===true){
                            			echo $provincia;
                           	 		}
                                }}
    }
}
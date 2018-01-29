<?php    
	$conn = '';
	$servername   = 'localhost';
	$database = 'my_sensorlogicsystemlogin';
	$user = 'sensorlogicsystemlogin';
	$pass = '';
    
    if($conn === '') {
    	$conn = new mysqli($servername, $user, $pass, $database);
    }
    return $conn;
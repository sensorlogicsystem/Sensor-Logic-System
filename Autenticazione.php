<?php
class Autenticazione{
  function autenticazione(){
    require 'config.php';

        
        $conn = '';
        session_start();
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
        if($conn === '') {
            $conn = new mysqli($servername, $user, $pass, $database);
        }
        $query = sprintf("SELECT * FROM credenziale where email='%s' and password='%s'",mysqli_real_escape_string($conn, $email),mysqli_real_escape_string($conn, $password));

        $result = $conn->query($query);
        if($result === false || $result->num_rows !== 1){
                header('Location: http://sensorlogicsystemlogin.altervista.org/index.php');
        }
  }
}
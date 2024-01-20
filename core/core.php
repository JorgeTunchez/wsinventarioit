<?php 

function getConexion(){
    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $dbname = "inventarioit";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        return $conn;
    }
}

function executeQuery($strQuery){
    if( $strQuery!='' ){
        $conn = getConexion();
        $result = mysqli_query($conn, $strQuery);
        mysqli_close($conn);
        return $result;
    }
}

?>
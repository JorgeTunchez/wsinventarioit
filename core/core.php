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


function wsRespuesta($httpCodigo, $codigoRes, $descripcionRes, $arrDatos = array()){

    header('Content-Type: application/json');
    if( $httpCodigo == 200){
        header("HTTP/1.1 200 OK");
    }else{
        header("HTTP/1.1 500 Internal Server Error");
    }
    $arrJson["codigoRespuesta"] = $codigoRes;
    $arrJson["descripcionRespuesta"] = $descripcionRes;
    if( count($arrDatos)>0 ){
        $arrJson["detalle"] = $arrDatos;
    }
    
    $jsonSalida = json_encode($arrJson,true);
    echo json_encode($arrJson, true);
}

?>
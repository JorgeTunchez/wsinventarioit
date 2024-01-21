<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
date_default_timezone_set("America/Guatemala");

include("model/wsinventarioitmodel.php");
$data = json_decode(file_get_contents('php://input'), true);

if( isset($data['cif']) ){
    $cif = trim($data['cif']);
    if( $cif != ''){
        $arrDatos = obtenerData($cif);
        if( count($arrDatos)>0 ){
            echo json_encode($arrDatos, true);
        }else{
            header('Content-Type: application/json');
            header("HTTP/1.1 500 Internal Server Error");
            $arrJson["respuesta"] = "No se encontraron datos con el cif ingresado.";
            $jsonSalida = json_encode($arrJson,true);
            echo json_encode($arrJson, true);
        }
        
    }else{
        header('Content-Type: application/json');
        header("HTTP/1.1 500 Internal Server Error");
        $arrJson["respuesta"] = "El campo cif se ingreso vacio.";
        $jsonSalida = json_encode($arrJson,true);
        echo json_encode($arrJson, true);
    }
}else{
    header('Content-Type: application/json');
    header("HTTP/1.1 500 Internal Server Error");
    $arrJson["respuesta"] = "Debe ingresar el campo cif en el json de entrada.";
    $jsonSalida = json_encode($arrJson, true);
    echo json_encode($arrJson, true);
}
?>
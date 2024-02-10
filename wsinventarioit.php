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
    if( $cif != '' ){
        $arrDatos = obtenerData($cif);
        if( count($arrDatos)>0 ){
            wsRespuesta(200, 0, "", $arrDatos);
        }else{
            wsRespuesta(500, 0, "No se encontraron datos con el cif ingresado.");
        }
    }else{
        wsRespuesta(500, 0, "El campo cif se ingreso vacio.");
    }
}else{
    wsRespuesta(500, 0, "Error en el json de entrada.");
}
?>
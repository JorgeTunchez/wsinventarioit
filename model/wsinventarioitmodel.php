<?php 

include("core/core.php");

function obtenerData($id){
    $arrDatos = array();
    $sql = "SELECT CONCAT(colaborador.nombres,' ',colaborador.apellidos) nombre_completo,
                   colaborador.cif,
                   colaborador.puesto,
                   area.nombre area,
                   expedientes.nombreequipo, 
                   expedientes.direccionip,
                   expedientes.dominio,
                   expedientes.usuario,
                   CASE WHEN colaborador.activo = 1 THEN 'Si' ELSE 'No' END activo
              FROM colaborador
                   INNER JOIN area ON colaborador.area = area.id
                   INNER JOIN expedientes ON expedientes.colaborador = colaborador.id
             WHERE colaborador.id = $id";
    $result = executeQuery($sql);
    if (!empty($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $arrDatos["DATOS_PERSONALES"]["NOMBRE_COMPLETO"] = $row["nombre_completo"];
            $arrDatos["DATOS_PERSONALES"]["CIF"] = $row["cif"];
            $arrDatos["DATOS_PERSONALES"]["PUESTO"] = $row["puesto"];
            $arrDatos["DATOS_PERSONALES"]["AREA"] = $row["area"];
            $arrDatos["DATOS_DOMINIO"]["NOMBRE_EQUIPO"] = $row["nombreequipo"];
            $arrDatos["DATOS_DOMINIO"]["DIRECCION_IP"] = $row["direccionip"];
            $arrDatos["DATOS_DOMINIO"]["DOMINIO"] = $row["dominio"];
            $arrDatos["DATOS_DOMINIO"]["USUARIO"] = $row["usuario"];
            $arrDatos["DATOS_DOMINIO"]["ACTIVO"] = $row["activo"];
        }
    }

    return $arrDatos;
}

?>
<?php 
include("core/core.php");


function obtenerHardware($expediente){
    $arrDatos = array();
    $sql = "  SELECT componente.nombre nombrecomponente, 
                     expediente_detail.marca, 
                     CASE WHEN expediente_detail.valor='-' THEN '' ELSE expediente_detail.valor END valor,
                     expediente_detail.serie,
                     expediente_detail.modelo,
                     expediente_detail.linea,
                     expediente_detail.anio  
                FROM expediente_detail 
                     INNER JOIN componente ON expediente_detail.componente = componente.id
                     INNER JOIN categoria ON componente.categoria = categoria.id
               WHERE expediente_detail.expediente = $expediente
                 AND categoria.id = 1";
    $result = executeQuery($sql);
    if (!empty($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $arrDatos[$row["nombrecomponente"]]["MARCA"] = $row["marca"];
            $arrDatos[$row["nombrecomponente"]]["VALOR"] = $row["valor"];
            $arrDatos[$row["nombrecomponente"]]["SERIE"] = $row["serie"];
            $arrDatos[$row["nombrecomponente"]]["MODELO"] = $row["modelo"];
            $arrDatos[$row["nombrecomponente"]]["LINEA"] = $row["linea"];
            $arrDatos[$row["nombrecomponente"]]["AÑO"] = $row["anio"];
        }
    }
    return $arrDatos;
}


function obtenerSoftware($expediente){
    $arrDatos = array();
    $sql = "SELECT TRIM(componente.nombre) software, 
                   CASE WHEN expediente_detail.pago = 1 THEN 'Si' ELSE 'No' END pago
              FROM expediente_detail 
                   INNER JOIN componente ON expediente_detail.componente = componente.id
                   INNER JOIN categoria ON componente.categoria = categoria.id
             WHERE expediente_detail.expediente = $expediente
               AND categoria.id = 2
          ORDER BY componente.nombre";
    $result = executeQuery($sql);
    if (!empty($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $arrDatos[$row["software"]]["PAGO"] = $row["pago"];
        }
    }
    return $arrDatos;
}


function obtenerPlataformas($expediente){
    $arrDatos = array();
    $sql = "SELECT TRIM(componente.nombre) plataforma, 
                   CASE WHEN expediente_detail.pago = 1 THEN 'Si' ELSE 'No' END pago
              FROM expediente_detail 
                   INNER JOIN componente ON expediente_detail.componente = componente.id
                   INNER JOIN categoria ON componente.categoria = categoria.id
             WHERE expediente_detail.expediente = $expediente
               AND categoria.id = 5
          ORDER BY componente.nombre";
    $result = executeQuery($sql);
    if (!empty($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $arrDatos[$row["plataforma"]]["PAGO"] = $row["pago"];
        }
    }
    return $arrDatos;
}


function obtenerData($cif){
    $arrDatos = array();
    $sql = "SELECT CONCAT(TRIM(colaborador.nombres),' ',TRIM(colaborador.apellidos)) nombre_completo,
                   colaborador.cif,
                   colaborador.puesto,
                   area.nombre area,
                   expedientes.nombreequipo, 
                   expedientes.direccionip,
                   expedientes.dominio,
                   expedientes.usuario,
                   CASE WHEN colaborador.activo = 1 THEN 'Si' ELSE 'No' END activo,
                   expedientes.id expediente
              FROM colaborador
                   INNER JOIN area ON colaborador.area = area.id
                   INNER JOIN expedientes ON expedientes.colaborador = colaborador.id
             WHERE colaborador.cif = $cif";
    $result = executeQuery($sql);
    if (!empty($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $arrDatos["INVENTARIO_IT"]["CIF"] = $row["cif"];
            $arrDatos["INVENTARIO_IT"]["NOMBRE_COMPLETO"] = $row["nombre_completo"];
            $arrDatos["INVENTARIO_IT"]["PUESTO"] = $row["puesto"];
            $arrDatos["INVENTARIO_IT"]["AREA"] = $row["area"];
            $arrDatos["INVENTARIO_IT"]["ACTIVO"] = $row["activo"];
            $arrDatos["INVENTARIO_IT"]["ACTIVE_DIRECTORY"]["NOMBRE_EQUIPO"] = $row["nombreequipo"];
            $arrDatos["INVENTARIO_IT"]["ACTIVE_DIRECTORY"]["DIRECCION_IP"] = $row["direccionip"];
            $arrDatos["INVENTARIO_IT"]["ACTIVE_DIRECTORY"]["DOMINIO"] = $row["dominio"];
            $arrDatos["INVENTARIO_IT"]["ACTIVE_DIRECTORY"]["USUARIO"] = $row["usuario"];
            $arrDatos["INVENTARIO_IT"]["HARDWARE"] = obtenerHardware($row["expediente"]);
            $arrDatos["INVENTARIO_IT"]["SOFTWARE"] = obtenerSoftware($row["expediente"]);
            $arrDatos["INVENTARIO_IT"]["PLATAFORMAS"] = obtenerPlataformas($row["expediente"]);
        }
    }

    return $arrDatos;
}

?>
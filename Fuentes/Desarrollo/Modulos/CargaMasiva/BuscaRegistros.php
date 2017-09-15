<?php
require("../../config/parametros.php");
//http://localhost:8080/proyecto-memre/Fuentes/Desarrollo/Modulos/CargaMasiva/BuscaRegistros.php
$depurar = 0; // Cambiar a 1 para ver el detalle
$aaData = array();

$query = "SELECT `HIS_ID`, `TEM_MONTO`, `TEM_NOMBRE`, `TEM_ANNO`, `TEM_BIP`, 
                 `TEM_FUENTE`, `TEM_ETAPA`, `TEM_CUENTA`, `TEM_ENERO`, `TEM_FEBRERO`, 
                 `TEM_MARZO`, `TEM_ABRIL`, `TEM_MAYO`, `TEM_JUNIO`, `TEM_JULIO`, `TEM_AGOSTO`, 
                 `TEM_SEPTIEMBRE`, `TEM_OCTUBRE`, `TEM_NOVIEMBRE`, `TEM_DICIEMBRE`, `TEM_UNI_TEC`, 
                 `TEM_NUMERO_COLUMNA`, `TEM_ANNO`, `TEM_ERRORES` FROM `tmm_temporal`";


$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);

if($mySqli->connect_errno)
{
    $aErrores["Error conexion MySql"] = $mySqli->connect_error;
}
$mySqli->query("SET CHARSET 'utf8'");
$res = $mySqli->query($query);

if($mySqli->affected_rows > 0)
{
    while($row = $res->fetch_assoc())
    {
        $aaData[] = array(  
                            "<img src='../../css/Search.png' onclick='verDetalle(".$row['HIS_ID'].")' />", // Ver
                            (isset($row['TEM_ERRORES']) && strlen($row['TEM_ERRORES']) > 0 ) ? "<img src='../../css/nocheck.png' onclick='verError(".$row['HIS_ID'].")' />" : "<img src='../../css/check.png' />", // Estado                    
                            $row['TEM_NUMERO_COLUMNA'], //N° Columna
                            $row['TEM_ANNO'], // Año
                            substr($row['TEM_NOMBRE'], 0, 15)."...", // Nombre
                            $row['TEM_ETAPA'], // Etapa
                            $row['TEM_CUENTA'], // Cuenta
                            $row['TEM_UNI_TEC'], // Unidad Tecnica
                            $row['HIS_ID'] // Id
                        );
     }
  
}

$aa = array(
     'sEcho' => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        'aaData' => $aaData);

if($depurar)
{
    echo "<span>";
    echo var_dump($aaData);
    echo "</span>";
    echo "<span>";
    echo var_dump($aa);
    echo "</span>";
   die;
}
        
echo json_encode($aa);

?>
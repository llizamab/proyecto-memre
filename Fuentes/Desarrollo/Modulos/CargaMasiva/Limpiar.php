<?php
require("../../config/parametros.php");

$data = array();
$msg = "";

$targetDir = $DIR_EXCEL;

if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
    while (($file = readdir($dir)) !== false) {
        $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
        if (preg_match('/\.xls/', $file)){
            $data[] = $tmpfilePath;    
        }
    }
    @unlink($data[0]);
}

$query = "DELETE FROM `tmm_temporal`";


$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);

if($mySqli->connect_errno)
{
    $aErrores["Error conexion MySql"] = $mySqli->connect_error;
}
$mySqli->query("SET CHARSET 'utf8'");
$res = $mySqli->query($query);

if($mySqli->affected_rows > 0){
	$msg = "Se han limpiado los temporales correctamente";
}
else{
	$msg = "No hay temporales que limpiar";
}

if($depurar == TRUE)
{
    $data["html"] = "$msg";
}
else 
{
    $data["html"] = $msg;
}
echo json_encode($data);
?>
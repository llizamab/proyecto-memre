<?php

error_reporting(TRUE);
set_time_limit(0);
require_once("comunes.php");
/* Archivo de configuracion */
//$url = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
$url = "http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
// Aqui se debe definir bien la ruta del fichero de configuracion
$sXmlConfig = "$url/proyecto-memre/Fuentes/Desarrollo/config/Config.xml";;
$xml = simplexml_load_file($sXmlConfig);

// Funcion para registrar las excepciones de la aplicacion en un fichero de log
function exception_handler($exception) {

  $fp = fopen("log.txt","a+");
  fwrite($fp, "*******************************************".PHP_EOL);
  fwrite($fp, date("Y-m-d H:i:s").PHP_EOL);
  fwrite($fp, "Fichero : ".$exception->getFile().PHP_EOL);
  fwrite($fp, "Linea   : ".$exception->getLine().PHP_EOL);
  fwrite($fp, "Mensaje : ".$exception->getMessage().PHP_EOL);
  fwrite($fp, $exception->getTraceAsString().PHP_EOL);
  fwrite($fp, "*******************************************".PHP_EOL);
  fclose($fp);
}

//set_exception_handler('exception_handler');

//throw new Exception("Error Processing Request", 1);


/* Variables de base de datos */
$V_HOST = $xml->Host;
$V_USER = $xml->User;
$V_PASS = $xml->Password;
$V_BBDD = $xml->BBDD;

/* Variables de configuracion */
$DIR_EXCEL = $xml->rutaExcel;

$COLUMNAS = array(
       $xml->COL_FUENTE,
       $xml->COL_BIP,
       $xml->COL_ETAPA,
       $xml->COL_CUENTA,
       $xml->COL_NOMBRE,
       $xml->COL_ENERO,
       $xml->COL_FEBRERO,
       $xml->COL_MARZO,
       $xml->COL_ABRIL,
       $xml->COL_MAYO,
       $xml->COL_JUNIO,
       $xml->COL_JULIO,
       $xml->COL_AGOSTO,
       $xml->COL_SEPTIEMBRE,
       $xml->COL_OCTUBRE,
       $xml->COL_NOVIEMBRE,
       $xml->COL_DICIEMBRE,
       $xml->COL_UNIDAD_TECNICA,
       $xml->COL_ANNIO
    );

$COLUMNAS_MSJ = array(
       $xml->MSJ_FUENTE,
       $xml->MSJ_BIP,
       $xml->MSJ_ETAPA,
       $xml->MSJ_CUENTA,
       $xml->MSJ_NOMBRE,
       $xml->MSJ_ENERO,
       $xml->MSJ_FEBRERO,
       $xml->MSJ_MARZO,
       $xml->MSJ_ABRIL,
       $xml->MSJ_MAYO,
       $xml->MSJ_JUNIO,
       $xml->MSJ_JULIO,
       $xml->MSJ_AGOSTO,
       $xml->MSJ_SEPTIEMBRE,
       $xml->MSJ_OCTUBRE,
       $xml->MSJ_NOVIEMBRE,
       $xml->MSJ_DICIEMBRE,
       $xml->MSJ_UNIDAD_TECNICA,
       $xml->MSJ_ANNIO
);
/* Variables para mostrar trazas */
$depurar = FALSE; 
if($xml->depurarSQL == "1")
{
    $depurar = TRUE;
}
$depurarMax = FALSE; 
if($xml->depurarDUMP == "1")
{
    $depurarMax = TRUE;
    error_reporting(E_ALL | E_STRICT);
}

?>
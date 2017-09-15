<?php
require("../../config/parametros.php");

$data = array();
$msg = "";

$msg = $_POST['ID'];

$ID = (isset($_POST['ID']))?$_POST['ID']:NULL;

$query = "SELECT `TEM_ERRORES` FROM `tmm_temporal` where HIS_ID = $ID";

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
        $msg = $row["TEM_ERRORES"];
    }
}

$errores = explode("#", $msg);
$msg = "<div><ul>";
foreach ($errores as $value) {
	//$msg .= "<li><img src='../../css/nocheck.png' >&nbsp;".$value."</li>";
	$msg .= "<li>&nbsp;".$value."</li>";
}
$msg .= "</ul></div>";

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
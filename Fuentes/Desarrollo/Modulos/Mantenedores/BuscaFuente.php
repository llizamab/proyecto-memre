<?php
require("../../config/parametros.php");

$depurar = 0; // Cambiar a 1 para ver el detalle
$aaData = array();
$Info_usuario = array();
$aErrores = array();

$Info_usuario['FUE_ID'] = (isset($_POST['FormRegRecIDRec']))?$_POST['FormRegRecIDRec']:NULL;
$Info_usuario['FUE_NOMBRE'] = (isset($_POST['FormRegRecNomRec']))?$_POST['FormRegRecNomRec']:NULL;

    $query = "SELECT FUE_ID, 
                     FUE_NOMBRE
              FROM TMM_FUENTE
              WHERE FUE_ID = FUE_ID ";

    if($Info_usuario["FUE_ID"] != NULL)
    {
        $query.="AND FUE_ID = ".$Info_usuario["FUE_ID"];
    }
    if($Info_usuario["FUE_NOMBRE"] != NULL)
    {
        $query.="AND FUE_NOMBRE LIKE '%".$Info_usuario["FUE_NOMBRE"]."%'";
    }

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
                    $row['FUE_ID'],
                    $row['FUE_NOMBRE']
                );
        }
    }

$aa = array(
     'sEcho' => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        'aaData' => $aaData);

if($depurar) // Detalle http://localhost:8080/proyecto-memre/Fuentes/Desarrollo/Modulos/Mantenedores/BuscaFuente.php
{
    echo "<span>";
    echo var_dump($_POST);
    echo "</span>";
    echo "<span>";
    echo var_dump($Info_usuario);
    echo "</span>";
    echo "<span>";
    echo var_dump($aErrores);
    echo "</span>";
    echo "<span>";
    echo var_dump($aa);
    echo "</span>";
   die;
}

echo json_encode($aa);

?>
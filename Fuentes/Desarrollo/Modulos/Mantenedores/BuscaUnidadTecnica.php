<?php
require("../../config/parametros.php");

$depurar = 0; // Cambiar a 1 para ver el detalle
$aaData = array();
$Info_usuario = array();
$aErrores = array();

$Info_usuario['UTEC_ID'] = (isset($_POST['FormRegPerIDPer']))?$_POST['FormRegPerIDPer']:NULL;
$Info_usuario['UTEC_NOMBRE'] = (isset($_POST['FormRegPerNomPer']))?$_POST['FormRegPerNomPer']:NULL;

    $query = "SELECT UTEC_ID, 
                     UTEC_NOMBRE
              FROM TMM_UNIDAD_TECNICA
              WHERE UTEC_ID = UTEC_ID ";

    if($Info_usuario["UTEC_ID"] != NULL)
    {
        $query.="AND UTEC_ID = ".$Info_usuario["UTEC_ID"];
    }
    if($Info_usuario["UTEC_NOMBRE"] != NULL)
    {
        $query.="AND UTEC_NOMBRE LIKE '%".$Info_usuario["UTEC_NOMBRE"]."%'";
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
                    $row['UTEC_ID'],
                    $row['UTEC_NOMBRE']
                );
        }
    }

$aa = array(
     'sEcho' => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        'aaData' => $aaData);

if($depurar) // Detalle http://localhost:8080/proyecto-memre/Fuentes/Desarrollo/Modulos/Mantenedores/BuscaUnidadTecnica.php
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
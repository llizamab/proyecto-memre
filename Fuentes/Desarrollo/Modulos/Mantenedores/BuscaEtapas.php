<?php
require("../../config/parametros.php");

$depurar = 0; // Cambiar a 1 para ver el detalle
$aaData = array();
$Info_usuario = array();
$aErrores = array();

$Info_usuario['ETA_ID'] = (isset($_POST['FormRegUsuIDUsu']))?$_POST['FormRegUsuIDUsu']:NULL;
$Info_usuario['ETA_NOMBRE'] = (isset($_POST['FormRegUsuNomUsu']))?$_POST['FormRegUsuNomUsu']:NULL;

    $query = "SELECT ETA_ID, 
                     ETA_NOMBRE
              FROM TMM_ETAPA
              WHERE ETA_ID = ETA_ID ";

    if($Info_usuario["ETA_ID"] != NULL)
    {
        $query.="AND ETA_ID = ".$Info_usuario["ETA_ID"];
    }
    if($Info_usuario["ETA_NOMBRE"] != NULL)
    {
        $query.="AND ETA_NOMBRE LIKE '%".$Info_usuario["ETA_NOMBRE"]."%'";
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
                    $row['ETA_ID'],
                    $row['ETA_NOMBRE']
                );
        }
    }

$aa = array(
     'sEcho' => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        'aaData' => $aaData);

if($depurar) // Detalle http://localhost:8080/proyecto-memre/Fuentes/Desarrollo/Modulos/Mantenedores/BuscaEtapas.php
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
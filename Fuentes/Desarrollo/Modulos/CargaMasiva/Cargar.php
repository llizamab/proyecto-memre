<?php
require("../../config/parametros.php");
$depurar = 0;
$data = array();
$aErrores = array();
$msg = "";

$mySqli = new mysqli($V_HOST, $V_USER, $V_PASS, $V_BBDD);
if($mySqli->connect_errno)
{
    $aErrores["Error conexion MySql"] = $mySqli->connect_error;
}

//$mySqli->query("SET CHARSET 'utf8'");
//$mySqli->query("SET NAMES 'cp1250'");

$query_select = "SELECT `HIS_ID`, 
				        `TEM_MONTO`, 
				        `TEM_NOMBRE`, 
                        `TEM_ANNO`, 
                        `TEM_BIP`, 
                        `TEM_FUENTE`, 
                        `TEM_ETAPA`, 
                        `TEM_CUENTA`, 
                        `TEM_ENERO`, 
                        `TEM_FEBRERO`, 
                        `TEM_MARZO`, 
                        `TEM_ABRIL`, 
                        `TEM_MAYO`, 
                        `TEM_JUNIO`, 
                        `TEM_JULIO`, 
                        `TEM_AGOSTO`, 
                        `TEM_SEPTIEMBRE`, 
                        `TEM_OCTUBRE`, 
                        `TEM_NOVIEMBRE`, 
                        `TEM_DICIEMBRE`, 
                        `TEM_UNI_TEC`, 
                        `TEM_NUMERO_COLUMNA`
                 FROM `tmm_temporal`";
			
$res = $mySqli->query($query_select);
$contador = 0;

if($mySqli->affected_rows > 0)
{
	while($row = $res->fetch_assoc())
    {
    	// Por cada registro, lo voy traspasando a las tablas respectivas TMM_INICIATIVA y TMM_PROGRAMACION
    	
    	// Sumo el monto
    	$UTEC_ID = NULL;
    	$FUE_ID = NULL;
    	$ETA_ID = NULL;
    	$INI_ID = NULL;
    	$monto = intval($row["TEM_ENERO"]) +
    	         intval($row["TEM_FEBRERO"]) +
    	         intval($row["TEM_MARZO"]) +
    	         intval($row["TEM_ABRIL"]) +
    	         intval($row["TEM_MAYO"]) +
    	         intval($row["TEM_JUNIO"]) +
    	         intval($row["TEM_JULIO"]) +
    	         intval($row["TEM_AGOSTO"]) +
    	         intval($row["TEM_SEPTIEMBRE"]) +
    	         intval($row["TEM_OCTUBRE"]) +
    	         intval($row["TEM_NOVIEMBRE"]) +
    	         intval($row["TEM_DICIEMBRE"])
    	         ;
    	
    	// obtengo el id de la TMM_UNIDAD_TECNICA (UTEC_ID)
    	$query_UT = "SELECT UTEC_ID FROM TMM_UNIDAD_TECNICA WHERE UTEC_NOMBRE = '".$row["TEM_UNI_TEC"]."'";

    	$out = $mySqli->query($query_UT);
    	if($mySqli->affected_rows > 0) // Si existe obtengo el id
		{
			$fila = $out->fetch_assoc();
			$UTEC_ID = $fila["UTEC_ID"];
		}
		else // si no existe la inserto y obtengo el id
		{ 
			$insert = "INSERT INTO TMM_UNIDAD_TECNICA (UTEC_NOMBRE) VALUES ('".$row["TEM_UNI_TEC"]."')";
			$mySqli->query($insert);
			$UTEC_ID = $mySqli->insert_id;
		}
    	
    	// obtengo el id de la TMM_FUENTE (FUE_ID)
    	$query_F = "SELECT FUE_ID FROM TMM_FUENTE WHERE FUE_NOMBRE = '".$row["TEM_FUENTE"]."'";

    	$out = $mySqli->query($query_F);
    	if($mySqli->affected_rows > 0) // Si existe obtengo el id
		{
			$fila = $out->fetch_assoc();
			$FUE_ID = $fila["FUE_ID"];
		}
		else // si no existe la inserto y obtengo el id
		{ 
			$insert = "INSERT INTO TMM_FUENTE (FUE_NOMBRE) VALUES ('".$row["TEM_FUENTE"]."')";
			$mySqli->query($insert);
			$FUE_ID = $mySqli->insert_id;
		}
    	
    	// obtengo el id de la TMM_ETAPA (ETA_ID)
    	$query_E = "SELECT ETA_ID FROM TMM_ETAPA WHERE ETA_NOMBRE = '".$row["TEM_ETAPA"]."'";

    	$out = $mySqli->query($query_E);
    	if($mySqli->affected_rows > 0) // Si existe obtengo el id
		{
			$fila = $out->fetch_assoc();
			$ETA_ID = $fila["ETA_ID"];
		}
		else // si no existe la inserto y obtengo el id
		{ 
			$insert = "INSERT INTO TMM_ETAPA (ETA_NOMBRE) VALUES ('".$row["TEM_ETAPA"]."')";
			$mySqli->query($insert);
			$ETA_ID = $mySqli->insert_id;
		}

    	//  obtengo el id de la TMM_INICIATIVA (INI_ID)
    	$query_insert_ini = "INSERT INTO TMM_INICIATIVA (FUE_ID,
    	                                                 UTEC_ID,
    	                                                 ETA_ID,
    	                                                 INI_BIP,
    	                                                 INI_ANNO,
    	                                                 INI_PROYECTO,
    	                                                 INI_CLASIFICADOR,
    	                                                 INI_MONTO) 
    	                     VALUES 
    	                                                 ($FUE_ID,
														  $UTEC_ID,
														  $ETA_ID,
														  ".$row["TEM_BIP"].",
														  ".$row["TEM_ANNO"].",
														  '".$row["TEM_NOMBRE"]."',
														  0,
														  $monto)";
		
		$mySqli->query($query_insert_ini);
		$INI_ID = $mySqli->insert_id;
    	
		// inserto la TMM_PROGRAMACION con el INI_ID
		
		$query_insert_pro = "INSERT INTO TMM_PROGRAMACION (INI_ID,
    	                                                 PRO_ENERO,
    	                                                 PRO_FEBRERO,
    	                                                 PRO_MARZO,
    	                                                 PRO_ABRIL,
    	                                                 PRO_MAYO,
    	                                                 PRO_JUNIO,
    	                                                 PRO_JULIO,
														 PRO_AGOSTO,
														 PRO_SEPTIEMBRE,
														 PRO_OCTUBRE,
														 PRO_NOVIEMBRE,
														 PRO_DICIEMBRE) 
    	                     VALUES 
    	                                                 ($INI_ID,
														  ".$row["TEM_ENERO"].",
														  ".$row["TEM_FEBRERO"].",
														  ".$row["TEM_MARZO"].",
														  ".$row["TEM_ABRIL"].",
														  ".$row["TEM_MAYO"].",
														  ".$row["TEM_JUNIO"].",
														  ".$row["TEM_JULIO"].",
														  ".$row["TEM_AGOSTO"].",
														  ".$row["TEM_SEPTIEMBRE"].",
														  ".$row["TEM_OCTUBRE"].",
														  ".$row["TEM_NOVIEMBRE"].",
														  ".$row["TEM_DICIEMBRE"].")";
    	$mySqli->query($query_insert_pro);
    	//$aErrores[] = $query_insert_pro;
    	//  Continuo iterando
    	$contador++;
	}
	$delete = "DELETE FROM TMM_TEMPORAL";
    $mySqli->query($delete);
	$msg = "Se ha realizado la carga masiva exitosamente!
	        Registros cargados: $contador";
	$data["estado"] = "OK";
}
else{
	$msg = "No hay datos para la carga masiva";
	$data["estado"] = "KO";
}


if($depurar == TRUE)
{
    $data["html"] = "$msg - $querySelect";
	$data["errores"] = implode("</ br>", $aErrores);
}
else 
{
    $data["html"] = $msg;
	$data["errores"] = implode("</ br>", $aErrores);
}
echo json_encode($data);
/*
echo "<span>";
echo var_dump($data);
echo "</span>";*/

?>
<?php
require("../../config/parametros.php");

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <title>Carga Masiva</title>
    <link href="../../css/dark-hive/jquery-ui-1.9.1.custom.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
    <script src="../../js/jquery-1.8.2.js"></script>
    <script src="../../js/jquery-ui-1.9.1.custom.js"></script>
    <!-- DataTable plugin -->
    <script type="text/javascript" src="../../js/DT/jquery.dataTables.js"></script>
    <style type="text/css" title="currentStyle">
        @import "../../css/DT/demo_page.css";
        @import "../../css/DT/demo_table.css";
        @import "../../css/DT/demo_table_jui.css";
        @import "../../css/DT/jquery.dataTables_themeroller.css";
    </style>

    <!-- Load plupload and all it's runtimes and finally the jQuery UI queue widget --> 
    <style type="text/css">@import url(../../js/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css);</style>
    <script type="text/javascript" src="../../js/plupload/js/plupload.full.js"></script>
    <script type="text/javascript" src="../../js/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
    <script type="text/javascript" src="../../js/plupload/js/i18n/es.js"></script>

    <!-- Funciones de la pagina -->
    <script type="text/javascript" src="../../js/funciones.js"></script>
</head>
<body>
<div id="principal">
    <div id="menu">
        <div id="titulo">Proyecto MEMRE</div>
        <div id='botones'>
            <input type='button' id='btnLinkCM' value='Carga Masiva' />
            <input type='button' id='btnLinkMt' value='Mantenedores' />
        </div>
    </div>
    <div id="container">
        <div id="contenido">
           <div>&nbsp;</div>
           <form id="FormRegUsu">
               <div id="uploader">
                 <p>Tu explorador no soporta esta aplicación</p>
               </div>
           </form>

           <div>&nbsp;</div>
            <input type="button" value="Validar" id="btnValidar" />
           <div>&nbsp;</div>
           <div id="dvResultados">
               <table id="tblResultados">
                    <thead>
                        <tr>
                            <th>Ver</th>
                            <th>Estado</th>
                            <th>N° Columna</th>
                            <th>Año</th>
                            <th>Nombre</th>
                            <th>Etapa</th>
                            <th>Cuenta</th>
                            <th>Unidad Tecnica</th>
                            <th>Id</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                </table>
           </div>
           <div>&nbsp;</div>
           <div id="dvBotonera">
               <input type="button" id="btnCargar" value="Cargar" />
               <input type="button" id="btnLimpiar" value="Limpiar" />
           </div>
        </div>
    </div>
    <div id="footer">
        Proyecto MEMRE V-1.0 - 2013
        Desarrollado por Luis Lizama  
    </div>
</div>
<div id="dvMensajes" style="display: none" >
    <div id="dMsg">
    </div>
</div>
<div id="dvLoading" class="modal" style="text-align: center">
	<p>Espere un momento mientras se realiza la acción</p>
	<div>&nbsp;</div>
    <img src="../../css/ajax-loader.gif" />
</div>
<div id="confirmG">
    Se va a validar el archivo
</div>
<div id="divDetalle" style="display: none" >
	<table id="tblDetalle">
		<thead>
	        <tr>
	            <?php
	             foreach ($COLUMNAS as $value) {
					echo "<th>$value</th>";	 
				 }
	            ?>
	        </tr>
	    </thead>
	    <tbody id="divDetalleTb">
	    </tbody>
    </table>
</div>

</body>
</html>
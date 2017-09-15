<?php
require("../../config/parametros.php");

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <title>Mantenedores</title>
    <link href="../../css/dark-hive/jquery-ui-1.9.1.custom.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
    <link href="../../css/Mant/Etapa.css" rel="stylesheet">
    <link href="../../css/Mant/UnidadTecnica.css" rel="stylesheet">
    <link href="../../css/Mant/Fuente.css" rel="stylesheet">
    <!-- JQuery -->
    <script src="../../js/jquery-1.8.2.js"></script>
    <script src="../../js/jquery-ui-1.9.1.custom.js"></script>
    <!-- JScrollable -->
    <link rel="stylesheet" type="text/css" href="../../css/style.css" /> 
    <link rel="stylesheet" type="text/css" href="../../css/jquery.jscrollpane.codrops1.css" />
    <!-- the mousewheel plugin -->
    <script type="text/javascript" src="../../js/jquery.mousewheel.js"></script>
    <!-- the jScrollPane script -->
    <script type="text/javascript" src="../../js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="../../js/scroll-startstop.events.jquery.js"></script>
    <!-- DataTable plugin -->
    <script type="text/javascript" src="../../js/DT/jquery.dataTables.js"></script>
    <style type="text/css" title="currentStyle">
        @import "../../css/DT/demo_page.css";
        @import "../../css/DT/demo_table.css";
        @import "../../css/DT/demo_table_jui.css";
        @import "../../css/DT/jquery.dataTables_themeroller.css";
    </style>
    <!-- validate Plugin -->
    <script type="text/javascript" src="../../js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../../js/additional-methods.min.js"></script>
    <!-- Funciones de la pagina -->
    <script type="text/javascript" src="../../js/funcionesMain.js"></script>
    <script type="text/javascript" src="../../js/Mant/Etapa.js"></script>
    <script type="text/javascript" src="../../js/Mant/UnidadTecnica.js"></script>
    <script type="text/javascript" src="../../js/Mant/Fuente.js"></script>
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
      <table id="tablaPrincipal">
       <tr>
        <td style="width: 270px;">
           <div id="menu2">
             <ul id="menuUl">
              <li><a href="#" onclick="cambiarContenido('P');">Etapas</a></li>
              <li><a href="#" onclick="cambiarContenido('A');">Unidades Tecnicas</a></li>
              <li><a href="#" onclick="cambiarContenido('C');">Fuentes</a></li>
             </ul>
           </div>
         </td>
         <td rowspan="2">  
            <div id="cotenido">
                <div id="P">
                        <div id="contenidoFormRegUsu">
                            <form id="FormRegUsu">
                            <div id="datosFormRegUsu">
                                <table id="tablaMUsuario">
                                    <tr>
                                        <td><p>&nbsp; Nombre Etapa      </p></td>
                                        <td><input id="FormRegUsuNomUsu" name="FormRegUsuNomUsu" type="text" /></td>
                                    </tr>
                                </table>
                            </div>
                            <input id="FormRegUsuIDUsu" name="FormRegUsuIDUsu" type="text" style="display: none" />
                            </form>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div id="botonesFormRegMUsu">
                                <input type="button" id="btRegUsub"  value="Buscar" />
                                <input type="button" id="btRegUsuGrabar"  value="Grabar" />
                                <input type="button" id="btRegUsuLimpiar" value="Limpiar" />
                            </div>
                            <div id="contTabla">
                                <table id="table_id">
                                <thead>
                                    <tr>
                                        <th>ID Etapa</th>
                                        <th>Nombre Etapa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                            </table>
                         </div>
                        </div>
                </div>
                <div id="A" style="display: none">
                        <div id="contenidoFormRegPerfiles">
                            <form id="FormRegPerfiles">
                            <div id="datosFormRegPerfiles">
                                <table id="tablaMPerfiles">
                                <tr>
                                    <td><p>&nbsp; Nombre Unidad Tecnica      </p></td>
                                    <td><input id="FormRegPerNomPer" name="FormRegPerNomPer" type="text" /></td>
                                </tr>
                                </table>
                            </div>
                            <input id="FormRegPerIDPer" name="FormRegPerIDPer" type="text" style="display: none" />
                            </form>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div id="botonesFormRegMPer">
                                <input type="button" id="btRegPerB"  value="Buscar" />
                                <input type="button" id="btRegPerG"  value="Grabar" />
                                <input type="button" id="btRegPerL"  value="Limpiar" />
                            </div>
                            <div id="contTablaPer">
                                <table id="tablaPerfiles">
                                <thead>
                                    <tr>
                                        <th>ID Unidad Tecnica</th>
                                        <th>Nombre Unidad Tecnica</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                            </table>
                         </div>
                        </div>
                </div>
                <div id="C" style="display: none">
                    <div id="contenidoFormRegRecursos">
                            <form id="FormRegRecursos">
                            <div id="datosFormRegRecursos">
                                <table id="tablaMRecursos">
                                <tr>
                                    <td><p>&nbsp; Nombre Fuente      </p></td>
                                    <td><input id="FormRegRecNomRec" name="FormRegRecNomRec" type="text" /></td>
                                </tr>
                                </table>
                            </div>
                            <input id="FormRegRecIDRec" name="FormRegRecIDRec" type="text" style="display: none" />
                            </form>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <div id="botonesFormRegMRec">
                                <input type="button" id="btRegRecB"  value="Buscar" />
                                <input type="button" id="btRegRecG"  value="Grabar" />
                                <input type="button" id="btRegRecL"  value="Limpiar" />
                            </div>
                            <div id="contTablaRec">
                                <table id="tablaRecursos">
                                <thead>
                                    <tr>
                                        <th>ID Fuente</th>
                                        <th>Nombre Fuente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 
                                </tbody>
                            </table>
                         </div>
                        </div>
                </div>
           </div>
         </td>
        </tr>
        <tr>
            <td> </td>
        </tr>
      </table>
    </div>
    <div id="footer">
        Proyecto MEMRE V-1.0 - 2013
        Desarrollado por Luis Lizama
    </div>
</div>
<!-- Paneles -->
<div id="FormIniSesErr">
    <div id="dMsg">
    </div>
</div>

<div id="dvLoading" class="modal" style="text-align: center">
    <p>Espere un momento mientras se realiza la acción</p>
    <div>&nbsp;</div>
    <img src="../../css/ajax-loader.gif" />
</div>

<div id="confirmG">
    ¿Seguro que desea guardar el registro?
</div>
<div id="confirmPerG">
    ¿Seguro que desea guardar el registro?
</div>
<div id="confirmRecG">
    ¿Seguro que desea guardar el registro?
</div>

</body>
</html>
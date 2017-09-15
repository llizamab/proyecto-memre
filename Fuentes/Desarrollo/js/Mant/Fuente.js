/* Funciones para el mantenedor de recursos */
$(function() {
	
	$( "#btRegRecB" ).button();
	$( "#btRegRecG" ).button();
	$( "#btRegRecL" ).button();

	/* Dialogo de confirmación para guardar */
	$( '#confirmRecG' ).dialog({
		autoOpen: false,
		width: 300,
		height: 260,
		modal: true,
		resizable: false,
		buttons : {
	        "Confirmar" : function() {
	           $.post("./GrabarFuente.php", $('#FormRegRecursos').serialize(),
					   function(data) {
					   	var obj = jQuery.parseJSON(data);
					   	if(obj.estado == 'OK'){
					   		$( "#FormRegRecIDRec" ).val("");
	 						$( "#FormRegRecNomRec" ).val("");	
					   	}
	
				   		$('#dMsg').html( obj.html );
				   		$('#FormIniSesErr').dialog( "open" );
				   		oTabRec.fnReloadAjax();
					   });

			   $(this).dialog("close");
	        },
	        "Cancelar" : function() {
	          $(this).dialog("close");
        	}}
	});

	/* Validaciones del formulario */
	var fRRec = $( '#FormRegRecursos').validate({
                rules: {
                    FormRegRecNomRec: {required: true, 
										 minlength: 1,
                    					 maxlength: 255}
                },
                messages: {
                    FormRegRecNomRec: {required: "",
                    					 minlength: "",
                    					 maxlength: ""}
                }
         });
	
    /* Inicializacion de la tabla */
	var oTabRec = $('#tablaRecursos').dataTable({   
         bJQueryUI: true,
         sPaginationType: "full_numbers", //tipo de paginacion
         "bFilter": true, // muestra el cuadro de busqueda
         "iDisplayLength": 10, // cantidad de filas que muestra
         "bLengthChange": false, // cuadro que deja cambiar la cantidad de filas
         "oLanguage": { // mensajes y el idio,a
	            "sLengthMenu": "Mostrar _MENU_ registros",
	            "sZeroRecords": "No hay resultados",
	            "sInfo": "Resultados del _START_ al _END_ de _TOTAL_ registros",
	            "sInfoEmpty": "0 Resultados",
	            "sInfoFiltered": "(filtrado desde _MAX_ registros)",
	            "sInfoPostFix":    "",
			    "sSearch":         "Buscar:",
			    "sUrl":            "",
			    "sInfoThousands":  ",",
			    "sLoadingRecords": "Cargando...",
			    "oPaginate": {
			        "sFirst":    "Primero",
			        "sLast":     "Último",
			        "sNext":     "Siguiente",
			        "sPrevious": "Anterior"
			    }
	        },
	     "bProcessing": true, //para procesar desde servidor
	     "sServerMethod": "POST",
	     "sAjaxSource": './BuscaFuente.php', // fuente del json
	     "fnServerData": function ( sSource, aoData, fnCallback ) { // Para buscar con el boton
            $.ajax( {
                "dataType": 'json', 
                "type": "POST", 
                "url": sSource, 
                "data": $('#FormRegRecursos').serialize(), 
                "success": fnCallback
            	} );
           }
	});

	/* Para cargar un elemento de la tabla */
	$("#tablaRecursos tbody").delegate("tr", "click", function() {
		
		/* parte donde cambiamos el css */
		if ( $(this).hasClass('row_selected') ) {
       	 $(this).removeClass('row_selected');
       	}
        else {
            oTabRec.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
        }
		/* Parte donde cargamos los input */
		var iPos = oTabRec.fnGetPosition( this );
		if(iPos!=null){
		    var aData = oTabRec.fnGetData( iPos );//get data of the clicked row
		    $("#FormRegRecIDRec").val(aData[0]);
		    $("#FormRegRecNomRec").val(aData[1]);
		}});

    /* Boton para limpiar */
    $("#btRegRecL").button().click( function() {
    	fRRec.resetForm();
	 	$( "#FormRegRecIDRec" ).val("");
	 	$( "#FormRegRecNomRec" ).val("");
	 	oTabRec.$('tr.row_selected').removeClass('row_selected');
	 	oTabRec.fnReloadAjax();
	});
	
	/* Boton para Buscar */
	$( "#btRegRecB" ).button().click( function() {
		oTabRec.fnReloadAjax();
	});

    /* Boton para guardar */
    $( "#btRegRecG" ).button().click( function() {
     	
     	if($('#FormRegRecursos').valid())
     	{
           $('#confirmRecG').dialog( "open" );
	    }
	    else
	    {
	   		$('#dMsg').html( 'Los campos destacados en rojo son obligatorios' );
	   		$('#FormIniSesErr').dialog( "open" );
	    }
    });

});


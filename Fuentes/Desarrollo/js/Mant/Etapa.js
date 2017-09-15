/* Funciones para el mantenedor de usuarios */

$(function() {
	
	$( "#btRegUsub" ).button();
	$( "#btRegUsuGrabar" ).button();
	$( "#btRegUsuLimpiar" ).button();
	
	/* Dialogo de confirmación para guardar */
	$( '#confirmG' ).dialog({
		autoOpen: false,
		width: 300,
		height: 260,
		modal: true,
		resizable: false,
		buttons : {
	        "Confirmar" : function() {
	           $.post("./GrabarEtapa.php", $('#FormRegUsu').serialize(),
					   function(data) {
					   	var obj = jQuery.parseJSON(data);
					   	if(obj.estado == 'OK'){
					   		$( "#FormRegUsuIDUsu" ).val("");
	 						$( "#FormRegUsuNomUsu" ).val("");	
					   	}
						
				   		$('#dMsg').html( obj.html );
				   		$('#FormIniSesErr').dialog( "open" );
				   		oTabUsu.fnReloadAjax();
					   });

			   $(this).dialog("close");
	        },
	        "Cancelar" : function() {
	          $(this).dialog("close");
        	}}
	});

	/* Validaciones del formulario */
	var fRU = $( '#FormRegUsu').validate({
                rules: {
                    
                    FormRegUsuNomUsu: {required: true, 
										 minlength: 1,
                    					 maxlength: 255}
                },
                messages: {
                    
                    FormRegUsuNomUsu: {required: "",
                    					 minlength: "",
                    					 maxlength: ""}
                }
         });
	
    /* Inicializacion de la tabla */
	var oTabUsu = $('#table_id').dataTable({   
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
	     "sAjaxSource": './BuscaEtapas.php', // fuente del json
	     "fnServerData": function ( sSource, aoData, fnCallback ) { // Para buscar con el boton
            $.ajax( {
                "dataType": 'json', 
                "type": "POST", 
                "url": sSource, 
                "data": $('#FormRegUsu').serialize(), 
                "success": fnCallback
            	} );
           }
	});

	/* Para cargar un elemento de la tabla */
	$("#table_id tbody").delegate("tr", "click", function() {
		
		/* parte donde cambiamos el css */
		if ( $(this).hasClass('row_selected') ) {
       	 $(this).removeClass('row_selected');
       	}
        else {
            oTabUsu.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
        }
		/* Parte donde cargamos los input */
		var iPos = oTabUsu.fnGetPosition( this );
		if(iPos!=null){
		    var aData = oTabUsu.fnGetData( iPos ); // obtiene data de la fila clickeada

		    //oTabUsu.fnDeleteRow(iPos); // elimina la fila clickeada
		    $("#FormRegUsuIDUsu").val(aData[0]);
		    $("#FormRegUsuNomUsu").val(aData[1]);
		}});
	
    /* Boton para limpiar */
    $("#btRegUsuLimpiar").button().click( function() {
    	fRU.resetForm();
	 	$( "#FormRegUsuIDUsu" ).val("");
	 	$( "#FormRegUsuNomUsu" ).val("");
	 	oTabUsu.$('tr.row_selected').removeClass('row_selected');
	 	oTabUsu.fnReloadAjax();
	});
	
	/* Boton para Buscar */
	$( "#btRegUsub" ).button().click( function() {
		oTabUsu.fnReloadAjax();
	});

    /* Boton para guardar */
    $( "#btRegUsuGrabar" ).button().click( function() {
     	
     	if($('#FormRegUsu').valid())
     	{
           $('#confirmG').dialog( "open" );
	    }
	    else
	    {
	   		$('#dMsg').html( 'Los campos destacados en rojo son obligatorios' );
	   		$('#FormIniSesErr').dialog( "open" );
	    }
    });

});


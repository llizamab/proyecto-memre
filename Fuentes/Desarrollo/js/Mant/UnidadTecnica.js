/* Funciones para el mantenedor de usuarios */

$(function() {
	
	$( "#btRegPerB" ).button();
	$( "#btRegPerG" ).button();
	$( "#btRegPerL" ).button();
	

	/* Dialogo de confirmación para guardar */
	$( '#confirmPerG' ).dialog({
		autoOpen: false,
		width: 300,
		height: 260,
		modal: true,
		resizable: false,
		buttons : {
	        "Confirmar" : function() {
	           $.post("./GrabarUnidadTecnica.php", $('#FormRegPerfiles').serialize(),
					   function(data) {
					   	var obj = jQuery.parseJSON(data);
					   	if(obj.estado == 'OK'){
					   		$( "#FormRegPerIDPer" ).val("");
	 						$( "#FormRegPerNomPer" ).val("");	
					   	}
	
				   		$('#dMsg').html( obj.html );
				   		$('#FormIniSesErr').dialog( "open" );
				   		oTabPer.fnReloadAjax();
					   });

			   $(this).dialog("close");
	        },
	        "Cancelar" : function() {
	          $(this).dialog("close");
        	}}
	});

	/* Validaciones del formulario */
	var fRPer = $( '#FormRegPerfiles').validate({
                rules: {
                    FormRegPerNomPer: {required: true, 
										 minlength: 1,
                    					 maxlength: 255}
                },
                messages: {
                    FormRegPerNomPer: {required: "",
                    					 minlength: "",
                    					 maxlength: ""}
                }
         });
	
    /* Inicializacion de la tabla */
	var oTabPer = $('#tablaPerfiles').dataTable({   
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
	     "sAjaxSource": './BuscaUnidadTecnica.php', // fuente del json
	     "fnServerData": function ( sSource, aoData, fnCallback ) { // Para buscar con el boton
            $.ajax( {
                "dataType": 'json', 
                "type": "POST", 
                "url": sSource, 
                "data": $('#FormRegPerfiles').serialize(), 
                "success": fnCallback
            	} );
           }
	});

	/* Para cargar un elemento de la tabla */
	$("#tablaPerfiles tbody").delegate("tr", "click", function() {
		
		/* parte donde cambiamos el css */
		if ( $(this).hasClass('row_selected') ) {
       	 $(this).removeClass('row_selected');
       	}
        else {
            oTabPer.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
        }
		/* Parte donde cargamos los input */
		var iPos = oTabPer.fnGetPosition( this );
		if(iPos!=null){
		    var aData = oTabPer.fnGetData( iPos );
		    $("#FormRegPerIDPer").val(aData[0]);
		    $("#FormRegPerNomPer").val(aData[1]);
		}});

    /* Boton para limpiar */
    $("#btRegPerL").button().click( function() {
    	fRPer.resetForm();
	 	$( "#FormRegPerIDPer" ).val("");
	 	$( "#FormRegPerNomPer" ).val("");
	 	oTabPer.$('tr.row_selected').removeClass('row_selected');
	 	oTabPer.fnReloadAjax();
	});
	
	/* Boton para Buscar */
	$( "#btRegPerB" ).button().click( function() {
		oTabPer.fnReloadAjax();
	});

    /* Boton para guardar */
    $( "#btRegPerG" ).button().click( function() {
     	
     	if($('#FormRegPerfiles').valid())
     	{
           $('#confirmPerG').dialog( "open" );
	    }
	    else
	    {
	   		$('#dMsg').html( 'Los campos destacados en rojo son obligatorios' );
	   		$('#FormIniSesErr').dialog( "open" );
	    }
    });

});


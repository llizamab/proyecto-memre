/* Funciones index.html */
$(function() {
	
	    // Limpio los temporales
		$.post("./Limpiar.php",// $('#FormRegUsu').serialize(),
			function(data) {
			var obj = jQuery.parseJSON(data);
	    });

		$( "#btnLinkCM" ).button();
		$( "#btnLinkMt" ).button();
		$( "#btnValidar" ).button();
		
		$( "#btnCargar" ).button();
		$( "#btnCargar" ).button("option", "disabled", true );
		$( "#btnLimpiar" ).button();
		
		$( "#btnLinkMt" ).click(function(){
			document.location.href = "../Mantenedores/Mantenedores.php";
		});
		
		var up = $("#uploader").plupload({
	        runtimes : 'html5',
	        url : '../CargaMasiva/upload.php',
	        max_file_size : '4mb',
	        chunk_size : '1mb',
	        unique_names : true,
	        multi_selection: false,
	        max_file_count:1,
	        multiple_queues : false,
	        filters : [
	            {title : "Excel files", extensions : "xls"}
	        ]
	    });
		
		$('#btnValidar').click(function(e) {
			$('#confirmG').dialog( "open" );
	    });

		var oTabla = $('#tblResultados').dataTable({   
         bJQueryUI: true,
         sPaginationType: "full_numbers", //tipo de paginacion
         "bFilter": false, // muestra el cuadro de busqueda
         "iDisplayLength": 4, // cantidad de filas que muestra
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
	     "sAjaxSource": './BuscaRegistros.php', // fuente del json
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
	  
	  $( "#btnLimpiar" ).click(function(){
			$.post("./Limpiar.php",// $('#FormRegUsu').serialize(),
					   function(data) {
					   	var obj = jQuery.parseJSON(data);

				   		$('#dMsg').html( obj.html );
				   		$('#dvMensajes').dialog( "open" );
				   		
				   		oTabla.fnReloadAjax();
			   });
	  });
	 
	  
	  $( "#btnCargar" ).click(function(){
	  	
	  	 $( "#btnCargar" ).button( "option", "disabled", true );
	  	 $.post("./Cargar.php", // $('#FormRegUsu').serialize(),
			   function(data) {
			   	var obj = jQuery.parseJSON(data);

		   		$('#dMsg').html( obj.html );
		   		if(obj.estado == 'KO'){
		   			$('#dMsg').html(obj.errores);
		   		}
		   		$('#dvMensajes').dialog( "open" );
		   		
		   		oTabla.fnReloadAjax();
	    });
	  });
	  
	  $('#dvLoading' ).dialog({
	  	    autoOpen: false,
			width: 300,
			height: 260,
			modal: true,
			resizable: false,
			beforeclose: function (event, ui) { return false; },
    		dialogClass: "noclose"
	  });
	  
	  /*$("#loadingImg").progressbar({
	      value: 100
	  });*/
	  
	  $('#divDetalle' ).dialog({
	  	    autoOpen: false,
			width: 1200,
			height: 250,
			modal: true,
			resizable: true
	  });
	  
	  $('#confirmG' ).dialog({
			autoOpen: false,
			width: 300,
			height: 260,
			modal: true,
			resizable: false,
			buttons : {
		        "Confirmar" : function() {
		           
		           $.post("./ValidarArchivo.php",// $('#FormRegUsu').serialize(),
						   function(data) {
						   	var obj = jQuery.parseJSON(data);

					   		$('#dMsg').html( obj.html );
					   		var estado =  obj.estado;
					   		if(estado == 'OK'){
					   			$( "#btnCargar" ).button( "option", "disabled", false );
					   		}
					   		$('#dvMensajes').dialog( "open" );
					   		
					   		oTabla.fnReloadAjax();
				   });
	
				   $(this).dialog("close");
		        },
		        "Cancelar" : function() {
		          $(this).dialog("close");
	        	}}
	  });
	  oTabla.fnSetColumnVis( 8, false );
	

	  $("body").on({
		    ajaxStart: function() { 
		        $(this).addClass("loading");
		        //$("#loadingImg" ).progressbar( "enable" );
		        $('#dvLoading').dialog( "open" );
		    },
		    ajaxStop: function() { 
		        $(this).removeClass("loading"); 
		        $('#dvLoading').dialog( "close" );
		    }    
	  });
		
	  $( "#dvMensajes" ).dialog({
			autoOpen: false,
			width: 500,
			height: 500,
			modal: true,
			resizable: false
	  });
		
		
	  $("#tblDetalle").styleTable();
		
	});
	
	// Para recargar la tabla
	$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
	{
	    if ( typeof sNewSource != 'undefined' && sNewSource != null ) {
	        oSettings.sAjaxSource = sNewSource;
	    }
	 
	    if ( oSettings.oFeatures.bServerSide ) {
	        this.fnDraw();
	        return;
	    }
	 
	    this.oApi._fnProcessingDisplay( oSettings, true );
	    var that = this;
	    var iStart = oSettings._iDisplayStart;
	    var aData = [];
	  
	    this.oApi._fnServerParams( oSettings, aData );
	      
	    oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
	        that.oApi._fnClearTable( oSettings );
	          
	        var aData =  (oSettings.sAjaxDataProp !== "") ?
	            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
	          
	        for ( var i=0 ; i<aData.length ; i++ )
	        {
	            that.oApi._fnAddData( oSettings, aData[i] );
	        }
	          
	        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
	          
	        if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
	        {
	            oSettings._iDisplayStart = iStart;
	            that.fnDraw( false );
	        }
	        else
	        {
	            that.fnDraw();
	        }
	          
	        that.oApi._fnProcessingDisplay( oSettings, false );
	          
	        if ( typeof fnCallback == 'function' && fnCallback != null )
	        {
	            fnCallback( oSettings );
	        }
	    }, oSettings );
	};
	
	// Para el estilo de la tabla de detalle
	(function ($) {
        $.fn.styleTable = function (options) {
            var defaults = {
                css: 'styleTable'
            };
            options = $.extend(defaults, options);

            return this.each(function () {

                input = $(this);
                input.addClass(options.css);

                input.find("tr").live('mouseover mouseout', function (event) {
                    if (event.type == 'mouseover') {
                        $(this).children("td").addClass("ui-state-hover");
                    } else {
                        $(this).children("td").removeClass("ui-state-hover");
                    }
                });

                input.find("th").addClass("ui-state-default");
                input.find("td").addClass("ui-widget-content");

                input.find("tr").each(function () {
                    $(this).children("td:not(:first)").addClass("first");
                    $(this).children("th:not(:first)").addClass("first");
                });
            });
        };
    })(jQuery);
    
	
	function verDetalle(id){
		$.post("./BuscarDetalle.php", {ID : id},
		   function(data) {
		   	var obj = jQuery.parseJSON(data);
	   		 $('#divDetalleTb').html( obj.html );
	   		 $('#divDetalle' ).dialog( "open" );
		 });
	}
	
	function verError(id){
		$.post("./BuscarErrores.php", {ID : id},
		   function(data) {
		   	var obj = jQuery.parseJSON(data);
	   		$('#dMsg').html( obj.html );
	   		$('#dvMensajes').dialog( "open" );
		 });
	}
	

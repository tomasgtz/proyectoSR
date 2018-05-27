/**
* Contiene las funciones para los plugins de visuales de innsert
*
* Esta función se correrá en el document ready
*
* @author	isaac
* @version	1
*/
function innsert(){
	/**
	* Botones que despliegan modales
	*
	* @var		jQueryObject
	*/
	var displayers = $( '.displayer' );

	/**
	* Botón para mostrar un menu responsivo en la barra superior
	*
	* @var		jQueryObject
	*/
	var buttons = $( '.display button' );

	/**
	* Botones que despliegan menus tipo dropdown en la barra de navegación
	*
	* @var		jQueryObject
	*/
	var droppers = $( '.dropper > a, .dropper > .pseudo' );

	/**
	* Dropdowns actuales
	*
	* @var		jQueryObject
	*/
	var dropdowns = $( '.dropdown' );

	/**
	* Tabs que seleccionan contenido
	*
	* @var		jQueryObject
	*/
	var tabs = $( '.tabs .pseudo, .tab-btn' );

	/**
	* Evento Click en .desplegador
	*
	* Despliega una ventana modal
	*/
	displayers.click( function( ev ){
		ev.preventDefault();
		$( $( this ).attr( 'data-obj' ) ).deploy();
	});

	/**
	* Evento Click en .desplegador
	*
	* Despliega el menu de la barra de navegación
	*/
	buttons.click( function( ev ){
		ev.preventDefault();
		var target = $( $( this ).attr( 'data-obj' ) );
		target.slideToggle( function(){
			target.toggleClass( 'displayed' );
			target.removeAttr( 'style' );
		});
	});

	/**
	* Evento Click
	*
	* Despliega un menu de tipo dropdown
	*/
	droppers.click( function( ev ){
		ev.preventDefault();
		ev.stopPropagation();
		var dropper = $( this ).parent();
		if ( !dropper.parent().closest( '.dropper' ).hasClass( 'act' ) ){
			droppers.parent().not( '.clicked' ).removeClass( 'act' ).find( '> .dropdown' ).hide();
		}
		dropper.addClass( 'clicked' );
		dropper.removeClass( 'clicked' ).toggleClass( 'act' ).find( '> .dropdown' ).toggle();
	});

	/**
	* Evento Click
	*
	* Cancela el cerrar un dropdown al dar click en el mismo
	*/
	dropdowns.click( function( ev ){
		ev.stopPropagation();
	});

	/**
	* Evento click
	*
	* Click fuera de los dropdowns para cerrarlos
	*/
	$( document ).click( function(){
		dropdowns.hide().parent().removeClass( 'act' );
	});

	/**
	* Evento click
	*
	* Contiene la funcionalidad de los tabs
	*/
	tabs.click( function( ev ){
		ev.preventDefault();
		var click = $( this );
		var tab = click.hasClass( 'tab-btn' ) ? $( click.attr( 'data-obj' ) ) : click;
		if ( !tab.hasClass( 'act' ) ){
			tabs.parent().removeClass( 'act' );
			tab.parent().addClass( 'act' );
			tab.closest( '.tab-panel' ).find( '.tab' ).removeClass( 'act' );
			$( tab.attr( 'data-obj' ) ).addClass( 'act' );
		}
	});

	/**
	* Evento change
	*
	* Muestra la opción default de un select en color gris
	*/
	$( '.select-default' ).change( function(){
		var select = $( this );
		if ( select.val() == '' ){
			select.addClass( 'select-default' );
		}
		else{
			select.removeClass( 'select-default' );
		}
	});
}

/**
* Función que despliega una ventana modal
*
* Se realiza como función de jquery para desplegar modales como se quiera
*
* @author	isaac
* @version	1
*/
$.fn.deploy = function(){
	return this.each( function(){
		var display = $( this );
		display.fadeIn().click( function( ev ){
			$( this ).fadeOut();
		}).find( '.message, .image' ).click( function( ev ){
			ev.stopPropagation();
		}).find( '.close' ).click( function( ev ){
			ev.preventDefault();
			display.fadeOut();
		});
	});
}

/**
* Función que convierte una tabla en una data-table
*
* Se realiza como un plugin para que solo las tablas deseadas tengan esta funcionalidad
*
* @author	isaac
* @version	1
*/
$.fn.dataTable = function( options ){
	return this.each( function(){
		var self = $( this ),
		parent = self.parent(),
		options = $.extend( {}, {
			table		:	self,
			display		:	10,
			pagination	:	parent.find( '.pagination' ),
			searcher	:	parent.find( '.searcher' ),
			active		:	0,
		}, options );
		$.refreshTable( options );
		self.data( 'options', options );
		if ( options.searcher && options.searcher.length > 0 ){
			options.searcher.keyup( function( ev ){
				var keycode = ev.charCode || ev.keyCode;
				if ( keycode == 13 )
				{
					ev.preventDefault();
					return false;
				}
				$.refreshTable( self.data( 'options' ) );
			});
		}
	});
}

/**
* Función complementaria del data-table para refrescar la tabla cuando han cambiado sus elementos
*
* Sub-fucnión del plugin anterior
*
* @author	isaac
* @version	1
*/
$.refreshTable = function( options ){
	var page = options.active, rows;
	if ( options.searcher && options.searcher.length > 0 && options.searcher.val().length > 1 ){
		rows = options.table.find( "tbody tr:contains('" + options.searcher.val().trim() + "')" );
	}
	else{
		rows = options.table.find( 'tbody tr' );
	}
	var pages = Math.ceil( rows.size() / options.display );
	if ( pages <= page ){
		page = pages - 1;
	}
	options.pagination.html( '' );
	for ( var i = 0; i < pages; i++ ){
		var item = $( document.createElement( 'li' ) ).attr( 'id', 'page_' + i ).append( $( document.createElement( 'a' ) ).html( i + 1 ).attr( 'href', i ) );
		options.pagination.append( item );
	}
	$( '#page_' + page ).addClass( 'act' );
	var start = page * options.display;
	options.table.find( 'tbody tr' ).hide();
	rows.slice( start, start + options.display ).show();
	options.pagination.find( 'li a' ).click( function( ev ){
		ev.preventDefault();
		options.active = $( this ).attr( 'href' );
		$.refreshTable( options );
	});
}

/**
* Función para crear un submitter de formularios por ajax
*
* Incluye los formularios que contienen imagenes
*
* @author	isaac
* @version	1
*/
$.fn.submitter = function( options ){
	return this.each( function(){
		var form = $( this ), loader;
		options = $.extend( {}, {
			error		:	'Error...',
			loader		:	true,
			useFrame	:	false
		}, options );
		form.submit( function( ev ){
			if ( !form.data( 'loading' ) ){
				var exec = true;
				if ( options.loader ){
					loader = $( document.createElement( 'div' ) ).addClass( 'loader' );
					form.find( 'input[type=submit]' ).parent().prepend( loader );
				}
				if ( options.beforeSubmit ){
					exec = options.beforeSubmit( form );
				}
				if ( exec ){
					form.data( 'loading', true );
					if ( form.attr( 'enctype' ) || options.useFrame ){
						var frame = $( document.createElement( 'iframe' ) ).attr( 'id', 'posteador' )
							.attr( 'name', 'posteador' ).css({
							height	:	0,
							width	:	0,
							border	:	'none'
						});
						form.attr( 'target', 'posteador' ).attr( 'method', 'POST' );
						$( 'body' ).append( frame );
						frame.load( function(){
							response( frame.contents().find( 'body' ).text(), form );
							setTimeout( function(){
								frame.remove();
							}, 1000 );
						});
					}
					else {
						ev.preventDefault();
						$.ajax({
							url			:	form.attr( 'action' ),
							type		:	'POST',
							dataType	:	'json',
							data		:	form.serialize(),
							success		:	function( data ){
								response( data, form );
							},
							error		:	function( data ){
								console.log( data.responseText );
							}
						});
					}
				}
				else{				
					ev.preventDefault();
					removeLoader();
				}
			}
			else{
				ev.preventDefault();
			}			
		});
		var response = function( json ){
			form.data( 'loading', false );
			removeLoader();
			if ( typeof json !== 'object' ){
				try{
					var data = $.parseJSON( json );
				}
				catch ( ex ){
					var data = { estatus : 'error', mensaje : options.error };
					console.log( json );
				}
			}
			else{
				var data = json;
			}
			if ( options.response ){
				options.response( data );
			}
		}
		var removeLoader = function(){
			if ( options.loader ){
				loader.remove();
			}
		}
	});
}

/**
* Función para crear un "spinner" para selección de números
*
* @author	isaac
* @version	1
*/
$.fn.numberSpinner = function(){
	return this.each( function(){
		var spinner = $( this ),
			input = spinner.find( 'input' );
		input.keydown( function( ev ){
			if ( ( ev.which < 48 || ev.which > 57 ) && ( ev.which < 96 || ev.which > 105 ) &&
				$.inArray( ev.which, [ 46, 8, 9, 27, 13, 110, 116, 37, 39 ] ) < 0 )
					ev.preventDefault();
		}).focus( function(){
			input.select();
		});
		spinner.find( '.spinner-down' ).click( function(){
			var current = parseInt( input.val() );
			if ( current > 0 )
				input.val( current - 1 );
		});
		spinner.find( '.spinner-up' ).click( function(){
			var current = parseInt( input.val() );
			input.val( current + 1 );
		});
	});
}

/**
* Función para amenizar los botones de subir archivo
*
* En caso de ser una imagen se muestra el preview de la misma
*
* @author	isaac
* @version	1
*/
$.fn.uploader = function(){
	return this.each( function(){
		$( this ).change( function( ev ){
			var upload = $( this ).closest( '.uploader' );
			upload.find( '.preview.removable' ).remove();
			for ( var i in ev.target.files ){
				if ( $.inArray( ev.target.files[ i ].type, [ 'image/jpeg', 'image/png', 'image/gif' ] ) >= 0  ){
					var image = $( document.createElement( 'img' ) ).attr( 'src', URL.createObjectURL( ev.target.files[ i ] ) ).addClass( 'preview removable' );
					upload.append( image );
				}
				else if ( ev.target.files[ i ] instanceof File ){
					var prev = $( document.createElement( 'div' ) ).html( ev.target.files[ i ].name.split( '.' ).pop() ).addClass( 'preview removable' );
					upload.append( prev );
				}
			}
		});
	});
}

/**
* Función para realizar validaciones de formularios
*
* Compatible con las validaciones del Tequila Framework
*
* @author	isaac
* @version	1
*/
$.validate = function( form ){
	var rules = {
		'v-requerido' : function( data ){ return data.trim() != '' },
		'v-plano' : function( data ){ return data.match( /^[a-zA-Z0-9]+$/ ) },
		'v-alfanumerico' : function( data ){ return data.match( /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑäëïöüÄËÏÖÜ’ ]+$/ ) },
		'v-escrito' : function( data ){ return data.match( /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑäëïöüÄËÏÖÜ’ ?!\+\-,\.;\$¿¡=\:´_/\\\@\(\)\#]+$#/ ) },
		'v-entero' : function( data ){ return data.match( /^[0-9]+$/ ) },
		'v-numerico' : function( data ){ return data.match( /^\d*\.?\d*$/ ) },
		'v-bandera' : function( data ){ return data.match( /^[01]+$/ ) },
		'v-timestamp' : function( data ){ return data.match( /^[0-9]+$/ ) },
		'v-decimal' : function( data ){ return data.match( /^\d*\.?\d*$/ ) },
		'v-min-longitud' : function( data, opcional ){ return data.length >= opcional },
		'v-max-longitud' : function( data, opcional ){ return data.length <= opcional },
		'v-minimo' : function( data, opcional ){ return parseInt( data ) >= opcional },
		'v-maximo' : function( data, opcional ){ return parseInt( data ) <= opcional },
		'v-email' : function( data ){ return data.match( /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/ ) }
	};
	var messages ={
		'v-requerido' : '% es requerido(a)',
		'v-plano' : '% solo permite letras y numeros',
		'v-alfanumerico' : '% solo acepta letras, números y espacios',
		'v-escrito' : '% contiene caracteres no permitidos',
		'v-entero' : '% debe ser un número entero',
		'v-numerico' : '% debe ser un número entero',
		'v-bandera' : '% debe ser verdadero o falso',
		'v-timestamp' : '% debe ser una estampa de tiempo',
		'v-decimal' : '%s debe ser un número',
		'v-min-longitud' : '% no puede ser menor a # caracteres',
		'v-max-longitud' : '% no puede ser mayor a # caracteres',
		'v-minimo' : '% no puede ser menir a #',
		'v-maximo' : '% no puede ser mayor a #',
		'v-email' : '% debe ser un email'
	}
	var inputs = form.find( ':input' ), errors = [];
	inputs.each( function(){
		var input = $( this );
		for ( var i in rules ){
			if ( typeof input.attr( i ) !== 'undefined' ){
				var name = input.attr( 'v-name' ) ? input.attr( 'v-name' ) : input.attr( 'name' );
				if ( !rules[ i ]( input.val(), input.attr( i ) ) ){
					errors.push( messages[ i ].replace( '%', name ).replace( '#', input.attr( i ) ) );
				}
			}
		}
	});
	return errors;
}

/**
* Función para realizar una visualización en grande de una imagen
*
* @author	isaac
* @version	1
*/
$.fn.imagePreview = function(){
	return this.each( function(){
		var image = $( this );
		image.click( function(){
			var preview = $( '#imagePreview' ).deploy();
			var previewImage = preview.find( '.image' );
			previewImage.attr( 'src', image.attr( 'src' ) );
			previewImage.css({
				'margin-top'	: '-' + ( previewImage[ 0 ].clientHeight / 2 ) + 'px',
				'margin-left'	: '-' + ( previewImage[ 0 ].clientWidth / 2 ) + 'px'
			});
		});
	});
}

/**
* Document ready function
*
* Se corre la función innsert
*/
$( function(){
	innsert();
});
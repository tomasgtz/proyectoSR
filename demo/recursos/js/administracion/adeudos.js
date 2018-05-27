/**
* Implementa funcionalidades para facilitar el pago de adeudos de un residente
*
* @author	isaac
*/
$( document ).ready( function(){
	var residente			= $( '#idResidente' ),
		cuenta				= $( '#idCuenta' ),
		conceptos			= $( '#conceptos tbody' ),
		cantidad			= $( '#cantidad' ),
		residenteDefault	= $( '#residenteDefault' ),
		url					= $( '#urlAdeudo' ).val(),
		residenteSelect		= residente.selectize();
	cuenta.selectize();
	/**
	* Si se encuentra un residente default se inicia la carga al instante
	*/
	if ( residenteDefault.val() !== '' ){
		residenteSelect[ 0 ].selectize.setValue( residenteDefault.val() );
		cargarConceptos();
	}
	/**
	* Al cambiar el usuario se obtienen los adeudos del mismo
	*
	* Evento change
	*/
	residente.change( function( ev ){
		cargarConceptos();
	});

	/**
	* Cambia el estatus de un pago a ignorado o lo devuelve a habilitado
	*
	* Evento Click
	*/
	conceptos.on( 'click', '.toggle', function( ev ){
		ev.preventDefault();
		var button	= $( this ),
			row		= button.closest( 'tr' );
		if ( row.hasClass( 'ignored' ) ){
			row.removeClass( 'ignored' ).find( '.payment' ).prop( 'disabled', false );
			button.removeClass( 'red' ).addClass( 'green' ).html( '<i class="fa fa-check"></i>' );
		}
		else{
			row.addClass( 'ignored' ).find( '.payment' ).prop( 'disabled', true );
			button.removeClass( 'green' ).addClass( 'red' ).html( '<i class="fa fa-close"></i>' );
		}
		establecerCantidad();
	});

	/**
	* Salda un pago a la cantidad adeudada
	*
	* Evento click
	*/
	conceptos.on( 'click', '.settle', function( ev ){
		ev.preventDefault();
		var row = $( this ).closest( 'tr' );
		row.find( '.payment' ).val( parseFloat( row.find( '.debt' ).val().replace( '$', '' ) ) );
		establecerCantidad();
	});

	/**
	* Actualiza la cantidad total al cambiar un valor
	*
	* Evento Blur
	*/
	conceptos.on( 'blur', '.payment', function( ev ){
		ev.preventDefault();
		establecerCantidad();
	});

	/**
	* Realiza la carga de los adeudos de un residente
	*/
	function cargarConceptos(){
		if ( residente.val().trim() != '' ){
			$.ajax({
				url		:	url,
				type	:	'POST',
				data	:	{ idResidente : residente.val() },
				dataType:	'json',
				success	:	function( data ){
					var first = true,
						source = conceptos.find( '.source' );
					source.find( '.detail' ).html( '-' );
					source.find( '.debt' ).prop( 'disabled', true ).val( '' );
					source.find( '.payment' ).prop( 'disabled', true ).val( '' );
					source.removeClass( 'ignored' );
					source.find( '.status' ).removeClass( 'red' ).addClass( 'green' ).html( '<i class="fa fa-check"></i>' );
					conceptos.find( '.added' ).remove();
					for ( i in data )
					{
						var pago		= data[ i ],
							cantidad	= parseFloat( pago.cantidad ) - parseFloat( pago.pagado ),
							row			= first ? conceptos.find( '.source' ) : row.clone();
						row.find( '.detail' ).html( pago.concepto );
						row.find( '.debt' ).val( '$ ' + cantidad.toFixed( 2 ) );
						row.find( '.payment' ).prop( 'disabled', false )
							.attr( 'name', row.find( '.payment' ).attr( 'data-name' ) + '[' + pago.id + ']' ).val( cantidad );
						if ( !first ){
							row.removeClass( 'source' ).addClass( 'added' );
							conceptos.append( row );							
						}
						first = false;
					}
					establecerCantidad();
				}
			});
		}
		else{
			concepto.prop( 'disabled', true );
		}
	}

	/**
	* Establece la cantidad total al cambiar el pago de un concepto
	*/
	function establecerCantidad(){
		var total = 0;
		conceptos.find( '.payment:enabled' ).each( function( index ){
			total += parseFloat( $( this ).val() );
		});
		cantidad.val( '$ ' + total.toFixed( 2 ) );
	}
});
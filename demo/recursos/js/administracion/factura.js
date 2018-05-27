$( document ).ready( function(){
	/**
	* Contenedor de los conceptos de la factura
	*
	* @var	jQueryObject
	*/
	var conceptos = $( '.details tbody' );

	/**
	* Inputs que contienen los totales de la factura
	*
	* @var	jQueryObject
	*/
	var subtotal	= $( '#subtotal' ),
		tasa		= $( '#tasaIVA' ),
		iva			= $( '#iva' ),
		total		= $( '#total' );

	/**
	* Añade conceptos a la factura
	*
	* Evento Click
	*/
	conceptos.find( '.add' ).click( function( ev ){
		ev.preventDefault();
		var row		= $( this ).closest( 'tr' ),
			clon	= row.clone(),
			last	= parseInt( conceptos.find( 'tr' ).last().attr( 'data-row' ) ) + 1;
		console.log( last );
		clon.find( '.green' )
			.removeClass( 'green add' )
			.addClass( 'red remove' )
			.html( '<i class="fa fa-close"></i>' );
		clon.attr( 'data-row', last )
			.find( '.erase' )
			.val( '' );
		clon.find( 'input' ).each( function( index ){
			$( this ).attr( 'name', clon.attr( 'data-name' ) + '[' + last + '][' + index +  ']' );
		});
		conceptos.append( clon );
		reajustarFactura();
	});
	/**
	* Quita un concepto de la factura
	*
	* Evento Click
	*/
	conceptos.on( 'click', '.remove', function( ev ){
		ev.preventDefault();
		var row		= $( this ).closest( 'tr' );
		row.remove();
		reajustarFactura();
	});
	/**
	* Actualiza los totales al cambiar una cantidad
	*
	* Evento Blur
	*/
	conceptos.on( 'blur', '.amounts', function(){
		reajustarFactura();
	});

	/**
	* Reajusta los totales de las facturas
	*/
	function reajustarFactura(){
		var suma = 0;
		$( '.amounts' ).each( function(){
			var amount = parseFloat( $( this ).val() );
			if ( !isNaN( amount ) ){
				suma += amount
			}
		});
		var tasaIVA = parseInt( tasa.val() ) / 100;
		subtotal.val( suma );			
		iva.val( ( suma * tasaIVA ).toFixed( 2 ) );
		total.val( ( suma * ( 1 + tasaIVA ) ).toFixed( 2 ) );
	}
});
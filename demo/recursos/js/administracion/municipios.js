$( document ).ready( function(){
	var url = $( '#urlMunicipio' ).val();
	$( '.estados' ).change( function(){
		var estado = $( this );
		var municipios = $( estado.attr( 'data-obj' ) );
		if ( estado.val().trim() != '' )
		{
			$.ajax({
				url		:	url,
				type	:	'POST',
				data	:	{ estado : estado.val() },
				dataType:	'json',
				success	:	function( data ){
					municipios.prop( 'disabled', false );
					municipios.html( '' );
					municipios.append( $( document.createElement( 'option' ) ).val( '' ).html( 'Seleccione...' ).addClass( 'select-default' ) );
					for ( i in data )
					{
						municipios.append( $( document.createElement( 'option' ) ).val( data[i].id ).html( data[i].nombre ) );
					}
				}
			});
		}
		else
		{
			municipios.html( '' ).prop( 'disabled', true );
		}
	});
});
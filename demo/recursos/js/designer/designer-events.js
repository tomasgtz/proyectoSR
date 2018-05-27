/**
* Eventos que funcionan con el diseñador
*
* @author	isaac
*/
$( document ).ready( function(){
	/**
	* Cuerpo del documento
	*
	* @var	jQueryObject
	*/
	var body = $( 'body' );

	/**
	* Botones que encienden y apagan el uso de una máscara sobre el fondo
	*
	* @var	jQueryObject
	*/
	var useMask = $( '.use-mask .btn' );

	/**
	* Input que contiene el valor del color de la máscara de fondo
	*
	* @var	jQueryObject
	*/
	var maskColor = $( '#maskColor' );

	/**
	* Elemento que contiene el valor de la opacidad de la máscara de fondo
	*
	* También instancía el plugin de slider para este control
	*
	* @var	jQueryObject
	*/
	var maskOpacity = $( '#maskOpacity' ),
	maskOpacitySlider = noUiSlider.create( maskOpacity.get( 0 ), {
		start: 0.1,
		range: {
			'min': 0.1,
			'max': 1
		},
		step: 0.1
	});

	/**
	* Select que contiene la font a utilizar
	*
	* @var	jQueryObject
	*/
	var font = $( '#font' );

	/**
	* Input que contiene el color del contorno del texto a ingresar
	*
	* @var	jQueryObject
	*/
	var textOutColor = $( '#textOutColor' );

	/**
	* Input que contiene el color del relleno del texto a ingresar
	*
	* @var	jQueryObject
	*/
	var textInColor = $( '#textInColor' );

	/**
	* Select que contiene el estilo del texto
	*
	* @var	jQueryObject
	*/
	var fontStyle = $( '#fontStyle' );

	/**
	* Select que contiene el formato de negritas del texto
	*
	* @var	jQueryObject
	*/
	var fontWeight = $( '#fontWeight' );

	/**
	* Select que contiene la decoración del texto
	*
	* @var	jQueryObject
	*/
	var textDecoration = $( '#textDecoration' );

	/**
	* Select que contiene la alineación del texto
	*
	* @var	jQueryObject
	*/
	var textAlign = $( '#textAlign' );

	/**
	* Input que contiene el tamaño de fuente del texto a añadir
	*
	* @var	jQueryObject
	*/
	var fontSize = $( '#fontSize' );

	/**
	* Botones que encienden y apagan el color de relleno de una figura
	*
	* @var	jQueryObject
	*/
	var useFill = $( '.use-fill .btn' );

	/**
	* Input que contiene el color de relleno de las figuras
	*
	* @var	jQueryObject
	*/
	var fillColor = $( '#fillColor' );

	/**
	* Botones que encienden y apagan el color de contorno de una figura
	*
	* @var	jQueryObject
	*/
	var useStroke = $( '.use-stroke .btn' );

	/**
	* Input que contiene el color de contorno de las figuras
	*
	* @var	jQueryObject
	*/
	var strokeColor = $( '#strokeColor' );

	/**
	* Elemento que contiene el ancho de contorno de las figuras
	*
	* También instancía el plugin de slider para este control
	*
	* @var	jQueryObject
	*/
	var strokeWidth = $( '#strokeWidth' );
	strokeWidthSlider = noUiSlider.create( strokeWidth.get( 0 ), {
		start: 1,
		range: {
			'min': 1,
			'max': 15
		},
		step: 1
	});

	/**
	* Inicializa el diseñador
	*/
	Designer.startCanvas( 'mainCanvas', 500, 700 );

	/**
	* Establece la imagen de fondo al dar click en una imagen
	*
	* Evento Click (.background-picker img)
	*/
	$( '.background-picker' ).on( 'click', 'img', function(){
		Designer.setBackgroundImage( $( this ).attr( 'src' ) );
	});

	/**
	* Establece una máscara a la imagen de fondo
	*
	* Evento Click (.use-mask .btn)
	*/
	useMask.click( function( ev ){
		ev.preventDefault();
		useMask.toggleClass( 'act' );
		if ( $( this ).attr( 'data-on' ) != 'yes' ){
			Designer.setBackgroundMask( maskColor.val(), parseFloat( maskOpacitySlider.get() ) );
		}
		else {
			Designer.removeBackgroundMask();
		}
	});

	/**
	* Cambia los valores de la máscara de fondo
	*
	* Evento change (#maskColor)
	*/
	maskColor.change( function(){
		if ( $( '.use-mask .act' ).attr( 'data-on' ) == 'yes' ){
			Designer.setBackgroundMask( maskColor.val(), parseFloat( maskOpacitySlider.get() ) );
		}
	});

	/**
	* Cambia los valores de la máscara de fondo
	*
	* Evento change (maskOpacitySlider)
	*/
	maskOpacitySlider.on( 'change', function( values ){
		if ( $( '.use-mask .act' ).attr( 'data-on' ) == 'yes' ){
			Designer.setBackgroundMask( maskColor.val(), parseFloat( values[ 0 ] ) );
		}
	});

	/**
	* Inserción de texto
	*
	* Evento keyup (#insertText)
	*/
	$( '#insertText' ).keyup( function( ev ){
		if ( ev.keyCode == 13 ){
			Designer.addText( $( this ).val().trim(),
				font.val(),
				textOutColor.val(),
				textInColor.val(),
				fontStyle.val(),
				fontWeight.val(),
				textDecoration.val(),
				textAlign.val(),
				parseInt( fontSize.val() ) );
		}
	});

	/**
	* Inserción de imagenes
	*
	* Evento click (.image-picker img)
	*/
	$( '.image-picker' ).on( 'click', 'img', function(){
		Designer.addImage( $( this ).attr( 'src' ) );
	});

	/**
	* Inserción de figuras
	*
	* Evento click (.shape-picker img)
	*/
	$( '.shape-picker img' ).click( function(){
		Designer.addShape( $( this ).attr( 'data-type' ) );
	});

	/**
	* Enciende el uso de color de relleno en figuras
	*
	* Evento click (.use-fill .btn)
	*/
	useFill.click( function( ev ){
		ev.preventDefault();
		useFill.toggleClass( 'act' );
		if ( $( this ).attr( 'data-on' ) != 'yes' ){
			Designer.editSelectedShape( 'fill', fillColor.val() );
		}
		else {
			Designer.editSelectedShape( 'fill', 'transparent' );
		}
	});

	/**
	* Cambia el valor del color de relleno de figuras
	*
	* Evento change (#fillColor)
	*/
	fillColor.change( function(){
		if ( $( '.use-fill .act' ).attr( 'data-on' ) == 'yes' ){
			Designer.editSelectedShape( 'fill', fillColor.val() );
		}
	});

	/**
	* Enciende el uso de color de contorno en figuras
	*
	* Evento Click (.use-fill .btn)
	*/
	useStroke.click( function( ev ){
		ev.preventDefault();
		useStroke.toggleClass( 'act' );
		if ( $( this ).attr( 'data-on' ) != 'yes' ){
			Designer.editSelectedShape( 'stroke', strokeColor.val() );
			Designer.editSelectedShape( 'strokeWidth', parseInt( strokeWidthSlider.get() ) );
		}
		else {
			Designer.editSelectedShape( 'stroke', 'transparent' );
		}
	});

	/**
	* Cambia el valor del color de contorno de figuras
	*
	* Evento change (#strokeColor)
	*/
	strokeColor.change( function(){
		if ( $( '.use-stroke .act' ).attr( 'data-on' ) == 'yes' ){
			Designer.editSelectedShape( 'stroke', strokeColor.val() );
		}
	});

	/**
	* Cambia el valor del color de contorno de figuras
	*
	* Evento change (strokeWidthSlider)
	*/
	strokeWidthSlider.on( 'change', function( values ){
		if ( $( '.use-stroke .act' ).attr( 'data-on' ) == 'yes' ){
			Designer.editSelectedShape( 'strokeWidth', parseInt( strokeWidthSlider.get() ) );
		}
	});

	/**
	* Cambia el tamaño del lienzo
	*
	* Evento change (#canvasSize)
	*/
	$( '#canvasSize' ).change( function(){

	});

	/**
	* Previene que el botón de backspace cambie la pantalla
	*
	* Evento keydown (body)
	*/
	body.keydown( function( ev ){
		if ( ev.which === 8 && !$( ev.target ).is( 'input, textarea' ) ){
			ev.preventDefault();
		}
	});

	/**
	* Borra el elemento seleccionado
	*
	* Evento keyup (body)
	*/
	body.keyup( function( ev ){
		if ( ev.keyCode === 46 || ev.keyCode === 8 ){
			Designer.removeSelectedObject();
		}
	});

	/**
	* Descarga la imagen diseñada
	*
	* Evento click (#export)
	*/
	$( '#export' ).click( function(){
		$( this ).attr({
			'download': 'download.png',
			'href'    : Designer.canvasUrl( 'type/png' )
		});
	});
});
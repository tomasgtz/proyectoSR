/**
* Controla los eventos del diseñador
*
* @author	isaac <innsert>
*/
$( document ).ready( function(){
	/**
	* Elementos que cambian las herramientas del menú lateral
	*
	* @var	jQueryObject
	*/
	var tools = $( '.tools .tool' );

	/**
	* Barra con las herramientas de diseño según la sección
	*
	* @var	jQueryObject
	*/
	var sidebar = $( '.sidebar' );

	/**
	* Ventana para cambiar el tamaño del lienzo
	*
	* @var	jQueryObject
	*/
	var resizeWindow = $( '#resizeWindow' );

	/**
	* Input que contiene la altura del canvas
	*
	* @var	jQueryObject
	*/
	var canvasHeight = $( '#canvasHeight' );

	/**
	* Input que contiene el ancho del canvas
	*
	* @var	jQueryObject
	*/
	var canvasWidth = $( '#canvasWidth' );

	/**
	* Elemento que contiene al canvas y el diseño del fodno del mismo
	*
	* @var	jQueryObject
	*/
	var canvasHolder = $( '#canvasHolder' );

	/**
	* Inicializa los spinners
	*/
	$( '.spinner' ).numberSpinner();

	/**
	* Controla los cambios de menús
	*
	* Evento click (.tools .tool)
	*/
	tools.click( function( ev ){
		ev.preventDefault();
		sidebar.find( 'li.act' ).removeClass( 'act' );
		$( $( this ).attr( 'data-target' ) ).addClass( 'act' );
	});

	/**
	* Despliega la ventana para cambiar el tamaño del área de diseño
	*
	* Evento click (#resize)
	*/
	$( '#resize' ).click( function(){
		resizeWindow.deploy();
	});

	/**
	* Efectúa el cambio de tamaño
	*
	* Evento click (#resizeWindow .blue)
	*/
	resizeWindow.find( '.blue' ).click( function(){
		var width = parseInt( canvasWidth.val() );
		canvasHolder.css( 'width', width );
		Designer.setCanvasSize( parseInt( canvasHeight.val() ), width );
	});

	/**
	* Evento para cargar imagenes o fondos
	*
	* Evento Change
	*/
	$( '#backgroundFolder, #imagesFolder' ).change( function(){
		var select = $( this );
		loadAssets( select.find( 'option:selected' ), $( select.attr( 'data-holder' ) ) );
	});

	/**
	* Realiza la carga de inicial de imagenes de carpeta
	*/
	loadAssets( $( '#backgroundDefault' ), $( '#background-holder' ) );
	loadAssets( $( '#imageDefault' ), $( '#image-holder' ) );
});

/**
* Realiza la carga de las carpetas de fondos o imagenes
*
* @param	jQueryObject		Elemento del seleccionador que contiene la carpeta
* @param	jQueryObject		Elemento que contendrá las imagenes de la carpeta
*/
function loadAssets( folder, holder ) {
	//Revisa si ya se cargaron las imagenes
	if ( folder.data( 'body' ) ) {
		holder.html( folder.data( 'body' ) );
		return;
	}

	//Carga de las imagenes de la carpeta
	$.ajax({
		url			: folder.attr( 'data-url' ),
		dataType	: 'json',
		success		: function( data ) {
			if ( data && data.estatus && data.estatus == 'exito' ) {
				html = '';
				for ( var i in data.images ) {
					html += '<div class="image-wrapper seis"><img src="' + data.images[ i ] + '" /></div>';
				}
				holder.html( html );
				folder.data( 'body', html );
			}
		}
	});
}
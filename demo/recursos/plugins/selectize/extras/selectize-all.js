/**
* Añade la opción de "select all" al selectize
*
* @author	isaac
* @param	Selectize		El objeto de selectize
* @param	jQueryObject	El botón que seleccionará todos
* @param	object			Las opciones de la función
*/
function addSelectAll( selectize, button, options ){
	/**
	* Valores defaults de la función
	*
	* @var		object
	*/
	var defaults = $.extend( {}, {
		selected	: false,
		addText		: '<i class="fa fa-check"></i>',
		clearText	: '<i class="fa fa-close"></i>',
		addHint		: 'Seleccionar Todos',
		clearHint	: 'Remover Todos'
	}, options );

	/**
	* Se establece el valor default del botón (seleccionar todos o borrar todos)
	*/
	button.data( 'selected', defaults.selected );

	/**
	* Realiza la selección de todos los valores del selectize
	*
	* Evento click
	*/
	button.click( function( ev ){
		ev.preventDefault();
		if ( !button.data( 'selected' ) ){
			console.log( selectize );
			$.each( selectize.options, function( index, object ){
				selectize.addItem( index );
			});
			button.data( 'selected', true ).html( defaults.clearText ).attr( 'title', defaults.clearHint );
		}
		else{
			selectize.clear();
			button.data( 'selected', false ).html( defaults.addText ).attr( 'title', defaults.addHint );
		}
	});
}
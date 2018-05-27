/**
* Clase que contiene las funciones para crear diseños con fabric.js
*
* @author	isaac
*/
Designer = {
	/**
	* Crea la instancia del canvas
	*
	* @param	string		El id del canvas en el DOM
	* @param	int			La altura del canvas
	* @param	int			El ancho del canvas
	*/
	startCanvas : function( id, height, width ){
		this.canvas = new fabric.Canvas( id );
		this.height = height;
		this.width = width;
		this.layers = [];
	},

	/**
	* Establece los valores del tamaño del canvas
	*
	* @param	int		La altura del canvas
	* @param	int		El ancho del canvas
	*/
	setCanvasSize : function( height, width ){
		this.height = height;
		this.width = width;
		this.canvas.setHeight( this.height );
		this.canvas.setWidth( this.width );
		this.canvas.renderAll();
	},

	/**
	* Estblece un fondo del canvas con una imagen
	*
	* @param	string		Url del la imagen de fondo
	*/
	setBackgroundImage : function( url ){
		var canvas = this.canvas;
		fabric.Image.fromURL( url, function( img ){
			img.set({
				width: canvas.width,
				height: canvas.height,
				originX: 'left',
				originY: 'top'
			});
			canvas.setBackgroundImage( img, canvas.renderAll.bind( canvas ) );
		});
	},

	/**
	* Establece la máscara para el fondo
	*
	* @param	string		El hexadecimal del color de la máscara
	* @param	float		La opacidad de la máscara de fondo
	*/
	setBackgroundMask : function( color, opacity ){
		var backgroundImage = this.canvas.backgroundImage;
		backgroundImage.filters[ 12 ] = new fabric.Image.filters.Tint({
			color	: color,
			opacity	: opacity
		});
		backgroundImage.applyFilters( this.canvas.renderAll.bind( this.canvas ) );
	},

	/**
	* Remueve la máscara del fondo
	*
	* @param	none
	*/
	removeBackgroundMask : function(){
		var backgroundImage = this.canvas.backgroundImage;
		backgroundImage.filters[ 12 ] = false;
		backgroundImage.applyFilters( this.canvas.renderAll.bind( this.canvas ) );
	},

	/**
	* Inserta un texto en el canvas
	*
	* @param	string		El texto a ingresar
	* @param	string		Fuente a utilizar
	* @param	string		Color del contorno del texto
	* @param	string		Color del relleno del texto
	* @param	string		Estilo del texto (normal, italic, oblique)
	* @param	string		Letras negritas (bold, normal)
	* @param	string		Decoración de texto (normal, underline, overline)
	* @param	string		Alineación de texto (left, right, center)
	* @param	int			Tamaño de fuente
	*/
	addText : function( text, font, outColor, inColor, fontStyle, fontWeight, textDecoration, textAlign, size ){
		var text = new fabric.IText( text, { 
			fontFamily: font,
			stroke: outColor,
			fill: inColor,
			fontStyle: fontStyle,
			fontWeight: fontWeight,
			textDecoration: textDecoration,
			textAlign: textAlign,
			fontSize: size,
			left: ( this.width / 2 ),
			top: -15,
		});
		text.left = ( this.width / 2 ) - ( text.width / 2 );
		text.namespace = 'Text';
		this.elementAnimationIn( text );
		this.layers.push( text );
	},

	/**
	* Edita un texto en el canvas
	*
	* @param	string		Fuente a utilizar
	* @param	string		Color del texto
	* @param	int			Tamaño de fuente
	*/
	editSelectedText : function( property, value ){
		var shape = this.canvas.getActiveObject();
		if ( shape && shape.namespace && shape.namespace === 'Text' ){
			shape[ property ] = value;
			this.canvas.renderAll();
		}
	},

	/**
	* Inserta una imagen en el canvas
	*
	* @param	string		Url del la imagen a añadir
	*/
	addImage : function( url ){
		var canvas = this.canvas,
			layers = this.layers,
			height = this.height,
			width = this.width;
		fabric.Image.fromURL( url, function( img ){
			img.set({
				left: ( width / 2 ) - ( img.width / 2 ),
				top: ( img.height * -1 )
			});
			Designer.elementAnimationIn( img );
			layers.push( img );
		});
	},

	/**
	* Inserta una figura al canvas
	*
	* @param	string		El tipo de la figura a insertar
	*/
	addShape : function( type ){
		var newShape,
			rectProperties = {
				left: ( this.width / 2 ) - 25,
				top: -50,
				width: 50,
				height: 50,
			},
			circleProperties = {
				left: ( this.width / 2 ) - 25,
				top: -50,
				radius: 25
			},
			namespace = 'Shape.';
		switch ( type ){
			case 'rect':
				newShape = new fabric.Rect( rectProperties );
				namespace += 'Rect';
				break;
			case 'circle':
				newShape = new fabric.Circle( circleProperties );
				namespace += 'Cirlce';
				break;
			default:
				newShape = new fabric.Rect( rectProperties );
				namespace += 'Rect';
				break;
		}
		newShape.namespace = namespace;
		this.elementAnimationIn( newShape );
		this.layers.push( newShape );
	},

	/**
	* Edita las preferencias de una figura
	*
	* @param	string		Propiedad a editar de la figura
	* @param	string		Valor que tendrá la propiedad
	*/
	editSelectedShape : function( property, value ){
		var shape = this.canvas.getActiveObject();
		if ( shape && shape.namespace && shape.namespace.substr( 0, 5 ) === 'Shape' ){
			shape[ property ] = value;
			this.canvas.renderAll();
		}
	},

	/**
	* Realiza la animación de entrada de un elemento al centro del canvas
	*
	* @param	object		Elemento a entrar
	*/
	elementAnimationIn : function( element ){
		var canvas = this.canvas;
		canvas.add( element );
		element.animate( 'top', ( this.height / 2 - ( element.height / 2 ) ), {
			onChange: canvas.renderAll.bind( canvas ),
			easing: fabric.util.ease.easeOutBounce
		});
	},

	/**
	* Elimina el objeto seleccionado
	*
	* Si no existe objeto seleccionado no hace nada
	*/
	removeSelectedObject : function(){
		var shape = this.canvas.getActiveObject();
		if ( shape && ( shape.namespace !== 'Text' || !shape.isEditing ) ){
			shape.remove();
		}
	},

	/**
	* Devuelve la url de la imagen diseñada
	*
	* @param	string		El tipo de formato
	* @return	string
	*/
	canvasUrl : function( type ){
		this.canvas.deactivateAll().renderAll();
		return this.canvas.toDataURL( type );
	}
}
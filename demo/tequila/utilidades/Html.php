<?php
use tequila\utilidades\BaseHtml;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Ayuda para la creación de formularios
*
* Son un conjunto de métodos estáticos que generan html
* esta clase esta dada de alta en Autoload como clase simple
*
* @package	tequila.utilidades
* @author	isaac
* @version	1.1
*/
class Html extends BaseHtml{	
	/**
	* Escapa una valor para evitar inyección de javascript
	*
	* @static
	* @param	string		$value		El valor a escapar
	* @access	public
	* @return	string
	*/
	public static function escapar( $value )
	{
		return htmlspecialchars( $value, ENT_QUOTES );
	}

	/**
	* Dibuja una tag de liga html
	*
	* @static
	* @param	string		$texto		El texto que mostrará la liga
	* @param	string		$href		La ruta a la que redireccionará la etiqueta
	* @param	array		$attrs		Atributos opcionales de la etiqueta
	* @access	public
	* @return	string
	*/
	public static function link( $texto, $href, array $attrs = array() )
	{
		$attrs['href'] = $href;
		return '<a ' . self::atributos( $attrs ) . ' >' . $texto . '</a>';
	}
	
	/**
	* Dibuja una tag de imagen
	*
	* @static
	* @param	string		$ruta		Ruta donde está ubicada la imagen
	* @param	string		$alt		Texto alternativo de la imagen
	* @param	array		$attrs		Atributos opcionales de la etiqueta
	* @access	public
	* @return	string
	*/
	public static function img( $ruta, $alt = '', array $attrs = array() )
	{
		$attrs['src'] = $ruta;
		$attrs['alt'] = $alt;
		return '<img ' . self::atributos( $attrs ) . '/>';
	}
	
	/**
	* Dibuja un elemento html
	*
	* @static
	* @param	string		$elemento	El tipo de elemento html que se dibujará
	* @param	string		$texto		El contenido en el elemento
	* @param	array		$attrs		Atributos opcionales de la etiqueta
	* @access	public
	* @return	string
	*/
	public static function elemento( $elemento, $texto, array $attrs = array() )
	{
		return '<' . $elemento . ' ' . self::atributos( $attrs ) . '>' . $texto . '</' . $elemento . '>';
	}

	/**
	* Dibuja un elemento sin texto interior
	*
	* Será usado principalmente para las etiquetas que son solo de estilo
	*
	* @static
	* @param	string		$elemento	La etiqueta que se cerrará
	* @param	string		$clase		La clase que tendrá el elemento
	* @access	public
	* @return	string
	*/
	public static function tag( $elemento, $clase = '' )
	{
		return self::elemento( $elemento, '', array( 'class' => $clase ) );
	}

	/**
	* Dibuja cualquier tag inicial con sus atributos
	*
	* @static
	* @param	string		$tag		La etiqueta que se abrirá
	* @param	array		$attrs		Atributos opcionales de la etiqueta
	* @access	public
	* @return	string
	*/
	public static function abrir( $tag, array $attrs = array() )
	{
		return '<' . $tag . ' ' . self::atributos( $attrs ) . ' >';
	}

	/**
	* Dibuja cualquier cierre de tag
	*
	* @static
	* @param	string		$tag		La etiqueta que se cerrará
	* @access	public
	* @return	string
	*/
	public static function cerrar( $tag )
	{
		return '</' . $tag . '>';
	}
}
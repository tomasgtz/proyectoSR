<?php
namespace tequila\utilidades;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase contiene metodos base para clases derivadas
* que ayuden en la creación de html
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
class BaseHtml{
	/**
	* Parsea un arreglo y devuelve una cadena con formato de atributos html
	*
	* @param	array	$attrs		El arreglo de atributos
	* @static
	* @access	public
	* @return	string
	*/
	public static function atributos( array $attrs )
	{
		foreach ( $attrs as $attr => &$value )
		{
			$value = is_int( $attr ) ? $value . ' ' : $attr . '="' . $value . '" ';
		}
		return join( '', $attrs );
	}
}
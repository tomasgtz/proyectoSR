<?php
use tequila\inicio\Boot;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Asiste en la creación de urls
*
* Esta dada de alta en el Autoload como clase simple
*
* @package	tequila.utilidades
* @author	isaac
* @version	1.1
*/
class Url{
	/**
	* Genera una URL con las partes dadas
	*
	* @static
	* @param	string[]	$partes		Las partes que formarán la URL
	* @access	public
	* @return	string
	*/
	public static function hacer()
	{
		return URL . join( US, func_get_args() );
	}

	/**
	* Devuelve la URL de la petición actual
	*
	* @static
	* @access	public
	* @return	string
	*/
	public static function actual()
	{
		return URL . Boot::$peticion->url;
	}

	/**
	* Devuelve la URL de la petición actual incluyendo su "query string"
	*
	* @static
	* @access	public
	* @return	string
	*/
	public static function completa()
	{
		return self::hacer( Boot::$peticion->url, http_build_query( Boot::$peticion->gets ) );
	}
}
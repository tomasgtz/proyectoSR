<?php
use tequila\inicio\ArchivoDeClaseException;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Se encarga de incluir los archivos de las clases del framework
*
* Maneja dos tipos de clases, las clases con namespace y las clases simples,
* para las clases simples el nombre de esta debe darse de alta en el arreglo
* $simples de esta clase para que puedan ser incluidos sus archivos correspondientes
*
* @package	tequila', 'inicio
* @author	isaac
* @version	1
*/
class Autoload{
	/**
	* Colección de clases simples
	*
	* @static
	* @access	private
	* @var		array
	*/
	private static $simples = array(
		'DB'			=> array( 'tequila', 'database', 'DB' ),
		'Sess'			=> array( 'tequila', 'libreria', 'Sess' ),
		'Url'			=> array( 'tequila', 'libreria', 'Url' ),
		'Membresia'		=> array( 'tequila', 'libreria', 'Membresia' ),
		'Redirect'		=> array( 'tequila', 'libreria', 'respuesta', 'Redirect' ),
		'Cadena'		=> array( 'tequila', 'utilidades', 'Cadena' ),
		'Fecha'			=> array( 'tequila', 'utilidades', 'Fecha' ),
		'Form'			=> array( 'tequila', 'utilidades', 'Form' ),
		'Html'			=> array( 'tequila', 'utilidades', 'Html' ),
		'Leng'			=> array( 'tequila', 'utilidades', 'lenguaje', 'Leng' ),
		'Paquete'		=> array( 'tequila', 'mvc', 'vistas', 'Paquete' ),
		'Css'			=> array( 'tequila', 'mvc', 'vistas', 'Css' ),
		'Js'			=> array( 'tequila', 'mvc', 'vistas', 'Js' ),
		'Icono'			=> array( 'tequila', 'mvc', 'vistas', 'Icono' ),
		'Metatag'		=> array( 'tequila', 'mvc', 'vistas', 'Metatag' ),
		'Title'			=> array( 'tequila', 'mvc', 'vistas', 'Title' )
	);
	
	/**
	* Esta es la función que se encarga de incluir los archivos de clases
	*
	* @static
	* @param	string	$clase		El nombre de la clase que require inclusión de archivo
	* @access	public
	*/
	public static function incluir( $clase )
	{
		if ( array_key_exists( $clase, self::$simples ) )
		{
			$archivo = join( DS , self::$simples[ $clase ] ) . EXT;
		}
		else
		{
			$archivo = str_replace( '\\', DS, $clase ) . EXT;
		}
		if ( !file_exists( $archivo ) )
		{
			throw new ArchivoDeClaseException( $clase, $archivo );
		}
		require $archivo;
	}
}
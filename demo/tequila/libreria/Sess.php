<?php
use tequila\libreria\Sesion;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Obtiene la instancia default de la sesión
*
* Esta puede cmabiarse según se requiera en el proyecto
*
* @package	tequila.libreria
* @author	isaac
* @version	1
*/
class Sess{
	/**
	* Instancia defualt de la sesión
	*
	* @static
	* @access	private
	* @var		Sesion
	*/
	private static $instancia;
	
	/**
	* Devuelve la instancia default de la sesión
	*
	* Aquí es donde se establece el tipo de sesión default
	*
	* @static
	* @access	public
	* @return	Sesion
	*/
	public static function instanciaDefault()
	{
		if ( !isset( self::$instancia ) )
		{
			self::$instancia = new Sesion();
		}
		return self::$instancia;
	}
}
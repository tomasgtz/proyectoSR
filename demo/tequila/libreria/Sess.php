<?php
use tequila\libreria\Sesion;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Obtiene la instancia default de la sesi�n
*
* Esta puede cmabiarse seg�n se requiera en el proyecto
*
* @package	tequila.libreria
* @author	isaac
* @version	1
*/
class Sess{
	/**
	* Instancia defualt de la sesi�n
	*
	* @static
	* @access	private
	* @var		Sesion
	*/
	private static $instancia;
	
	/**
	* Devuelve la instancia default de la sesi�n
	*
	* Aqu� es donde se establece el tipo de sesi�n default
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
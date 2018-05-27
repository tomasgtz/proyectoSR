<?php
use tequila\libreria\membresia\MembresiaUsuario;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Obtiene la instancia default de la membresía
*
* Esta puede cmabiarse según se requiera en el proyecto
*
* @package	tequila.libreria
* @version	1
* @author	isaac
*/
class Membresia{
	/**
	* Instancia defualt de la membresía
	*
	* @static
	* @access	private
	* @var		Sesion
	*/
	private static $instancia;
	
	/**
	* Devuelve la instancia default de la membresía
	*
	* Aquí es donde se establece el tipo de membresía default
	*
	* @static
	* @access	public
	* @return	Sesion
	*/
	public static function instanciaDefault()
	{
		if ( !isset( self::$instancia ) )
		{
			self::$instancia = new MembresiaUsuario();
		}
		return self::$instancia;
	}
}
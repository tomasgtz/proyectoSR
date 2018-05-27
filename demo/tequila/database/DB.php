<?php
use tequila\database\PdoMysql;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Obtiene la instancia default de de base de datos
*
* Esta puede cmabiarse según se requiera en el proyecto
*
* @package	tequila.database
* @author	isaac
* @version	1
*/
class DB{
	/**
	* Instancia defualt de la base de datos
	*
	* @static
	* @access	private
	* @var		InterfazDatabase
	*/
	private static $instancia;
	
	/**
	* Devuelve la instancia default de la base de datos
	*
	* Aquí es donde se establece el driver de base de datos default
	*
	* @static
	* @access	public
	* @return	InterfazDb
	*/
	public static function instanciaDefault()
	{
		if ( !isset( self::$instancia ) )
		{
			self::$instancia = new PdoMysql();
		}
		return self::$instancia;
	}
}
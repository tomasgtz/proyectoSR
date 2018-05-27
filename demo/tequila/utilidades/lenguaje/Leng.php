<?php
use tequila\utilidades\lenguaje\Lenguaje;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase estática para llamar la clase default de lenguaje
*
* @author	isaac
* @package	tequila.utilidades
* @version	1
*/
class Leng{
	/**
	* Instancia defualt del lenguaje
	*
	* @static
	* @access	private
	* @var		Idioma
	*/
	private static $instancia;
	
	/**
	* Devuelve la instancia default del lenguaje
	*
	* Aquí es donde se establece la clase default del lenguaje
	*
	* @static
	* @access	public
	* @return	Idioma
	*/
	public static function instanciaDefault()
	{
		if ( !isset( self::$instancia ) )
		{
			self::$instancia = new Lenguaje();
		}
		return self::$instancia;
	}
}
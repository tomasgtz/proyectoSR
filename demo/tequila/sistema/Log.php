<?php
namespace tequila\sistema;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Registra mensajes en un archivo de texto seleccionado
*
* Estos archivos se guardan el carpeta tequila.logs,
* esta clase esta dada de alta en el Autoload como clase simple
*
* @package	tequila.sistema
* @author	isaac
* @version	1
*/
class Log{
	/**
	* Añade un mensaje de error a un archivo
	*
	* @static
	* @param	string		$nombre		El nombre del archivo que se modificará
	* @param	string		$mensaje	El mensaje que se añadirá
	* @access	public
	* @return	void
	*/
	public static function add( $nombre, $mensaje )
	{
		$archivo = 'tequila' . DS . 'logs' . DS . $nombre . '.txt';
		file_put_contents( $archivo, $mensaje . ' :: ' . date( 'r' ) . PHP_EOL, FILE_APPEND );
	}
}
<?php
namespace tequila\inicio;
use tequila\sistema\Exception;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta exceción se lanza cuando no se encuantra un archivo de clase
*
* Debe recibir el archivo que no se encontró
* y el nombre de la clase que se intentó instanciar
* estos estarán disponibles en propiedades de la exceción
*
* @package	tequila.inicio
* @author	isaac
* @version	1
*/
class ArchivoDeClaseException extends Exception{
	/**
	* Nombre de la clase que no se encontró
	*
	* @access	public
	* @var		string
	*/
	public $clase;
	
	/**
	* Nombre del archivo que no se encontró
	*
	* @access	public
	* @var		string
	*/
	public $archivo;
	
	/**
	* Constructor
	*
	* Crea la exceción y establece el nombre de la clase y del archivo
	* que arrojaron esta exceción
	*
	* @param	string	$clase		El nombre de la clase
	* @param	string	$archivo	El archivo que no se encontró
	* @access	public
	*/
	public function __construct( $clase, $archivo )
	{
		$this->clase = $clase;
		$this->archivo = $archivo;
		parent::__construct( 'CLASE (' . $clase . ') ARCHIVO (' . $archivo . ')');
	}
}
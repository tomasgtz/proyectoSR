<?php
namespace tequila\sistema;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase padre para las que clases que tengan archivos de configuración ligados
*
* Las clases extendidas de esta deben tener declaradas como propiedad
* $_ruta que tendrá como valor la ruta del archivo de configuración
* el cual podrá ser leído mediante la propiedad $_config como un arreglo,
* la ruta del archivo debe estar definido de la siguiente forma:
* "'tequila' . DS . 'database' . DS . 'mysqlConfiguracion'"
*
* @package	tequila.sistema
* @author	isaac
* @version	1
*/
abstract class Configurable{
	/**
	* Ruta del archivo de configuración
	*
	* @access	protected
	* @var		array
	*/
	protected $_ruta = array();
	
	/**
	* Arreglo de las configuraciones
	*
	* @access	protected
	* @var		array
	*/
	protected $_config;
	
	/**
	* Constructor
	*
	* Asigna las configuraciones a la propiedad $_config
	*
	* @access	public
	*/
	public function __construct()
	{
		$archivo = join( US, $this->_ruta ) . EXT;
		$this->_config = require $archivo;
	}
}
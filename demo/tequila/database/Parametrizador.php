<?php
namespace tequila\Database;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase que colecciona parametros para una sentencia preparada
*
* A la hora de realizar una consulta preparada en las clase que implementan InterfazDatabase
* se debe pasar un objeto de esta clase con los parametros a enlazar en esa sentencia
*
* @package	tequila.database
* @author	isaac
* @version	1
*/
class Parametrizador{
	/**
	* Conjunto de "types"
	*
	* Estos son los tipos de datos de los valores a enlazar
	*
	* @access	public
	* @var		array
	*/
	public $types = array();
	
	/**
	* Conjunto de "values"
	*
	* Los  valores que tendrán los datos enlazados
	*
	* @access	public
	* @var		array
	*/
	public $values = array();
	
	/**
	* Añade un tipo y un valor a las respectivas colecciones
	*
	* @param	string	$type	el tipo del dato enlazado
	* @param	mixed	$value	el valor a enlazar
	* @access	public
	*/
	public function add( $type, $value )
	{
		$this->types[] = $type;
		$this->values[] = $value;
	}
	
	/**
	* Traduce los valores de los types por valores aceptados por el driver de base de datos
	*
	* @param	array	$definiciones		Los valores por los que se cambiaran los tipos
	* @access	public
	*/
	public function traducir( array $definiciones )
	{
		foreach ( $this->types as &$type )
		{
			$type = $definiciones[$type];
		}
	}
}
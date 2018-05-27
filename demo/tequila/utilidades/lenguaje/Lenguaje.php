<?php
namespace tequila\utilidades\lenguaje;
use tequila\sistema\Configurable, \arrayaccess;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase para realizar el despliegue de ciertos datos en diferentes lenguajes
*
* @author	isaac
* @package	tequila.utilidades
* @version	1
*/
class Lenguaje extends Configurable implements arrayaccess{
	/**
	* Ruta del archivo de configuraciones de la clase
	*
	* @access	protected
	* @var		array
	*/
	protected $_ruta = array( 'tequila', 'utilidades', 'configuraciones', 'etiquetas' );

	/**
	* El lenguaje actualmente seleccionado
	*
	* Por default el lenguaje seleccionado es español
	*
	* @access	public
	* @var		string
	*/
	public $actual = 'es_mx';

	/**
	* Establece el lenguaje a utilizar
	*
	* @param	string		$lenguaje		El lenguaje que se utilizará
	* @access	public
	*/
	public function establecer( $lenguaje )
	{
		$this->actual = $lenguaje;
	}

	/**
	* Devuelve una etiqueta según el idioma
	*
	* @param	string		$etiqueta		La etiqueta a desplegar
	* @access	public
	* @return	string
	*/
	public function etiqueta( $etiqueta )
	{
		return $this->_config[ $etiqueta ][ $this->actual ];
	}

	/**
	* Método para interfaz arrayaccess
	*
	* Establece un nuevo valor al arreglo
	*
	* @param	mixed	$offset		El indice del arreglo
	* @param	mixed	$value		El valor que tendrá el arreglo en esta posición
	* @access	public
	*/
	public function offsetSet( $offset, $value )
	{
		$this->_config[ $offset ][ $this->actual ] = $value;
	}

	/**
	* Método para interfaz arrayaccess
	*
	* Revisión sobre si existe el indice dado
	*
	* @param	mixed	$offset		El indice del arreglo
	* @access	public
	*/
	public function offsetExists( $offset )
	{
		return isset( $this->_config [$offset ][ $this->actual ] );
	}

	/**
	* Método para interfaz arrayaccess
	*
	* Elimina una posición del arreglo de etiquetas
	*
	* @param	mixed	$offset		El indice del arreglo
	* @access	public
	*/
	public function offsetUnset( $offset )
	{
		unset( $this->_config[ $offset ][ $this->actual ] );
	}

	/**
	* Método para interfaz arrayaccess
	*
	* Devuelve el valor dado del arreglo de etiquetas
	*
	* @param	mixed	$offset		El indice del arreglo
	* @access	public
	*/
	public function offsetGet( $offset )
	{
		return isset( $this->_config[ $offset ][ $this->actual ] ) ? $this->_config[ $offset ][ $this->actual ] : null;
	}
}
<?php
namespace tequila\sistema;
use \Leng;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase tiene funciones para coleccionar mensajes preconfigurados de error
*
* @package	tequila.sistema
* @author	isaac
* @version	1
*/
class ColeccionErrores extends Configurable{
	/**
	* Arreglo que almacena los errores encontrados
	*
	* @access	protected
	* @var		array
	*/
	protected $errores = array();
	
	/**
	* Añade un mensaje de error al arreglo
	*
	* @param	string		$dato		El nombre del dato que levantó el error
	* @param	string		$config		La configuración del mensaje
	* @param	mixed		$opcion		Dato opcional del mensaje
	* @access	protected
	*/
	protected function addError( $dato, $config, $opcion = null )
	{
		$error = is_array( $this->_config[ $config ] ) ? $this->_config[ $config ][ Leng::instanciaDefault()->actual ] : $this->_config[ $config ];
		if ( !isset( $opcion ) || is_bool( $opcion ) )
		{
			$mensaje = sprintf( $error, $dato );
		}
		else
		{
			$mensaje = sprintf( $error, $dato, $opcion );
		}
		$this->errores[] = $mensaje;
	}
	
	/**
	* Devuelve los mensajes de error en una cadena con formato
	*
	* Recibe un parametro que será la unión entre los mensajes
	*
	* @param	string		$union		Texto de unión entre mensajes
	* @access	public
	* @return	string
	*/
	public function getErrores( $union = '<br/>' )
	{
		return join( $union, $this->errores );
	}
}
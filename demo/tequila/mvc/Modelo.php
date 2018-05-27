<?php
namespace tequila\mvc;
use tequila\utilidades\Validacion;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase base de los modelos del framework
*
* Esta clase represeta la capa de datos
*
* @package	tequila.mvc
* @authorq	isaac
* @version	1
*/
class Modelo{	
	/**
	* El campo de identificación del modelo
	*
	* @access	public
	* @var		int
	*/
	public $id;

	/**
	* El conjunto de reglas de validación del objeto
	*
	* @access	protected
	* @var		array
	*/
	protected $_reglas = array();

	/**
	* Establece las reglas que utilizará el objeto
	*
	* @param	array	$reglas		El conjunto de reglas de validación
	* @access	public
	*/
	public function setReglas( array $reglas )
	{
		$this->_reglas = $reglas;
	}
	
	/**
	* Valida el modelo según las anotaciones establecidas
	*
	* Si la bandera completo se establece como false solo se validarán
	* las propiedades establecidas en el objeto
	*
	* @param	bool		$completo	Bandera que indica si se debe validar el objeto completo
	* @param	string		$union		La unión que puede tener la cadena de errores
	* @access	public
	* @throws	ModeloException
	*/
	public function validar( $completo = true, $union = '<br/>' )
	{
		$validacion = new Validacion( $this, $this->_reglas );
		$validacion->completo = $completo;
		if ( !$validacion->validar() )
		{
			throw new ModeloException( $validacion->getErrores( $union ) );
		}
	}
}
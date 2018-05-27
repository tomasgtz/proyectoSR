<?php
namespace tequila\contexto;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Clase base para los distintos tipos de relaciones entre Cxmodelos
*
* Las clases derivadas realizarán consultas desde los contextos para buscar Cxmodelos
* relacionados y devolverlos
*
* @package	tequila.contexto
* @author	isaac
* @version	1
*/
abstract class Relacion{
	/**
	* Cxmodelo donde se buscará la relación
	*
	* @access	protected
	* @var		Cxmodelo
	*/
	protected $modelo;
	
	/**
	* Contexto de relación
	*
	* @access	protected
	* @var		Contexto
	*/
	protected $contexto;
	
	/**
	* Constructor
	*
	* Establece el modelo principal y el contexto de la relación
	*
	* @param	Cxmodelo	$modelo			El modelo principal
	* @param	Contexto	$contexto		El contexto de la relación
	* @param	string		$nombre			nombre de la relación
	* @access	public
	*/
	public function __construct( Cxmodelo $modelo, Contexto $contexto )
	{
		$this->modelo = $modelo;
		$this->contexto = $contexto;
	}
	
	/**
	* Función abstracta
	*
	* En esta función se devuelve el resultado de la relación
	*
	* @access	public
	* @return	mixed
	*/
	abstract public function ejecutar();
}
<?php
namespace tequila\contexto;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Los resultados de una consulta en base de datos se pasan a Cxmodelos
*
* Recibe un arreglo como los obtenidos en una consulta de base de datos
* y recibe un Contexto para obtener la colección de Cxmodelos
*
* @package	tequila.contexto
* @author	isaac
* @version	1
*/
class Resultado{
	/**
	* Arreglo original de resultados
	*
	* @access	private
	* @var		array
	*/
	private $originales;
	
	/**
	* Arreglo con los resultados en forma de Contexto
	*
	* @access	private
	* @var		public
	*/
	private $resultados = array();
	
	/**
	* Contexto que llamó este resultado
	*
	* @access	private
	* @var		Contexto
	*/
	private $contexto;
	
	/**
	* Constructor
	*
	* Recibe los resultados originales y el contexto que instanciará
	* los Cxmodelos
	*
	* @param	array		$originales		Resultados a parsear
	* @param	Contexto	$contexto		El contexto de los modelos
	* @access	public
	*/
	public function __construct( array $originales, Contexto $contexto )
	{
		$this->originales = $originales;
		$this->contexto = $contexto;
	}
	
	/**
	* Instancía los resultados originales en Cxmodelos
	*
	* @access	public
	*/
	public function instanciar()
	{
		foreach ( $this->originales as $objeto => $propiedades )
		{
			$modelo = $this->contexto->instancia();
			foreach ( $propiedades as $propiedad => $valor )
			{
				$modelo->$propiedad = $valor;
			}
			$this->resultados[] = $modelo;
		}
	}
	
	/**
	* Devuelve los resultados en el arreglo original
	*
	* @access	public
	* @return	array
	*/
	public function originales()
	{
		return $this->originales;
	}
	
	/**
	* Devuelve los modelos en un arreglo
	*
	* @access	public
	* @return	array
	*/
	public function lista()
	{
		$this->instanciar();
		return $this->resultados;
	}
	
	/**
	* Devuelve el primer modelo del arreglo de resultados
	*
	* En caso de no existir ningún modelo en el resultado
	* se devuelve "null"
	*
	* @access	public
	* @return	Cxmodelo
	*/
	public function unico()
	{
		$this->instanciar();
		return empty( $this->resultados ) ? null : $this->resultados[0];
	}
}
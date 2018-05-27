<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Encabezado html que se pueden añadir a las páginas master
*
* @package	tequila.mvc.vistas
* @author	isaac
* @version	1
*/
class Paquete{
	/**
	* Atributos que tendrá el encabezado
	*
	* @access	protected
	* @var		array
	*/
	protected $atributos = array();

	/**
	* Nombre del encabezado a imprimir
	*
	* @access	protected
	* @var		
	*/
	protected $encabezado;

	/**
	* Constructor
	*
	* Establece el arreglo de atributos
	*
	* @param	string		$encabezado		La etiqueta que se imprmirá en el encabezado
	* @param	array		$atributos		Atributos que compondrán el encabezado
	* @access	public
	*/
	public function __construct( $encabezado, array $atributos )
	{
		$this->encabezado = $encabezado;
		$this->atributos = $atributos;
	}

	/**
	* Imprime el paquete
	*
	* @access	public
	*/
	public function dibujar()
	{
		return Html::abrir( $this->encabezado, $this->atributos );
	}
}
<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Metatag para la pagina html
*
* @package	tequila.mvc
* @author	isaac
* @version	1
*/
class Metatag extends Paquete{
	/**
	* Constructor
	*
	* @param	array		$atributos		Atributos que compondrán el encabezado
	* @access	public 
	*/
	public function __construct( array $atributos )
	{
		parent::__construct( 'meta', $atributos );
	}
}
<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Icono para la pagina html
*
* @package	tequila.mvc
* @author	isaac
* @version	1
*/
class Icono extends Paquete{
	/**
	* Constructor
	*
	* @param	string		$referencia		El nombre del icono a cargar
	* @access	public 
	*/
	public function __construct( $referencia )
	{
		if ( strpos( $referencia, ':' ) === false )
		{
			$referencia = URL . 'recursos' . US . 'iconos' . US . $referencia;
		}
		parent::__construct( 'link', array( 'rel' => 'shortcut icon', 'type' => 'image/png', 'href' => $referencia ) );
	}
}
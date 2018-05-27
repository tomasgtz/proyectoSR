<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Archivo css para la pagina html
*
* @package	tequila.mvc
* @author	isaac
* @version	1
*/
class Css extends Paquete{
	/**
	* Constructor
	*
	* @param	string		$referencia		El nombre del icono a cargar
	* @param	string		$version		Versión del archivo
	* @access	public 
	*/
	public function __construct( $referencia, $version = null )
	{
		if ( strpos( $referencia, '//' ) === false )
		{
			if ( $referencia[ 0 ] != '/' )
			{
				$referencia = URL . 'recursos' . US . 'css' . US . $referencia . '.css';
			}
			else
			{
				$referencia = URL . ltrim( $referencia, '/' ) . '.css';
			}
		}
		if ( isset( $version ) )
		{
			$referencia .= '?v=' . $version;
		}
		parent::__construct( 'link', array( 'type' => 'text/css', 'rel' => 'stylesheet', 'href' => $referencia ) );
	}
}
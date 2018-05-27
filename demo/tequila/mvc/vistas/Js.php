<?php
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Archivo js para la pagina html
*
* @package	tequila.mvc
* @author	isaac
* @version	1
*/
class Js extends Paquete{
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
				$referencia = URL . 'recursos' . US . 'js' . US . $referencia . '.js';
			}
			else
			{
				$referencia = URL . ltrim( $referencia, '/' ) . '.js';
			}
		}		
		if ( isset( $version ) )
		{
			$referencia .= '?v=' . $version;
		}
		parent::__construct( 'script', array( 'type' => 'text/javascript', 'src' => $referencia ) );
	}

	/**
	* Imprime este paquete
	*
	* @access	public
	* @return	string
	*/
	public function dibujar()
	{
		return parent::dibujar() . Html::cerrar( 'script' );
	}
}
<?php
namespace tequila\libreria\respuesta;
use tequila\libreria\respuesta\Respuesta, tequila\mvc\Vista;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Manda de respuesta a una petición un xml con sus debidos encabezados.
*
* @package	tequila.libreria.respuesta
* @author	isaac
* @version	1
*/
class RespuestaXml extends Respuesta{
	/**
	* Constructor
	*
	* Recibe un arreglo y lo convierte en contenido xml
	*
	* @param	array	$xml			El xml a desplegar
	* @param	array	$encabezados	Arreglo de encabezados opcionales
	* @access	public
	*/
	public function __construct( array $xml, array $encabezados = array() )
	{
		parent::__construct( $encabezados );
		$this->contenido = Xml::encode( $xml );
		$this->type = 'application/xml';
	}

	/**
	* Esta clase recibe un arreglo de php y generá un xml con una composición similar
	*
	* @param	array		$arreglo	El arreglo de php a convertir en texto xml
	* @access	private
	* @return	string
	*/
	private function encode( array $arreglo )
	{
		$documento = new \DOMDocument( '1.0' );
		$global = new \DOMElement( 'XML' );
		$documento->appendChild( $global );
		self::elemento( $arreglo, $global );
		return $documento->saveXml();
	}

	/**
	* Crea un elemento de un archivo xml
	*
	* @param	array			$arreglo		El elemento que se añadirá al archivo
	* @param	DOMDocument		$documento		El documento donde se añadirán los elementos
	* @access	private
	*/
	private function elemento( array $arreglo, \DOMNode $nodo )
	{
		foreach ( $arreglo as $indice => $valor )
		{
			if ( is_int( $indice ) )
			{
				$indice = '_' . $indice;
			}
			if ( is_array( $valor ) )
			{
				$elemento = new \DOMElement( $indice );
				$nodo->appendChild( $elemento );
				self::elemento( $valor, $elemento );
			}
			else
			{
				$elemento = new \DOMElement( $indice, $valor );
				$nodo->appendChild( $elemento );
			}
		}
	}
}
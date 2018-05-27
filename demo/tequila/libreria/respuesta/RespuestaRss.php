<?php
namespace tequila\libreria\respuesta;
use tequila\libreria\respuesta\Respuesta;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Manda de respuesta a una petición del tipo rss
*
* @package	tequila.libreria.respuesta
* @author	isaac
* @version	1
*/
class RespuestaRss extends Respuesta{
	/**
	* Opciones del rss
	*
	* Conjunto de etiquetas que lleva el xml
	*
	* @access	private
	* @var		array
	*/
	private $opciones = array();

	/**
	* Constructor
	*
	* Recibe un arreglo y lo convierte en contenido xml
	*
	* @param	array	$xml			El xml a desplegar
	* @param	array	$encabezados	Arreglo de encabezados opcionales
	* @access	public
	*/
	public function __construct( array $xml, array $opciones = array(), array $encabezados = array() )
	{
		parent::__construct( $encabezados );
		$this->opciones = $opciones;
		$this->contenido = $this->rss( $xml );
		$this->type = 'application/rss+xml';
	}

	/**
	* Esta clase recibe un arreglo de php y generá un xml con una composición similar
	*
	* @param	array		$arreglo	El arreglo de php a convertir en texto xml
	* @access	private
	* @return	string
	*/
	private function rss( array $arreglo )
	{
		$documento = new \DOMDocument( '1.0', 'UTF-8' );
		$rss = $documento->createElement( 'rss' );
		$rss->setAttribute( 'version', '2.0' );
		$channel = new \DOMElement( 'channel' );
		$documento->appendChild( $rss );
		$rss->appendChild( $channel );
		foreach ( $this->opciones as $opcion => $valor )
		{
			$node = new \DOMElement( $opcion, $valor );
			$channel->appendChild( $node );
		}
		$this->generar( $arreglo, $channel );
		return $documento->saveXml();
	}

	/**
	* Genera los elementos del rss
	*
	* @param	array			$arreglo	El elemento que se añadirá al archivo
	* @param	DOMNode			$nodo		El nodo donde se añadirán los elementos
	* @access	private
	*/
	private function generar( array $arreglo, \DOMNode $nodo )
	{
		foreach ( $arreglo as $registro )
		{
			$item = new \DOMElement( 'item' );
			$nodo->appendChild( $item );
			foreach ( $registro as $indice => $valor )
			{
				$elemento  = new \DOMElement( $indice, $valor );
				$item->appendChild( $elemento );
			}
		}
	}
}
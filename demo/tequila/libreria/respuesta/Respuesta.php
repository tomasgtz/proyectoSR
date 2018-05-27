<?php
namespace tequila\libreria\respuesta;
use tequila\inicio\Boot;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Ayuda en la elaboración de respuestas al navegador
*
* Maneja tres tipos de respuestas:
* vista, jsons y texto.
* Tiene funciones para establecer encabezados, códigos de estatus y charsets
*
* @package	tequila.libreria.respuesta
* @author	isaac
* @version	1
*/
class Respuesta{
	/**
	* Charset de la respuesta
	*
	* Por defecto será utf-8
	*
	* @access	public
	* @var		string
	*/
	public $charset = 'utf-8';
	
	/**
	* Content type de la respuesta
	*
	* Por defecto será text/html
	*
	* @access	public
	* @var		string
	*/
	public $type = 'text/html';
	
	/**
	* Código del estatus de la respuesta
	*
	* Por defecto es 200 (exitoso)
	*
	* @access	public
	* @var		int
	*/
	public $codigo = 200;

	/**
	* Protocolo que utiliza la petición
	*
	* @access	public
	* @var		string
	*/
	public $protocolo;
	
	/**
	* Encabezados que serán enviados a la respuesta
	*
	* @access	private
	* @var		array
	*/
	private $encabezados = array();
	
	/**
	* Colección con los mensajes de estatus más comunes
	*
	* @access	private
	* @var		array
	*/
	private $mensajes = array(
		'200' => 'OK',
		'300' => 'Multiple Choices',
		'301' => 'Moved Permanently',
		'302' => 'Found',
		'304' => 'Not Modified',
		'307' => 'Temporary Redirect',
		'400' => 'Bad Request',
		'401' => 'Unauthorized',
		'403' => 'Forbidden',
		'404' => 'Not Found',
		'410' => 'Gone',
		'500' => 'Internal Server Error',
		'501' => 'Not Implemented',
		'503' => 'Service Unavailable',
		'550' => 'Permission denied'
	);
	
	/**
	* Contenido a desplegar al navegador
	*
	* @access	protected
	* @var		string
	*/
	protected $contenido = '';
	
	/**
	* Constructor
	*
	* Establece los encabezados que puede tener la respuesta
	*
	* @param	array		$encabezados	Encabezados de la respuesta, es un arreglo de strings
	* @access	public
	*/
	public function __construct( array $encabezados )
	{
		$this->encabezados = $encabezados;
		$this->protocolo = Boot::$peticion->server( 'SERVER_PROTOCOL' );
	}
	
	/**
	* Imprime el contenido guardado y termina el script
	*
	* @access	public
	*/
	public function enviar()
	{
		$this->enviarEncabezados();
		echo $this->contenido;
		exit( 0 );
	}
	
	/**
	* Manda los encabezados añadidos y los que se lanzan por defecto
	*
	* @access	private
	*/
	private function enviarEncabezados()
	{
		$encabezado = 'Content-Type: ' . $this->type . '; charset=' . $this->charset;
		$this->encabezados[] = $encabezado;
		foreach ( $this->encabezados as $header )
		{
			header( $header );
		}
		$mensaje = array_key_exists( $this->codigo, $this->mensajes ) ?	$this->mensajes[$this->codigo] : 'Undefined Message';
		header( ' ' . $this->protocolo . ' ' . $mensaje, true, $this->codigo );
	}
}
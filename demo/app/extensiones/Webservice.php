<?php
namespace app\extensiones;
use tequila\mvc\Controlador;
/**
* Clase base para los webservices
*
* @author	isaac
* @package	tienda
* @version	1
*/
class Webservice extends Controlador{
	/**
	* Propiedad que contiene los encabezados necesarios para el webservice
	*
	* @access	protected
	* @var		array
	*/
	protected $encabezados = array(
		'Access-Control-Allow-Origin: *',
		'Access-Control-Allow-Headers: origin, x-requested-with, accept, authentication, content-type',
		'Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS'
	);

	/**
	* Clave de seguridad de los webservices
	*
	* @access	protected
	* @var		string
	*/
	protected $password = 'aW5uc2VydDpwYXNzVzAmRA==';

	/**
	* Bandera que indica si la petición pasó la autenticación
	*
	* @access	protected
	* @var		bool
	*/
	protected $autenticada = false;

	/**
	* Constructor
	*
	* Contiene una validación con una llave de seguridad
	*
	* @access	public
	*/
	public function __construct()
	{
		parent::__construct();
		$headers = $this->peticion->headers();
		$password = isset( $headers[ 'Authentication' ] ) ? $headers[ 'Authentication' ] : '';
		if ( isset( $password ) && $password == $this->password )
		{
			$this->autenticada = true;
		}
	}

	/**
	* Respuesta para las peticiones "OPTIONS"
	*
	* @access	protected
	* @return	RespuestaJson
	*/
	protected function respuestaOptions()
	{
		return $this->respuestaJson( array( 'estatus' => 'OPTIONS' ), $this->encabezados );
	}

	/**
	* Respuesta de error cuando no se pasaron la autenticación
	*
	* @access	protected
	* @return	RespuestaJson
	*/
	protected function peticionNoAutenticada()
	{
		return $this->respuestaJson( array( 'estatus' => 'ERROR', 'mensaje' => 'ERROR' ), $this->encabezados );
	}
}
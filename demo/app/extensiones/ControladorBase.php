<?php
namespace app\extensiones;
use tequila\mvc\Controlador, tequila\contexto\Contexto, \Leng, \Sess, \Membresia;
/**
* Clase base para los módulos del sistema
*
* @author	isaac
* @package	tienda
* @version	1
*/
class ControladorBase extends Controlador{
	/**
	* Propiedad que contiene la clase de lenguaje
	*
	* @access	protected
	* @var		Lenguaje
	*/
	protected $leng;

	/**
	* Constructor
	*
	* Inicializa el arreglo de selección del menú lateral
	*
	* @access	public
	*/
	public function __construct()
	{
		parent::__construct();
		$this->leng = Leng::instanciaDefault();;
	}

	/**
	* Genera una consulta para combobox (select)
	*
	* @param	Contexto	$contexto		El contexto del que se obtendrán los datos
	* @param	string		$propiedad		La propiedad visible en el select
	* @access	protected
	* @return	array
	*/
	public function select( Contexto $contexto, $propiedad )
	{
		return $contexto->obtener( array( $propiedad ) )->buscar()->lista();
	}

	/**
	* Realiza una validación de una variable en sesión, si no se encuentra cierra sesión
	*
	* @access	public
	* @param	string		$espacio	El espacio donde se buscarán los permisos especiales
	* @param	string		$permiso	El permiso a buscar
	* @return	Redirect
	*/
	public function permisoEspecial( $espacio, $permiso )
	{
		if ( !in_array( $permiso, Sess::instanciaDefault()->get( $espacio ) ) )
		{
			return Membresia::instanciaDefault()->sinLicencia();
		}
	}
}
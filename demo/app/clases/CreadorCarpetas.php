<?php
namespace app\clases;
/**
* Clase que representa un item del menu principal
*
* @author	isaac
* @package	clases
* @version	1
*/
class CreadorCarpetas{
	/**
	* Ruta origen de las carpetas
	*
	* @access	public
	* @var		string
	*/
	public $ruta;

	/**
	* Carpetas a añadir a una dirección
	*
	* @access	public
	* @var		array
	*/
	public $carpetas = array();

	/**
	* Resultado de la ruta origen más las carpetas
	*
	* @access	public
	* @var		string
	*/
	public $resultado;

	/**
	* Constructor
	*
	* Asigna los valores de la clase
	*
	* @param	string		$ruta		La ruta origen
	* @param	array		$carpetas	Las carpetas a añadir a la ruta
	* @access	public
	*/
	public function __construct( $ruta, array $carpetas = array() )
	{
		$this->ruta = $ruta;
		$this->carpetas = $carpetas;
	}

	/**
	* Crea la nueva carpeta, asigna y devuelve el resultado
	*
	* @access	public
	* @return	string
	*/
	public function crear()
	{
		$this->resultado = $this->ruta;
		foreach ( $this->carpetas as $carpeta )
		{
			$this->resultado .= DS . $carpeta;
			if ( !is_dir( $this->resultado ) )
			{
				mkdir( $this->resultado );
			}
		}
		return $this->resultado;
	}
}
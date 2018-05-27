<?php
namespace app\controladores;
use app\extensiones\ControladorBase, \Url;
/**
* Controlador para el demo
*
* @author	isaac
* @package	localnet
* @version	1
*/
class inicioControlador extends ControladorBase{
	/**
	* Ruta base de fondos
	*
	* @access	private
	* @var		string
	*/
	private $backgroundsRoot = '/recursos/uploads/backgrounds';

	/**
	* Ruta base de imagenes
	*
	* @access	private
	* @var		string
	*/
	private $imagesRoot = '/recursos/uploads/images';

	/**
	* Carpeta default de background
	*
	* @access	private
	* @var		string
	*/
	private $backgroundDefault = 'Predeterminadas';

	/**
	* Carpeta default de imagenes
	*
	* @access	private
	* @var		string
	*/
	private $imagesDefault = 'Predeterminadas';

	/**
	* Muestra la pantalla de diseño
	*
	* @access	public
	*/
	public function index()
	{
		return $this->respuestaVista( 'design' );
	}

	/**
	* Carga los fondos de una carpeta
	*
	* @access	public
	*/
	public function loadBackgrounds( $folder = 'Predeterminadas' )
	{
		$imagenesDeFondo = array_diff( scandir( getcwd() . '/recursos/uploads/backgrounds' . '/' . $folder ), array( '.', '..' ) );
		foreach ( $imagenesDeFondo as &$imagen )
		{
			$imagen = Url::hacer( 'recursos/uploads/backgrounds', $folder, $imagen );
		}
		return $this->respuestaJson( array( 'estatus' => 'exito', 'images' => $imagenesDeFondo ) );
	}

	/**
	* Carga las imagenes de una carpeta
	*
	* @access	public
	*/
	public function loadImages( $folder = 'Predeterminadas' )
	{
		$imagenesGraficas = array_diff( scandir( getcwd() . '/recursos/uploads/images' . '/' . $folder ), array( '.', '..' ) );
		foreach ( $imagenesGraficas as &$imagen )
		{
			$imagen = Url::hacer( 'recursos/uploads/images', $folder, $imagen );
		}
		return $this->respuestaJson( array( 'estatus' => 'exito', 'images' => $imagenesGraficas ) );
	}
}
<?php
namespace app\clases;
use \Html;
/**
* Clase que representa un item del menu principal
*
* @author	isaac
* @package	clases
* @version	1
*/
class Item{
	/**
	* Arreglo de atributos que tendrá el item
	*
	* @access	public
	* @var		array
	*/
	public $attrs = array();

	/**
	* Icono de cierre que tendrá el item
	*
	* @access	public
	* @var		string
	*/
	public $icon;

	/**
	* Constructor
	*
	* Establece los valores del item
	*
	* @param	array	$clase		La clase html que tendrá el item
	* @param	string	$icon		El tipo de caret que se añade al final del texto del item
	* @access	public
	*/
	public function __construct( $clase = null, $icon = 'right' )
	{
		if ( isset( $clase ) )
		{
			$this->attrs[ 'class' ] = $clase;
		}
		$this->icon = Html::elemento( 'i', '', array( 'class' => 'fa ct fa-caret-' . $icon ) );
	}
}
<?php
namespace tequila\scaffolding;
/**
* Esta clase creo los modelos físicamente
*
* @package	tequila.scaffolding
* @author	isaac
* @version	1
*/
class Modelo{
	/**
	* Clase scaffolfing
	*
	* @access	private
	* @var		Scaffolding
	*/
	private $data;

	/**
	* Nombre del modelo
	*
	* @access	private
	* @var		string
	*/
	private $nombre;

	/**
	* Constructor
	*
	* Establece el objeto scaffolding
	* Remueve la pluralización de la clase para nombrar al modelo
	*
	* @param	Scaffolding		$scaffolding		El scaffolding de la generación
	* @access	public
	*/
	public function __construct( $scaffolding )
	{
		$this->data = $scaffolding;
		if ( substr( $this->data->nombre, -3 ) == 'nes' )
		{
			$this->nombre = substr( $this->data->nombre, 0, -2 );
		}
		else
		{
			$this->nombre = substr( $this->data->nombre, 0, -1 );
		}
	}

	/**
	* Generación del archivo
	*
	* @access	public
	*/
	public function generar()
	{
		$ruta = $this->data->ruta;
		$proyecto = $this->data->proyecto;
		$generacion = <<<TEXTO
<?php
namespace app\modelos{$ruta};
use tequila\contexto\Cxmodelo;
/**
* Objeto de la tabla de {$this->nombre}
*
* @package	{$proyecto}.modelos
* @author	scaffolding
* @version	1
*/
class {$this->nombre} extends Cxmodelo{

}
TEXTO;
		if ( empty ( $this->data->ruta ) )
		{
			$archivo = 'app' . DS . 'modelos' . DS;
		}
		else
		{
			$archivo = 'app' . DS . 'modelos' . DS . join( DS, $this->carpetas ) . DS;
		}
		if ( file_put_contents( $archivo . $this->nombre . '.php', $generacion ) )
		{
			echo 'modelo "' . $this->nombre . '" generado! :D<br/>';
		}
		else
		{
			echo 'Error :(<br/>';
		}
	}
}
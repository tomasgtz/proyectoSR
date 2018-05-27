<?php
namespace tequila\plugins\mail;
use tequila\mvc\vistas\Vista, \stdClass;
/**
* Esta clase representa un correo electrónico
*
* Se debe instanciar un objeto por correo.
* No es recomendable para enviar varios correos en un ciclo
*
* @package	tequila.utilidades
* @author	isaac
* @version	2
*/
class Mail{

	/**
	* Correo electrónico de la persona que envía el correo
	*
	* @access	private
	* @var		string
	*/
	private $de;
	/**
	* Correos de las personas que recibiran el correo
	*
	* @access	private
	* @var		array
	*/
	private $para = array();

	/**
	* Copias al correo electrónico
	*
	* @access	private
	* @var		array
	*/
	private $copias = array();

	/**
	* Copias ocultas que se enviarán
	*
	* @access	private
	* @var		array
	*/
	private $ocultas = array();

	/**
	* Contrenido del correo electrónico
	*
	* @access	private
	* @var		string
	*/
	private $contenido;

	/**
	* Título del correo electrónico
	*
	* @access	private
	* @var		string
	*/
	private $titulo;

	/**
	* El encabezado del charset que manejará el correo
	*
	* @access	public
	* @var		string
	*/
	public $charset = 'Content-type: text/plain; charset=utf-8';

	/**
	* Encabezados del correo electrónico
	*
	* @access	private
	* @var		array
	*/
	private $encabezados = array();

	/**
	* Establece el correo que envía el mensaje
	*
	* @param	string		$correo		El correo de quien envía
	* @param	string		$nombre		El nombre de quien envía
	* @access	public
	*/
	public function setDe( $correo, $nombre = null )
	{
		$this->de = !isset( $nombre ) ? $correo : "$nombre <$correo>";
	}

	/**
	* Establece los correos electrónicos receptores
	*
	* @param	array		$correos		Lista de correos receptores
	* @access	public
	*/
	public function setPara( array $correos )
	{
		$this->setCorreos( $this->para, $correos );
	}

	/**
	* Establece los correos receptores en copia
	*
	* @param	array		$correos		Lista de correos copias
	* @access	public
	*/
	public function setCopias( array $correos )
	{
		$this->setCorreos( $this->copias, $correos );
	}

	/**
	* Establece los correos receptores en copia oculta
	*
	* @param	array		$correos		Lista de correos copias ocultas
	* @access	public
	*/
	public function setCopiasOcultas( $correo )
	{
		$this->setCorreos( $this->ocultas, $correos );
	}

	/**
	* Establece el título del correo
	*
	* @param	string	$titulo	El título del correo
	* @access	public
	*/
	public function setTitulo( $titulo )
	{
		$this->titulo = $titulo;
	}

	/**
	* Añade el contenido del mensaje desde una vista
	*
	* @param	string		$vista		La ruta de la vista partiendo de 'app/vistas'
	* @param	array		$coleccion	Objetos que se mandarán a la vista
	* @access	public
	*/
	public function setVista( $vista, array $coleccion = array() )
	{
		$contenido = new Vista( $vista, (object) $coleccion );
		$contenido->generar();
		$this->charset = 'Content-type: text/html; charset=utf-8';
		$this->mensaje = $contenido->dibujar();
	}

	/**
	* Añade el contenido del mensaje como texto
	*
	* @param	string		$contenido		El contenido del correo
	* @param	bool		$html			Bandera que indica si el correo se despliega como html
	* @access	public
	*/
	public function setContenido( $contenido, $html = false )
	{
		if ( $html )
		{
			$this->charset = 'Content-type: text/html; charset=utf-8';
		}
		$this->mensaje = $contenido;		
	}

	/**
	* Añade una lista de correos al arreglo establecido
	*
	* @param	array		$arreglo		El arreglo a llenar (Por referencia)	
	* @param	array		$correos		Lista de correos copias ocultas
	* @access	private
	*/
	private function setCorreos( array &$arreglo, array $correos )
	{
		foreach ( $correos as $correo => $opcional )
		{
			$arreglo[] = is_int( $correo ) ? $opcional : "$opcional <$correo>";
		}
	}

	/**
	* Añade encabezados directos al correo
	*
	* @param	string		$encabezado		Contenido del encabezado
	* @access	public
	*/
	public function addEncabezado( $encabezado )
	{
		$this->encabezados[] = $encabezado;
	}

	/**
	* Envía el correo electrónico
	*
	* @access	public
	* @return	bool
	*/
	public function enviar()
	{
		$encabezados = array( 'MIME-Version: 1.0', $this->charset );
		if ( isset( $this->de ) )
		{
			$encabezados[] = 'From: ' . $this->de;
		}
		if ( !empty( $this->copias ) )
		{
			$encabezados[] = 'Cc: ' . join( ', ', $this->copias );
		}
		if ( !empty( $this->ocultas ) )
		{
			$encabezados[] = 'Bcc: ' . join( ', ', $this->ocultas );
		}
		$encabezados = array_merge( $encabezados, $this->encabezados );
		return mail( join( ', ', $this->para ), $this->titulo, $this->mensaje,  join( "\r\n", $encabezados ) );
	}
}
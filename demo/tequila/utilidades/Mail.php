<?php
namespace tequila\utilidades;
/**
* Esta clase representa un correo electrónico
*
* Se debe instanciar un objeto por correo.
* No es recomendable para enviar varios correos en un ciclo
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
class Mail{
	/**
	* Tipo de charset del correo
	*
	* Puede ser "html" o "texto"
	*
	* @access	private
	* @var		string
	*/
	private $tipo;

	/**
	* Correos de las personas que recibiran el correo
	*
	* @access	private
	* @var		array
	*/
	private $para = array();

	/**
	* Correo electrónico de la persona que envía el correo
	*
	* @access	public
	* @var		string
	*/
	public $de;

	/**
	* Contrenido del correo electrónico
	*
	* @access	private
	* @var		string
	*/
	private $mensaje;

	/**
	* Título del correo electrónico
	*
	* @access	private
	* @var		string
	*/
	private $titulo;

	/**
	* Encabezados del correo electrónico
	*
	* @access	private
	* @var		array
	*/
	private $encabezados = array();

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
	* Separador para el mensaje del correo y para los encabezados
	*
	* @static
	* @access	public
	*/
	const SEPARADOR = "\r\n";

	/**
	* Constructor
	*
	* Establece el tipo de correo que se mandará (html/text)
	*
	* @param	string		$titulo		El título del correo a enviarse
	* @param	string		$mensaje	El copntenido del correo electrónico
	* @param	string		$tipo		El tipo de mime del correo
	* @access	public
	*/
	public function __construct( $titulo, $mensaje, $tipo = 'html' )
	{
		$this->titulo = $titulo;
		$this->mensaje = $mensaje;
		$this->tipo = $tipo;
	}

	/**
	* Añade un correo electrónico para recibir
	*
	* @param	string		$correo		Correo electrónico a añadir
	* @access	public
	*/
	public function addPara( $correo )
	{
		$this->para[] = $correo;
	}

	/**
	* Añade copias al correo
	*
	* @param	string		$correo		Añade copias que se enviarán
	* @access	public
	*/
	public function addCopia( $correo )
	{
		$this->copias[] = $correo;
	}

	/**
	* Añade copias ocultas al correo
	*
	* @param	string		$correo		Añade copias ocultas al correo
	* @access	public
	*/
	public function addOculta( $correo )
	{
		$this->ocultas[] = $correo;
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
		$encabezados = array( 'MIME-Version: 1.0' );
		if ( $this->tipo == 'html' )
		{
			$encabezados[] = 'Content-type: text/html; charset=utf-8';
		}
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
		return mail( join( ', ', $this->para ), $this->titulo, $this->mensaje,  join( self::SEPARADOR, $encabezados ) );
	}
}
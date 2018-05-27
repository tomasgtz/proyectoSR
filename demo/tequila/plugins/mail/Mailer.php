<?php
namespace tequila\plugins\mail;
use tequila\mvc\vistas\Vista, \PHPMailer, \stdClass;
/**
* Clase intermediaria con PHPMailer para mandar correos electrónicos
*
* Es posible generar los contenidos de los correos en vistas
*
* @package	utilidades
* @author	isaac
* @version	1
*/
class Mailer{
	/**
	* Objeto de PHPMailer
	*
	* @access	public
	* @var		PHPMailer
	*/
	public $phpMailer;

	/**
	* Valor para Debugging (0 => producción, 1 => mensaje cliente, 2 => mensaje cliente servidor)
	*
	* @access	public
	* @var		int
	*/
	public $debug = 0;

	/**
	* SMTP que usará el mailer (gmail = smtp.gmail.com)
	*
	* @access	public
	* @var		string
	*/
	public $smtp = 'a2plcpnl0047.prod.iad2.secureserver.net';

	/**
	* Puerto que utilizará el smtp (gmail = 587)
	*
	* Para ssl = 465; Para tls = 587;
	*
	* @access	public
	* @var		int
	*/
	public $puerto = 465;

	/**
	* Tipo de conexión que se usará (gmail = tls)
	*
	* 'tls' - 'ssl'
	*
	* @access	public
	* @var		string
	*/
	public $conexion = 'ssl';

	/**
	* Nombre de usuario de la cuenta
	*
	* @access	public
	* @var		string
	*/
	public $usuario = 'contacto@innsert.com';

	/**
	* Password de la cuenta
	*
	* @access	public
	* @var		string
	*/
	public $password = 'tr3snnI!!';

	/**
	* Constructor
	*
	* Importa la librería
	*
	* @access	public
	*/
	public function __construct()
	{
		if ( !class_exists( 'PHPMailer', false ) )
		{
			require 'tequila' . DS . 'plugins' . DS . 'mail' . DS . 'PHPMailer' . DS . 'PHPMailerAutoload' . EXT;
		}
		$this->phpMailer = new PHPMailer;
		$this->phpMailer->CharSet = "UTF-8";
		$this->phpMailer->SMTPDebug = $this->debug;
	}

	/**
	* Añade el correo que envía
	*
	* @param	string		$correo		El correo de quien lo envía
	* @param	string		$nombre		El nombre de quien lo envía
	* @access	public
	*/
	public function setDe( $correo, $nombre = null )
	{
		$this->phpMailer->setFrom( $correo, $nombre );
	}

	/**
	* Añade receptores al correo con un arreglo
	*
	* @param	array	$receptores		Lista de correos a los que se enviará
	* @access	public
	*/
	public function setPara( array $receptores )
	{
		foreach ( $receptores as $receptor => $opcional )
		{
			if ( is_int( $receptor ) )
			{
				$this->phpMailer->addAddress( $opcional );
			}
			else
			{
				$this->phpMailer->addAddress( $receptor, $opcional );
			}
		}
	}

	/**
	* Establece los correos receptores en copia
	*
	* @param	array		$correos		Lista de correos copias
	* @access	public
	*/
	public function setCopias( array $correos )
	{
		foreach ( $correos as $receptor => $opcional )
		{
			if ( is_int( $receptor ) )
			{
				$this->phpMailer->AddCC( $opcional );
			}
			else
			{
				$this->phpMailer->AddCC( $receptor, $opcional );
			}
		}
	}

	/**
	* Establece los correos receptores en copia oculta
	*
	* @param	array		$correos		Lista de correos copias ocultas
	* @access	public
	*/
	public function setCopiasOcultas( $correos )
	{
		foreach ( $correos as $receptor => $opcional )
		{
			if ( is_int( $receptor ) )
			{
				$this->phpMailer->AddBCC( $opcional );
			}
			else
			{
				$this->phpMailer->AddBCC( $receptor, $opcional );
			}
		}
	}

	/**
	* Establece el título del correo
	*
	* @param	string	$titulo	El título del correo
	* @access	public
	*/
	public function setTitulo( $titulo )
	{
		$this->phpMailer->Subject = $titulo;
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
		$this->phpMailer->IsHTML( true );
		$contenido->generar();
		$this->phpMailer->Body = $contenido->dibujar();
	}

	/**
	* Añade el contenido del mensaje como texto
	*
	* @param	string		$contenido		El contenido del correo
	* @param	bool		$html			Bandera que indica si el contenido se despliega como html
	* @access	public
	*/
	public function setContenido( $contenido, $html = false )
	{
		$this->phpMailer->IsHTML( $html );
		$this->phpMailer->Body = $contenido;
	}

	/**
	* Envía el correo con las configuraciones establecidas
	*
	* @access	public
	* @return	bool
	*/
	public function enviar()
	{
		if ( isset( $this->smtp ) )
		{
			$this->phpMailer->isSmtp();
			$this->phpMailer->Host = $this->smtp;
			$this->phpMailer->SMTPAuth = true;
			if ( isset( $this->conexion ) )
			{
				$this->phpMailer->SMTPSecure = $this->conexion;
			}
			$this->phpMailer->Port = $this->puerto;
			$this->phpMailer->Username = $this->usuario;
			$this->phpMailer->Password = $this->password;
		}
		return $this->phpMailer->send();
	}
}
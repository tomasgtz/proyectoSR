<?php
namespace tequila\utilidades\uploader;
use tequila\sistema\ColeccionErrores, \arrayaccess, \iterator;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Recibe un arreglo de archivos subidos por el usuario
*
* Los guarda en el servidor
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
class Uploader extends ColeccionErrores implements arrayaccess, iterator{
	/**
	* Ruta del archivo de configuraci�n de la clase
	*
	* @access	protected
	* @var		array
	*/
	protected $_ruta = array( 'tequila', 'utilidades', 'configuraciones', 'uploader' );
	
	/**
	* Mime-types aceptados por el objeto actual
	*
	* @access	private
	* @var		array
	*/
	private $mimes = array();
	
	/**
	* Ruta donde se guardar�n los archivos a guardar
	*
	* @access	public
	* @var		string
	*/
	public $carpeta;

	/**
	* Propiedad que indica si no existen archivos en el objeto
	*
	* @access	public
	* @var		bool
	*/
	public $vacio = false;
	
	/**
	* Arreglo con los archivos a guardar
	*
	* El arreglo orignal de archivos tiene un formato p�simo,
	* se parsea y reacomodan en este arreglo
	*
	* @access	public
	* @var		array
	*/
	public $archivos = array();

	/**
	* Bandera sobre la regla de archivo existente
	*
	* Si la bandera es verdadera se producir� un error
	*
	* @access	private
	* @var		bool
	*/
	private $existente;
	
	/**
	* Constructor
	*
	* Recibe la ruta donde se guaradr�n los archivos,
	* los mime types aceptados y el arreglo de archivos
	*
	* @param	array		$archivos	El arreglo de archivos
	* @param	array		$mimes		Los mimeTypes aceptados
	* @param	string		$carpeta	La ruta donde se guaradr�n los archivos
	* @param	bandera		$existente	Bandera sobre la reglas de archivos existentes
	* @access	public
	*/
	public function __construct( array $archivos, array $mimes, $carpeta, $existente = false )
	{
		parent::__construct();
		$this->existente = $existente;
		if ( !empty( $archivos ) )
		{
			if ( is_array( $archivos['name'] ) )
			{
				$arreglos = array();
				foreach ( array_keys( $archivos['name'] ) as $key )
				{
					foreach ( $archivos as $opcion => $values )
					{
						$arreglos[$key][$opcion] = $values[$key];
					}
				}
				foreach ( $arreglos as $arreglo )
				{
					$this->archivos[] = new File( $arreglo );
				}
			}
			else
			{
				$this->archivos = array( new File( $archivos ) );
			}
			$this->mimes = $mimes;
			$this->carpeta = str_replace( array( '.', '/', '\\' ), DS, $carpeta );
		}
		$this->vacio = empty( $this->archivos );
	}
	
	/**
	* Realiza una validaci�n de los archivos seleccionados
	*
	* @param	bool	$vacio		Valida si un objeto vaci� debe mandarlo como error
	* @access	public
	* @return	bool
	*/
	public function validar( $vacio = false )
	{
		if ( $vacio && $this->vacio )
		{
			$this->addError( 'Empty', 'vacio' );
		}
		foreach ( $this->archivos as $archivo )
		{
			if ( $archivo->get( 'error' ) != UPLOAD_ERR_OK )
			{
				$this->addError( $archivo->get( 'name' ), $archivo->get( 'error' ) );
			}
			else if ( !in_array( $archivo->get( 'type' ), $this->mimes ) )
			{
				$this->addError( $archivo->get( 'name' ), 'mimes' );
			}
		}
		return empty( $this->errores );
	}
	
	/**
	* Intenta guardar los archivos
	*
	* Si se encuantra un error, se aborta la operaci�n
	*
	* @param	bool	$escapar	Bandera para indicar que los nombres de los archivos se deben limpiar
	* @access	public
	* @return	bool
	*/
	public function guardar( $escapar = true )
	{
		foreach ( $this->archivos as &$archivo )
		{
			if ( $this->existente && $archivo->existe( $this->carpeta ) )
			{
				$this->addError( $archivo->get( 'name' ), 'existente' );
			}
			if ( !$archivo->guardar( $this->carpeta, $escapar ) )
			{
				$this->addError( $archivo->get( 'name' ), 'guardado' );
			}
		}
		return empty( $this->errores );
	}

	/**
	* Realiza las operaciones de validar y guardar
	*
	* @param	bool	$vacio		Valida si un objeto vac�o debe mandarlo como error
	* @access	public
	* @return	bool
	*/
	public function validarYGuardar( $vacio = false )
	{
		if ( !$this->validar( $vacio ) )
		{			
			return false;
		}
		if ( !$this->guardar() )
		{
			$this->borrar();
			return false;
		}
		return true;
	}
	
	/**
	* Borra todos los archivos en el objeto
	*
	* @access	public
	*/
	public function borrar()
	{
		foreach ( $this->archivos as $archivo )
		{
			$archivo->borrar();
		}
	}

	/**
	* M�todo para interfaz arrayaccess
	*
	* Establece un nuevo valor al arreglo
	*
	* @param	mixed	$offset		El indice del arreglo
	* @param	mixed	$value		El valor que tendr� el arreglo en esta posici�n
	* @access	public
	*/
	public function offsetSet( $offset, $value )
	{
		$this->archivos[ $offset ] = $value;
	}

	/**
	* M�todo para interfaz arrayaccess
	*
	* Revisi�n sobre si existe el indice dado
	*
	* @param	mixed	$offset		El indice del arreglo
	* @access	public
	*/
	public function offsetExists( $offset )
	{
		return isset( $this->archivos[ $offset ] );
	}

	/**
	* M�todo para interfaz arrayaccess
	*
	* Elimina una posici�n del arreglo de archivos
	*
	* @param	mixed	$offset		El indice del arreglo
	* @access	public
	*/
	public function offsetUnset( $offset )
	{
		unset( $this->archivos[ $offset ] );
	}

	/**
	* M�todo para interfaz arrayaccess
	*
	* Devuelve el valor dado del arreglo de archivos
	*
	* @param	mixed	$offset		El indice del arreglo
	* @access	public
	*/
	public function offsetGet( $offset )
	{
		return isset( $this->archivos[ $offset ] ) ? $this->archivos[ $offset ] : null;
	}

    /**
    * M�todo para la interfaz iterator
    *
    * Resetea el arreglo de archivos
    *
	* @access	public
    */
	public function rewind()
	{
		return reset( $this->archivos );
	}

	/**
	* M�todo para la interfaz iterator
	*
	* Devuelve el item actual en el arreglo de archivos
    *
	* @access	public
	*/
	public function current()
	{
		return current( $this->archivos );
	}

	/**
	* M�todo para la interfaz iterator
	*
	* Devuelve el indice actual del arreglo de archivos
    *
	* @access	public
	*/
	public function key()
	{
		return key( $this->archivos );
	}

	/**
	* M�todo para la interfaz iterator
	*
	* Devuelve el siguiente item del arreglo
    *
	* @access	public
	*/
	public function next()
	{
		return next( $this->archivos );
	}

	/**
	* M�todo para la interfaz iterator
	*
	* Devuelve si el item actual del arreglo de archivos sea v�lido
    *
	* @access	public
	*/
	public function valid()
	{
		return key( $this->archivos ) !== null;
	}
}
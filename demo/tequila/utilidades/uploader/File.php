<?php
namespace tequila\utilidades\uploader;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Representa un único archivo
*
* Esta clase se utiliza en conjunto con el uploader
*
* @package	tequila.utilidades.uploader
* @author	isaac
* @version	1
*/
class File{
	/**
	* Arreglo de las propiedades del archivo subido
	*
	* @access	private
	* @var		array
	*/
	private $propiedades;

	/**
	* Nombre de la ruta completa del archivo
	*
	* Incluye ruta u extensión
	*
	* @access	public
	* @var		string
	*/
	public $archivo;

	/**
	* Nombre del archivo
	*
	* Sólo el nombre del archivo, sin extensión ni ruta
	*
	* @access	public
	* @var		string
	*/
	public $nombre;

	/**
	* Extensión del archivo
	*
	* Se establece automáticamente en el constructor
	*
	* @access	public
	* @var		string
	*/
	public $extension;

	/**
	* Constructor
	*
	* Asigna el el arreglo de propiedades, obtiene la extensión del archivo
	*
	* @param	array		$propiedades		Las propiedades del archivo que se está subiendo
	* @access	public
	*/
	public function __construct( array $propiedades )
	{
		$this->propiedades = $propiedades;
		$this->nombre = $propiedades['name'];
		$this->extension = pathinfo( $this->nombre, PATHINFO_EXTENSION );
	}

	/**
	* Revisa si el archivo ya existe
	*
	* @param	string		$ruta		Ruta donde se buscará el archivo
	* @access	public
	* @return	bool
	*/
	public function existe( $ruta )
	{
		return file_exists( $ruta . DS . $this->nombre );
	}

	/**
	* Guarda el archivo en la ruta definida
	*
	* @param	string		$ruta		Ruta donde se salvará el archivo
	* @param	bool		$escapar	Bandera para indicar que los nombres de los archivos se deben limpiar
	* @access	public
	* @return	bool
	*/
	public function guardar( $ruta, $escapar = true )
	{
		if ( $escapar )
		{
			$provisional = preg_replace( '/([^A-Za-z0-9_\-\.]|[\.]{2})/', '', $this->nombre );
			$this->nombre = basename( $provisional );
		}
		$this->archivo = $ruta . DS . $this->nombre;
		return move_uploaded_file( $this->propiedades['tmp_name'], $this->archivo );
	}

	/**
	* Establece el nombre del archivo y le reasigna la extensión propia del archivo a menos que se establezca lo contrario
	*
	* @param	string		$nombre		El nombre que tendrá el archivo sin la extensión
	* @param	string		$extension	Extensión opcional que puede tener el archivo
	* @access	public
	*/
	public function setNombre( $nombre, $extension = null )
	{
		if ( isset( $extension ) )
		{
			$this->extension = $extension;
		}
		$this->nombre = $nombre . '.' . $this->extension;
	}

	/**
	* Devuelve la propiedad dada de las propiedades del archivo subido
	*
	* @param	string		$indice		El valor que se quiere obtener del arreglo
	* @access	public
	* @return	string
	*/
	public function get( $indice )
	{
		return $this->propiedades[$indice];
	}

	/**
	* Devuelve una bandera sobre si un archivo fue omitido o no
	*
	* @access	public
	* @return	bool
	*/
	public function omitido()
	{
		return $this->propiedades[ 'error' ] == 4;
	}

	/**
	* Borra el archivo de donde se encuentre almacenado
	*
	* Usa de referencia el nombre completo (full)
	*
	* @access	public
	*/
	public function borrar()
	{
		if ( isset( $this->archivo ) && file_exists( $this->archivo ) )
		{
			unlink( $this->archivo );
		}
	}
}
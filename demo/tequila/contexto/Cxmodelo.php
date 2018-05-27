<?php
namespace tequila\contexto;
use tequila\mvc\Modelo, tequila\database\DatabaseException, tequila\mvc\ModeloException, tequila\contexto\relaciones\PerteneceAUno, tequila\contexto\relaciones\TieneMuchos,
tequila\contexto\relaciones\TieneUno, tequila\contexto\relaciones\PerteneceAMuchos;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Modelos ligados a un Contexto
*
* Estos modelos son llenados desde la base de datos,
* contienen funciones ligadas a los Contextos
*
* @package	tequila.contexto
* @author	isaac
* @version	1
*/
class Cxmodelo extends Modelo{
	/**
	* Mensaje de error generico que se mostrará cuando falla la inserción del modelo
	*
	* @static
	* @access	public
	* @var		string
	*/
	const ERROR = 'Error';
	
	/**
	* Objeto Contexto ligado a este objeto
	*
	* @access	protected
	* @var		Contexto
	*/
	protected $_contexto;
	
	/**
	* Constructor
	*
	* Asigna el objeto Contexto a este objeto
	*
	* @param	Contexto	$contexto		El contexto ligado
	* @access	public
	*/
	public function __construct( Contexto $contexto )
	{
		$this->_contexto = $contexto;
		$this->_reglas = $this->_contexto->propiedades;
	}
	
	/**
	* Devuelve el contexto ligado a este modelo
	*
	* @access	public
	* @return	Contexto
	*/
	public function getContexto()
	{
		return $this->_contexto;
	}
	
	/**
	* Valida y guarda un modelo en la base de datos
	*
	* @param	bool				$validar	Bandera que indica si se debe validar el modelo
	* @param	bool				$ultimoId	Si es una inserción de establece el id insertado en el modelo
	* @access	public
	* @throws	ModeloException
	*/
	public function guardar( $validar = true, $ultimoId = false )
	{
		if ( $validar )
		{
			$this->validar( $this->_contexto->propiedades );
		}
		try
		{
			$this->_contexto->guardar( $this, $ultimoId );
		}
		catch ( DatabaseException $ex )
		{
			throw new ModeloException( self::ERROR );
		}
	}
	
	/**
	* Busca un elemento relacionado con este modelo del tipo "prtenece a uno"
	*
	* @param	Contexto	$contexto	El contexto donde se buscará la relación
	* @param	string		$propiedad	El nombre de la propiedad que es llave foranea
	* @access	public
	* @return	CxModelo
	*/
	public function perteneceAUno( Contexto $contexto, $propiedad = null )
	{
		$relacion = new PerteneceAUno( $this, $contexto, $propiedad );
		return $relacion->ejecutar();
	}
	
	/**
	* Busca elementos relacionados con este modelo del tipo "tiene muchos"
	*
	* @param	Contexto	$contexto	Donde se buscarán los elementos relacionados
	* @param	string		$foranea	Nombre del campo que es llave en la tabla relacionada
	* @access	public
	* @return	array
	*/
	public function tieneMuchos( Contexto $contexto, $foranea = null )
	{
		$relacion = new TieneMuchos( $this, $contexto, $foranea );
		return $relacion->ejecutar();
	}
	
	/**
	* Busca un elemento relacionado con este modelo del tipo "tiene uno"
	*
	* @param	Contexto	$contexto	Donde se buscarán los elementos relacionados
	* @param	string		$foranea	Nombre del campo que es llave en la tabla relacionada
	* @access	public
	* @return	CxModelo
	*/
	public function tieneUno( Contexto $contexto, $foranea = null )
	{
		$relacion = new TieneUno( $this, $contexto, $foranea );
		return $relacion->ejecutar();
	}
	
	/**
	* Busca elementos relacioandos con este modelo del tipo "tiene y pertenece a muchos"
	*
	* @param	Contexto	$contexto	Donde se buscarán los modelos relacionados
	* @param	string		$intermedia	Nombre de la tabla intermedia de la relación
	* @param	string		$foranea	Nombre del campo llave de este modelo en la tabla intermedia
	* @param	string		$asociada	Nombre del campo llave del contexto en la tabla intermedia
	* @access	public
	* @return	array
	*/
	public function perteneceAMuchos( Contexto $contexto, $intermedia = null, $foranea = null, $asociada = null )
	{
		$relacion = new PerteneceAMuchos( $this, $contexto, $intermedia, $foranea, $asociada );
		return $relacion->ejecutar();
	}

	/**
	* Busca elementos relacioandos con este modelo del tipo "tiene y pertenece a muchos"
	*
	* Pero solo regresa un arreglo de id's
	*
	* @param	Contexto	$contexto	Donde se buscarán los modelos relacionados
	* @param	string		$intermedia	Nombre de la tabla intermedia de la relación
	* @param	string		$foranea	Nombre del campo llave de este modelo en la tabla intermedia
	* @param	string		$asociada	Nombre del campo llave del contexto en la tabla intermedia
	* @access	public
	* @return	array
	*/
	public function idsRelacionados( Contexto $contexto, $intermedia = null, $foranea = null, $asociada = null )
	{
		$relacion = new PerteneceAMuchos( $this, $contexto, $intermedia, $foranea, $asociada );
		return $relacion->relacionados();
	}
}
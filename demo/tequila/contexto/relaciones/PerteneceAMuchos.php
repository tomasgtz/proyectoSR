<?php
namespace tequila\contexto\relaciones;
use tequila\contexto\Relacion, tequila\contexto\Cxmodelo, tequila\contexto\Contexto, tequila\database\Query, tequila\database\InterfazDatabase, tequila\database\DatabaseException,
tequila\database\Parametrizador;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Obtiene Cxmodelos relacionados del tipo "tiene y pertenece a muchos"
*
* @package	tequila.contexto.relaciones
* @author	isaac
* @version	1
*/
class PerteneceAMuchos extends Relacion{
	/**
	* Mensaje de error generico que se mostrará cuando falla la actualización de una relación
	*
	* @static
	* @access	public
	* @var		string
	*/
	const ERROR = 'Error';

	/**
	* Nombre de la tabla intermedia de la relación
	*
	* @acess	private
	* @var		string
	*/
	private $intermedia;
	
	/**
	* Nombre de la llave foranea del modelo en la tabla intermedia
	*
	* @access	private
	* @var		string
	*/
	private $foranea;
	
	/**
	* Nombre de la llave asociada del contexto en la tabla intermedia
	*
	* @access	private
	* @var		string
	*/
	private $asociada;
	
	/**
	* Constructor
	*
	* Se establecen los valores necesarios para realizar la busqueda,
	* si la propiedad que es llave foranea no se establece se establecerá una por default
	*
	* @param	Cxmodelo	$modelo		El modelo principal
	* @param	Contexto	$contexto	El contexto de la relación
	* @param	string		$intermedia	Nombre de la tabla intermedia de la relación
	* @param	string		$foranea	Nombre del campo llave de este modelo en la tabla intermedia
	* @param	string		$asociada	Nombre del campo llave del contexto en la tabla intermedia
	* @access	public
	*/
	public function __construct( Cxmodelo $modelo, Contexto $contexto, $intermedia = null, $foranea = null, $asociada = null )
	{
		parent::__construct( $modelo, $contexto );
		$this->intermedia = isset( $intermedia ) ?
			$intermedia : $this->modelo->getContexto()->table . '_' . $this->contexto->table;
		$this->foranea = isset( $foranea ) ? $foranea : 'id_' . $this->modelo->getContexto()->table;
		$this->asociada = isset( $asociada ) ? $asociada : 'id_' . $this->contexto->table;
	}
	
	/**
	* Devuelve los modelos relacionados
	*
	* @acess	public
	* @return	Cxmodelo
	*/
	public function ejecutar()
	{
		return $this->contexto->join( $this->intermedia, $this->asociada, $this->contexto->primary )
			->where( $this->intermedia . '.' . $this->foranea, '=', $this->modelo->id )->buscar()->lista();
	}

	/**
	* Devuelve un arreglo con los id's de la tabla relacionada que están relacionados con el Cxmodelo
	*
	* @access	public
	* @return	array
	*/
	public function relacionados()
	{
		$this->contexto->obtener();
		$relacionados = $this->ejecutar();
		$resultado = array();
		foreach ( $relacionados as $relacionado )
		{
			$resultado[] = $relacionado->id;
		}
		return $resultado;
	}
	
	/**
	* Actualiza los valores de una relación
	*
	* Los valores actualizados son los que se encuentran en la tabla intermedia
	*
	* @param	array	$valores	Los valores a actualizarde la relación
	* @access	public
	* @return	bool
	*/
	public function actualizarRelacion( array $valores, InterfazDatabase $bd )
	{
		$query = new Query( $this->intermedia );
		$query->where( $this->foranea, '=', $bd->escapar( $this->modelo->id ) );
		try
		{
			$bd->ejecutar( $query->borrarQuery() );
			$insertar = new Query( $this->intermedia );
			$bd->preparar( $insertar->insertarQuery( array( $this->foranea, $this->asociada ) ) );
			foreach ( $valores as $valor )
			{
				$params = new Parametrizador();
				$params->add( 'ENTERO', $this->modelo->id );
				$params->add( 'ENTERO', $valor );
				$bd->parametros( $params );
				$bd->ejecutarSentencia();
			}
		}
		catch ( DatabaseException $ex )
		{
			throw new ModeloException( self::ERROR );
		}
	}
}
<?php
namespace tequila\contexto;
use tequila\database\Query, tequila\database\Parametrizador, tequila\database\InterfazDatabase, tequila\contexto\relaciones\PerteneceAMuchos, \DB;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase representa una tabla en la base de datos.
*
* Es posible instanciarse o usarse como singleton.
* Intermediario entre una base de datos y los modelos del sistema,
* esta clase hereda de la clase "tequila\database\Query".
* Todos los contextos deben tener un objeto Cxmodelo ligado al mismo,
* por ejemplo, el contexto de usuarios debe tener un Cxmodelo de usuarios.
* Este debe definirse en la derivación de esta clase.
* Contiene metodos de insertar y actualizar de está manera:
* <code>
* $this->actualizar( $cxmodelo );
* </code>
* donde $cxmodelo representa un objeto Cxmodelo relacionado con está clase.
* Para realizar busquedas se utilizan los métodos de la clase Query
* <code>
* $resultado = $this->buscar( '*' )->where( 'estatus', '=', true );
* </code>
*
* @package	tequila.contexto
* @author	isaac
* @version	1
*/
abstract class Contexto extends Query{
	/**
	* Nombre del id de la tabla del contexto
	*
	* @access	public
	* @var		string
	*/
	public $primary = 'id';
	
	/**
	* Propiedades de los datos del contexto
	*
	* El arreglo puede contener las validaciones de los datos en un arreglo
	* o solo el tipo del dato, si añadirán las validaciones el arreglo debe
	* tener el tipo de dato con la llave 'CLASE'
	*
	* @access	public
	* @var		array
	*/
	public $propiedades = array();
	
	/**
	* Objeto de base de datos del contexto
	*
	* @access	protected
	* @var		bdInterface
	*/
	protected $bd;
	
	/**
	* Constructor
	*
	* Obtiene el nombre de la tabla,
	* este se obtiene con el nombre de la clase que tenga el objeto
	* se pueden asignar los campos de una consulta desde el constructor,
	* esto puede ser de uno por uno en un arreglo o mediante el uso de '*' para buscar todos
	* Establece el objeto de base de datos a usar, por default se utiliza
	* la configurada en DB
	*
	* @param	mixed				$seleccionar	Campos por defecto en una consulta
	* @param	interfazDatabase	$bd				El objeto de base de datos que se utilizará
	* @access	public
	*/
	public function __construct( interfazDatabase $bd = null )
	{
		$this->reset();
		if ( !isset( $this->table ) )
		{
			$namespace = explode( '\\', get_class( $this ) );
			$this->table = end( $namespace );
		}
		$this->bd = isset( $bd ) ? $bd : DB::instanciaDefault();
	}
	
	/**
	* Realiza al selección de elementos del query
	*
	* Puede ser un arreglo con valores o la cadena '*' para seleccionar todos
	*
	* @param	mixed	$campos		Los campos a elegir
	* @access	public
	* @return	Contexto
	*/
	public function obtener( $campos = array() )
	{
		$seleccionar = is_array( $campos ) ? $campos : array_keys( $this->propiedades );
		foreach ( $seleccionar as &$campo )
		{
			if ( stripos( $campo, '.' ) === false )
			{
				$campo = $this->table . '.' . $campo;
			}
			else
			{
				$campo = $campo . ' AS ' . str_replace( '.', '_', $campo );
			}
		}
		$seleccionar[] = $this->table . '.' . $this->primary . ' AS id';
		$this->select = '';
		return $this->select( $seleccionar );
	}
	
	/**
	* Realiza una unión de campos de tablas relacionadas al query
	*
	* Cada campo debe tener especificado el campo de unión y el valor a seleccionar
	* Si se desea obtener un dato ligado de una tercer tabla añada el contexto del segundo nivel de la relación
	*
	* @param	array		$joins		Campos a unir de tablas relacionadas
	* @param	Contexto	$contexto	Contexto opcional donde se buscará el dato
	* @access	public
	* @return	Contexto
	*/
	public function unir( array $seleccion, Contexto $contexto = null )
	{
		if ( !$contexto )
		{
			$contexto = $this;
		}
		if ( $this->select == '' )
		{
			$this->obtener( '*' );
		}
		$uniones = $seleccionar = array();
		foreach ( $seleccion as $campo )
		{
			list( $propiedad, $dato ) = explode( '.', $campo );
			$tabla = $contexto->propiedades[$propiedad]['RELACION']['TABLA'];
			if ( !in_array( $tabla, $uniones ) )
			{
				$this->join( $tabla, $contexto->propiedades[$propiedad]['RELACION']['LLAVE'], $contexto->table . '.' . $propiedad );
				$uniones[] = $tabla;
			}
			$campos[] = $tabla . '.' . $dato . ' AS ' . $propiedad . '_' . $dato;
		}
		return $this->select( $campos );
	}
	
	/**
	* Busca todos los registros que coincidan con los filtros establecidos
	*
	* Opcionalmente puede haber datos parametrizados para busquedas aún más seguras
	*
	* @param	Parametrizador $params	Lista de datos a parametrizar para la consulta
	* @access	public
	* @return	Array
	*/
	public function buscar( Parametrizador $params = null )
	{
		if ( $this->select == '' )
		{
			$this->obtener( '*' );
		}
		return $this->busqueda( $this->seleccionarQuery(), $params );
	}

	/**
	* Realiza un query crudo de busqueda
	*
	* Opcionalmente puede haber datos parametrizados para busquedas aún más seguras
	*
	* @param	string			$sql		La sentencia de busqueda
	* @param	Parametrizador	$params		Lista de datos a parametrizar para la consulta
	* @access	public
	* @return	Array
	*/
	public function busqueda( $sql, Parametrizador $params = null )
	{
		$this->bd->ejecutar( $sql, $params );
		$this->reset();
		return new Resultado( $this->bd->resultados(), $this );
	}
	
	/**
	* Busca un registro por id
	*
	* @param	int		$id		El identificador del registro
	* @access	public
	* @return	Cxmodelo
	*/
	public function buscarId( $id )
	{
		$this->where( $this->table . '.' . $this->primary, '=', $this->bd->escapar( $id ) );
		return $this->buscar()->unico();
	}
	
	/**
	* Realiza la inserción de un registro en la base de datos
	*
	* @param	Cxmodelo	$modelo		El objeto que se guardará en la base de datos
	* @param	bool		$ultimoId	Bandera que indica si se debe asignar el último id
	* @access	public
	*/
	public function insertar( Cxmodelo $modelo, $ultimoId = false )
	{
		$this->reset();
		$params = new Parametrizador();
		foreach ( $this->propiedades as $propiedad => $attrs )
		{
			$type = is_array( $attrs ) ? $attrs['CLASE'] : $attrs;
			$params->add( $type, $modelo->$propiedad );
		}
		$this->bd->ejecutar( $this->insertarQuery( array_keys( $this->propiedades ) ), $params );
		if ( $ultimoId )
		{
			$modelo->id = $this->bd->ultimoId();
		}
	}
	
	/**
	* Realiza la actualización de un registro en la base de datos
	*
	* @param	Cxmodelo	$modelo		El objeto que se actualizará
	* @access	public
	*/
	public function actualizar( Cxmodelo $modelo )
	{
		$this->resetBusqueda()->where( $this->primary, '=', '?' );
		$params = new Parametrizador();
		$objeto = array_keys( get_object_vars( $modelo ) );
		$propiedades = array_intersect( array_keys( $this->propiedades ), $objeto );
		foreach ( $propiedades as $propiedad )
		{
			$attrs = $this->propiedades[$propiedad];
			$type = is_array( $attrs ) ? $attrs['CLASE'] : $attrs;
			$params->add( $type, $modelo->$propiedad );
		}
		$params->add( 'ENTERO', $modelo->id );
		$this->bd->ejecutar( $this->actualizarQuery( $propiedades ), $params );
		$this->resetBusqueda();
	}
	
	/**
	* Guarda un objeto en la base de datos
	*
	* Si el objeto es nuevo lo inserta si ya existía lo actualiza
	*
	* @param	Cxmodelo	$modelo		El objeto a guardar
	* @param	bool		$ultimoId	Si es una inserción de establece el id insertado en el modelo
	* @access	public
	*/
	public function guardar( Cxmodelo $modelo, $ultimoId = false )
	{
		if ( !$modelo->id )
		{
			$this->insertar( $modelo, $ultimoId );
		}
		else
		{
			$this->actualizar( $modelo );
		}
	}
	
	/**
	* Actualiza una tabla intermedia relacionada con el contexto
	*
	* @param	Cxmodelo	$modelo		el modelo a actualizar
	* @param	Contexto	$relacion	contexto relacionado
	* @param	array		$valores	Los valores a insertarse en la tabla
	* @param	string		$tabla		tabla intermedia, opcional
	* @param	string		$foranea	llave de este contexto, opcional
	* @param	string		$asociada	llave del contexto relacionado, opcional
	* @access	public
	* @return	bool
	*/
	public function actualizarRelacion( Cxmodelo $modelo, Contexto $relacion, array $valores, $intermedia = null, $foranea = null, $asociada = null )
	{
		$perteneceAMuchos = new PerteneceAMuchos( $modelo, $relacion, $intermedia, $foranea, $asociada );
		return $perteneceAMuchos->actualizarRelacion( $valores, $this->bd );
	}
	
	/**
	* Borra un objeto de la base de datos
	*
	* @param	Cxmodelo	$modelo		El objeto a borrar
	* @access	public
	*/
	public function borrar( Cxmodelo $modelo )
	{
		$this->reset()->where( $this->primary, '=', $this->bd->escapar( $modelo->id ) );
		$this->bd->ejecutar( $this->borrarQuery() );
	}
	
	/**
	* Nos devuelve si se encontrarón registros en la consulta
	*
	* @param	Parametrizador		$params		Parametros que puede tener la consulta
	* @access	public
	* @return	bool
	*/
	public function existe( Parametrizador $params = null )
	{
		$this->select = '';
		$resultado = $this->select( 'COUNT(1) AS EXISTE' )->limit( 1 )->buscar( $params )->originales();
		$this->reset();
		return $resultado[ 0 ][ 'EXISTE' ] != 0;
	}
	
	/**
	* Devuelve la cantidad de registros en la tabla
	*
	* @param	Parametrizador		$params		Parametros que puede tener la consulta
	* @access	public
	* @return	int
	*/
	public function contar( Parametrizador $params = null )
	{
		$this->select = '';
		$resultado = $this->select( 'COUNT(1) AS TOTAL' )->buscar( $params )->originales();
		$this->reset();
		return isset( $resultado[ 0 ][ 'TOTAL' ] ) ? $resultado[ 0 ][ 'TOTAL' ] : 0;
	}

	/**
	* Escapa un valor para su ejecución en queries
	*
	* @param	mixed	$valor		El string o numero a escapar
	* @access	public
	* @return	string
	*/
	public function escapar( $valor )
	{
		return $this->bd->escapar( $valor );
	}
	
	/**
	* Función Abstracta
	*
	* Genera una nueva instancia del modelo enlazado
	*
	* @access	public
	* @return	DbModelo
	*/
	abstract protected function instancia();
}
<?php
namespace tequila\database;
/**
* Copyright (c) <2013> INNSERT
* See the file license.txt for copying permission.
*
* Esta clase es una abstracción para generar queries
*
* Forma orientada a objeto de escribir queries,
* es fácilmente extendible para añadir opciones de sql no establecidas en esta clase
*
* @package	tequila.database
* @author	isaac
* @version	1
*/
class Query{
	/**
	* Nombre de la tabla al que hará referencia este query
	*
	* @access	public
	* @var		string
	*/
	public $table;

	/**
	* Alias que puede tener la tabla
	*
	* @access	protected
	* @var		string
	*/
	protected $alias;
	
	/**
	* Campos a seleccionar en una sentencia
	*
	* @access	protected
	* @var		string
	*/
	protected $select;
	
	/**
	* Uniones de esta tabla con otras
	*
	* @access	protected
	* @var		string
	*/
	protected $join;

	/**
	* Agrupación de los resultados de una consulta
	*
	* @access	protected
	* @var		string
	*/
	protected $group;
	
	/**
	* Condiciones de sentencia
	*
	* @access	protected
	* @var		string
	*/
	protected $where;

	/**
	* Bandera que indica si se tiene abierto un subwhere
	*
	* @access	protected
	* @var		bool
	*/
	protected $opened = false;

	/**
	* Having para wheres de valores calculados
	*
	* @access	protected
	* @var		string
	*/
	protected $having;
	
	/**
	* Límite de selección en una busqueda
	*
	* @access	protected
	* @var		string
	*/
	protected $limit;
	
	/**
	* Orden de los registros en una busqueda
	*
	* @access	protected
	* @var		string
	*/
	protected $order;
	
	/**
	* Constructor
	*
	* Establece el nombre de la tabla
	*
	* @param	string	$table		El nombre de la tabla
	* @access	public
	*/
	public function __construct( $table )
	{
		$this->table = $table;
		$this->reset();
	}
	
	/**
	* Resetea los valores del objeto
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @access	public
	* @return	Query
	*/
	public function reset()
	{
		$this->alias = $this->select = $this->join = $this->where = $this->group = $this->having = $this->limit = $this->order = '';
		return $this;
	}
	
	/**
	* Borra todos los valores del objeto excepto el select
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @access	public
	* @return	Query
	*/
	public function resetBusqueda()
	{
		$this->join = $this->where = $this->group = $this->having = $this->limit = $this->order = '';
		return $this;
	}

	/**
	* Establece el alias de la tabla
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @access	public
	* @return	Query
	*/
	public function alias( $alias )
	{
		$this->alias = $alias;
		return $this;
	}
	
	/**
	* Establece los campos a seleccionar
	*
	* Los campos pueden venir en un arreglo o como una cadena
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	mixed	$select		Campos a seleccionar en una busqueda
	* @access	public
	*¨@return	Query
	*/
	public function select( $select )
	{
		if ( $this->select !== '' )
		{
			$this->select .= ',';
		}
		$this->select .= is_array( $select ) ? join( ',', $select ) : $select;
		return $this;
	}
	
	/**
	* Añade una unión entre tablas
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string		$table		Nombre de la tabla relacionada
	* @param	string		$foreign	La llave de la tabla relacionada
	* @param	string		$field		El campo de esta tabla que esta relacionado
	* @param	string		$alias		Alias que tiene la tabla en el query
	* @param	string		$type		El tipo de unión (ej: LEFT, INNER)
	* @access	public
	* @return	Query
	*/
	public function join( $table, $foreign, $field, $alias = null, $type = 'INNER' )
	{
		$this->join .= $type . ' JOIN ' . $table;
		if ( isset( $alias ) )
		{
			$this->join .= ' ' . $alias;
			$table = $alias;
		}
		if ( strpos( $field, '.' ) === false )
		{
			$field = $this->table . '.' . $field;
		}
		$this->join .= ' ON ' . $table . '.' . $foreign . '=' . $field . ' ';
		return $this;
	}

	/**
	* Añade un LEFT JOIN a la sentencia
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string		$table		Nombre de la tabla relacionada
	* @param	string		$foreign	La llave de la tabla relacionada
	* @param	string		$field		El campo de esta tabla que esta relacionado
	* @param	string		$alias		Alias que tiene la tabla en el query
	* @access	public
	* @return	Query
	*/
	public function leftJoin( $table, $foreign, $field, $alias = null )
	{
		return $this->join( $table, $foreign, $field, $alias, 'LEFT' );
	}
	
	/**
	* Añade una condición de where con solo texto
	*
	* De preferencia se deben usar las funciones más específicas de where
	*
	* @param	string	$where		El texto de la condición
	* @param	string	$type		El tipo de unión que tendrá con otras condiciones
	* @access	public
	* @return	Query
	*/
	public function textWhere( $where, $type = 'AND' )
	{
		if ( $this->where !== '' && !$this->opened )
		{
			$this->where .= ' ' . $type . ' ';
		}
		if ( $this->opened )
		{
			$this->opened = false;
		}
		$this->where .= $where;
		return $this;
	}

	/**
	* Añade una condición a la sentencia estableciendo si es adición o diferenciación (and u or)
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string	$field		El campo a comparar
	* @param	string	$oparator	El operador de comparación
	* @param	string	$value		El valor al cual se comparará el campo
	* @param	string	$type		El tipo de unión que tendrá con otras condiciones
	* @access	public
	* @return	Query
	*/
	public function cWhere( $field, $operator, $value, $type = 'AND' )
	{
		return $this->textWhere( $field . ' ' . $operator . ' ' . $value, $type );
	}
	
	/**
	* Añade una condición a la sentencia estableciendo si es adición o diferenciación (and u or)
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string	$field		El campo a comparar
	* @param	string	$oparator	El operador de comparación
	* @param	string	$value		El valor al cual se comparará el campo
	* @param	string	$type		El tipo de unión que tendrá con otras condiciones
	* @access	public
	* @return	Query
	*/
	public function where( $field, $operator, $value, $type = 'AND' )
	{
		if ( strpos( $field, '.' ) === false )
		{
			$field = $this->table . '.' . $field;
		}
		return $this->textWhere( $field . ' ' . $operator . ' ' . $value, $type );
	}

	/**
	* Añade una condición a la sentencia tratandola como una adicón (and)
	* alias de la función where
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string	$field		El campo a comparar
	* @param	string	$oparator	El operador de comparación
	* @param	string	$value		El valor al cual se comparará el campo
	* @access	public
	* @return	Query
	*/
	public function andw( $field, $operator, $value )
	{
		return $this->where( $field, $operator, $value );
	}

	/**
	* Añade una condición a la sentencia tratandola como una diferenciación (or)
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string	$field		El campo a comparar
	* @param	string	$oparator	El operador de comparación
	* @param	string	$value		El valor al cual se comparará el campo
	* @access	public
	* @return	Query
	*/
	public function orw( $field, $operator, $value )
	{
		return $this->where( $field, $operator, $value, 'OR' );
	}
	
	/**
	* Añade una condición de tipo "in" a la sentencia
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string	$field		El campo donde se buscarán los valores de in
	* @param	array	$in			El arreglo de valores a buscar
	* @param	string	$type		El tipo de unión que tendrá con otras condiciones
	* @access	public
	* @return	Query
	*/
	public function whereIn( $field, array $in, $type = 'AND' )
	{
		return !empty( $in ) ? $this->textWhere( $field . ' IN(' . join( ',', $in ) . ')', $type ) : $this;
	}

	/**
	* Añade un paréntesis "(" a las condicionales para inidcar el inicio de un subwhere
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string		$type		El tipo de unión que tendrá el subwhere
	* @access	public
	* @return	Query
	*/
	public function open( $type = 'AND' )
	{
		if ( !$this->opened && $this->where !== '' )
		{
			$this->where .= ' ' . $type;
		}
		$this->where .= ' ( ';
		$this->opened = true;
		return $this;
	}

	/**
	* Añade un paréntesis ")" a las condicionales para inidcar el cierre de un subwhere
	* Devuelve este mismo objeto para "chaining"
	*
	* @access	public
	* @return	Query
	*/
	public function close()
	{
		$this->where .= ' )';
		return $this;
	}

	/**
	* Añade una condición de having a la consulta
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string	$field		El campo a comparar
	* @param	string	$oparator	El operador de comparación
	* @param	string	$value		El valor al cual se comparará el campo
	* @param	string	$type		El tipo de unión que tendrá con otras condiciones
	* @access	public
	* @return	Query
	*/
	public function having( $field, $operator, $value, $type = 'AND' )
	{
		if ( $this->having !== '' )
		{
			$this->having .= ' ' . $type . ' ';
		}
		$this->having .= $field . ' ' . $operator . ' ' . $value;
		return $this;
	}

	/**
	* Establece una agrupación a los resultados de una consulta
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string	$group		El campo por el cual se agrupará el resultado
	* @access	public
	* @return	Query
	*/
	public function group( $group )
	{
		$this->group = $group;
		return $this;
	}
	
	/**
	* Establece el límite de la busqueda
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string	$limite		El límite de la busqueda escript copmo en una sentencia
	* @access	public
	* @return	Query
	*/
	public function limit( $limit )
	{
		$this->limit = $limit;
		return $this;
	}
	
	/**
	* Establece el orden de los registros de una busqueda
	*
	* Devuelve este mismo objeto para "chaining"
	*
	* @param	string	$order		El orden de la busqueda escript copmo en una sentencia
	* @access	public
	* @return	Query
	*/
	public function order( $order )
	{
		$this->order = $order;
		return $this;
	}

	/**
	* Devuelve la sentencia de selección como un subquery
	*
	* @param	string		$alias	Nombre que tendrá el campo resultado del subquery
	* @access	public
	* @return	string
	*/
	public function sub( $alias )
	{
		return '(' . $this->seleccionarQuery() . ') AS ' . $alias;
	}
	
	/**
	* Devuelve la sentencia sql se selección
	*
	* @access	public
	* @return	string
	*/
	public function seleccionarQuery()
	{
		$sql = 'SELECT ' . $this->select . ' FROM ' . $this->table;
		if ( $this->alias !== '' )
		{
			$sql .= ' ' . $this->alias;
		}
		$sql .= ' ' . $this->join;
		if ( $this->where !== '' )
		{
			$sql .= ' WHERE ' . $this->where;
		}
		if ( $this->group !== '' )
		{
			$sql .= ' GROUP BY ' . $this->group;
		}
		if ( $this->having !== '' )
		{
			$sql .= ' HAVING ' . $this->having;
		}
		if ( $this->order !== '' )
		{
			$sql .= ' ORDER BY ' . $this->order;
		}
		if ( $this->limit !== '' )
		{
			$sql .= ' LIMIT ' . $this->limit;
		}
		return $sql;	
	}
	
	/**
	* Devuelve la sentencia sql de inserción
	*
	* @param	array	$campos		Los campos a insertar
	* @access	public
	* @return	string
	*/
	public function insertarQuery( array $campos )
	{
		$params = array_fill( 0, count( $campos ), '?' );
		return 'INSERT INTO ' . $this->table . '(' . join( ',', $campos ) .	') VALUES( ' . join( ',', $params ) . ' )';
	}

	/**
	* Devuelve una sentencia sql de inserción con texto
	*
	* @param	string	$insert		El query para la inserción
	* @access	public
	* @return	string
	*/
	public function textInsertarQuery( $insert )
	{
		return 'INSERT INTO ' . $this->table . $insert;
	}
	
	/**
	* Devuelve la sentencia sql de actualización
	*
	* @param	array	$campos		Los campos a actualizar
	* @access	public
	* @return	string
	*/
	public function actualizarQuery( array $campos )
	{
		foreach ( $campos as &$campo )
		{
			$campo = $campo . '=?';
		}
		return 'UPDATE ' . $this->table . ' SET ' . join( ',', $campos ) . ' WHERE ' . $this->where;
	}

	/**
	* Devuelve una sentencia sql de actualización con texto
	*
	* @param	string	$update		El query para la actualización
	* @access	public
	* @return	string
	*/
	public function textUpdateQuery( $update )
	{
		return 'UPDATE ' . $this->table . ' SET ' . $update . ' WHERE ' . $this->where;
	}
	
	/**
	* Devuelve la sentencia sql de borrado
	*
	* @access	public
	* @return	string
	*/
	public function borrarQuery()
	{
		return 'DELETE FROM ' . $this->table . ' WHERE ' . $this->where;
	}
}
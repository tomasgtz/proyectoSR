<?php
namespace tequila\utilidades\buscador;
use tequila\contexto\Contexto, tequila\utilidades\Fechas, tequila\inicio\Boot, \DateTime;
/**
* Realiza busquedas en contextos y paginación
*
* @author	isaac
* @package	tequila.utilidades
* @version	2
*/
class BaseBuscador{
	/**
	* Contexto en el que se realizarán las busquedas
	*
	* @access	protected
	* @var		Contexto
	*/
	protected $contexto;

	/**
	* Arreglo de opciones de busqueda y orden
	*
	* @access	protected
	* @var		array
	*/
	protected $opciones = array();

	/**
	* Valores de la busqueda
	*
	* @access	protected
	* @var		array
	*/
	protected $valores = array();

	/**
	* Página actul de paginación
	*
	* @access	protected
	* @var		int
	*/
	protected $pagina;

	/**
	* Total de páginas a dibujar
	*
	* @access	protected
	* @var		int
	*/
	protected $paginas;

	/**
	* Query String resultado de la busqueda
	*
	* @access	protected
	* @var		string
	*/
	protected $query;

	/**
	* Resultado de la busqueda en el contexto
	*
	* @access	public
	* @var		array
	*/
	public $resultados;

	/**
	* Elementos a mostrar por pagina
	*
	* @access	public
	* @var		int
	*/
	public $mostrar = 40;

	/**
	* Bandera que indica si se debe validar la página para no pasarse
	*
	* @access	public
	* @var		bool
	*/
	public $validarPagina = true;

	/**
	* Url a la que se dirigirán los resultados del paginador
	*
	* @access	public
	* @var		string
	*/
	public $url;

	/**
	* Bandera que indica si la pagina viene contenida en la url
	*
	* @access	public
	* @var		bool
	*/
	private $definida;

	/**
	* Constructor
	*
	* Establece los valores de la clase
	*
	* @param	Contexto	$contexto	El contexto donde se realizará la busqueda
	* @param	int			$pagina		La pagina actual de paginación
	* @param	array		$valores	Los valores de la busqueda
	* @param	array		$opciones	Las opciones de busqueda y ordenamiento
	* @access	public
	*/
	public function __construct( Contexto $contexto, $pagina, array $valores = array(), array $opciones = array() )
	{
		$this->contexto = $contexto;
		$this->definida = ctype_digit( $pagina );
		$this->pagina = $this->definida ? $pagina : 1;
		$this->valores = $valores;
		$this->opciones = $opciones;
		$this->query = empty( $valores ) ? '' : '?' . http_build_query( $valores );
	}

	/**
	* Ejecuta la busqueda de elementos
	*
	* @access	public
	*/
	public function ejecutar()
	{
		if ( !isset( $this->url ) )
		{
			$parametros = Boot::$peticion->parametros;
			if ( $this->definida )
			{
				array_pop( $parametros );
			}
			$this->url = join( US, Boot::$peticion->controlador ) . US . join( US, $parametros );
		}
		if ( !empty( $this->valores ) )
		{
			$this->buscar();
		}
		$this->paginar();
	}

	/**
	* Arma el contexto según los valores de busqueda
	*
	* @access	private
	*/
	private function buscar()
	{
		$defaults = array(
			'type'	=>	'where',
			'opt'	=> 	'LIKE',
			'uni'	=>	'AND',
			'data'	=>	'default'
		);
		$valores = array();
		foreach ( $this->valores as $propiedad => $valor )
		{
			$valores[ str_replace( array( '__', '-', '/' ), '.', $propiedad ) ] = $valor;
		}
		$ordenamiento = array();
		foreach ( $this->opciones as $prop => $opcion )
		{
			if ( !is_array( $opcion ) )
			{
				$prop = $opcion;
				$opcion = array( 'prop' => $opcion );
			}
			if ( !isset( $opcion[ 'prop' ] ) )
			{
				$opcion[ 'prop' ] = $prop;
			}
			$opcion = array_merge( $defaults, $opcion );
			if ( array_key_exists( $prop, $valores ) )
			{
				$dato = is_array( $valores[ $prop ] ) ? $valores[ $prop ] : trim( $valores[ $prop ] );
				if ( !empty( $dato ) )
				{
					if ( $opcion[ 'type' ] == 'where' )
					{
						$dato = $this->convertir( $dato, $opcion[ 'data' ] );
						if ( $opcion[ 'opt' ] == 'LIKE' )
						{
							$this->contexto->where( $opcion[ 'prop' ], 'LIKE', $this->contexto->escapar( "{$dato}%" ), $opcion[ 'uni' ] );
						}
						elseif( $opcion[ 'opt' ] == 'SLIKE' )
						{
							$this->contexto->where( $opcion[ 'prop' ], 'LIKE', $this->contexto->escapar( "%{$dato}%" ), $opcion[ 'uni' ] );
						}
						else
						{
							$this->contexto->where( $opcion[ 'prop' ], $opcion[ 'opt' ], $this->contexto->escapar( $dato ), $opcion[ 'uni' ] );
						}
					}
					elseif ( $opcion[ 'type' ] == 'whereIn' )
					{
						if ( !is_array( $dato ) )
						{
							$dato = array( $dato );
						}
						foreach ( $dato as &$valor )
						{
							$valor = $this->contexto->escapar( $valor );
						}
						$this->contexto->whereIn( $opcion[ 'prop' ], $dato, $opcion[ 'uni' ] );
					}
					else
					{
						if ( in_array( $dato, array( 'desc', 'asc' ) ) )
						{
							$ordenamiento[] = $opcion[ 'prop' ] . " {$dato} ";
						}
					}
				}
			}
		}
		if ( !empty( $ordenamiento ) )
		{
			$this->contexto->order( join( ', ', $ordenamiento ) );
		}
	}

	/**
	* Realiza la paginación
	*
	* @access	public
	*/
	private function paginar()
	{
		$contador = clone $this->contexto;
		$encontrados = $contador->contar();
		$this->paginas = max( ceil( $encontrados / $this->mostrar ), 1 );
		$this->pagina = $this->validarPagina ? max( min( $this->pagina, $this->paginas ), 1 ) : $this->pagina;
		$inicia = ( $this->pagina * $this->mostrar ) - $this->mostrar;
		$this->resultados = $this->contexto->limit( "{$inicia}, {$this->mostrar}" )->buscar();
	}

	/**
	* Convierte un dato especial
	*
	* Si un dato es una fecha  un timestamp lo convierte en el valor correcto
	*
	* @param	mixed		$dato	El valor a convertir
	* @param	string		$type	El tipo de valor especial
	* @access	private
	* @return	mixed
	*/
	private function convertir( $dato, $type )
	{
		if ( in_array( $type, array( 'stamp', 'timestamp', 'start' ) ) )
		{
			return Fechas::getTime( $dato );
		}
		elseif ( in_array( $type, array( 'stampEnd', 'timestampEnd', 'end' ) ) )
		{
			return Fechas::getEndTime( $dato );
		}
		elseif ( in_array( $type, array( 'date', 'datetime' ) ) )
		{
			return DateTime::createFromFormat( 'd-m-Y', $dato )->format( 'Y-m-d 00:00:00' );
		}
		elseif ( in_array( $type, array( 'dateEnd', 'datetimeEnd' ) ) )
		{
			return DateTime::createFromFormat( 'd-m-Y', $dato )->format( 'Y-m-d 23:59:59' );
		}
		else
		{
			return $dato;
		}
	}
}
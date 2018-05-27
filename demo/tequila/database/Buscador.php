<?php
namespace tequila\utilidades;
use tequila\contexto\Contexto, tequila\mvc\Controlador, tequila\utilidades\paginador\Paginador, \Url;
/**
* Clase para realizar busquedas según paramateros opcionales
*
* @package	tequila.utilidades
* @author	isaac
* @version	1
*/
class Buscador{
	/**
	* Contexto donde se realizarán las busquedas
	*
	* @access	public
	* @var		Contexto
	*/
	public $contexto;

	/**
	* Parametros de busqueda
	*
	* @access	public
	* @var		array
	*/
	public $parametros;

	/**
	* Opciones de busqueda
	*
	* Arreglo con los campos de busqueda y que condiciones tiene ese campo
	*
	* @access	public
	* @var		array
	*/
	public $opciones = array();

	/**
	* Paginador de la busqueda
	*
	* @access	public
	* @var		Paginador
	*/
	public $paginador;

	/**
	* Constructor
	*
	* Recibe el conterxto donde se buscarán los datos y el arreglo con los valores opcionales
	*
	* @param	string		$url			La url que visitará el buscador
	* @param	int			$index			La página actual
	* @param	Contexto	$contexto		El contexto donde se buscarán los datos
	* @param	array		$parametros		Los parametros de busqueda
	* @param	array		$likes			Los likes que puede usar el contexto
	* @param	array		$orders			Los orders quepuede usar el contexto
	* @access	public
	*/
	public function __construct( $url, $index, Contexto $contexto, array $parametros, array $opciones = array() )
	{
		$this->contexto = $contexto;
		$this->parametros = $parametros;
		$this->opciones = $opciones;
		$this->ejecutar();
		$this->paginador = new Paginador( $index, $this->contexto );
		$this->paginador->url = $url;
		$this->paginador->query = empty( $parametros ) ? '' : '?' . http_build_query( $parametros );
		$this->paginador->buscar();
		
		var_dump( $this->parametros );
	}

	/**
	* Construye el query de busqueda
	*
	* Escapa todos los parametros
	*
	* @access	public
	*/
	public function ejecutar()
	{
		$defaults = array(
			'type'	=>	'busqueda',
			'opt'	=> 	'LIKE',
			'int'	=>	false,
		);
		$ordenamiento = '';
		foreach ( array_keys( $this->parametros ) as &$parametro )
		{
			$parametro = str_replace( array( '-', '__', '/' ), '.', $parametro );
		}
		foreach ( $this->opciones as $opcion => $valores )
		{
			if ( !is_array( $valores ) )
			{
				$opcion = $valores;
				$valores = array( 'prop' => $valores );
			}
			if ( !isset( $valores[ 'prop' ] ) )
			{
				$valores[ 'prop' ] = $opcion;
			}
			$valores = array_merge( $valores, $defaults );
			if ( in_array( $opcion, array_keys( $this->parametros ) ) )
			{
				if ( $valores[ 'type' ] == 'busqueda' )
				{
					$dato = trim( $this->parametros[ $opcion ] );
					$opt = $valores[ 'opt' ];
					if ( $dato != '' )
					{
						if ( $opt == 'LIKE' )
						{							
							if ( $valores[ 'int'] )
							{
								$dato = $this->contexto->escapar( '%' . $dato . '%' );
							}
							else
							{
								$dato = $this->contexto->escapar( $dato . '%' );
							}
						}
						else
						{
							$dato = $this->contexto->escapar( $dato );
						}
						$this->contexto->where( $valores[ 'prop' ], $opt, $dato );
					}
				}
				else
				{
					$direccion = $this->parametros[ $opcion ] == 'desc' ? 'desc' : 'asc';
					$ordenamiento = $valores[ 'prop' ] . ' ' . $direccion . ' ';
				}
			}
		}
		if ( $ordenamiento != '' )
		{
			$this->contexto->order( $ordenamiento );
		}
	}
}
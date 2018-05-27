<?php
namespace tequila\scaffolding;
/**
* Esta clase crea el controlador del contexto físicamente
*
* @package	tequila.scaffolding
* @author	isaac
* @version	1
*/
class Controlador{
	/**
	* Clase scaffolfing
	*
	* @access	private
	* @var		Scaffolding
	*/
	private $data;

	/**
	* Nombre del controlador
	*
	* @access	private
	* @var		string
	*/
	private $nombre;

	/**
	* Nombre de una instancia
	*
	* @access	private
	* @var		string
	*/
	private $instancia;

	/**
	* Constructor
	*
	* Establece el objeto scaffolding
	*
	* @param	Scaffolding		$scaffolding		El scaffolding de la generación
	* @access	public
	*/
	public function __construct( $scaffolding )
	{
		$this->data = $scaffolding;
		if ( substr( $this->data->nombre, -3 ) == 'nes' )
		{
			$this->instancia = substr( $this->data->nombre, 0, -2 );
		}
		else
		{
			$this->instancia = substr( $this->data->nombre, 0, -1 );
		}
		$this->nombre = $this->data->nombre;
	}

	/**
	* Realiza las asignaciones de las propiedades de una instancia del contexto
	*
	* @access	private
	* @return	string
	*/
	private function propiedades()
	{
		$texto = '';
		foreach ( $this->data->contexto->propiedades as $propiedad => $valores )
		{
			if ( is_array( $valores ) && !isset( $valores['OMITIR'] ) )
			{
				$texto .= "\n\t\t" . '$' . $this->instancia . '->' . $propiedad . ' = $this->peticion->post( \'' . $propiedad . '\' );';
			}
		}
		return $texto;
	}

	/**
	* Realiza la inclusión de listas de los contextos relacionados
	*
	* @access	private
	* @return	string
	*/
	private function inclusion()
	{
		$texto = '';
		foreach ( $this->data->contexto->propiedades as $propiedad => $valores )
		{
			if ( is_array( $valores ) && isset( $valores['RELACION'] ) && !isset( $valores['OMITIR'] ) )
			{
				$tabla = $valores['RELACION']['TABLA'];
				$texto .= "\n\t\t" . '$' . $tabla . ' = new ' . $tabla . ";\n\t\t";
				$texto .= '$this->coleccion->' . $tabla . ' = $' . $tabla . '->obtener( array( \'nombre\' ) )->buscar()->lista();';
			}
		}
		return $texto;
	}

	/**
	* Realiza los imports de los contextos compatibles
	*
	* @access	private
	* @return	string
	*/
	private function imports()
	{
		$texto = '';
		foreach ( $this->data->contexto->propiedades as $propiedad => $valores )
		{
			if ( is_array( $valores ) && isset( $valores['RELACION'] ) && !isset( $valores['OMITIR'] ) )
			{
				$texto .= ' app\contextos\\' . $valores['RELACION']['TABLA'] . ',';
			}
		}
		return $texto;
	}

	/**
	* Generación del archivo
	*
	* @access	public
	*/
	public function generar()
	{
		$ruta = $this->data->ruta;
		$nombre = $this->data->nombre;
		$proyecto = $this->data->proyecto;
		$permiso = $this->data->permiso;
		$contexto = get_class( $this->data->contexto );
		$master = $this->data->master;
		if ( !empty( $this->data->permiso ) )
		{
			$permiso = "\n\t\t" . 'Membresia::autenticado( \'' . $this->data->permiso . '\' );';
			$permisoJson = "\n\t\t" . 'if ( !Membresia::checkAutenticado( \'' . $this->data->permiso . '\' ) )
{
	return $this->respuestaJson( array( \'estatus\' => \'SESION\', \'mensaje\' => \'La sesión del usuario expiró\' ) );
}';
		}
		else
		{
			$permiso = $permisoJson = '';
		}
		$generacion = <<<TEXTO
<?php
namespace app\controladores{$ruta};
use app\extensiones\Administracion, {$contexto},{$this->imports()} tequila\utilidades\Paginador, tequila\database\Parametrizador, tequila\mvc\ModeloException, \Url, \Membresia, \Sess;
/**
* Controlador para el catálogo de {$nombre}
*
* @package	{$proyecto}.controladores
* @author	scaffolding
* @version	1
*/
class {$nombre}Controlador extends Administracion{
	/**
	* Constructor
	*
	* Selecciona el item actual del menu
	*
	* @access	public
	*/
	public function __construct()
	{
		parent::__construct();
		\$this->coleccion->sidebar['{$nombre}']->seleccionar();
		\$this->coleccion->ruta->agregar( array(
			'indice'	=>	'{$nombre}',
			'texto'		=>	'{$nombre}',
			'url'		=>	Url::obtener( 'administracion/{$nombre}' )
		));
	}

	/**
	* Muestra la tabla del catálogo
	*
	* @access	public
	*/
	public function index( \$index = 1 )
	{{$permiso}
		\${$nombre} = new {$nombre};
		\$paginador = new Paginador( \$index, \${$nombre}->obtener( array( '...' ) ) );
		\$paginador->buscar();
		\$this->coleccion->{$nombre} = \$paginador;
		return \$this->respuestaVista( '{$master}' );
	}

	/**
	* Realiza una busqueda de elementos del catálogo
	*
	* @access	public
	*/
	public function POST_buscar()
	{{$permiso}
		\$ordenamiento = \$this->peticion->post( 'ordenamiento' );
		\$busqueda = \$this->peticion->post( 'buscar' );
		\${$nombre} = new {$nombre};
		\${$nombre}->obtener( array( '...' ) );
		if ( \$ordenamiento )
		{
			\${$nombre}->order( \$ordenamiento );
		}
		if ( \$busqueda && strlen( \$busqueda ) > 2 )
		{
			\${$nombre}->where( 'nombre', 'LIKE', '?' );
			\$params = new Parametrizador();
			\$params->add( 'TEXTO', '%' . \$busqueda . '%' );
		}
		\$paginador = new Paginador( \$this->peticion->post( 'index' ), \${$nombre} );
		if ( isset( \$params ) )
		{
			\$paginador->buscar( \$params );
		}
		else
		{
			\$paginador->buscar();
		}
		\$this->coleccion->{$nombre} = \$paginador;
		return \$this->respuestaVista();
	}

	/**
	* Muestra el formulario para ingresar un nuevo elemento del catálogo
	*
	* @access	public
	*/
	public function insertar()
	{{$permiso}{$this->inclusion()}
		return \$this->respuestaVista( '{$master}' );
	}

	/**
	* Realiza el registro de una nueva {$this->instancia}
	*
	* @access	public
	*/
	public function POST_insertar()
	{{$permisoJson}
		\${$this->instancia} = \$this->peticion->recibir( new {$nombre} );
		try
		{
			\${$this->instancia}->guardar();
		}
		catch ( ModeloException \$ex )
		{
			return \$this->respuestaJson( array( 'estatus' => 'ERROR', 'mensaje' => \$ex->getMessage() ) );
		}
		return \$this->respuestaJson( array( 'estatus' => 'EXITO', 'mensaje' => 'Registro guardado correctamente' ) );
	}

	/**
	* Muestar el formulario para actualizar una {$this->instancia}
	*
	* @param	int		\$id		El id de la sección a actualizar
	* @access	public
	*/
	public function actualizar( \$id = null )
	{{$permiso}
		\${$nombre} = new {$nombre};
		\$this->coleccion->{$this->instancia} = \${$nombre}->obtener( '*' )->buscarId( \$id );
		if ( !\$this->coleccion->{$this->instancia} )
		{
			return \$this->errorPeticion();
		}{$this->inclusion()}
		return \$this->respuestaVista( '{$master}' );
	}

	/**
	* Realiza la actualización de una {$this->instancia}
	*
	* @access	public
	*/
	public function POST_actualizar()
	{{$permisoJson}
		\${$nombre} = new {$nombre};
		\${$this->instancia} = \${$nombre}->obtener( '*' )->buscarId( \$this->peticion->post( 'id' ) );
		if ( !\${$this->instancia} )
		{
			return \$this->errorPeticion();
		}{$this->propiedades()}
		try
		{
			\${$this->instancia}->guardar();
		}
		catch ( ModeloException \$ex )
		{
			return \$this->respuestaJson( array( 'estatus' => 'ERROR', 'mensaje' => \$ex->getMessage() ) );
		}
		return \$this->respuestaJson( array( 'estatus' => 'EXITO', 'mensaje' => 'Registro guardado correctamente' ) );
	}
}
TEXTO;
		if ( empty ( $this->data->ruta ) )
		{
			$archivo = 'app' . DS . 'controladores' . DS;
		}
		else
		{
			$archivo = 'app' . DS . 'controladores' . DS . join( DS, $this->carpetas ) . DS;
		}
		if ( file_put_contents( $archivo . $this->nombre . 'Controlador.php', $generacion ) )
		{
			echo 'controlador "' . $this->nombre . '" generado! :D<br/>';
		}
		else
		{
			echo 'Error :(<br/>';
		}
	}
}
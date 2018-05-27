<?php
namespace app\extensiones;
use app\extensiones\ControladorBase, app\clases\Item, \Membresia, app\contextos\colonias;
/**
* Clase base para los módulos del sistema
*
* @author	isaac
* @package	tienda
* @version	1
*/
class Administracion extends ControladorBase{
	/**
	* Constructor
	*
	* Inicializa el arreglo de selección del menú lateral
	*
	* @access	public
	*/
	public function __construct()
	{
		parent::__construct();
		Membresia::instanciaDefault()->autenticado( array( 'Innsert', 'Administración' ) );
		$this->masters->opciones = (object) array(
			'super_residentes'	=>	new Item( 'sub-menu', 'right' ),
			'residentes'		=>	new Item,
			'lotes'				=>	new Item,
			'estacionamientos'  =>  new Item,
			'almacenes'			=> 	new Item,
			'super_zonas'		=>	new Item( 'sub-menu', 'right' ),
			'horarios'			=>	new Item,
			'zonas'				=>	new Item,
			'reservaciones'		=>	new Item,
			'reglamentos'		=>	new Item,
			'super_admin'		=>	new Item( 'sub-menu', 'right' ),
			'datosFiscales'		=>  new Item,
			'puestos'			=>	new Item,
			'usuarios'			=>	new Item,
			'perfiles'			=>	new Item,
			'colonias'			=>	new Item,
			'administradores'	=>	new Item,
			'miembros'			=>	new Item,
			'asambleas'			=>	new Item,
			'minutas'			=>	new Item,
			'unidades'			=>	new Item,
			'super_finanzas'	=>	new Item( 'sub-menu', 'right' ),
			'facturas'			=>  new Item,
			'adeudos'			=>	new Item,
			'recargos'			=>	new Item,
			'bancos'			=>	new Item,
			'cuentas'			=>	new Item,
			'ingresos'			=>	new Item,
			'pagar'				=>	new Item,
			'aportaciones'		=>	new Item,
			'egresos'			=>	new Item,
			'super_proyectos'	=>	new Item( 'sub-menu', 'right' ),
			'proveedores'		=>	new Item,
			'cotizaciones'		=>	new Item,
			'proyectos'			=>	new Item,
			'correos'			=>	new Item,
			'iniciativas'		=>	new Item,
			'quejas'			=>	new Item,
			'tipos'				=>	new Item,
			'super_reportes'	=>	new Item( 'sub-menu', 'right' ),
			'finanzas'			=>	new Item,
			'estados'			=>	new Item
		);
		$colonias = new colonias;
		$this->masters->colonias = $colonias->obtener( array( 'nombre' ) )
			->join( 'usuarios_colonias', 'idColonia', 'id' )
			->where( 'usuarios_colonias.idUsuario', '=', Membresia::instanciaDefault()->usuario->id )
			->where( 'idEstatus', '=', 1 )
			->buscar()->lista();
	}
}
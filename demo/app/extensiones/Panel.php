<?php
namespace app\extensiones;
use app\extensiones\ControladorBase, app\contextos\reservaciones, app\contextos\cuentas,
app\contextos\reglamentos, app\contextos\pagos, app\contextos\egresos, app\contextos\adeudos,
app\contextos\gastos_programados, \Membresia, \Sess, \Fecha;
/**
* Clase base para los módulos del sistema
*
* @author	isaac
* @package	colonias
* @version	1
*/
class Panel extends ControladorBase{
	/**
	* Constructor
	*
	* Busca las reservaciones pendientes
	*
	* @access	public
	*/
	public function __construct()
	{
		parent::__construct();
		Membresia::instanciaDefault()->autenticado();
		//Reservaciones
		$reservaciones = new reservaciones;
		$this->masters->reservaciones = $reservaciones->obtener( array( 'fecha', 'nombreResidente', 'nombreZona', 'nombreHorario' ) )
			->unir( array( 'idHorario.descripcion' ) )
			->where( 'idColonia', '=', $reservaciones->escapar( Sess::instanciaDefault()->get( 'idColonia' ) ) )
			->where( 'idEstatus', '=', 4 )
			->where( 'fecha', '>=', $reservaciones->escapar( date( 'Y-m-d 00:00:00' ) ) )
			->buscar()->originales();
		//Reglamento
		$reglamentos = new reglamentos;
		$this->masters->reglamentos = $reglamentos->obtener( array( 'nombre' ) )
			->order( 'reglamentos.nombre desc' )
			->where( 'idColonia', '=', Sess::instanciaDefault()->get( 'idColonia' ) )
			->where( 'idEstatus', '=', 1 )
			->buscar()->lista();
		//Aportaciones Pendientes
		$adeudos = new adeudos;
		$pagos = new pagos;
		$adeudos->select( array(
			'adeudos.concepto',
			'adeudos.cantidad',
			'adeudos.fechaVence',
			$pagos->select( 'ifnull(sum(cantidad), 0)' )
				->join( 'ingresos', 'id', 'idIngreso' )
				->where( 'idAdeudo', '=', 'adeudos.id' )
				->where( 'ingresos.idEstatus', '=', 1 )
				->sub( 'pagado' )
		))
			->unir( array( 'idResidente.nombre' ) )
			->where( 'idColonia', '=', Sess::instanciaDefault()->get( 'idColonia' ) )
			->where( 'residentes.idUsuario', '=', Membresia::instanciaDefault()->usuario->id )
			->where( 'fechaInicio', '<', $adeudos->escapar( date( 'Y-m-d H:i:s' ) ) )
			->where( 'idEstatus', '=', 1 );
		$this->coleccion->adeudos = $adeudos->buscar()->lista();
		//Dinero en Cuentas
		$cuentas = new cuentas;
		$pagos = new pagos;
		$egresos = new egresos;
		$cuentas->select( array(
			'cuentas.id',
			'cuentas.nombre',
			'cuentas.nombreBanco',
			$pagos->select( 'sum(pagos.cantidad)' )
				->join( 'ingresos', 'id', 'idIngreso' )
				->where( 'ingresos.idCuenta', '=', 'cuentas.id' )
				->where( 'ingresos.idEstatus', '=', 1 )
				->sub( 'ingreso' ),
			$egresos->select( 'sum(egresos.cantidad)' )
				->where( 'idCuenta', '=', 'cuentas.id' )
				->where( 'idEstatus', '=', 1 )
				->sub( 'gasto' )
		))
			->where( 'idColonia', '=', Sess::instanciaDefault()->get( 'idColonia' ) )
			->where( 'idEstatus', '=', 1 )
			->group( 'cuentas.id, cuentas.nombre, cuentas.nombreBanco' );
		$this->coleccion->cuentas = $cuentas->buscar()->lista();
		//Cuentas por Pagar
		$gastos_programados = new gastos_programados;
		$pagado = new egresos;
		$gastos_programados->select( array(
			'gastos_programados.cantidad AS programado',
			'gastos_programados.concepto AS concepto',
			'gastos_programados.fechaVence',
			$pagado->select( 'IFNULL(sum(cantidad), 0)' )
				->where( 'idGastoProgramado', '=', 'gastos_programados.id' )
				->where( 'idEstatus', '=', 1 )->sub( 'pagado' )
		))
			->where( 'idColonia', '=', Sess::instanciaDefault()->get( 'idColonia' ) )
			->where( 'idEstatus', '=', 1 )
			->where( 'fechaVence', '<', $gastos_programados->escapar( date_create()->modify( '+1 month' )->format( 'Y-m-d H:i:s' ) ) )
			->having( 'pagado', '<', 'programado' )
			->order( 'gastos_programados.fechaVence' );
		$this->coleccion->porPagar = $gastos_programados->buscar()->lista();
	}
}
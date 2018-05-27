<?php
namespace tequila\plugins\cfdi;
use \SoapClient, \Exception;
/**
* Realiza el xml de una factura electrónica con el proveedor Invoice One
*
* @author	isaac
* @package	tequila
* @version	1
*/
class InvoiceOne extends FacturaCFDI{
	/**
	* Bandera que indica si se debe usar el web service de pruebas o el de producción
	*
	* @access	private
	* @var		bool
	*/
	public $produccion = false;

	/**
	* Envía el xml a timbrar
	*
	* @access	public
	* @return	stdClass
	*/
	public function enviar()
	{
		$url = 'https://invoiceone.mx/TimbreCFDI/TimbreCFDI.asmx?wsdl';
		$cliente = new SoapClient( $url, array( 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' => TRUE ) );
		try
		{
			if ( $this->produccion )
			{
				$resultado = $cliente->ObtenerCFDI( array(
					'xmlComprobante'	=> $this->xml->saveXML(),
					'nombreUsuario'		=> 'IIS13110',
					'contrasena'		=> 'tr3snnI1'
				));
				$this->resultado = $resultado->ObtenerCFDIResult;
			}
			else
			{
				$resultado = $cliente->ObtenerCFDIPrueba( array(
					'xmlComprobante'	=> $this->xml->saveXML(),
					'usuario'			=> 'IIS13110',
					'contrasena'		=> 'tr3snnI1'
				));
				$this->resultado = $resultado->ObtenerCFDIPruebaResult;
			}	
		}
		catch ( Exception $ex )
		{
			$this->resultado = $ex->getMessage();
			return false;
		}
		return true;
	}
}
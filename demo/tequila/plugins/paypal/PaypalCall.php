<?php
namespace tequila\plugins\paypal;
use PayPal\Rest\ApiContext, PayPal\Auth\OAuthTokenCredential, PayPal\Api\Payer, PayPal\Api\Details,
PayPal\Api\Amount, PayPal\Api\Item, PayPal\Api\ItemList, PayPal\Api\Transaction, PayPal\Api\Payment, PayPal\Api\RedirectUrls,
PayPal\Exception\PayPalConnectionException, tequila\sistema\Log, \Sess, \Redirect;
/**
* Clase para realizar pagos a paypal utilizando el método standard
*
* La clase utiliza la librería de composer de paypal
*
* @author	isaac
* @package	tequila.plugins
* @version	1
*/
require 'PayPal-PHP-SDK' . DS . 'vendor' . DS . 'autoload' . EXT;
class PaypalCall{
	/**
	* Objeto principal de la api de paypal
	*
	* @access	public
	* @var		ApiContext
	*/
	public $api;

	/**
	* Conjunto de productos que se comprarán
	*
	* @access	public
	* @var		array
	*/
	public $productos = array();

	/**
	* Tipo de cambio por default
	*
	* @access	public
	* @var		string
	*/
	public $tipoDeCambio = 'MXN';

	/**
	* Configuraciones de la api
	*
	* @access	protected
	* @var		array
	*/
	protected $apiConfigs = array(
		'mode'						=>	'sandbox',
		'http.ConnectionTimeOut'	=>	30,
		'log.logEnabled'			=>	false,
		'log.FileName'				=>	'',
		'log.LogLevel'				=>	'FINE',
		'validation.level'			=>	'log'
	);

	/**
	* Constructor
	*
	* Inicia el contexto de PaylPal y asigna las credenciales
	*
	* @access	public
	* @param	string		$clientId	El id del cliente PayPal
	* @param	string		$secret		El secreto del cliente PayPal
	*/
	public function __construct( /*$clientId, $secret*/ )
	{
		$this->api = new ApiContext( new OAuthTokenCredential(
			'Aeh2iJrxMwKRNMgELs0h-3VIKd1OOizKOPIZlpN_jnzNuCyI9aX33ycqy1bG4kXvB1tDFtlRW1x52l6V',
			'EMaRFPfWpULCA56PlxY-nMvzbQu7sc6mgoCfUby6Mf__scxv6-FXq0uxihQvPzu59tDUWHgG-daYAnHS'
		));
		$this->api->setConfig( $this->apiConfigs );
	}

	/**
	* Añade un producto al carrito
	*
	* @access	public
	* @param	string		$descripcion	Descripción del producto
	* @param	float		$subTotal		El precio final del producto
	* @param	int			$cantidad		La cantidad de producto comprado
	* @param	double		$impuesto		Impuesto del producto
	* @param	string		$tipoDeCambio	El tio de cambio del producto
	*/
	public function addProducto( $descripcion, $subTotal, $cantidad = 1, $impuesto = 0, $tipoDeCambio = null )
	{
		if ( !isset( $tipoDeCambio ) )
		{
			$tipoDeCambio = $this->tipoDeCambio;
		}
		$item = new Item;
		$this->productos[] = $item
			->setName( $descripcion )
			->setCurrency( $tipoDeCambio )
			->setQuantity( $cantidad )
			->setPrice( $subTotal )
			->setTax( $impuesto );
	}

	/**
	* Devuelve la información acumulada de los productos añadidos
	*
	* @access	public
	* @return	stdObject
	*/
	public function getProductosInfo()
	{
		$subTotal = $impuestos = 0;
		foreach	( $this->productos as $producto )
		{
			$subTotal += $producto->getPrice();
			$impuestos += $producto->getTax();
		}
		return (object) array( 'subTotal' => $subTotal, 'impuestos' => $impuestos );
	}

	/**
	* Crea un pago a recibir
	*
	* @access	public
	* @param	array		$opciones		Las opciones del pago
	*/
	public function recibirPago( array $opciones )
	{
		$defaults = (object) array_merge( array(
			'metodoDePago'		=>	'paypal',
			'descripcion'		=>	'/',
			'envio'				=>	'0',
			'intento'			=>	'sale',
			'urlPagoExitoso'	=>	'/',
			'urlCancelacion'	=>	'/',
			'identificador'		=>	0
		), $opciones );
		foreach ( $this->productos as $producto )
		{
			$subTotal += $producto->getPrice();
			$impuestos 
		}
		$productosInfo = $this->getProductosInfo();
		$payer = new Payer;
		$payer
			->setPaymentMethod( $defaults->metodoDePago );
		$itemList = new ItemList;
		$itemList
			->setItems( $this->productos );
		$details = new Details;
		$details
			->setShipping( $defaults->envio )
			->setTax( $productosInfo->impuestos )
			->setSubtotal( $productosInfo->subTotal );			
		$amount = new Amount;
		$amount
			->setCurrency( $this->tipoDeCambio )
			->setTotal( $productosInfo->impuestos + $productosInfo->subTotal )
			->setDetails( $details );
		$transaction = new Transaction;
		$transaction
			->setAmount( $amount )
			->setItemList( $itemList )
			->setDescription( $defaults->descripcion )
			->setInvoiceNumber( uniqid());
		$redirectUrls = new RedirectUrls;
		$redirectUrls
			->setReturnUrl( $defaults->urlPagoExitoso )
			->setCancelUrl( $defaults->urlCancelacion );
		$payment = new Payment;
		$payment
			->setIntent( $defaults->intento )
			->setPayer( $payer )
			->setTransactions( array( $transaction ) )
			->setRedirectUrls( $redirectUrls );
		try
		{
			$payment->create( $this->api );
			Sess::instanciaDefault()->set( 'paypal_id', $payment->getId() );
			Sess::instanciaDefault()->set( 'paypal_productId', $defaults->identificador );
		}
		catch ( PayPalConnectionException $ex )
		{
			Log::add( 'excepciones', $ex->getMessage() . PHP_EOL );
		}
		return new Redirect( $payment->getApprovalLink() );
	}
}
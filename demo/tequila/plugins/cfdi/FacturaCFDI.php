<?php
namespace tequila\plugins\cfdi;
use \DOMDocument, \DOMElement, \DateTime, \DOMNode, tequila\sistema\ColeccionErrores,
\XSLTProcessor, tequila\plugins\pdf\PlantillaPDF, \QRcode, \Url;
/**
* Realiza el xml de una factura electrónica versión 3.2 del SAT
*
* @author	isaac
* @package	tequila
* @version	1
*/
abstract class FacturaCFDI extends ColeccionErrores{
	/**
	* Ruta del archivo de configuraciones de la clase
	*
	* @access	protected
	* @var		array
	*/
	protected $_ruta = array( 'tequila', 'plugins', 'cfdi', 'errores' );

	/**
	* Objeto xml de la factura
	*
	* @access	public
	* @var		DOMDocument
	*/
	public $xml;

	/**
	* Raíz del xml
	*
	* @access	public
	* @var		DOMElement
	*/
	public $raiz;

	/**
	* Texto con el xml generado
	*
	* @access	public
	* @var		string
	*/
	public $xmlString;

	/**
	* Datos de la factura
	*
	* Los datos que tienen un valor son obligatorios
	*
	* @access	protected
	* @var		array
	*/
	protected $factura = array(
		'cfdi:Comprobante'	=> array(
			'version'			=> 'TEXTO',
			'folio'				=> 'ENTERO',
			'fecha'				=> 'TEXTO',
			'formaDePago'		=> 'TEXTO',
			'subTotal'			=> 'NUMERO',
			'descuento',
			'total'				=> 'NUMERO',
			'metodoDePago'		=> 'TEXTO',
			'tipoDeComprobante'	=> 'TEXTO',
			'Moneda',
			'LugarExpedicion'	=> 'TEXTO',
			'cfdi:Emisor'		=> array(
				'rfc'					=> 'TEXTO',
				'nombre'				=> 'TEXTO',
				'cfdi:DomicilioFiscal'	=> array(
					'calle'					=> 'TEXTO',
					'noExterior'			=> 'TEXTO',
					'noInterior',
					'colonia'				=> 'TEXTO',
					'localidad',
					'municipio'				=> 'TEXTO',
					'estado'				=> 'TEXTO',
					'pais'					=> 'TEXTO',
					'codigoPostal'			=> 'ENTERO'
				),
				'cfdi:RegimenFiscal'	=> array(
					'Regimen'		=> 'TEXTO'
				)
			),
			'cfdi:Receptor'		=> array(
				'rfc'					=> 'TEXTO',
				'nombre'				=> 'TEXTO',
				'cfdi:Domicilio'		=> array(
					'calle'					=> 'TEXTO',
					'noExterior'			=> 'TEXTO',
					'noInterior',
					'colonia'				=> 'TEXTO',
					'localidad',
					'municipio'				=> 'TEXTO',
					'estado'				=> 'TEXTO',
					'pais'					=> 'TEXTO',
					'codigoPostal'			=> 'ENTERO'
				)
			),
			'cfdi:Impuestos'	=> array(
				'totalImpuestosTrasladados'	=> 'NUMERO',
				'cfdi:Traslados'				=> array(
					'cfdi:Traslado'					=> array(
						'impuesto'					=> 'TEXTO',
						'tasa'						=> 'NUMERO',
						'importe'					=> 'NUMERO'
					)
				)
			)
		)
	);

	/**
	* Datos de un cocepto del comprobante
	*
	* @access	protected
	* @var		array
	*/
	protected $conceptos = array(
		'cantidad'		=> 'ENTERO',
		'unidad'		=> 'TEXTO',
		'descripcion'	=> 'TEXTO',
		'valorUnitario'	=> 'NUMERO',
		'importe'		=> 'NUMERO',
	);

	/**
	* Indice de conceptos que se han añadido
	*
	* @access	private
	* @var		int
	*/
	private $conceptoIndice = 0;

	/**
	* Arreglo que contiene los valores de la factura
	*
	* @access	public
	* @var		array
	*/
	public $comprobante = array(
		'cfdi:Comprobante'	=> array(
			'xmlns:xsi'			=> 'http://www.w3.org/2001/XMLSchema-instance',
			'xsi:schemaLocation'=> 'http://www.buzonfiscal.com/ns/addenda/bf/2 http://www.buzonfiscal.com/schema/xsd/Addenda_BF_v20.xsd http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd',
			'cfdi:Emisor'		=> array(
				'cfdi:DomicilioFiscal'	=> array(),
				'cfdi:RegimenFiscal'	=> array()
			),
			'cfdi:Receptor'		=> array(
				'cfdi:Domicilio'		=> array(),
			),
			'cfdi:Conceptos'	=> array(),
			'cfdi:Impuestos'	=> array(
				'cfdi:Traslados'		=> array(
					'cfdi:Traslado'			=> array()
				)
			)
		)
	);

	/**
	* Se almacenará el resultado del webservice
	*
	* @access	public
	* @var		stdClass
	*/
	public $resultado;

	/**
	* Asigna valores generales
	*
	* @access	public
	* @param	array	$datos		Los valores generales
	*/
	public function comprobante( array $datos )
	{
		$this->asignarValores( $this->factura[ 'cfdi:Comprobante' ],
			$this->comprobante[ 'cfdi:Comprobante' ],
			$datos );
	}

	/**
	* Asigna valores emisor
	*
	* @access	public
	* @param	array	$datos		Los valores emisor
	*/
	public function emisor( array $datos )
	{
		$this->asignarValores( $this->factura[ 'cfdi:Comprobante' ][ 'cfdi:Emisor' ],
			$this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Emisor' ],
			$datos );
	}

	/**
	* Asigna valores domicilio emisor
	*
	* @access	public
	* @param	array	$datos		Los valores domicilio emisor
	*/
	public function domicilioEmisor( array $datos )
	{
		$this->asignarValores( $this->factura[ 'cfdi:Comprobante' ][ 'cfdi:Emisor' ][ 'cfdi:DomicilioFiscal' ],
			$this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Emisor' ][ 'cfdi:DomicilioFiscal' ],
			$datos );
	}

	/**
	* Asigna valores domicilio emisor
	*
	* @access	public
	* @param	array	$datos		Los valores domicilio emisor
	*/
	public function regimenEmisor( array $datos )
	{
		$this->asignarValores( $this->factura[ 'cfdi:Comprobante' ][ 'cfdi:Emisor' ][ 'cfdi:RegimenFiscal' ],
			$this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Emisor' ][ 'cfdi:RegimenFiscal' ],
			$datos );
	}

	/**
	* Asigna valores emisor
	*
	* @access	public
	* @param	array	$datos		Los valores emisor
	*/
	public function receptor( array $datos )
	{
		$this->asignarValores( $this->factura[ 'cfdi:Comprobante' ][ 'cfdi:Receptor' ],
			$this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Receptor' ],
			$datos );
	}

	/**
	* Asigna valores domicilio emisor
	*
	* @access	public
	* @param	array	$datos		Los valores domicilio emisor
	*/
	public function domicilioReceptor( array $datos )
	{
		$this->asignarValores( $this->factura[ 'cfdi:Comprobante' ][ 'cfdi:Receptor' ][ 'cfdi:Domicilio' ],
			$this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Receptor' ][ 'cfdi:Domicilio' ],
			$datos );
	}

	/**
	* Asigna valores domicilio emisor
	*
	* @access	public
	* @param	array	$datos		Los valores domicilio emisor
	*/
	public function impuestos( array $datos )
	{
		$this->asignarValores( $this->factura[ 'cfdi:Comprobante' ][ 'cfdi:Impuestos' ],
			$this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Impuestos' ],
			$datos );
	}

	/**
	* Asigna valores emisor
	*
	* @access	public
	* @param	array	$datos		Los valores emisor
	*/
	public function traslado( array $datos )
	{
		$this->asignarValores( $this->factura[ 'cfdi:Comprobante' ][ 'cfdi:Impuestos' ][ 'cfdi:Traslados' ][ 'cfdi:Traslado' ],
			$this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Impuestos' ][ 'cfdi:Traslados' ][ 'cfdi:Traslado' ],
			$datos );
	}

	/**
	* Asigna los valores al comprobante
	*
	* @access	public
	* @param	array	$reglas			El arreglo de las reglas
	* @param	array	$referencia		El arreglo al cual se añadirán
	* @param	array	$datos			Los valores a registrar
	*/
	public function asignarValores( array &$reglas, array &$referencia, array $datos )
	{
		foreach ( $reglas as $indice => $valor )
		{
			if ( !is_array( $valor ) )
			{
				if ( !is_int( $indice ) )
				{
					if ( !isset( $datos[ $indice ] ) )
					{
						$this->addError( ucfirst( $indice ), 'REQUERIDO' );
					}
					elseif ( $this->validar( $datos[ $indice ], $valor ) === false )
					{
						$this->addError( ucfirst( $indice ), 'FORMATO' );
					}
					else
					{
						$referencia[ $indice ] = $datos[ $indice ];
					}
				}
				else
				{
					$referencia[ $indice ] = isset( $datos[ $indice ] ) ? $datos[ $indice ] : '';
				}
			}
		}
	}

	/**
	* Añade los conceptos a la factura
	*
	* @access	public
	* @param	array		$concepto			El concepto a añadir
	*/
	public function addConcepto( array $concepto )
	{
		foreach ( $this->conceptos as $indice => $regla )
		{
			if ( !$this->validar( $concepto[ $indice ], $regla ) )
			{
				$this->addError( $indice, 'FORMATO' );
			}
		}
		$this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Conceptos' ]
			[ "cfdi:Concepto[{$this->conceptoIndice}]" ] = $concepto;
		$this->conceptoIndice++;
	}

	/**
	* Crea el xml
	*
	* Si se encontraron errores en la validación de datos se devuelve "false"
	*
	* @access	public
	* @return	bool
	*/
	public function generar()
	{
		if ( !empty( $this->errores ) )
		{
			return false;
		}
		$this->xml = new DOMDocument( '1.0', 'utf-8' );
		$this->addNode( $this->xml, $this->comprobante );
		$this->xmlString = $this->xml->saveXML();
		return true;
	}

	/**
	* Construye el xml en base al arreglo de la factura
	*
	* @access	private
	* @param	DOMNode		$node		El nodo con el que se está trabajando
	* @param	array		$datos		Los datos a agregar al nodo
	*/
	private function addNode( DOMNode $node, array $data )
	{
		foreach ( $data as $name => $value )
		{
			if ( is_array( $value ) && !empty( $value ) )
			{
				$name = preg_replace( '#\[[0-9]+\]#', '', $name );
				$newNode = new DOMElement( $name, null, 'http://www.sat.gob.mx/cfd/3' );
				if ( $node instanceof DOMDocument )
				{
					$this->raiz = $newNode;
				}
				$node->appendChild( $newNode );
				$this->addNode( $newNode, $value );
			}
			else
			{
				$value = trim( $value );
				if ( $value !== '' )
				{
					$newAttribute = $node->setAttribute( $name, $value );
					$node->appendChild( $newAttribute );
				}
			}
		}
	}

	/**
	* Crea la cadena original del xml
	*
	* Se deben tener los archivos xslt en versión 1
	*
	* @access	public
	* @return	string
	*/
	public function cadenaOriginal()
	{
		$xslt = new DOMDocument();
		$xslt->load( dirname ( __FILE__ ) . DS . 'xslts' . DS . 'cadenaoriginal_3_2.xslt' );
		$procesador = new XSLTProcessor;
		$procesador->importStyleSheet( $xslt );
		return $procesador->transformToXML( $this->xml );
	}

	/**
	* Crea la cadena original del complemento de certificación digital
	*
	* Se debe tener el archivo xslt en versión 1
	*
	* @access	public
	* @param	DOMNode		$nodo		El nodo xml del timbrado fiscal
	* @return	string
	*/
	public function cadenaOriginalCertificada( DOMNode $nodo )
	{
		$xslt = new DOMDocument;
		$xslt->load( dirname ( __FILE__ ) . DS . 'xslts' . DS . 'cadenaoriginal_TFD_1_0.xslt' );
		$procesador = new XSLTProcessor;
		$procesador->importStyleSheet( $xslt );
		$timbrado = new DOMDocument;
		$timbrado->appendChild( $timbrado->importNode( $nodo, true ) );
		return $procesador->transformToXML( $timbrado );
	}

	/**
	* Añade el numero de certificado, el sello y el certificado al xml
	*
	* @access	public
	* @param	string		$noCertificado		El numero del certificado
	* @param	string		$cadenaOriginal		La cadena para generar el sello
	* @param	string		$llave				El archivo fr la llave
	* @param	string		$certificado		El archivo del certificado
	*/
	public function sellarYCertificar( $noCertificado, $cadenaOriginal, $llave, $certificado )
	{
		//Numero de certificado
		$newAttribute = $this->raiz->setAttribute( 'noCertificado', $noCertificado );
		$this->raiz->appendChild( $newAttribute );
		$this->comprobante[ 'cfdi:Comprobante' ][ 'noCertificado' ] = $noCertificado;
		//Sello del xml
		$id = openssl_get_privatekey( file_get_contents( $llave ) );
		openssl_sign( $cadenaOriginal, $sign, $id, OPENSSL_ALGO_SHA1 );
		openssl_free_key( $id );
		$sello = base64_encode( $sign );
		$newAttribute = $this->raiz->setAttribute( 'sello', $sello );
		$this->raiz->appendChild( $newAttribute );
		$this->comprobante[ 'cfdi:Comprobante' ][ 'sello' ] = $sello;
		//Certificado
		$contenido = str_replace( array( 'BEGIN CERTIFICATE', 'END CERTIFICATE', '-', "\n" ),
			'', file_get_contents( $certificado ) );
		$newAttribute = $this->raiz->setAttribute( 'certificado', $contenido );
		$this->raiz->appendChild( $newAttribute );
		$this->comprobante[ 'cfdi:Comprobante' ][ 'certificado' ] = $contenido;
	}

	/**
	* Genera el pdf de una respuesta exitosa
	*
	* @access	public
	* @param	string		$path		La ruta de guardado
	*/
	public function guardarPDF( $path )
	{
		$xml = new DOMDocument;
		$xml->loadXML( $this->resultado->Xml );
		$pdf = new PlantillaPDF;
		$pdf->addPlantilla( dirname( __FILE__ ) . DS . 'plantilla.pdf' );
		//Añade el logo al documento
		$pdf->Image( 'recursos' . DS . 'imagenes' . DS . 'innsert.png', 16.5, 7, 0, 18 );
		//Comprobante
		$pdf->SetFont( 'Arial', '', 9 );
		$pdf->celda( 144, 25.5, 50, 20, $this->comprobante[ 'cfdi:Comprobante' ][ 'folio' ], 'R' );
		$pdf->celda( 144, 56.5, 50, 20, $this->comprobante[ 'cfdi:Comprobante' ][ 'fecha' ], 'R' );
		$pdf->celda( 144, 46.5, 50, 20, $this->comprobante[ 'cfdi:Comprobante' ][ 'noCertificado' ], 'R' );
		//Datos emisor
		$emisor = $this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Emisor' ];
		$domicilio = (object)$emisor[ 'cfdi:DomicilioFiscal' ];
		$direccion = "{$domicilio->calle} #{$domicilio->noExterior}";
		$direccion .= !empty( $domicilio->noInterior ) ? " Int:{$domicilio->noInterior}" : '';
		$direccion .= " {$domicilio->colonia}";
		$direccion .= !empty( $domicilio->localidad ) ? " Localidad: {$domicilio->localidad}" : '';
		$ubicacion = "{$domicilio->municipio}, {$domicilio->estado}, {$domicilio->pais} CP:{$domicilio->codigoPostal}";
		$pdf->celda( 45, 21, 10, 20, $emisor[ 'rfc' ] );
		$pdf->SetFont( 'Arial', 'B', 9 );
		$pdf->celda( 16.5, 26, 10, 20, $emisor[ 'nombre' ] );
		$pdf->SetFont( 'Arial', '', 9 );
		$pdf->celda( 16.5, 31, 10, 20 , $direccion );
		$pdf->celda( 16.5, 35.5, 10, 20, $ubicacion );
		//Datos receptor
		$receptor = $this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Receptor' ];
		$domicilio = (object)$receptor[ 'cfdi:Domicilio' ];
		$direccion = "{$domicilio->calle} #{$domicilio->noExterior}";
		$direccion .= !empty( $domicilio->noInterior ) ? " Int:{$domicilio->noInterior}" : '';
		$direccion .= " {$domicilio->colonia}";
		$direccion .= !empty( $domicilio->localidad ) ? " Localidad: {$domicilio->localidad}" : '';
		$ubicacion = "{$domicilio->municipio}, {$domicilio->estado}, {$domicilio->pais} CP:{$domicilio->codigoPostal}";
		$pdf->celda( 50, 38, 10, 30, $receptor[ 'rfc' ] );
		$pdf->SetFont( 'Arial', 'B', 9 );
		$pdf->celda( 16.5, 48, 10, 20, $receptor[ 'nombre' ] );
		$pdf->SetFont( 'Arial', '', 9 );
		$pdf->celda( 16.5,  53, 10, 20, $direccion );
		$pdf->celda( 16.5, 57.5, 10, 20, $ubicacion );
		//Conceptos
		$conceptos = $this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Conceptos' ];
		$conceptoY = 85;
		foreach ( $conceptos as $concepto )
		{
			$pdf->celda( 17.5, $conceptoY, 10, 20, $concepto[ 'descripcion' ] );
			$pdf->celda( 115, $conceptoY, 10, 20, $concepto[ 'cantidad' ] );
			$pdf->celda( 130, $conceptoY, 10, 20, $concepto[ 'unidad' ] );
			$pdf->celda( 150, $conceptoY, 10, 20, $concepto[ 'valorUnitario' ] );
			$pdf->celda( 172.5, $conceptoY, 10, 20, $concepto[ 'importe' ] );
			$conceptoY += 8;
		}
		//Sumatorias
		$pdf->celda( 172.5, 177, 10, 20, $this->comprobante[ 'cfdi:Comprobante' ][ 'subTotal' ] );
		$pdf->celda( 172.5, 185, 10, 20, $this->comprobante[ 'cfdi:Comprobante' ][ 'cfdi:Impuestos' ][ 'totalImpuestosTrasladados' ] );
		$pdf->celda( 172.5, 194, 10, 20, $this->comprobante[ 'cfdi:Comprobante' ][ 'total' ] );
		//Timbrado
		$timbrado = $xml->getElementsByTagNameNs( 'http://www.sat.gob.mx/TimbreFiscalDigital', 'TimbreFiscalDigital' )->item( 0 );
		$pdf->multiCelda( 17, 212.5, 175, 5, $timbrado->getAttribute( 'selloCFD' ), 'L' );
		$pdf->multiCelda( 17, 229.5, 175, 5, $timbrado->getAttribute( 'selloSAT' ), 'L' );
		$pdf->celda( 144, 36, 50, 20, $timbrado->getAttribute( 'UUID' ), 'R' );
		$pdf->celda( 17, 189.5, 100, 5, $timbrado->getAttribute( 'noCertificadoSAT' ), 'L' );
		$pdf->celda( 17, 201.5, 100, 5, $timbrado->getAttribute( 'FechaTimbrado' ), 'L' );
		$pdf->multiCelda( 72, 246, 120, 5, $this->cadenaOriginalCertificada( $timbrado ), 'L' );
		//Añade el código
		$er = $emisor[ 'rfc' ];
		$rr = $receptor[ 'rfc' ];
		$tt = $this->comprobante[ 'cfdi:Comprobante' ][ 'total' ];
		$id = $timbrado->getAttribute( 'UUID' );
		$this->qrcode( $pdf, "?re={$er}&rr={$rr}&tt={$tt}&id={$id}", 17, 242, 50 );
		$pdf->output( $path );
	}

	/**
	* Genera en código QR
	*
	* @access	private
	* @param	PlantillaPDF	$pdf		El documento pdf que tendrá el código
	* @param	string			$data		El contenido del código
	* @param	int				$x			Posición en x
	* @param	int				$y			Posición en y
	* @param	int				$s			Tamaño del código
	*/
	private function qrcode( $pdf, $data, $x, $y, $s )
	{
		if ( !class_exists( 'QRcode', false ) )
		{
			require dirname( __FILE__ ) . DS . 'qrcode' . DS . 'qrcode.class' . EXT;
		}
		$qrcode = new QRcode( $data );
		$qrcode->displayFPDF( $pdf, $x, $y, $s );
	}

	/**
	* Guarda el xml generado
	*
	* @access	public
	* @param	string		$path		La ruta del archivo a guardar
	*/
	public function guardarXML( $path )
	{
		file_put_contents( $path , $this->resultado->Xml );
	}

	/**
	* Valida los tipos de datos que se aceptan en los conceptos de la factura
	*
	* @access	private
	* @param	mixed		$valor		El valor a validar
	* @param	atring		$tipo		El tipo de dato requerido
	* @return	bool
	*/
	private function validar( &$valor, $tipo )
	{
		$valor = trim( $valor );
		switch ( $tipo )
		{
			case 'TEXTO':
				return ( $valor != '' );
			case 'NUMERO':
				$valor = str_replace( ',', '', $valor );
				return is_numeric( $valor );
			case 'ENTERO':
				return ( ctype_digit( $valor ) || is_int( $valor ) );
			default:
				return false;
		}
	}

	/**
	* Envía el el xml a timbrar
	*
	* Función abstracta, cambia según el proveedor
	*
	* @access	public
	*/
	abstract public function enviar();
}
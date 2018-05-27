<?php
namespace tequila\scaffolding;
/**
* Esta clase creo los modelos físicamente
*
* @package	tequila.scaffolding
* @author	isaac
* @version	1
*/
class Vista{
	/**
	* Clase scaffolfing
	*
	* @access	private
	* @var		Scaffolding
	*/
	private $data;

	/**
	* Nombre del modelo
	*
	* @access	private
	* @var		string
	*/
	private $instancia;

	/**
	* Constructor
	*
	* Establece el objeto scaffolding
	* Remueve la pluralización de la clase para nombrar al modelo
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
	}

	/**
	* Creación de los elementos del formulario
	*
	* @access	private
	* @return	string
	*/
	private function insert()
	{
		$texto = '';
		foreach ( $this->data->contexto->propiedades as $propiedad => $valores )
		{
			if ( is_array( $valores ) && !isset( $valores['OMITIR'] ) )
			{
				if ( !isset( $valores['RELACION'] ) )
				{
					$texto .= "
			Form::label( '$propiedad', '" . ucfirst( $propiedad ) . "' );
			Form::text( '$propiedad' );";
				}
				else
				{
					$tabla = $valores['RELACION']['TABLA'];
					$texto .= "
			Form::label( '$propiedad', '" . ucfirst( $propiedad ) . "' );
			Form::select( '$propiedad', \$$tabla, 'nombre' );";
				}
			}
		}
		return $texto;
	}

	/**
	* Creación de los elementos del formulario para actualización
	*
	* @access	private
	* @return	string
	*/
	private function update()
	{
		$texto = '';
		foreach ( $this->data->contexto->propiedades as $propiedad => $valores )
		{
			if ( is_array( $valores ) && !isset( $valores['OMITIR'] ) )
			{
				if ( !isset( $valores['RELACION'] ) )
				{
					$texto .= "
			Form::label( '$propiedad', '" . ucfirst( $propiedad ) . "' );
			Form::text( '$propiedad', \${$this->instancia}->$propiedad );";
				}
				else
				{
					$tabla = $valores['RELACION']['TABLA'];
					$texto .= "
			Form::label( '$propiedad', '" . ucfirst( $propiedad ) . "' );
			Form::select( '$propiedad', \$$tabla, 'nombre', \${$this->instancia}->$propiedad );";
				}
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
		$titulo = ucfirst( $this->data->nombre );
		$mayusculas = strtoupper( $this->data->nombre );
		$nombre = $this->data->nombre;
		$index = <<<INDEX
<?php
	\$this->master->paquetes( new Js( 'innTable' ), new Css( 'innTable' ) );
	\$sidebar->dibujar();
?>

<div id="contenido">
	<?php
		\$ruta['{$nombre}']->seleccionar();
		\$ruta->dibujar();
	?>

	<h3>
		{$mayusculas}
	</h3>

	<article>
		<div class="utilidades">
			<div class="opciones">
				<?php echo Html::link( '<i class="fa fa-plus"></i>Añadir', Url::obtener( 'administracion/{$nombre}/insertar' ), array( 'class' => 'button azul' ) ); ?>
				<div class="buscador">
					<?php
						Form::label( 'buscar', 'Buscar por ...:' );
						Form::text( 'buscar' );
						echo Html::elemento( 'button', '<i class="fa fa-search "></i>', array( 'class' => 'icono', 'id' => 'buscador' ) );
					?>
				</div>
			</div>
		</div>

		<?php Form::hidden( 'url', Url::obtener( 'administracion/{$nombre}/buscar' ) ); ?>

		<div class="innTable">
			<table>
				<thead>
					
					<!-- Títulos -->

					<th>Acciones</th>
				</thead>

				<tbody>

				<?php foreach ( \${$nombre}->resultado->lista() as \${$this->instancia} ):	?>

					<tr>
						
						<!-- Registros -->

						<td class="grupo">
							<?php
								echo Html::link( '<i class="fa fa-pencil"></i>', Url::obtener( 'administracion/{$nombre}/actualizar/' . \${$this->instancia}->id ),
									array( 'class' => 'button azul icono', 'title' => 'Editar' ) );
							?>
						</td>
					</tr>

				<?php endforeach; ?>
					
				</tbody>
			</table>

			<div class="paginacion">
				<?php echo \${$nombre}->paginar() ?>
			</div>
		</div>

	</article>
</div>

<script>
	\$( 'div.innTable' ).innTable( {	url : document.getElementById( 'url' ).value, buscar : { text : '#buscar', button : '#buscador' } } );
</script>
INDEX;
		if ( empty ( $this->data->ruta ) )
		{
			$archivo = 'app' . DS . 'vistas' . DS . $this->data->nombre . DS;
		}
		else
		{
			$archivo = 'app' . DS . 'vistas' . DS . join( DS, $this->carpetas ) . DS . $this->data->nombre . DS;
		}
		if ( file_put_contents( $archivo . 'index.php', $index ) )
		{
			echo 'index "' . $this->instancia . '" generado! :D<br/>';
		}
		else
		{
			echo 'Error :(<br/>';
		}
		$insertar = <<<INSERTAR
<?php
	\$sidebar->dibujar();
?>

<div id="contenido">
	<?php
		\$ruta->agregar( array(
			'indice'		=>	'insertar',
			'texto'			=>	'Nueva {$titulo}',
			'url'			=>	Url::obtener( 'administracion/{$nombre}/insertar' ),
			'seleccionado'	=>	true
		));
		\$ruta->dibujar();
	?>

	<h3>NUEVA {$mayusculas}</h3>

	<article>

		<?php
			Form::abrir( Url::actual() );{$this->insert()}
			Form::submit( 'ok', 'Aceptar', array( 'class' => 'verde' ) );
			Form::cerrar();
		?>

	</article>
</div>
INSERTAR;
		if ( file_put_contents( $archivo . 'insertar.php', $insertar ) )
		{
			echo 'insertar "' . $this->instancia . '" generado! :D<br/>';
		}
		else
		{
			echo 'Error :(<br/>';
		}
		$actualizar = <<<ACTUALIZAR
<?php
	\$sidebar->dibujar();
?>

<div id="contenido">
	<?php
		\$ruta->agregar( array(
			'indice'		=>	'actualizar',
			'texto'			=>	'Actualizar {$titulo}',
			'url'			=>	Url::obtener( 'administracion/{$nombre}/actualizar/' . \${$this->instancia}->id ),
			'seleccionado'	=>	true
		));
		\$ruta->dibujar();
	?>

	<h3>ACTUALIZAR {$mayusculas}</h3>

	<article>

		<?php
			Form::abrir( Url::actual() );
			Form::hidden( 'id', \${$this->instancia}->id );{$this->update()}
			Form::submit( 'ok', 'Aceptar', array( 'class' => 'verde' ) );
			Form::cerrar();
		?>

	</article>
</div>
ACTUALIZAR;
		if ( file_put_contents( $archivo . 'actualizar.php', $actualizar ) )
		{
			echo 'actualizar "' . $this->instancia . '" generado! :D<br/>';
		}
		else
		{
			echo 'Error :(<br/>';
		}
		$tabulacion = <<<BUSCAR
<table>
	<thead>
		
		<!-- Títulos -->

		<th>Acciones</th>
	</thead>

	<tbody>

	<?php foreach ( \${$nombre}->resultado->lista() as \${$this->instancia} ):	?>

		<tr>
			
			<!-- Registros -->

			<td class="grupo">
				<?php
					echo Html::link( '<i class="fa fa-pencil"></i>', Url::obtener( 'administracion/{$nombre}/actualizar/' . \${$this->instancia}->id ),
						array( 'class' => 'button azul icono', 'title' => 'Editar' ) );
				?>
			</td>
		</tr>

	<?php endforeach; ?>
		
	</tbody>
</table>

<div class="paginacion">
	<?php echo \${$nombre}->paginar() ?>
</div>
BUSCAR;
		if ( file_put_contents( $archivo . 'buscar.php', $tabulacion ) )
		{
			echo 'buscar "' . $this->instancia . '" generado! :D<br/>';
		}
		else
		{
			echo 'Error :(<br/>';
		}
	}
}
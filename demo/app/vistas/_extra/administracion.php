<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Innsert - Administración de Residenciales</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
			$this->paquetes(
				new Icono( 'favicon.png' ),
				new Css( 'innsert' ),
				new Css( 'administracion' ),
				new Css( 'http://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css' ),
				new Js( 'jquery' ),
				new Js( 'innsert' ),
				new Js( 'http://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js' ),
				new Js( 'administracion' ) );
			$this->dibujarPaquetes();
		?>
	</head>

	<body class="clearfix">
		<div id="menu" class="dos-10">
			<?php echo $this->importar( 'administracion/sidebar' ) ?>
		</div>

		<div id="content" class="ocho-10">
			<?php echo $this->importar( 'administracion/topbar' ), $vista ?>
		</div>

		<?php echo Form::hidden( 'configuracionesEspeciales', htmlspecialchars( json_encode( Sess::instanciaDefault()->get( 'configuraciones' ) ) ) ) ?>
	</body>

	<!-- Mensaje modal para las respuestas de los formularios -->
	<div id="submits" class="displayable">
		<div class="message">
			<div class="title">
				<b>innsert</b>
			</div>
			<div class="body"></div>
			<div class="footer text-right">
				<button class="close">Aceptar</button>
			</div>
		</div>
	</div>
	<!-- Modal para imagenes -->
	<div id="imagePreview" class="displayable">
		<img class="image" />
	</div>
	
	<!-- Mensaje modal para los borrados de registros -->
	<div id="deletes" class="displayable">
		<div class="message">
			<div class="title">
				<b>innsert</b>
			</div>
			<div class="body">Esto no se puede deshacer ¿Desea continuar?</div>
			<div class="footer text-right">
				<button class="close red confirm">Aceptar</button>
				<button class="close blue">Cancelar</button>
			</div>
		</div>
	</div>
</html>
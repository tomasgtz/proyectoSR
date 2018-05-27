<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Localnet - Diseña tu campaña</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
			$this->paquetes(
				new Icono( 'favicon.png' ),
				new Css( 'innsert' ),
				new Css( 'designer' ),
				new Css( 'localnet' ),
				new Css( '/recursos/plugins/noUiSlider/nouislider.min' ),
				new Css( 'http://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.min.css' ),
				new Js( 'jquery' ),
				new Js( 'innsert' ),
				new Js( 'jscolor/jscolor' ),
				new Js( 'localnet' ),
				new Js( 'designer/designer' ),
				new Js( 'designer/designer-events' ),
				new Js( '/recursos/plugins/noUiSlider/nouislider.min' ),
				new Js( 'http://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.5.0/fabric.min.js' ),
				new Js( 'http://malihu.github.io/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js' ) );
			$this->dibujarPaquetes();
		?>
	</head>

	<body class="clearfix">
		<?php echo $vista ?>
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
	<!-- Modal para tamaño del lienzo -->
	<div id="resizeWindow" class="displayable">
		<div class="message">
			<div class="title">
				<b>Localnet</b>
			</div>
			<div class="body">
				<div>
					<label>Ancho</label>
					<input class="text-right" id="canvasWidth" type="text" placeholder="Tamaño en pixeles">
				</div>

				<div class="input">
					<label>Alto</label>
					<input class="text-right" id="canvasHeight" type="text" placeholder="Tamaño en pixeles">
				</div>
			</div>
			<div class="footer text-right">
				<button class="blue close" style="margin-right: 5px">Aceptar</button>
				<button class="red close">Cancelar</button>
			</div>
		</div>
	</div>
</html>
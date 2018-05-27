<ul>
	<!-- Fondo -->
	<li id="background-menu" class="act picker-menu">
		<div class="sidebar-title">Fondo</div>

		<div class="search">
			<div class="labeled l-right">
				<span class="btn blue info" title="Buscar">Buscar</span>
				<div>
					<input type="text" id="background-search" />
				</div>
			</div>

			<div style="margin-top: 15px">
				<select id="backgroundFolder" data-holder="#background-holder">
					<option data-url="<?php echo Url::hacer( 'inicio/loadBackgrounds/Predeterminadas' ) ?>" data-name="Predeterminada" id="backgroundDefault">Predeterminada</option>
					<option data-url="<?php echo Url::hacer( 'inicio/loadBackgrounds/OXXO' ) ?>" data-name="OXXO">OXXO</option>
					<option data-url="<?php echo Url::hacer( 'inicio/loadBackgrounds/Muguerza' ) ?>" data-name="Muguerza">Muguerza</option>
				</select>
			</div>
		</div>

		<div id="background-holder" class="background-picker picker-list">
		</div>
	</li>

	<li id="effects-menu">
		<div class="sidebar-title">Efectos</div>

		<div class="control">
			<label>Color de Máscara</label>
			<?php echo Form::text( 'maskColor', null, array( 'class' => 'color {hash:true}', 'readonly' => 'readonly' ) ) ?>
		</div>

		<div class="control mask-opacity">
			<label>Opacidad</label>
			<div id="maskOpacity"></div>
		</div>

		<div class="control use-mask">
			<div class="text-right">
				<button class="btn switch green act" data-on="no">Aplicar Máscara</button>
				<button class="btn switch red" data-on="yes">Remover Máscara</button>
			</div>
		</div>
	</li>

	<li id="texts-menu">
		<div class="sidebar-title">Textos</div>

		<div class="control">
			<label>Fuente</label>
			<?php echo Form::arraySelect( 'font', array(
				'Roboto'		=>	'Roboto',
				'Oswald'		=>	'Oswald',
				'Montserrat'	=>	'Montserrat',
				'Courgette'		=>	'Courgette',
				'Handlee'		=>	'Handlee',
				'Candal'		=>	'Candal',
				'Syncopate'		=>	'Syncopate',
				'Paytone One'	=>	'Paytone One',
				'Luckiest Guy'	=>	'Luckiest Guy',
				'Archivo Black'	=>	'Archivo Black',
				'Fredoka One'	=>	'Fredoka One',
				'Arimo'			=>	'Arimo',
				'Raleway'		=>	'Raleway',
				'Michroma'		=>	'Michroma'
			)) ?>
		</div>

		<div class="control">
			<label>Color del Contorno del Texto</label>
			<?php echo Form::text( 'textOutColor', '#000000', array( 'class' => 'color {hash:true}', 'readonly' => 'readonly' ) ) ?>
		</div>

		<div class="control">
			<label>Color del Relleno del Texto</label>
			<?php echo Form::text( 'textInColor', '#000000', array( 'class' => 'color {hash:true}', 'readonly' => 'readonly' ) ) ?>
		</div>

		<div class="control">
			<label>Tamaño de Fuente</label>
			<div class="labeled l-both spinner">
				<span class="btn blue lbl-left spinner-down">-</span>
				<div>
					<?php echo Form::text( 'fontSize', 12, array( 'class' => 'text-center' ) ) ?>
				</div>
				<span class="btn blue lbl-right spinner-up">+</span>
			</div>
		</div>

		<div class="control">
			<label>Estilo de Texto</label>
			<?php echo Form::arraySelect( 'fontStyle', array(
				'normal'		=>	'Normal',
				'italic'		=>	'Itálica',
				'oblique'		=>	'Oblicua'
			)) ?>
		</div>

		<div class="control">
			<label>Negritas</label>
			<?php echo Form::arraySelect( 'fontWeight', array(
				'bold'		=>	'Sí',
				'normal'	=>	'No'
			)) ?>
		</div>

		<div class="control">
			<label>Decoración de Texto</label>
			<?php echo Form::arraySelect( 'textDecoration', array(
				''				=>	'Normal',
				'underline'		=>	'Subrayado',
				'overline'		=>	'Línea Encima'
			)) ?>
		</div>

		<div class="control">
			<label>Alineación de Texto</label>
			<?php echo Form::arraySelect( 'textAlign', array(
				'left'		=>	'Izquierda',
				'center'	=>	'Centrado',
				'right'		=>	'Derecha'
			)) ?>
		</div>

		<div class="control">
			<label>Ingresa Texto y Presiona ENTER</label>
			<?php echo Form::text( 'insertText' ) ?>
		</div>
	</li>

	<li id="images-menu" class="picker-menu">
		<div class="sidebar-title">Imágenes</div>

		<div class="search">
			<div class="labeled l-right">
				<span class="btn blue info" title="Buscar">Buscar</span>
				<div>
					<input type="text" id="image-search" />
				</div>
			</div>

			<div style="margin-top: 15px">
				<select id="imagesFolder" data-holder="#image-holder">
					<option data-url="<?php echo Url::hacer( 'inicio/loadImages/Predeterminadas' ) ?>" id="imageDefault" data-name="Predeterminada">Predeterminada</option>
					<option data-url="<?php echo Url::hacer( 'inicio/loadImages/OXXO' ) ?>" data-name="OXXO">OXXO</option>
					<option data-url="<?php echo Url::hacer( 'inicio/loadImages/Muguerza' ) ?>" data-name="Muguerza">Muguerza</option>
				</select>
			</div>
		</div>

		<div id="image-holder" class="image-picker picker-list">
		</div>
	</li>

	<li id="shapes-menu" class="picker-menu">
		<div class="sidebar-title">Figuras</div>

		<div class="tab-panel">
			<nav class="nav tabs">
				<ul class="lists">
					<li class="act">
						<span id="btn-shapes" class="pseudo" data-obj="#shapes-tab">Figuras</span>
					</li>
					<li>
						<span id="btn-options" class="pseudo" data-obj="#options-tab">Opciones</span>
					</li>
				</ul>
			</nav>

			<div id="shapes-tab" class="tab act">
				<div class="search">
					<div class="labeled l-right">
						<span class="btn blue info" title="Buscar">Buscar</span>
						<div>
							<input type="text" id="shape-search" />
						</div>
					</div>
				</div>

				<ul class="shape-picker picker-list">
					<li class="row">
						<div class="seis image-wrapper">
							<?php echo Html::img( Url::hacer( 'recursos/uploads/shapes/square.png' ), 'rect', array( 'data-type' => 'rect' ) ) ?>
						</div>

						<div class="seis image-wrapper">
							<?php echo Html::img( Url::hacer( 'recursos/uploads/shapes/circle.png' ), 'circle', array( 'data-type' => 'circle' ) ) ?>
						</div>
					</li>
				</ul>
			</div>
			<div id="options-tab" class="tab">
				<div class="control">
					<label>Color de Relleno</label>
					<?php echo Form::text( 'fillColor', '#000000', array( 'class' => 'color {hash:true}', 'readonly' => 'readonly' ) ) ?>
				</div>

				<div class="control use-fill">
					<div class="text-right">
						<button class="btn switch red act" data-on="yes">Aplicar Relleno</button>
						<button class="btn switch green" data-on="no">Remover Relleno</button>
					</div>
				</div>

				<div class="control mask-opacity">
					<label>Color de Contorno</label>
					<?php echo Form::text( 'strokeColor', null, array( 'class' => 'color {hash:true}', 'readonly' => 'readonly' ) ) ?>
				</div>

				<div class="control">
					<label>Ancho del controno</label>
					<div id="strokeWidth"></div>
				</div>

				<div class="control use-stroke">
					<div class="text-right">
						<button class="btn switch red" data-on="yes">Aplicar Contorno</button>
						<button class="btn switch green act" data-on="no">Remover Contorno</button>
					</div>
				</div>
			</div>
		</div>
	</li>
</ul>
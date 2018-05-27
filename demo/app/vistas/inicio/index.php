<div class="container">
	<?php echo $this->importar( 'designer/topbar' ); ?>

	<div class="sidebar">
		<?php echo $this->importar( 'designer/sidebars' ) ?>
	</div>

	<div class="worktable">
		<?php echo $this->importar( 'designer/tools' ) ?>

		<div class="designer">
			<div id="canvasHolder">
				<canvas id="mainCanvas" height="500px" width="700px"></canvas>
			</div>
		</div>
	</div>
</div>
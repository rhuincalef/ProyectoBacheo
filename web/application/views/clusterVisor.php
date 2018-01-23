<div class="tab-pane" id="visorClusters">
	<!-- Header-->
  	<h2>Fallas clasificadas</h2>
  	<!--
	<div class="row" style="text-align:center;">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<hr>
		</div>
	</div>
	-->
	<?php 
	$arrayDatos = json_decode($datosClusters);
	foreach ($arrayDatos as $datos) {
		# code...
		echo '<table class="table table-hover" style="margin-top:3em;">';
		echo '<tr class="info"><td>Tipo de Falla</td><td>'.$datos->tipoMuestra.'</td></tr>';
		echo "<tr><td>Nombre</td><td>$datos->nombre</td></tr>";
		echo '<tr class="info"><td>Alto</td><td>'.$datos->alto.'</td></tr>';
		echo "<tr><td>Ancho</td><td>$datos->ancho</td></tr>";
		echo '<tr class="info"><td>Profundidad</td><td>'.$datos->profundidad.'</td></tr>';
		echo "</table>";
	}
	?>
	<!-- Contenedor para el thumnail -->
	<div id = "containerTable" class="row"></div>	
	
<!-- Fin del div de tabbed panel -->
</div> 
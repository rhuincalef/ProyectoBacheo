<div class="tab-pane" id="visor">
	<!-- Header-->
  	<h2>Captura del bache</h2>
	<div class="row" style="text-align:center;">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<hr>
		</div>
	</div>

	<!-- Contenedor para el thumnail -->
	<div id = "containerThumnail" class="row">
	</div>
	
	<!-- Contenedor para renderizar la nube con webGL -->
	<!--<div id="containerWebGL" style="display:block; width:50%; height:50%; position:relative;" >
		<div class="row">
			<button id="boton-info"   data-toggle="collapse"   data-target="#datos-falla" type="button" 
			class="btn btn-primary boton-personalizado btn-lg">Info
				<span class="glyphicon glyphicon-signal" aria-hidden="true"></span>
			</button> -->
			<!-- Boton de regreso -->
	<!--		<button id="boton-volver"   data-toggle="collapse"   data-target="#datos-falla"   type="button" 
			class="btn btn-primary boton-personalizado btn-lg ">Regresar </button>
			<div id ="error-alert" style="display:none; ">Error al cargar el csv remoto</div>
		</div>
	</div> -->
<!-- Fin del div de tabbed panel -->
</div> 

<!-- Se carga la coleccion de thumnails por falla -->
<?php
	echo "<script type='text/javascript'>";
	echo "window.nameSpaceThumbnail.solicitarCapturas('".$id."','".base_url()."');";
	//echo "window.nameSpaceThumbnail.configurar_thumbnail( '".base_url("/_/img/res/generandoArchivos.svg")."' );";
	//echo "$('#containerWebGL').hide();";
	//echo "$('#progressbar-container').hide();";
	//echo "$('#boton-info').hide();";
	//echo "$('#cargando-gif').hide();";
	echo "</script>";
?>
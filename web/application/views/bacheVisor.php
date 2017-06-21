<div class="tab-pane" id="visor">
  	<h2>Captura del bache</h2>
	<div class="row" style="text-align:center;">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<hr>
		</div>
	</div>
	<!-- Contenedor para el thumnail -->
	<div id = "containerThumnail" class="row">
		<!-- Div para el thumbnail de la falla. -->
		<div id = "thumnailFalla" class="col-lg-4 col-sm-4 col-xs-6">
		  <div class="thumbnail" >
		    <div id ="titulo" class="caption" >
		        <div id="descripcion" >
		        </div>
		        <p id="contBoton"> <a id="botonVisualizador" class="btn btn-lg btn-primary" style="display:none;">Ver</a>
		        </p>
		    </div>
		    <img id ="imagenThumb" class="img-responsive"></img>
		  </div>
		</div>
	</div>
	<!-- Imagen que se muestra cuando se carga el csv desde el servidor -->
	<img id="cargando-gif"></img>


	<!-- Contenedor para renderizar la nube con webGL -->
	<div id="containerWebGL" style="display:block; width:50%; height:50%; position:relative;" >
		<button id="boton-info"   data-toggle="collapse"   data-target="#datos-falla"   type="button" 
		class="btn btn-primary boton-personalizado btn-lg ">Info
			<span class="glyphicon glyphicon-signal" aria-hidden="true"></span>
		</button>
		<!-- Boton de regreso -->
		<button id="boton-volver"   data-toggle="collapse"   data-target="#datos-falla"   type="button" 
		class="btn btn-primary boton-personalizado btn-lg ">Regresar </button>
		<div id ="error-alert" style="display:none; ">Error al cargar el csv remoto</div>

		<!-- Barra de progreso activada por .js -->
		<!-- <div id="progressbar-container" class="progress progress-striped" style="position:absolute;left:10px !important; z-index:999999; width:50%; top:50%;">
			<div id="progressbar" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="100" style="width:3%">3%</div>
		</div> -->
	</div>

	<!--Separador -->
	<div class="row" style="text-align:center;">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<hr>
		</div>
	</div>

	<!-- Tabla donde se muestra la info de la falla. -->
	<!-- <div id = "datos-falla" style="width:300px;"></div> -->

<!-- Fin del div de tabbed panel -->
</div> 

<!-- Se carga el thumnail por javascript -->
<?php
	echo "<script type='text/javascript'>";
	echo "window.nameSpaceThumbnail.configurar_thumbnail( '".base_url("/_/img/res/generandoArchivos.svg")."' );";
	echo "window.nameSpaceThumbnail.solicitarDatos('".$id."','".base_url()."');";
	echo "$('#containerWebGL').hide();";
	echo "$('#progressbar-container').hide();";
	echo "$('#boton-info').hide();";
	echo "$('#cargando-gif').hide();";
	echo "</script>";
?>
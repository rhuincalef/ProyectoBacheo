
<?php 
//TODO Comentar! Clase de firephp utilizada para la depuración.
if (defined('DIR_DEBUGGING') == FALSE) {
	define("DIR_DEBUGGING","/var/www/html/repoProyectoBacheo/web/application/debugging/");
	set_include_path(get_include_path() . PATH_SEPARATOR . DIR_DEBUGGING);
}
require_once('FirePHP.class.php');
$firephp = FirePHP::getInstance(true);

?>

<div class="oculto">
	<label id="idBache"><?php echo $id; ?></label>
	<label id="titulo"><?php echo $titulo; ?></label>
	<label id="longBache"><?php echo $longitud; ?></label>
	<label id="latBache"><?php echo $latitud; ?></label>
	<label id="imagenesBache"><?php echo $imagenes; ?></label>
	<label id="baseUrlBache"><?php echo $this->config->base_url();?></label>
	<label id="estadoBache"><?php echo $estado;?></label>
	<label id="tiposEstadoBache"><?php echo $tiposEstado;?></label>
	<label id="logueado"><?php echo $logueado?></label>
</div>

<div class="contenido">

	<div class="imagenesCarrucel">
			 <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			 
			  <ol id="carousel-indicators" class="carousel-indicators">
			    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			    <!-- <li data-target="#carousel-example-generic" data-slide-to="1"></li> -->
			  </ol>

			 
			  <div id="carousel" class="carousel-inner">
			    <div class="item active">
			      <img src="<?php echo $this->config->base_url(); ?>_/img/img404.jpg" width="325px" alt="">
			 
			    </div>
			    <!-- <div class="item">
			      <img src="<?php echo $this->config->base_url(); ?>_/img/bache2.jpg" width="325px"  alt="">
			    </div> -->
			    
			  </div>

        </div>
	</div>

	<div class="jumbotron personalizacionJumbotron">
      	  
        <h1>#Falla<?php echo $id; ?></h1>

	</div>
	
	<ul class="nav nav-tabs tabInfo" role="tablist">
	  <li class="active"><a href="#especificaciones" role="tab" data-toggle="tab">Especificación Basica</a></li>
	  <?php 
            if ($logueado) {
             echo '<li><a href="#estado" role="tab" data-toggle="tab">Estado de Falla</a></li>';
        }?>
	  <li><a href="#social" role="tab" data-toggle="tab">Comunidad Social</a></li>

	  <li><a href="#visor" role="tab" data-toggle="tab">Visor nube de puntos</a></li>
	   
	</ul>



	<div class="tab-content	">
	  <div class="tab-pane active" id="especificaciones">
	  	
	  <div id="canvasMapa" class="contenedorMapa"></div>
		<div class="especificacionesBache">
			<h1>Especificación de Falla</h1>
			<table class="table table-hover">
				<tr>
					<td> Tipo de falla </td>
					<td> <?php echo $titulo;?> </td>
				</tr>
				<tr>
					<td> Criticidad </td>
					<td> <?php echo $criticidad;?> </td>
				</tr>
				<tr>
					<td> Dirección </td>
					<td><?php echo $calle;?> - <?php echo $alturaCalle;?></td>
				</tr>
				<tr>
					<td> Estado </td>
					<td id="campoEstadoBache"> <?php $estadoActual = json_decode($estado);
					echo $estadoActual->tipoEstado->nombre;
					?> </td>
				</tr>
				<tr>
					<td> Fecha Ultimo Estado </td>
					<td id="campoFechaEstado"> <?php $estadoActual = json_decode($estado);
					echo $estadoActual->fecha;?> </td>
					<td></td>
				</tr>

				<?php
					if (isset($material)) {
					 	echo"<tr><td> Material de Calle </td><td>$material</td></tr>";         
					 }
					 if (isset($nroBaldosa)) {
					 	echo"<tr><td> Numero de Baldosa </td><td>$nroBaldosa</td></tr>";         
					 }
					 if (isset($rotura)) {
					 	echo"<tr><td> Tipo de Rotura </td><td>$rotura</td></tr>";         
					 }
					 if (isset($ancho)) {
					 	echo"<tr><td> Ancho del Bache </td><td>$ancho</td></tr>";         
					 }
					 if (isset($largo)) {
					 	echo"<tr><td> Largo del Bache </td><td>$largo</td></tr>";         
					 }
					 if (isset($profundidad)) {
					 	echo"<tr><td> Profundidad </td><td>$profundidad</td></tr>";         
					 }
					 if (isset($monto)) {
					 	echo"<tr><td> Monto Estimado </td><td>$monto</td></tr>";         
					 }
					 if (isset($tipoObstruccion)) {
					 	echo"<tr><td> Estado de la Calle</td><td>$tipoObstruccion</td></tr>";         
					 }

					 if (isset($fechaFin)) {
					 	echo"<tr><td> Fecha Estimada de Reparación</td><td>$fechaFin</td></tr>";         
					 }
				?>
				


			</table>

		</div>
	  </div>
	  <?php 
          if ($logueado) {
            echo '<div class="tab-pane" id="estado">';
            	echo '<h1 id="nombreEstado" >Estado de Falla:  </h1>';
            	echo '<div class="contenedorControles">';
            		echo '<h2 id="cambiarEstado" >Cambiar estado a:  </h2>';
            	echo '</div>';
           		echo '<div class="contenedorControles">';
            		echo '<div id="contenedorControladorEstado" class="contenedorPropiedades">';
            		echo '</div>';
            	echo '</div>';
            	echo '<div id="contenedorFormulario" class="oculto">';
            		echo '<form role="form" method="post" action="'.$this->config->base_url().'index.php/cambiarEstadoBache">';
            		echo '<div id="formularioEspecificacionesTecnicas" class="form-group selectFormulario">';
						echo '<div id="contenedorEstado1" class="oculto selectFormulario">';
							echo '<label class="control-label col-sm-2 itemFormularioEstado" for="material"> Material</label><select class="form-control itemFormularioEstado" type="text" id="material" name="material"></select>';
							echo '<label for="factorArea" class="control-label col-sm-4 itemFormularioEstado"> Factor Área (%)</label>';
							echo '<input type="number" class="form-control itemFormularioEstado" name="factorArea" id="factorArea" value="0.5" step="0.1" min="0">';
							echo '<label class="control-label col-sm-4 itemFormularioEstado" for="tipoFalla"> Tipo de Falla</label><select class="form-control itemFormularioEstado" type="text" id="tipoFalla" name="tipoFalla"> <option value="0" selected="selected">Esquina</option>   <option value="1">Huellon</option>	<option value="2">Fisura Transversal</option></select>';
							echo '<label class="control-label col-sm-4 itemFormularioEstado"> Atributos</label>';
								echo '<div style="width:100%; border-top-style:solid; border-top-color: grey; border-bottom-style: solid; border-bottom-color: grey;" class="input-group" id="contenedorAtributosFalla">';
									echo '<input id="ancho" class="form-control itemFormularioEstado" type="text" placeholder="Ancho" name="ancho"/>';
									echo '<label class="control-label col-sm-8 itemFormularioEstado" for="tipoReparacion"> Tipo de Reparación</label>';
									echo '<select id="tipoReparacion" name="tipoReparacion" class="form-control itemFormularioEstado"><option value="1" selected="">reparación especial</option></select>';
								echo ';</div>';
							echo '<label class="control-label col-sm-2 itemFormularioEstado" for="criticidad"> Criticidad</label><select class="form-control itemFormularioEstado" type="text" id="criticidad" name="criticidad"></select>';
							echo '</div>';
						echo '</div>';
							echo '<textarea class="form-control selectFormulario" maxlength="100" placeholder="Descripcion" name="descripcion"></textarea>';
						echo '<div id="contenedorEstado2" class="oculto selectFormulario">';
							echo '<input id="montoEstimado" class="form-control itemFormularioEstado" type="number" placeholder="Monto Estimado" name="montoEstimado" step="any" min="0"/>';
							echo '<label class="control-label col-sm-10 itemFormularioEstado" for="fechaFin"> Fecha Fin Reparación Estimada</label>';
							echo '<input id="fechaFin" class="form-control itemFormularioEstado" type="text"/>';
							echo '<label class="control-label col-sm-10 itemFormularioEstado" for="tipoObstruccion"> Obstruccion de Calle</label><select class="form-control itemFormularioEstado" type="text" id="tipoObstruccion" name="tipoObstruccion"> <option value="0" selected="selected">Parcial</option>';
								echo '<option value="1">Total</option> </select>';
        				echo '</div>';
        				echo '<div class="oculto selectFormulario" id="contenedorEstado3" style="display: none;">';
        					echo '<input type="number" min="0" step="any" name="montoReal" placeholder="Monto Real" class="form-control itemFormularioEstado" id="montoReal">';
        					echo '<input type="text" class="form-control hasDatepicker itemFormularioEstado" id="fechaFinReal">';
        				echo '</div>';
        				echo '<br><button id="registrarEstadoBache"> Confirmar</button></form>';
    				echo '</div>';
				echo '</div>';

        }?>

	  <div class="tab-pane" id="social">

	  		<div id="observaciones"> 
	  			<h1>Comentarios</h1>
	  		</div>
	  		<div id="controles"> 
			</div>

			<div class="areaParaComentar">
			  <div class="divBotones"> 
			  		<button id="enviarObservacion" type="button" class="btn btn-primary botonComentario"> <i class="fa fa-weixin"></i> Comentar</button>
		          	<button id="botonTwitter" type="button" class="btn btn-primary botonComentario"> <i class="fa fa-twitter"></i> Twittear</button>
		      </div>
	          <form id="formularioComentario" class="formularioComentario">
		          <input id="nombreObservador" type="User" class="form-control inputUsuario <?php if($logueado){echo 'oculto';}?>" placeholder="Usuario">
		          <input id="emailObservador" type="Email" class="form-control inputEmail <?php if($logueado){echo 'oculto';}?>" placeholder="Email">
		          <textarea id="comentarioObservador" placeholder="Comentario" maxlength="100" class="form-control areaComentario"></textarea>
		          
	          </form>
	      	</div>	  		

	  </div>


	  <!-- Contenedor del thumnail -->
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
			<div id="progressbar-container" class="progress progress-striped" style="position:absolute;left:10px !important; z-index:999999; width:50%; top:50%;">
				<div id="progressbar" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="100" style="width:3%">3%</div>
			</div>
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

	</div>
		<!-- Se carga el thumnail por javascript -->
		<?php
			$firephp->fb("En bache.php, idfalla = ". $id);
			$firephp->fb("");
			echo "<script type='text/javascript'>";
			echo "window.nameSpaceThumbnail.configurar_thumbnail( '".base_url("/_/img/res/generandoArchivos.svg")."' );";
			echo "window.nameSpaceThumbnail.solicitarDatos('".$id."','".base_url()."');";
			echo "$('#containerWebGL').hide();";
			echo "$('#progressbar-container').hide();";
			echo "$('#boton-info').hide();";
			echo "$('#cargando-gif').hide();";
			// echo "window.nameSpaceCgi.transformarNubePtos('".$id."','".site_url()."');";
			echo "</script>";
		?>

</div>

	<!--<script>Bache.cargarImagenes('<?php echo $this->config->base_url();?>',<?php echo json_encode($imagenes);?>);</script>-->

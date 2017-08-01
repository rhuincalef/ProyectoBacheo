<div class="oculto">
	<label id="idBache"><?php echo $id; ?></label>
	<label id="titulo"><?php echo $titulo; ?></label>
	<label id="longBache"><?php echo $longitud; ?></label>
	<label id="latBache"><?php echo $latitud; ?></label>
	<label id="imagenesBache"><?php echo $imagenes; ?></label>
	<label id="baseUrlBache"><?php echo $this->config->base_url();?></label>
	<label id="imgUrl"><?php echo $this->config->base_url($this->config->item('upload_path') . '/' . $id . '/');?></label>
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
			  </div>

        </div>
	</div>

	<div class="jumbotron personalizacionJumbotron">
      	  
        <h1>#Falla<?php echo $id; ?></h1>

	</div>
	
	<ul class="nav nav-tabs tabInfo" role="tablist">
	  <li class="active"><a href="#especificaciones" role="tab" data-toggle="tab">Especificación Básica</a></li>
      <li><a href="#estado" role="tab" data-toggle="tab">Estado de Falla</a></li>
	  <li><a href="#social" role="tab" data-toggle="tab">Comunidad Social</a></li>
	  <li><a href='#visor' role='tab' data-toggle='tab'>Visor nube de puntos</a></li>
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
					<td> Fecha último estado </td>
					<td id="campoFechaEstado"> <?php $estadoActual = json_decode($estado);
					echo $estadoActual->fecha;?> </td>
				</tr>
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
            		echo '<div class="col-sm-5">
      <input checked="" data-group-cls="btn-group-justified m-b" class="hidden" type="checkbox"><div class="btn-group btn-group-justified m-b" tabindex="0"></div>
    </div>';
            	echo '</div>';
            	echo '<div id="contenedorFormulario" class="oculto">';
            		echo '<form role="form" method="post" action="'.$this->config->base_url().'index.php/cambiarEstadoBache">';
            		echo '<div id="formularioEspecificacionesTecnicas" class="form-group">';
						echo '<div id="contenedorEstado" class="oculto">';
						if (!strcmp($estadoActual->tipoEstado->nombre, "Informado")) {
							//require_once 'bacheAConfirmado.php';
							$this->load->view('bacheAConfirmado.php');
						}
						if (!strcmp($estadoActual->tipoEstado->nombre, "Confirmado")) {
							//require_once 'bacheEnReparacion.php';
							$this->load->view('bacheEnReparacion.php');
						}
						if (!strcmp($estadoActual->tipoEstado->nombre, "Reparando")) {
							//require_once 'bacheAReparando.php';
							$this->load->view('bacheAReparando.php');
						}
						echo '</div>';
					/* End contenedorEstado div */
					/* End formularioEspecificacionesTecnicas div */
					echo '</div>';
						echo '<textarea class="form-control" maxlength="100" placeholder="Descripcion" name="descripcion"></textarea>';
        				echo '<button id="registrarEstadoBache" class="btn btn-primary" type="submit" style="width: 100%; margin-top:2em;"> Confirmar</button>';
        			echo "</form>";
				echo '</div>';
				/* End contenedorFormulario div */
			echo '</div>';
			/* End tab-pane estado div */

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

	<!-- Contenedor del thumbnail -->
	<?php
		require_once("bacheVisor.php");
	?>
	</div>
<footer style="margin-top: 2em; margin-bottom: 4em;">
</footer>
</div>

	<!--<script>Bache.cargarImagenes('<?php echo $this->config->base_url();?>',<?php echo json_encode($imagenes);?>);</script>-->

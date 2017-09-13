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
			</ol>
			<div id="carousel" class="carousel-inner">
				<div class="item active">
					<img src="<?php echo $this->config->base_url(); ?>_/img/img404.jpg" width="325px" alt="">
				</div>
			</div>
		</div>
	</div>
	<!-- end imagenesCarrucel -->
	<div class="jumbotron personalizacionJumbotron">
        <h1><i class="fa cf-bache"></i> #Falla<?php echo $id; ?></h1>
	</div>
	<ul class="nav nav-tabs tabInfo" role="tablist">
		<li class="active"><a href="#especificaciones" role="tab" data-toggle="tab">Especificación Básica</a></li>
		<li><a href="#social" role="tab" data-toggle="tab">Comunidad Social</a></li>
	</ul>
	<!-- end tab list -->
	<div class="tab-content	">
	  <div class="tab-pane active" id="especificaciones">
	  	<div id="canvasMapa" class="contenedorMapa"></div>
	  	<div class="especificacionesBache">
			<h1>Especificación de Falla</h1>
		  	<?php
				$this->load->view('especificacionesFallas.php');
			?>
		</div>
	  </div>
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
	  <!-- end tab-pane social -->
	</div>
	<!-- end tab-content -->
</div>

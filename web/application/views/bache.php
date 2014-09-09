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
      	  
        <h1>#Bache<?php echo $id; ?></h1>

	</div>
	
	<ul class="nav nav-tabs tabInfo" role="tablist">
	  <li class="active"><a href="#especificaciones" role="tab" data-toggle="tab">Especificación Basica</a></li>
	  <li><a href="#social" role="tab" data-toggle="tab">Comunidad Social</a></li>
	</ul>



	<div class="tab-content	">
	  <div class="tab-pane active" id="especificaciones">
	  	
	  <div id="canvasMapa" class="contenedorMapa"></div>
		<div class="especificacionesBache">
			<h1>Especificación del Bache</h1>
			<table class="table table-hover">
				<tr>
					<td> Tamaño </td>
					<td> 2.5 metros </td>
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
					<td> Tipo Rotura </td>
					<td> Falta de Mantenimiento </td>
				</tr>
				<tr>
					<td> Estado </td>
					<td> Reparando </td>
				</tr>
				<tr>
					<td> Fecha Ultimo Estado </td>
					<td> 10/05/2003</td>
				</tr>
			</table>

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
			  		<button id="botonEnviarComentario" type="button" class="btn btn-primary botonComentario"> <i class="fa fa-weixin"></i> Comentar</button>
		          	<button id="botonTwitter" type="button" class="btn btn-primary botonComentario"> <i class="fa fa-twitter"></i> Twittear</button>
		      </div>
	          <form id="formularioComentario" class="formularioComentario">
		          <input name="usuario" type="User" class="form-control inputUsuario" placeholder="Usuario">
		          <input name="email" type="Email" class="form-control inputEmail" placeholder="Email">
		          <textarea name="mensaje" placeholder="Comentario" maxlength="100" class="form-control areaComentario"></textarea>
	          </form>
	      	</div>	  		

	  </div>
	</div>

</div>

<div class="oculto">
	<label id="idBache"><?php echo $id; ?></label>
	<label id="longBache"><?php echo $longitud; ?></label>
	<label id="latBache"><?php echo $latitud; ?></label>
	<label id="imagenesBache"><?php echo $imagenes; ?></label>
	<label id="baseUrl"><?php echo $this->config->base_url();?></label>
	<script>Bache.cargarImagenes('<?php echo $this->config->base_url();?>',<?php echo json_encode($imagenes);?>);</script>
	
</div>

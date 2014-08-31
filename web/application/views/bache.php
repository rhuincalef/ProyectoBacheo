
<script>
	// alert(<?php echo $latitud.$longitud; ?>);
</script>

<div class="contenido">

	<div class="imagenesCarrucel">
			 <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			 
			  <ol class="carousel-indicators">
			    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
			  </ol>

			 
			  <div class="carousel-inner">
			    <div class="item active">
			      <img src="<?php echo $this->config->base_url(); ?>_/img/bache1.jpg" width="325px" alt="">
			 
			    </div>
			    <div class="item">
			      <img src="<?php echo $this->config->base_url(); ?>_/img/bache2.jpg" width="325px"  alt="">
			    </div>
			    
			  </div>

        </div>
	</div>

	<div class="jumbotron personalizacionJumbotron">
      	  
        <h1>#Bache <?php echo $id; ?></h1>

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
			<div class="areaParaComentar">
	          <form id="formularioComentario" class="formularioComentario">
		          <input name="usuario" type="text" class="form-control inputUsuario" placeholder="Usuario">
		          <button id="botonEnviarComentario" type="button" class="btn btn-primary botonComentario"> Enviar Comentario!</button>
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
</div>

<?php var_dump($imagenes);?>
<!-- </div> -->
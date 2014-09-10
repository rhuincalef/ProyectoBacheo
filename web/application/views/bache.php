
<div class="oculto">
	<label id="idBache"><?php echo $id; ?></label>
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
      	  
        <h1>#Bache<?php echo $id; ?></h1>

	</div>
	
	<ul class="nav nav-tabs tabInfo" role="tablist">
	  <li class="active"><a href="#especificaciones" role="tab" data-toggle="tab">Especificación Basica</a></li>
	  <?php 
            if ($logueado) {
             echo '<li><a href="#estado" role="tab" data-toggle="tab">Estado del Bache</a></li>';
        }?>
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
					<td id="campoEstadoBache"></td>
				</tr>
				<tr>
					<td> Fecha Ultimo Estado </td>
					<td id="campoFechaEstado"></td>
				</tr>
			</table>

		</div>
	  </div>
	  <?php 
          if ($logueado) {
            echo '<div class="tab-pane" id="estado"> <div class="contenedorControles">';
            echo '<h1 id="nombreEstado" >Estado del Bache:  </h1> </div>';
            echo '<div class="contenedorControles">';
            echo '<div id="contenedorControladorEstado" class="contenedorPropiedades"></div></div>';
            echo '<div id="contenedorFormulario" class="oculto"> <form role="form" method="post" action="'.$this->config->base_url().'index.php/inicio/cambiarEstadoBache">   <div id="formularioEspecificacionesTecnicas" class="form-group"> </div>   <button id="registrarEstadoBache"> Confirmar</button></form> </div></div>';
           // echo '<script type="text/javascript">estadoBache(this.estado,this.tiposEstado);</script>'; 
      
            //var_dump($tiposEstado);
        }?>

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
		          <input id="nombreObservador" type="User" class="form-control inputUsuario" placeholder="Usuario">
		          <input id="emailObservador" type="Email" class="form-control inputEmail" placeholder="Email">
		          <textarea id="comentarioObservador" placeholder="Comentario" maxlength="100" class="form-control areaComentario"></textarea>
		          <button id="enviarObservacion" type="button" class="btn btn-primary botonComentario"> <i class="fa fa-weixin"></i>Enviar Comentario</button>
	          </form>
	      	</div>	  		

	  </div>
	</div>

</div>

	<script>Bache.cargarImagenes('<?php echo $this->config->base_url();?>',<?php echo json_encode($imagenes);?>);</script>

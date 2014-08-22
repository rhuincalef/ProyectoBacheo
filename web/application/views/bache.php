<script>
	// alert(<?php echo $latitud.$longitud; ?>);
</script>

<div class="contenido">

	<div class="imagenesCarrucel">
			 <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
			  </ol>

			  <!-- Wrapper for slides -->
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
      	  
        <h1>#Bache<?php echo $id; ?></h1>

	</div>

	<!-- Menu de Pestañas -->
	<ul class="nav nav-tabs tabInfo" role="tablist">
	  <li class="active"><a href="#especificaciones" role="tab" data-toggle="tab">Especificación Basica</a></li>
	  <li><a href="#social" role="tab" data-toggle="tab">Comunidad Social</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
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
					<td> Media </td>
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
	  <div class="tab-pane" id="social"></div>
	</div>
	<!--  -->

</div>


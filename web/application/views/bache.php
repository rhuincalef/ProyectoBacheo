<script>
	alert(<?php echo $latitud.$longitud; ?>);
</script>
<div class="contenedorJumbotron">
	<div class="jumbotron personalizacionJumbotron">
      	  
        <h1>#Bache<?php echo $id; ?></h1>

	</div>

</div>
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
			<td> Calle </td>
			<td><?php echo $calle; ?></td>
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

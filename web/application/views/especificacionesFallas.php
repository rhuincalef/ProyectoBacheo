<table class="table table-hover">
	<tr>
		<td> Tipo de falla </td>
		<td> <?php echo $titulo;?> </td>
	</tr>
	<tr>
		<td> Criticidad </td>
		<td> <?php 
		switch ($criticidad) {
		case 'Bajo':
			echo '<i class="fa cf-peligro color-crit-bajo font-size-crit"></i> '.$criticidad;
			break;
		case 'Medio':
			echo '<i class="fa cf-peligro color-crit-medio font-size-crit"></i> '.$criticidad;
			break;
		case 'Alto':
			echo '<i class="fa cf-peligro color-crit-alto font-size-crit"></i> '.$criticidad;
			break;
		default:
			echo $criticidad;
			break;
		}
		?> </td>
	</tr>
	<tr>
		<td> Dirección </td>
		<td><?php echo $calle;?><?php if ($alturaCalle > 0) echo "-".$alturaCalle;?></td>
	</tr>
	<tr>
		<td> Estado </td>
		<td id="campoEstadoBache"> <?php $estadoActual = json_decode($estado);
		echo $estadoActual->tipoEstado->nombre;
		?> </td>
	</tr>
	<tr>
		<td> Fecha último estado </td>
		<td id="campoFechaEstado"><i class="fa fa-calendar"></i> <?php setlocale(LC_TIME, 'es_AR.UTF-8');
		$estadoActual = json_decode($estado);
		echo strftime("%A, %d de %B de %Y", strtotime($estadoActual->fecha));?> </td>
		<td></td>
	</tr>
	<?php
	$estadoActual = json_decode($estado);
	if ($estadoActual->tipoEstado->nombre == 'Reparado') {
		echo "<tr>";
		echo '<td> Fecha de reparación </td><td> <i class="fa fa-calendar"></i> ';
		setlocale(LC_TIME, 'es_AR.UTF-8');
		$CI = &get_instance();
		echo strftime("%A, %d de %B de %Y", strtotime($estadoActual->fechaFinReparacionReal));
		echo "</td></tr>";
		echo "<tr>";
		echo '<td> Monto </td><td>';
		echo $montoReal;
		echo "</td></tr>";
	}
	if ($estadoActual->tipoEstado->nombre == 'Reparando') {
		echo "<tr>";
		echo '<td> Fecha de reparación estimada </td><td> <i class="fa fa-calendar"></i> ';
		setlocale(LC_TIME, 'es_AR.UTF-8');
		$CI = &get_instance();
		echo strftime("%A, %d de %B de %Y", strtotime($estadoActual->fechaFinReparacionEstimada));
		echo "</td></tr>";
	}
	/* 
	*/
	?>
</table>
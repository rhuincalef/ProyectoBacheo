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
			echo '<i class="fa cf-peligro color-crit-medio font-size-crit"></i> '.$criticidad;
		case 'Medio':
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
		<td></td>
	</tr>
</table>
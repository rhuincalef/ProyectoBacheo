<html>
<head>FORMULARIO DE PRUEBA PARA LA CARGA DE LOS BACHES</head>
<body>
	<br><b>Ingrese los datos del bache que desea cargar</b>
	<br><br>
	<form id="cargarBache"  action="../inicio/altaBache" method="POST">
			<label for="latitud" >Latitud</label>		
			<input type="text" id="latitud" name="latitud"  autofocus requeried><br>
			<label for="longitud">Longitud</label>		
			<input type="text" id="longitud" name="longitud"><br>
			<label for="criticidad" >Criticidad</label>		
			<input type="text" id="criticidad" name="criticidad"><br>
			<label for="descripcion" >Descripcion</label>		
			<input type="text" id="descripcion" name="descripcion"><br>
			<label for="calle">Calle</label>		
			<input type="text" id="calle" name="calle"><br>
			<label for="alturaCalle">Altura de la calle</label>		
			<input type="text" id="alturaCalle" name="alturaCalle"><br>
			<input type="submit" value="Enviar bache"><br>
	</form> 
<body>
</html>
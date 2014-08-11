<html>

	
	<head>
		<!-- Se importa el script de iamgenes de pablo -->
		<!-- <script type="text/javascript" src="../../_/js/libs/dropZone/dropzone.js"></script> -->
		<title>FORMULARIO DE PRUEBA PARA ASOCIAR OBSERVACIONES A UN BACHE</title>
	</head>
<body>
	<br><b>Ingrese el ID de bache y la observación que se asociará al bache</b>
	<br><br>
	 <form id="asociarObs"  action="../inicio/asociarObservacion" method="POST" > 
			<label for="idBache" >Identificador del bache(idBache):</label>		
			<input type="text" id="idBache" name="idBache"  ><br>
			<label for="nombreObservador" >Nombre del observador:</label>		
			<input type="text" id="nombreObservador" name="nombreObservador"><br>
			<label for="emailObservador">Email:</label>		
			<input type="text" id="emailObservador" name="emailObservador"><br>
			<input  id="modaInfoBacheAceptar" type="submit" value="Asociar observación"><br>
	</form> 
<body>
</html>
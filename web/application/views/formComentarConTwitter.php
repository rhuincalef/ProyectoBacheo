<html>

	
	<head>
		<!-- Se importa el script de iamgenes de pablo -->
		<!-- <script type="text/javascript" src="../../_/js/libs/dropZone/dropzone.js"></script> -->
		<title>FORMULARIO DE PRUEBA PARA ASOCIAR OBSERVACIONES A UN BACHE</title>
	</head>
<body>

	<br><b>Ingrese el ID de bache y el nuevo estado que asociara</b>
	<div id="datosUsr">
		<!-- Acá se cargarán los datos del usuario.-->
	</div>
	<br><br>
	<form id="comentarTwitter" method="POST" action="../inicio/comentarConTwitter" > 
			<label for="idBache" >Identificador del bache(idBache):</label>		
			<input type="text" id="idBache" name="idBache"  ><br>
			<label for="comentario">Comentario acerca del bache</label>		
			<input type="text" id="comentario" name="comentario"  ><br>
			<input  id="comentarTw" type="submit" value="Comentar Tw"><br>
	</form> 
<body>
</html>
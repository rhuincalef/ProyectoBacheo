<html>

	
	<head>
		<!-- Se importa el script de iamgenes de pablo -->
		<!-- <script type="text/javascript" src="../../_/js/libs/dropZone/dropzone.js"></script> -->
		<title>FORMULARIO DE PRUEBA PARA ASOCIAR OBSERVACIONES A UN BACHE</title>
	</head>
<body>
	<br><b>Ingrese el ID de bache y el nuevo estado que asociara</b>
	<br><br>
	 <form id="asociarObs" method="POST" action="../inicio/modificarEstado"  > 
			<label for="idBache" >Identificador del bache(idBache):</label>		
			<input type="text" id="idBache" name="idBache"  ><br>
			<label for="estadoBache">Estado del bache</label>		
			<select name="estadoBache" id="estadoBache"> 
			  <option value="informado">informado</option>
			  <option value="confirmado">confirmado</option>
			  <option value="reparando">reparando</option>
			  <option value="reparado">reparado</option>
			</select><br>
			<input  id="modEstadoBache" type="submit" value="Modificar estado"><br>
	</form> 
<body>
</html>
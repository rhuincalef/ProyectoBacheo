<html>

	
	<head>
		<!-- Se importa el script de iamgenes de pablo -->
		<!-- <script type="text/javascript" src="../../_/js/libs/dropZone/dropzone.js"></script> -->
		<title>FORMULARIO DE PRUEBA PARA LA CARGA DE LOS BACHES</title>
	</head>
<body>
	<br><b>Ingrese los datos del bache que desea cargar</b>
	<br><br>
	
	<?php echo validation_errors(); ?>
	<form id="cargarBache"  action="../inicio/altaBache" method="POST"  enctype="multipart/form-data"> 
			<label for="titulo" >Titulo del bache</label><br>		
			<?php echo form_error('titulo'); ?>		
			<input type="text" id="titulo" name="titulo"  ><br>

			<label for="latitud" >Latitud</label><br>		
			<?php echo form_error('latitud'); ?>		
			<input type="text" id="latitud" name="latitud"><br>

			<label for="longitud">Longitud</label><br>		
			<?php echo form_error('longitud'); ?>		
			<input type="text" id="longitud" name="longitud"><br>
		

			<label for="criticidad">Criticidad</label><br>		
			<?php echo form_error('criticidad'); ?>		
			<select id="criticidad" name="criticidad" >
                <option value="baja">Pequeño</option>
                <option value="media">Mediano</option>
                <option value="alta">Grande</option>
            </select><br><br>

			<label for="descripcion" >Descripcion</label><br>
			<?php echo form_error('descripcion'); ?>		
			<input type="text" id="descripcion" name="descripcion"><br>

			<label for="calle">Calle</label><br>		
			<?php echo form_error('calle'); ?>		
			<input type="text" id="calle" name="calle"><br>

			<label for="altura">Altura de la calle</label><br>
			<?php echo form_error('altura'); ?>		
			<input type="text" id="altura" name="altura"><br><br>

			<!-- Campo para la subida de las imagenes.-->
          	<input type="file" name="file" id="file"  size="20" /><br><br>
          	<!-- Boton de envio del formulario -->
			<input  id="modaInfoBacheAceptar" type="submit" value="Enviar bache1"><br>

	</form> 

<body>
</html>
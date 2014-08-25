<html>
	<head>
		<!-- Se importa el script de iamgenes de pablo -->
		<!--<script type="text/javascript" src="../../_/js/libs/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../../_/js/libs/dropZone/dropzone.js"></script>
		<link href="../../_/css/dropZone/dropzone.css" type="text/css" rel="stylesheet" /> -->
		<!-- Se configura el formulario para que se dé de alta-->
		 <!-- <script type="text/javascript">
		 // $(document).ready(function(){
		 //    Dropzone.options.myAwesomeDropzone = { // The camelized version of the ID of the form element
		 //        // The configuration we've talked about above
		 //        autoProcessQueue: false,
		 //        uploadMultiple: true,
		 //        parallelUploads: 5,
		 //        maxFiles: 5,
		 //        acceptedFiles: "image/*",
		 //        dictDefaultMessage: "Arrastrar las imagenes aqui o click para agregarlas",
		 //        // The setting up of the dropzone
		 //        // init: function() {
		 //        //   var myDropzone = this;
		 //        //  // Here's the change from enyo's tutorial...
		 //        //     // $("#submit-all").click(function (e) {
		 //        //     //     e.preventDefault();
		 //        //     //     e.stopPropagation();
		 //        //     //     myDropzone.processQueue();
		 //        //     //     }
		 //        //     // );

		 //        // }
		 //        init: function() {
		 //          this.on("addedfile", function(file) {
		 //            // Create the remove button
		 //            var removeButton = Dropzone.createElement("<button>Remove file</button>");
		 //            // Capture the Dropzone instance as closure.
		 //            var _this = this;
		 //            // Listen to the click event
		 //            removeButton.addEventListener("click", function(e) {
		 //              // Make sure the button click doesn't submit the form:
		 //              e.preventDefault();
		 //              e.stopPropagation();
		 //              // Remove the file preview.
		 //              _this.removeFile(file);
		 //              // If you want to the delete the file on the server as well,
		 //              // you can do the AJAX request here.
		 //            });
		 //            // Add the button to the file preview element.
		 //            file.previewElement.appendChild(removeButton);
		 //          });
		 //        }
		 //      };

		 // });

			//OTRO CODIGO.
			// $(function(){
			// 	// Se crea programaticamente el formulario de carga de archivos.
			// 	var myDropzone = new Dropzone("#formImagenes", { url: "/subirImagen"});
			// 	$("#modaInfoBacheAceptar").on("click",function(){
			// 		console.log("Se pulso ");
			// 		// ../inicio/altaBache
			// 		$.post( "../inicio/AltaBache", function(data) {
			// 			var json=JSON.parse(data);	
			// 			console.log("El json retornado es:"+json);
			// 			//Se llama a la carga de los baches programaticamente.
			// 			Dropzone.options.myAwesomeDropzone = {
			// 			  paramName: "file", // El nombre del archivo que será enviado al servidor.
			// 			  maxFilesize: 4, // MB
			// 			  autoProcessQueue: false,  //Se deshabilita el procesamiento de la cola de archivos.
			// 			};
			// 		}).fail(function(){
			// 			alert("Error al dar de alta el bache en la BD! ");
			// 		});		
			// 	});
			// });
		</script> -->
		<title>FORMULARIO DE PRUEBA PARA LA CARGA DE LOS BACHES</title>
	</head>
<body>
	<br><b>Ingrese los datos del bache que desea cargar</b>
	<br><br>
	
	<?php echo validation_errors(); ?>
	<form id="cargarBache"  action="../inicio/AltaBache" method="POST"  enctype="multipart/form-data"> 
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


			<!-- Script de prueba de Dropzone-->
			<!--TODO Pasar el argumentmo con inicio/subirImagen/<ID_BACHE>-->
			<!-- <form id="my-awesome-dropzone" action="/upload" class="dropzone cargarImagenes">  
              <div class="dropzone-previews"></div>
              <div class="fallback">
              <input name="file" type="file" multiple />
              </div>
          	</form> -->


			<!-- <form  class="dropzone" action="../inicio/subirImagen/62" id="my-awesome-dropzone">
					<div class="dropzone-previews"></div>
					<div class="fallback"> 
						<input name="file" type="file" multiple />
					</div>
			</form> -->

			<!-- Campo para la subida de las imagenes.-->
          	<!-- <input type="file" name="file" id="file"  size="20" /><br><br> -->
          	<!-- Boton de envio del formulario -->
			<input  id="modaInfoBacheAceptar" type="submit" value="Enviar bache1"><br>

	</form> 

<body>
</html>
<div class="tab-pane" id="visor">
	<!-- Header-->
  	<h2>Captura del bache</h2>
	<div class="row" style="text-align:center;">
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<hr>
		</div>
	</div>

	<!-- Contenedor para el thumnail -->
	<div id = "containerThumbnail" class="row"></div>

	<!-- Contenido con los comandos del visor de capturas -->
	
	<div id="ayudaVisor" class="panel panel-primary containerAyuda" >
		<div class="panel-heading">Comandos del visor de fallas <button id="botonCerrar" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
		<div class="panel-body">
    		<p class="parrafoPanel" > <strong>c : </strong> Cambiar entre distintos colores del panel</p>
    		<p class="parrafoPanel"> <strong> + : </strong> Aumentar el tamanio de los puntos de la captura </p>
    		<p class="parrafoPanel"> <strong> - : </strong> Disminuir el tamanio de los puntos de la captura </p>
    		<p class="parrafoPanel"> <strong> Manter presionado Click : </strong> Desplazar la camara desde donde se percibe la captura </p>
  		</div>
	</div>
	
	
<!-- Fin del div de tabbed panel -->
</div> 

<!-- Se carga la coleccion de thumnails por falla -->
<?php
	echo "<script type='text/javascript'>";

	//imgCarga,imgError,imgFondo
	echo "window.nameSpaceThumbnail.inicializarImgs('". base_url(URL_IMG_THUMBNAIL_CARGA) ."','". base_url(URL_IMG_THUMBNAIL_ERROR) ."','". base_url(URL_IMG_THUMBNAIL_FONDO) ."','".EXTENSION_CAPTURA ."'); ";

	echo "window.nameSpaceThumbnail.solicitarCapturas(".$id.",'".base_url()."');";

	echo "</script>";
?>
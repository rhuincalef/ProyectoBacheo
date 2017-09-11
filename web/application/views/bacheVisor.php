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
	
<!-- Fin del div de tabbed panel -->
</div> 

<!-- Se carga la coleccion de thumnails por falla -->
<?php
	echo "<script type='text/javascript'>";

	//imgCarga,imgError,imgFondo
	echo "window.nameSpaceThumbnail.inicializarImgs('". base_url(URL_IMG_THUMBNAIL_CARGA) ."','". base_url(URL_IMG_THUMBNAIL_ERROR) ."','". base_url(URL_IMG_THUMBNAIL_FONDO) ."'); ";
	echo "window.nameSpaceThumbnail.solicitarCapturas(".$id.",'".base_url()."');";

	echo "</script>";
?>
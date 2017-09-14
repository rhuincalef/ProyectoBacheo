<head>
	<meta charset="utf-8">
	<title>  Bacheo Trelew - <?php echo $page_title; ?></title>
	<meta name="description" content="<?php echo $meta_description; ?>" />
	<meta name="keywords" content="<?php echo $meta_keywords; ?>" />

	<?php /* Mobile viewport optimized: j.mp/bplateviewport */ ?>
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<?php /* CSS: implied media="all" */ ?>
	<link href="<?php echo $this->config->base_url(); ?>_/css/fontAwesome/font-awesome.css" rel="stylesheet">
		<link href="<?php echo $this->config->base_url(); ?>_/css/bootstrap/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $this->config->base_url(); ?>_/css/header.css" rel="stylesheet">
		<link href="<?php echo $this->config->base_url(); ?>_/css/PNotify/pnotify.custom.min.css" rel="stylesheet" type="text/css" />
	  	<!--<script src="<?php echo $this->config->base_url(); ?>_/js/libs/jquery-3.2.1.min.js"></script>-->
	  	<script src="<?php echo $this->config->base_url(); ?>_/js/libs/jquery-2.1.1.min.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>_/js/libs/bootstrap/bootstrap.min.js"></script>

	    <script src="<?php echo $this->config->base_url(); ?>_/js/plugins.js"></script>
	    
	    <!-- IMPORT API DE GOOGLE OBLIGATORIO-->
	    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrSwzqn60EgqwOk7a9U68PlLHqT8LtsBI&libraries=places"></script>

	    <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>_/js/libs/PNotify/pnotify.custom.min.js"></script>
	    <script src="<?php echo $this->config->base_url(); ?>_/js/header.js"></script>
		

		
	    <!-- Carga de las librerias para webGL -->
	    <!--
	    <script src="<?php echo $this->config->base_url(); ?>_/js/webgl-detector.js"></script>-->

		<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>_/css/estiloPanelAyudaVisor.css">


	    <!--three.modules.js-->

	    <!-- <script src="<?php echo $this->config->base_url(); ?>_/js/three.min.js "></script>-->
	    <script src="<?php echo $this->config->base_url(); ?>_/js/three.js "></script>


	    <script src="<?php echo $this->config->base_url(); ?>_/js/papaparse.min.js"></script>
	    <script src="<?php echo $this->config->base_url(); ?>_/js/notify/bootstrap-notify.js"></script>
	   
	    <script type="text/javascript" src ="<?php echo $this->config->base_url(); ?>_/js/inicializador_webGLPCD.js"></script>
	  
		<script type="text/javascript" src ="<?php echo $this->config->base_url(); ?>_/js/PCDLoader.js"></script>
		<script type="text/javascript" src ="<?php echo $this->config->base_url(); ?>_/js/TrackballControls.js"></script>

		<script type="text/javascript" src ="<?php echo $this->config->base_url(); ?>_/js/Detector.js"></script>
		<script type="text/javascript" src ="<?php echo $this->config->base_url(); ?>_/js/stats.min.js"></script>
	    




	    <!-- Se cargan las librerias para la generacion de la imagen y 
	    la descripcion del thumbnail. -->

	    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>_/css/estilosThumbnailVisores.css">

	    <script type='text/javascript' src="<?php echo $this->config->base_url(); ?>_/js/conversorJs.js" ></script>
	    <script type="text/javascript" src ="<?php echo $this->config->base_url(); ?>_/js/thumnailFalla.js" ></script>


		<link rel="stylesheet" type="text/css" href="<?php echo $this->config->base_url(); ?>_/css/noscroll.css">

	    <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>_/js/libs/PNotify/pnotify.custom.min.js"></script>
	    <!-- Se carga lib de image-scale -->
	    <script src="<?php echo $this->config->base_url(); ?>_/js/image-scale/image-scale.js"></script>	    
	    
	    <script src="<?php echo $this->config->base_url(); ?>_/js/header.js"></script>	    
		<script>
			CODIGO_EXITO = 200;
			CODIGO_ERROR = 400;
		</script>
	
	<?php /* More ideas for your <head> here: h5bp.com/d/head-Tips */
	if (is_array($path)){
		foreach($path as $value){
			$this->load->view("{$header_directory}/".$value);
		}
	}else{$this->load->view("{$header_directory}/".$path);} 
	?>
	
</head>
<!DOCTYPE html>
<html>
	<head>
	  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Bacheo trelew</title>
	  	<link href="<?php echo $this->config->base_url(); ?>_/css/fontAwesome/font-awesome.css" rel="stylesheet">
		<link href="<?php echo $this->config->base_url(); ?>_/css/bootstrap/bootstrap.min.css" rel="stylesheet">
	  	<script src="<?php echo $this->config->base_url(); ?>_/js/libs/jquery-2.1.1.min.js"></script>
		<script src="<?php echo $this->config->base_url(); ?>_/js/libs/bootstrap/bootstrap.min.js"></script>
	    <script src="<?php echo $this->config->base_url(); ?>_/js/plugins.js"></script>

	</head>
	<body>	 
		<?php echo $this->load->view('header') ?>
		<?php echo $this->load->view($content)?>
		<?php echo $this->load->view('footer') ?>
		 
	</body>
</html>
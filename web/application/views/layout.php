<!DOCTYPE html>
<html>
	<head>
		<link href="/css/style.css" rel="stylesheet" type="text/css" />
		<title>Mi titulo</title>
	</head>
	 
	<body>
	 
		<?php echo $this->load->view('header') ?>
		<?php echo $this->load->view($content)?>
		<?php echo $this->load->view('footer') ?>
	 
	</body>
</html>
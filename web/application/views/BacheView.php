<?php 
/*	echo "<b>Vista renderizada hehe</b><br><br>";
	echo "<b>Lo que se retorno de la BD convertido a JSON fue:";
	echo $respuestaJSON."</b>";*/

	$rta = array('estado' => 1, 'id' =>$respuestaJSON);
	echo json_encode($rta);

/* End of file BacheView.php */
/* Location: ./application/views/BacheView.php */
?>
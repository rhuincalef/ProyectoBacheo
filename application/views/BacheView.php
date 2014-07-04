<?php 
	echo "<b>Vista renderizada hehe</b><br><br>";
	echo "<b>Lo que se retorno de la BD convertido a JSON fue:";
	echo $respuestaJSON;
	/*Instrucciones de Uso: 
		-->Alta de Bache: Para realizar la carga del bache llamar a http://localhost/code-igniter/index.php/inicio/altaBache,
		y el query string de un form con POST. El modelo de encargará de realizar las conversiones a JSON necesarias.
		(Hay un ejemplo de un form funcionando en CargaDeBacheView en la carpeta View ). 
		Al realizarse correctamente la inserción se retornará un JSON (correspondiente al bache recien agregado),que tiene
		un codigo de estado (201=OK), una descripcion y los datos del bache agregado.
		A continuación se muestra un JSON de ejemplo al agregar el bache en la BD:
		{"codigo":201,"descripcion":"Se inserto correctamente el bache","datos":{"id":"31","latitud":"232131","longitud":"2111111","idCriticidad":"1","idCalle":"20"}}
		
		--> ObtenerCriticidad: Para obtener los niveles de criticidad para el form de alta, se debe llamar a la URL:
		http://localhost/code-igniter/index.php/inicio/obtenerTiposCriticidad, sin ningun argumento. Esto retornara un
		JSON como el siguiente:
		{"codigo":500,"descripcion":"Datos obtenidos correctamente","datos":[{"nombre":"alta"},{"nombre":"media"},{"nombre":"baja"}
	*/
/* End of file BacheView.php */
/* Location: ./application/views/BacheView.php */
?>
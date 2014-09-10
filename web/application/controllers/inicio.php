<?php

//TODO Comentar! Clase de firephp utilizada para la depuración.
require_once('FirePHP.class.php');

class Inicio extends CI_Controller {

	/*URL de prueba: http://localhost/gitBaches/ProyectoBacheo/index.php/incio/AltaBache 
					 http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/formBache
	*/

	public $configAltaBache=array(
                                    array(
                                            'field' => 'titulo',
                                            'label' => 'Titulo',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'latitud',
                                            'label' => 'Latitud',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'longitud',
                                            'label' => 'Longitud',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'descripcion',
                                            'label' => 'Descripcion',
                                            'rules' => 'required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'calle',
                                            'label' => 'Calle',
                                            'rules' => 'required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'alturaCalle',
                                            'label' => 'Altura',
                                            'rules' => 'required|integer|max_length[4]'
                                         )
	);


	public function index()
	{
		echo "LLame al controlador de baches";
	}

	//Formulario de alta de baches.
	public function formBache(){
		$this->load->view('CargaDeBacheView');	
	}


	//Metodo del controlador que ataja la subida de imagenes
	//al servidor.	
	// http://localhost/gitBaches/ProyectoBacheo/web/
	public function subirImagen($idBache){
		$this->load->model("Multimedia");
		$this->Multimedia->subirImagen($idBache);
	}

	public function AltaBache(){
		$firephp = FirePHP::getInstance(True);
		
		//Se cargan las reglas los modulos para la validacion de los formularios.
		$this->load->database();
		$this->load->model('Bache');		
		
		$firephp->log("Inicio de altaBache()");
		$firephp->log("Resultado de la validacion: ".$this->sonDatosValidos('altaBache'));

		$firephp->log("Cargando las reglas...");		

		$firephp->log("--------------------------------------------------------------------------------");
		$firephp->log("--------------------------------------------------------------------------------");
		$datosBache=array( "titulo"=>$_POST["titulo"] ,"latitud"=>$_POST["latitud"],"longitud"=>$_POST["longitud"],"criticidad"=>$_POST["criticidad"],
			"calle"=>$_POST["calle"],"descripcion"=>$_POST["descripcion"],"altura"=>$_POST["alturaCalle"]);
			
		$firephp->log("El array de datos es...");
		$firephp->log($datosBache);
		$firephp->log("--------------------------------------------------------------------------------");
		$firephp->log("Arreglo...");
		$firephp->log("..........");
		$firephp->log("--------------------------------------------------------------------------------");


		if ($this->sonDatosValidos()==TRUE) {
			//Descomentar estas lineas para la entrega
			$datosBache=array( "titulo"=>$_POST["titulo"] ,"latitud"=>$_POST["latitud"],"longitud"=>$_POST["longitud"],"criticidad"=>$_POST["criticidad"],
			"calle"=>$_POST["calle"],"descripcion"=>$_POST["descripcion"],"altura"=>$_POST["alturaCalle"]);
			
			$firephp->log("El array de datos es...");
			$firephp->log($datosBache);

			//Nombre de la copia local del archivo que mantiene el servidor --> "file"=>$_FILES["file"]["tmp_name"]
			$idBache['respuestaJSON']=$this->Bache->darAltaBache($datosBache);

			$firephp->log("Despues de dar de alta el bache!");
			$this->load->view('BacheView',$idBache);	
		}else{
			$firephp->log("El valor de sonCamposValidos no es valido! y es:FALSE");
			//Se carga nuevamente el formulario
			// $this->load->view('CargaDeBacheView');
		}
		$firephp->log("Fin de altaBache()");

	}


	
	/*Esta funcion valida si los datos de los campos del formulario  cumplen con las reglas para 
	las validaciones. SI las cumple retorna True, si no cunmple con alguna retorna FALSE.
	Este metodo acepta como argumento el conjunto de reglas que serán ejecutadas para cada 
	formulario.
	*/
	// NOTA: Las reglas de validacion que acepta sonDatosValidos() estan definidas en el archivo
	// application/config/form_validation.php.
	private function sonDatosValidos(){
		$firephp = FirePHP::getInstance(True);
		$firephp->log("Dentro de sonDatosValidos()...");
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		//BACKUP! version funcionando
		// $this->form_validation->set_rules('titulo','Titulo','required');

		$firephp->log("El arreglo que se cargará es el siguiente:");
		$firephp->log($this->configAltaBache);
		$firephp->log("********************************************");
		$this->form_validation->set_rules($this->configAltaBache);
		$firephp->log("Se cargaron todas las reglas para el altaBache.");

		$sonCamposValidos=TRUE;
		if($this->form_validation->run()==FALSE){
			$firephp->log("Dio FALSE!!!");
			$sonCamposValidos=FALSE;			
		}else{
			$firephp->log("Dio TRUE!!!");
		}
		return $sonCamposValidos;
	}//Fin validarDatos().


	//Dado un idBache se obtiene toda la información del bache, junto con la URL
	// de las imagenes.
	//Para fines de prueba la URL es: http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/obtenerInfo/2.
	//para id=2.
	 public function obtenerInfo($idBache){
	 	$firephp = FirePHP::getInstance(true);
	 	$firephp->log("El idBache pasado por parámetro es:".$idBache);
	 	$this->load->model('Bache');
	 	return $this->Bache->obtenerInfo($idBache);
	 }


	// http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/BajaBache/
	public function BajaBache($idBache){
		$this->load->database();
		$this->load->model('Bache');		
		$this->Bache->darDeBajaBache($idBache);
	}


	public function asociarObservacion(){
		$firephp = FirePHP::getInstance(true);
		$this->load->database();
		$this->load->model('Bache');
		//$firephp->log($this->input->post("idBache"));
		//$firephp->log("----------------------------");			
		$datosBache=array( "idBache"=>$_POST["idBache"] ,"nombreObservador"=>$_POST["nombreObservador"],"emailObservador"=>$_POST["emailObservador"],"comentario"=>$_POST["comentario"]);
		$this->Bache->asociarObservacion($datosBache);
		//$this->Bache->asociarObservacion($_POST);
	}

	public function formAsociarObservaciones(){
		$this->load->view('formAsociarObservacionesView');	
	}


	//Formulario de prueba para la modificacion de estado.
	//http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/formCambiarEstado
	public function formCambiarEstado(){
		$this->load->view("formCambiarEstado");
	}
	//Metodo para modificar el estado de un bache, pasando como argumento el id del bache
	//URL de prueba --> http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/formCambiarEstado

	public function modificarEstado(){
		$firephp = FirePHP::getInstance(True);
		$this->load->database();
		$this->load->model('Estado');
		//TODO Deshardcodear el idUsuario cuando se da cambia el estado (cuando este listo el manejo de sesions de usuarios).
		$idUsuario=1;
		$idBache=$_POST["idBache"];
		$estado=$_POST["estadoBache"];
		$firephp->log("idBache=".$idBache.";idUsuario=".$idUsuario.";estado=".$estado);
		$this->Estado->cambiarEstado($idBache,$idUsuario,$estado);
		$firephp->log("Se cambio el estado del bache!");
	}





	//Metodo de prueba para las criticidades
	public function getNiveles(){
		//Se debe realizar conexion en BD. Ver propiedad de config/Autoload.php para eliminar
		//esta instruccion de carga de los controladores y modelos.
		$this->load->database();
		$this->load->model("Criticidad");
		$listaNiveles = $this->Criticidad->obtenerNivelesDeCriticidad();
		foreach ($listaNiveles as $row){
			$nivel = array('id'=>$row["id"],'nombre' => $row["nombre"], 'descripcion'=>$row["descripcion"]);
			echo json_encode($nivel);
			echo "/";
		}
	}


	public function getBaches(){
		$baches = $this->db->get("Bache");
		foreach ($baches->result() as $row){
			echo json_encode($row);
			echo "/";
		}
	}
	// /index.php/inicio/getBache/id/3
	public function getBache(){
		$firephp = FirePHP::getInstance(True);
		$this->load->library('ion_auth');
		$get = $this->uri->uri_to_assoc();
		$id = $get['id'];
		$this->load->model("Bache");
		$bache= $this->Bache->getBache($id);

		$firephp->log("El bache obtenido es getBache()...");
		$firephp->log($bache);

		$this->output->enable_profiler(FALSE);
		$bache['logueado'] = $this->ion_auth->logged_in();
		if ($bache['logueado']) {
			$bache['usuario'] = $this->ion_auth->user()->row()->username;
		}
		$this->template->build_page("bache",$bache);
		
	}

	//Get bache con calle y criticidad.
	//  /web/index.php/inicio/getBacheConCalle/1 
	public function getBacheConCalle($idBache){
		$this->load->model("Bache");
		return $this->Bache->getBache($idBache);
	}



	// URL DE PRUEBA --->
	// http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/obtenerObservacionesTw/62
	public function obtenerObservacionesTw($idBache){
		$firephp = FirePHP::getInstance(True);
		$this->load->model("Bache");
		//BACKUP version vieja.
		// $linkVerBache="http://www.localhost.com/gitBaches/ProyectoBacheo/web/index.php/inicio/verBache/".$idBache;
		$hashtag="Bache".$idBache;
		$tweets=$this->Bache->obtenerObservacionesTw($hashtag);	
		$firephp->log("<p><b> Los tweets retornados fueron: </b></p><br>");
		$firephp->log($tweets);
		return $tweets;
	}


	//FORM Utilizado para comentar con la API de Twitter.
	public function loginConTwitter(){
		$this->load->view('loginConTwitter');	
	}

	//Metodo llamado por el formulario de twitter para comentar.
	public function formComentarConTwitter(){
		$this->load->view("formComentarConTwitter");
	}


	// Esta funcion sube el comentario a Twitter para un bache determinado.
	//Es llamado por meido del view "formaComentarConTwitter".
	public function comentarConTwitter(){
		$firephp = FirePHP::getInstance(True);
		$firephp->log("Dentro de comentarConTwitter()");
		$this->load->model("Observacion");
		$json=$this->Observacion->enviarComentarioTwitter();
		$firephp->log("<p>El json retornado es: ".$json."</p>");
		$firephp->log("Fin de comentarConTwitter!");
	}


		//BACKUP COMENTARCONTwitter!!
		// Include config file and twitter PHP Library by Abraham Williams (abraham@abrah.am)
		//Las librerias para usar include_once() estan en /opt/lamp/php
		// include_once("configOAuth.php");
		// include_once("twitteroauth.php");

		// $firephp = FirePHP::getInstance(True);
		// $firephp->log("Dentro de comentar con Twitter...");
		// // $datosBache=array( "idBache"=>$_POST["idBache"] ,"nombreObservador"=>$_POST["nombreObservador"],"emailObservador"=>$_POST["emailObservador"],"comentario"=>$_POST["comentario"]);

		// //Se obtienen de la session los datos del usuario (nombreUsuario,email y la fechaPublicacion)
		// $hashBache=" #proyectoBacheoTwBache".$_POST["idBache"];
		// //TODO Cambiar la URL de verBache.
		// $comentario=$hashBache." en "."http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/verBache/".$_POST["idBache"]." ".$_POST["comentario"];

		// $firephp->log("El hashtag del bache es: ".$hashBache);
		// $firephp->log("El comentario es: ".$comentario);

		// //Se obtienen los token de acceso desde la session en php, para
		// //crear la conexion y acceder a los metodos de la API. 
		// session_start(); 
		// $firephp->log($_SESSION['oauth_token']);
		// $firephp->log($_SESSION['oauth_token_secret']);

		// $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
  //       $content = $connection->post('statuses/update', array('status' => $comentario));

  //       $firephp->log("El contenido retornado fue:");
  //       $firephp->log($content);
  //      	//Se compara el contenido en JSON retonado por la petición a la API.
  //      	//TODO Preguntar: ¿Sirve el screen_name del usaurio como id unico en lugar del E-mail?

  //      	if($content && isset($content->user) ){
  //      		return json_encode(array("usuario"=>$_SESSION['name'],"email"=>$content->screen_name,"fecha"=>$content->created_at,"img_perfil"=>$content->profile_image_url_https));
  //       }




	//URL de Callback --> http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/usuarioValido 
	public function loginTwitter(){

		$firephp = FirePHP::getInstance(True);
		// Include config file and twitter PHP Library by Abraham Williams (abraham@abrah.am)
		//Las librerias para usar include_once() estan en /opt/lamp/php
		include_once("configOAuth.php");
		include_once("twitteroauth.php");

		//Se con el metodo TwitterOAuth() se crea un objeto que permite pedir las credenciales del cliente
		// con la clave del consumidor y la clave secreta del consumidor.
		$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);
		$firephp->log("'CONSUMER_KEY':$CONSUMER_KEY;'CONSUMER_SECRET':$CONSUMER_SECRET");
		$firephp->log("Se creo el objeto TwitterOAuth!");
		$firephp->log($connection);

		//Con getRequestToken() se piden las credenciales temporales utilizadas por el cliente y el servidor(antes de pedir el token de rta)
		$request_token = $connection->getRequestToken($OAUTH_CALLBACK); //get Request Token
		$firephp->log("'$request_token':");
		$firephp->log($request_token);
		if( $request_token)
		{
			$firephp->log("Session iniciada=");
			$firephp->log(session_start()); 
			//Si se obtiene un token temporal, se almacena en las variables de session
			$token = $request_token['oauth_token'];
			$_SESSION['request_token'] = $token ;
			$_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];
			switch ($connection->http_code){
				case 200:
					// Si la peticion del token temporal fue exitosa, 
					// con getAutorizeURL() se redirige hacia la pagina de login de Twitter,.
					$url = $connection->getAuthorizeURL($token);
					header('Location: '.$url);
					break;
				default:
					echo "Connection with Twitter FAILED!!";
					break;
			}
		}
		else //error receiving request token
		{
			echo "<b>Error Receiving Request Token</b>";
		}
	}

	// Este metodo es llamado luego de que el usuario es redirigido por loginTwitter()
	// se autentica  y da permisos a la aplicación para que acceda a los datos de su cuenta de Twitter.
	public function usuarioTWValido(){
		include_once("configOAuth.php");
		include_once("twitteroauth.php");
		
		$firephp = FirePHP::getInstance(True);
		$firephp->log("Session iniciada=");
		$res=(session_start())?'true':'false';
		$firephp->log($res); 

		$firephp->log("Session:"); 
		if(isset($_GET['oauth_token']))
		{
		//Una vez obtenida la autorización se crea otro objeto TwitterOAuth con las claves temporales
	    $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $_SESSION['request_token'], $_SESSION['request_token_secret']);
	    // Y se solicita el Token de acceso de larga duración que utilizará el cliente para acceder a los recursos del propietario.
	    $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		$firephp->log("access_token:");
		$firephp->log($access_token);
	    if($access_token)
	    {
	    	//Luego de tener el TokenAcceso, se crea otro objeto TwitterOAuth con los tokens temporales (el dl consumidor y el secreto ) y el token
	    	// de acceso. A partir de este punto se pueden hacer peticiones a twitter en representación del usuario, con GET, POST y DELETE. 
	    	$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	        $params =array();

	        //Una vez obtenido el token de acceso para el cliente, se utilizan los metodos conn->get/post() con la URL de la API
	        //y los parametros del metodo de la api en un array asociativo.
	        
	        // $params['include_entities']='true';
	        $params['include_entities']='false';
	        $content = $connection->get('account/verify_credentials',$params);
	        if($content && isset($content->screen_name) && isset($content->name))
	        {
	        	
	            $_SESSION['name']=$content->name;
	            $_SESSION['image']=$content->profile_image_url;
	            $_SESSION['twitter_id']=$content->screen_name;

	            //Se guardan los tokens de acceso, para crear el objeto de conexion de nuevo, en la $_SESSION[].
	            $_SESSION['oauth_token']=$access_token['oauth_token'];
	            $_SESSION['oauth_token_secret']=$access_token['oauth_token_secret'];
				

	            // A partir de este punto se puede redigir nuevamente al usuario a la pagina donde se le solicitó hacer el login.
 				header('Location: http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/formComentarConTwitter'); 
	        }
	        else
	        {
	            echo "<h4> Login Error </h4>";
	        }
	    }
		else
		{
		    echo "<h4> Login Error </h4>";
		}
	  }

	}

	public function obtenerObservaciones($idBache){	
		$firephp = FirePHP::getInstance(True);
		$firephp->log("El arreglo que se cargará es el siguiente:");
		$this->load->model("Bache");
		$comentarios = $this->Bache->obtenerObservaciones($idBache);
		$firephp->log("Se obtuvieron los comentarios!!!!");
		$firephp->log($comentarios);
		//$comentariosOrdenados=$this->ordenarPorFecha(json_decode($comentarios,TRUE));
		$comentariosOrdenados = $comentarios;
		$firephp->log("Se ordenaron los comentarios...");
		$firephp->log(json_encode($comentariosOrdenados));
		//echo json_encode($comentariosOrdenados);
		echo $comentariosOrdenados;
	}


	//Este metodo ordena un arreglo de fechas de forma ascendente y
	// retorna el JSON que será devuelto como respuesta!
	private function ordenarPorFecha($arregloComentarios){
		$firephp = FirePHP::getInstance(True);
		$firephp->log("Dentro de ordenar por Fecha");
		$arregloOrd=array();

		for ($i=0; $i < count($arregloComentarios); $i++) { 
			if($i+1>=count($arregloComentarios)){
				break;
			}
			$firephp->log("Dentro del FOR");
			//Se crea la fecha2 y se compara con la 1
			$f1= strtotime($arregloComentarios[$i]["fecha"]);
			$f2=strtotime($arregloComentarios[$i+1]["fecha"]);
			if($f1>$f2){					
				array_push($arregloOrd,$arregloComentarios[$i+1]);
				array_push($arregloOrd,$arregloComentarios[$i]);
				$i++;
			}else{
				array_push($arregloOrd,$arregloComentarios[$i]);
			}
		}//Fin del For
		$firephp->log("Fin de ordenar por Fecha. ".count($arregloComentarios));
		return $arregloOrd;
	}
		
	public function cambiarEstadoBache()
	{
		$firephp = FirePHP::getInstance(True);
		$firephp->log("Dentro de cambiar Estado Bache");
		$this->load->library('ion_auth');

		if($this->ion_auth->logged_in()){
			$idUser = $this->ion_auth->user()->row()->id;
			$idBache = $this->input->post('idBache');
			$this->load->model('Estado');
			$firephp->log("Estado cargado");
			$idNuevoEstado = $this->Estado->asociarNuevoEstado($idBache);
$firephp->log("Nuevo Estado Asociado");
			$material = $this->input->post('material');
			$numeroBaldosa = $this->input->post('numeroBaldosa');
			$rotura = $this->input->post('rotura');
			$ancho = $this->input->post('ancho');
			$largo = $this->input->post('largo');
			$profundidad = $this->input->post('profundidad');
			$criticidad = $this->input->post('criticidad');
$firephp->log("cargando Array");
			$datos = array('material' => strval($material),
							'numeroBaldosa' => intval($numeroBaldosa),
							'rotura' => strval($rotura),
							'ancho' => floatval($ancho),
							'largo' => floatval($largo),
							'profundidad' => floatval($profundidad),
							'idCriticidad' => intval($criticidad)+1);
			$firephp->log("Array Cargado");
			$this->load->model("Bache");
			$this->Bache->actualizarDatosEstado($idBache,$datos,$idNuevoEstado);
			$firephp->log("Se actualizaron los datos del bache correctamente");
		}
	}

}

/* End of file bache.php */
?>

<?php 
class Observacion extends MY_Model {


//URL DE PRUEBA --> http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/formAsociarObservaciones
  
	private $idBache;
	private $nombreObservador;
	private $emailObservador;

    public $_table = 'Observacion';//Este atributo permite denominar la forma en que  se llama la tabla
                                //realmente en lugar de dejar que adivine automaticamente como se llama.
    public $primary_key = 'id';//Sobreescribiendo el id por defecto.

    public $belongs_to = array( 'Bache' => array('model' => 'Bache', 'primary_key' => 'idBache' ));
	

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->database();
	}

	function insertarObservacion($valores){
		$firephp = FirePHP::getInstance(true);        
		$firephp->log("array de valores es ...");
		$firephp->log($valores)	;
		$this->load->model("Observacion");
        $this->Observacion->insert($valores);
		$firephp->log("valores insertados...");
	}

	//Esta funcion borra las observaciones asociadas a un bache.
	function borrarObservaciones($idBache){
		$firephp = FirePHP::getInstance(true);        
		$observaciones=$this->delete_by("idBache",$idBache);
		$firephp->log("Se borraron correctamente las observaciones del bache!");
	}


	// Esta funcion sube el comentario a Twitter para un bache determinado.
	// URL de posteo de tweets --> statuses/update


	//Cuando se envíe el comentario, se tendría que enviar haciendo una mension de
	//la cuenta de los baches con la funcion REST --> https://api.twitter.com/1.1/search/tweets.json?q=%40proyBacheoTw
	//filtrando por los tweets que hacen mencion al usuario @proyBacheoTw.

	function enviarComentarioTwitter(){
		//Las librerias para usar include_once() estan en /opt/lamp/libs/php
		include_once("configOAuth.php");
		include_once("twitteroauth.php");
		$firephp = FirePHP::getInstance(True);
		$firephp->log("Dentro de comentar con Twitter...");

		//Se obtienen de la session los datos del usuario (nombreUsuario,email y la fechaPublicacion)
		//TODO Corregir la URL de verBache.
		// $comentario="@proyBacheoTw"." Ver mas en "."http://www.localhost.com/gitBaches/ProyectoBacheo/web/index.php/inicio/verBache/".$_POST["idBache"]." ".$_POST["comentario"];
		// $comentario= "@proyBacheoTw"." ".$_POST["comentario"]; -->Funca OK!

		//El comentario del sistema solo puede ser de 49 caracteres-->
		$comentario= "@proyBacheoTw #Bache".$_POST["idBache"].". http://localhost/gitBaches/ProyectoBacheo/web/index.php/inicio/verBache/".$_POST["idBache"]."\n".$_POST["comentario"];

		$firephp->log("El comentario a enviar es ".$comentario);

		//Se obtienen los token de acceso desde la session en php, para
		//crear la conexion y acceder a los metodos de la API. 
		session_start(); 
		$firephp->log($_SESSION['oauth_token']);
		$firephp->log($_SESSION['oauth_token_secret']);

		$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        $content = $connection->post('statuses/update', array('status' => $comentario));
        $firephp->log("El contenido retornado fue:");
        $firephp->log($content);
       	//Se compara el contenido en JSON retonado por la petición a la API.
       	//TODO Preguntar: ¿Sirve el screen_name del usaurio como id unico en lugar del E-mail?
       	if($content && isset($content->user) ){
       		return json_encode(array("usuario"=>$_SESSION['name'],"email"=>$content->user->screen_name,"fecha"=>$content->created_at,"img_perfil"=>$content->user->profile_image_url_https));
        }
	}




		//BACKUP VERSION de observaciones con Twitter con busqueda por medio de URL.
		//NOTA: Esta alternativa serviría y encontraría un usuario con varios seguidores. Se podría probar con la de Pablo o Samuel.

		// function enviarComentarioTwitter(){
		// //Las librerias para usar include_once() estan en /opt/lamp/libs/php
		// include_once("configOAuth.php");
		// include_once("twitteroauth.php");
		// $firephp = FirePHP::getInstance(True);
		// $firephp->log("Dentro de comentar con Twitter...");

		// //Se obtienen de la session los datos del usuario (nombreUsuario,email y la fechaPublicacion)
		// //TODO Corregir la URL de verBache.
		// // $comentario="@proyBacheoTw"." Ver mas en "."http://www.localhost.com/gitBaches/ProyectoBacheo/web/index.php/inicio/verBache/".$_POST["idBache"]." ".$_POST["comentario"];
		// // $comentario= "@proyBacheoTw"." ".$_POST["comentario"]; -->Funca OK!


		// // Cadena valida -->
		// // @proyBacheoTw Ver mas en http://t.co/MQLKbTO8Dk \nEste bache se volvió a formar :(

		// $comentario= $_POST["comentario"]."\n\n @proyBacheoTw. Ver mas en #proyBacheoTwBache62";
		// $firephp->log("El comentario a enviar es ".$comentario);

		// //Se obtienen los token de acceso desde la session en php, para
		// //crear la conexion y acceder a los metodos de la API. 
		// session_start(); 
		// $firephp->log($_SESSION['oauth_token']);
		// $firephp->log($_SESSION['oauth_token_secret']);

		// $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
 //        $content = $connection->post('statuses/update', array('status' => $comentario));
 //        $firephp->log("El contenido retornado fue:");
 //        $firephp->log($content);
 //       	//Se compara el contenido en JSON retonado por la petición a la API.
 //       	//TODO Preguntar: ¿Sirve el screen_name del usaurio como id unico en lugar del E-mail?
 //       	if($content && isset($content->user) ){
 //       		return json_encode(array("usuario"=>$_SESSION['name'],"email"=>$content->user->screen_name,"fecha"=>$content->created_at,"img_perfil"=>$content->user->profile_image_url_https));
 //        }
	// }



}
/* End of file observacion.php */
/* Location: ./application/models/observacion.php */
?>
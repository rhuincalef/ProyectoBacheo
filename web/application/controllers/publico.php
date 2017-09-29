<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//include 'ChromePhp.php';

class Publico extends Frontend_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}

	public function _remap($method)
	{
		$args = array_slice($this->uri->rsegment_array(),2);
		if (method_exists($this, $method))
		{
			return call_user_func_array(array(&$this,$method),$args);
		}

		if(!$this->ion_auth->logged_in())
		{
			require_once(APPPATH."controllers/invitado.php");
		    $invitado = new Invitado();
		    if (method_exists($invitado, $method)) {
				call_user_func_array(array(&$invitado,$method),$args);
		    }else{
		    	require_once(APPPATH."controllers/api_rest.php");
		    	$api_rest = new Api_rest();
		    	$metodo_1 = $method.'_post';				
		    	if (method_exists($api_rest, $metodo_1)) {
					call_user_func_array(array(&$api_rest,$metodo_1),$args);
				}else{
					$metodo_1 = $method.'_get';
					if (method_exists($api_rest, $metodo_1)) {
						call_user_func_array(array(&$api_rest,$metodo_1),$args);		
					}else{
						echo "REDIRECCIONE A INDEX<br>";
				    	// Redirecciona a index
				    	// redirect('/', 'refresh');
				    	// return;						
					}
	
				}
		    }
		}else{
			require_once(APPPATH."controllers/privado.php");
		    $privado = new Privado();
		    call_user_func_array(array(&$privado,$method),$args);
		}
	}

	public function getObservaciones($idFalla)
	{
		try{
			$observaciones = Observacion::getAll($idFalla);
			echo json_encode($observaciones);
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function getMultimedia($idFalla){
		try{ 
			$multimedias = Multimedia::getAll($idFalla);
			$this->utiles->debugger($multimedias);
			echo json_encode($multimedias);
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
		
	}

	public function getTiposEstado(){
		try{
			$tipos = TipoEstado::getTiposEstado();
			echo json_encode($tipos);	
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function getEstados($idFalla){
		try {
			$estados = Estado::getAll($idFalla);
			echo json_encode($estados);
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function getEstado($idFalla){
		try {
				$estado = Estado::getEstadoActual($idFalla);
			echo json_encode($estado);
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function login_via_ajax()
	{
		$identity = $this->input->post('login_identity');
		$password = $this->input->post('login_password');
		// $remember = $this->input->post('remember_me');
		$remember = true;
	    # Usar si es necesario enviar mas info del usuario
	    // $user = $this->ion_auth->user()->row();
	    if ($this->ion_auth->logged_in())
		{
			echo json_encode(array('status' => 'OK','data' => array('logged_in' => 'Ya se encuentra logeado.')));
		}
		else
		{
			if($this->ion_auth->login($identity, $password, $remember))
				echo json_encode(array('status' => 'OK','data' => array('login_identity' => $identity, 'login_password' => $password)));
			else
				echo json_encode(array('status' => 'error_log(message)','data' => 'User invalid!'));
		}
	}

	public function logout()
	{
		$this->ion_auth->logout();
		$this->session->set_flashdata('message', $this->ion_auth->messages());
	}

	public function getCriticidades()
	{
		$criti = Criticidad::getCriticidades();
		echo json_encode((array_map(function($obj){ return $obj; }, $criti)));
	}

	/*
	* get
	* Devuelve un objeto dada la clase y el id.
	* @access	public
	* @param    string => clase del objeto a obtener
	* @param    numeric => id del objeto
	*/
	public function get()
	{
		// Si es una petición POST por ajax.
		$arguments = func_get_args();
		$class = $arguments[0];
		$id = $arguments[1];
		try {
			// $object = call_user_func(array($class, 'get'), $id);
			$object = $class::{'getInstancia'}($id);
			echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>$object));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "$class no existe", 'valor' =>''));
			
		}
	}

	/*
	* get
	* Devuelve un objeto dada la clase y el id.
	* @access	public
	* @param    string => clase del objeto a obtener
	* @param    numeric => id del objeto
	*/
	public function getAll()
	{
		// Si es una petición POST por ajax.
		$arguments = func_get_args();
		$class = $arguments[0];
		try {
			// $object = call_user_func(array($class, 'get'), $id);
			$objectArray = $class::{'getAll'}();
			$codigo = 400;
			$mensaje = "No hay elementos para mostrar";
			if(count($objectArray) != 0)
			{
				$codigo = 200;
				$mensaje = "Elementos Cargados";
			}
			echo json_encode(array('codigo' => $codigo, 'mensaje' => $mensaje, 'valor' =>json_encode($objectArray)));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "$class no existe", 'valor' =>''));
			
		}
	}


	// URL de prueba -->
	// http://localhost/repoProyectoBacheo/web/index.php/inicio/genPass/administrator
	// USER: administrator
	// PASSWORD: administrator.
	// NOTA PASSWORD: Cuando se almacena en la BD borrar las comillas ''.
	// 
	// Genera un hash para la BD partiendo de un string.
	public function genPass($password){
		//$firephp = FirePHP::getInstance(True);
		$this->load->library('ion_auth');
	    $pass = $this->ion_auth->hash_password($password,FALSE,FALSE);
	    //$firephp->log("Pass encriptada OK:");
	    //$firephp->log($pass);
	    //$firephp->log("<------------------------>");
	}



	/*
	Clases accesibles: TipoFalla
	Devuelve los Tipos de Falla que de un material dado.
	*/
	public function getTiposFalla()
	{
		$arguments = func_get_args();
		$idMaterial = $arguments[0];
		try {
			$tiposFalla = TipoFalla::{'getTiposFallaPorMaterial'}($idMaterial);
			echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>json_encode($tiposFalla)));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "$class no existe", 'valor' =>''));
			
		}
	}

	/*
	GET baseurl/getAlly/TipoMaterial
	Retorna todos los tipos de material con los tipos de falla asociadas de la siguiente manera:
		material: {nombre, tiposFalla:[idFalla1, idFalla2, ..., idFallaN]}
	*/
	public function getAlly()
	{
		$arguments = func_get_args();
		$class = $arguments[0];
		try {
			$objectArray = $class::{'getAlly'}();
			$codigo = 400;
			$mensaje = "No hay elementos para mostrar";
			if(count($objectArray) != 0)
			{
				$codigo = 200;
				$mensaje = "Elementos Cargados";
			}
			echo json_encode(array('codigo' => $codigo, 'mensaje' => $mensaje, 'valor' =>json_encode($objectArray)));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "$class no existe", 'valor' =>''));
			
		}
	}

	public function gety()
	{
		$arguments = func_get_args();
		$class = $arguments[0];
		$id = $arguments[1];
		try {
			$object = $class::{'gety'}($id);
			echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>$object));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "$class no existe", 'valor' =>''));
			
		}
	}

	/*
	Probar:
	$.post("publico/getTiposFallasPorIDs", {"idTipos":JSON.stringify([4,5])})
	*/
	public function getTiposFallasPorIDs()
	{
		$arregloIDsTiposFallas = json_decode($this->input->post('idTipos'));
		$tiposFalla = array();
		try {
			foreach ($arregloIDsTiposFallas as $key => $value) {
				array_push($tiposFalla, TipoFalla::gety($value));
			}
			echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>json_encode(array_values($tiposFalla))));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "No se pudo realizar la petición", 'valor' =>''));
		}
	}

	/*
	Probar:
	$.post("publico/getReparacionesPorIDs", {"idReparaciones":JSON.stringify([4,5])})
	*/
	public function getReparacionesPorIDs()
	{
		$arregloIDsTiposReparacion = json_decode($this->input->post('idReparaciones'));
		$tiposReparacion = array();
		try {
			foreach ($arregloIDsTiposReparacion as $key => $value) {
				array_push($tiposReparacion, TipoReparacion::get($value));
			}
			echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>json_encode($tiposReparacion)));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "No se pudo realizar la petición o no se encuentran todos los valores", 'valor' =>''));
		}
	}

	public function getBaches()
	{
		try {
			$fallas = Falla::getAll();
			$codigo = 400;
			$mensaje = "No hay elementos para mostrar";
			if(count($fallas) != 0)
			{
				$codigo = 200;
				$mensaje = "Elementos Cargados";

			}
			echo json_encode(array('codigo' => $codigo, 'mensaje' => $mensaje, 'valor' =>json_encode($fallas)));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => $mensaje, 'valor' =>json_encode('')));
		}
	}

	/*
	Probar:
	$.post("publico/getTiposAtributo", {"idTipos":JSON.stringify([4,5])})
	*/
	public function getTiposAtributo()
	{
		$arregloIDsTiposAtributo = json_decode($this->input->post('idTipos'));
		$tiposAtributo = array();
		try {
			foreach ($arregloIDsTiposAtributo as $key => $value) {
				array_push($tiposAtributo, TipoAtributo::getInstancia($value));
			}
			echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>json_encode($tiposAtributo)));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "No se pudo realizar la petición", 'valor' =>''));
		}
	}

	public function obtenerObservaciones($idBache){
		$this->utiles->debugger($idBache);
		$comentarios = Falla::obtenerObservaciones($idBache);
		echo json_encode($comentarios);
	}

	/*
	$.post('getFallasPorCalle', {"calle":"Gales", tiposFalla:JSON.stringify({"id":1, "id":2})}, function(data){console.log(data)})
	$.post('getFallasPorCalle', {"calle":"Gales", tiposFalla:JSON.stringify([1,2]), estados:JSON.stringify([1,2])})
	*/
	public function getFallasPorCalle(){
		$calle = $this->input->post('calle');
		$idsTiposFalla = json_decode($this->input->post('tiposFalla'));
		$idsEstadoFalla = json_decode($this->input->post('estados'));
		$fallasPorTipoFalla = array();
		/* Si el valor en idsTiposFalla es -1 se debe obtener las fallas por todos los
		   tipos de fallas */
		if (in_array(-1,$idsTiposFalla)) {
			$tiposFalla = TipoFalla::getTiposFalla();
			$idsTiposFalla = array();
			foreach ($tiposFalla as $value) {
				array_push($idsTiposFalla, $value->id);
			}
		}
		foreach ($idsTiposFalla as $value) {
			$mini_fallas = Falla::getFallasPorTipoFalla($value);
			$fallasPorTipoFalla = array_merge($fallasPorTipoFalla, $mini_fallas);
		}
		$fallasPorCalle = array_filter($fallasPorTipoFalla,
			function ($falla) use ($calle)
			{
				return $falla->esCalle($calle);
			});
		$tiposEstado = array();
		/* Si el valor en idsEstadoFalla es -1 se debe obtener todos los tipos estados */
		if (in_array(-1, $idsEstadoFalla)) {
			$tiposEstado = TipoEstado::getTiposEstado();
			$idsEstadoFalla = array();
			foreach ($tiposEstado as $value) {
				array_push($idsEstadoFalla, $value->id);
			}
		}
		foreach ($idsEstadoFalla as $value) {
					$this->utiles->debugger($value);
			array_push($tiposEstado, TipoEstado::getInstancia($value));
		}
		/* Buscamos por Tipos Estados */
		$fallasPorEstados = array();
		foreach ($tiposEstado as $value) {
			$fallasPorEstados = $fallasPorEstados + array_filter($fallasPorCalle,
				function ($falla) use ($value)
				{
					return $falla->esEstadoActual($value);
				});
		}
		$fallas = array_filter( $fallasPorEstados);
		echo json_encode(array_values($fallasPorEstados));
		return;
	}

	// Metodo del controlador que ataja la subida de imagenes
	// al servidor.	
	// http://baseurl/subirImagen/id
	public function subirImagen($idBache){
		if (empty($_FILES)) {
			$this->utiles->debugger("empty _FILES!");
			return;
		}
		//$this->db->trans_begin();
		$falla = Falla::getInstancia($idBache);
		$imagen = new Imagen();
		$imagen->inicializar($idBache, $_FILES['file']['name'], $_FILES['file']['tmp_name'], $this->config->item('upload_img_path'));
		$array_file_name = explode('.', $_FILES['file']['name']);
		$extension = end($array_file_name);
		$imagen->setType($extension);
		$imagen->falla = $falla;
		$imagen->save();
		//$this->db->trans_rollback();
	}

}

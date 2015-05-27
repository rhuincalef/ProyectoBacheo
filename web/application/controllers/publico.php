<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
			call_user_func_array(array(&$invitado,$method),$args);
		}else{
			require_once(APPPATH."controllers/privado.php");
		    $privado = new Privado();
		    call_user_func_array(array(&$privado,$method),$args);
		}
	}

	// --------------------------------------------------------------------
	


	public function index()
	{
		
		$data['logueado'] = $this->ion_auth->logged_in();
		if ($data['logueado'])
		{
			$data['usuario'] = $this->ion_auth->user()->row()->username;
			$data['admin'] = $this->ion_auth->is_admin(); 
		}

		$this->template->build_page("mapa",$data);
	}

	public function getObservaciones($idFalla){
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

	public function getTiposRotura(){
		try {
			$tipos = TipoRotura::getTiposRotura();
			echo json_encode($tipos);
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

	/*
	 * crearTipoMaterial
	 *
	 * @access	public
	 * @param	numeric
	 * @param	string
	 */
	public function crearTipoMaterial($nombre)
	{
		try {
			// Se Busca si el tipo de material existe.
			$tipoMaterial = TipoMaterial::getTipoDeMaterialPorNombre($nombre);
			echo "El tipo de Material ingresado ya se encuentra cargado";
		} catch (MY_BdExcepcion $e) {
			$tipoMaterial = new TipoMaterial();
			$tipoMaterial->nombre = $nombre;
			$tipoMaterial->save();
			echo "El tipo de Material ha sido ingresado correctamente";
		}

	}

	/*
	 * crearTipoMaterial
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	double
	 */
	public function crearTipoReparacion($nombre, $descripcion, $costo)
	{
		try {
			// Se Busca si el tipo de reparacion existe.
			$tipoReparacion = TipoReparacion::getTipoDeReparacionPorNombre($nombre);
			// $this->utiles->debugger(get_class_methods('TipoReparacion'));
			// $tipoReparacion = call_user_func(array('TipoReparacion', 'get'.'TipoDeReparacion'.'PorNombre'), $nombre);
			// $this->utiles->debugger($tipoReparacion);
			echo json_encode(array('codigo' => 400, 'mensaje' => "El tipo de reparacion ya se encontraba cargado", 'valor' => ''));
		} catch (Exception $e) {
			$tipoReparacion = new TipoReparacion();
			$tipoReparacion->nombre = $nombre;
			$tipoReparacion->descripcion = $descripcion;
			$tipoReparacion->costo = (float)$costo;
			$id= $tipoReparacion->save();
			echo json_encode(array('codigo' => 200, 'mensaje' => "El tipo de Reparacion ha sido ingresada correctamente", 'valor' => $id ));

		}
	}

	public function getCriticidades()
	{
		$criti = Criticidad::getCriticidades();
		echo json_encode((array_map(function($obj){ return $obj; }, $criti)));
	}

	/*
	$.post('crear/TipoFalla', 
       {"clase": "TipoFalla", 
        "datos": JSON.stringify({"general": {"nombre": "Bache", "influencia": 2},
                  "materiales": [{"nombre": "Adoquines"}],
                  "atributos": [{"nombre": "ancho", "unidadMedida": "cm"}],
                                 "criticidades": [{"nombre": "alto", "descripcion": "una descripcion", "ponderacion": 1}],
                  "reparaciones": [{"nombre": "sellado de juntas", "costo": 54.2, "descripcion": "una descripcion"}]
                 })
       })
      $.post('crear/TipoMaterial', 
       {"clase":"TipoMaterial",
        "datos":JSON.stringify({"nombre":"Adoquines"})
       });
       $.post('crear/TipoReparacion', 
       {"clase": "TipoReparacion", 
        "datos": JSON.stringify({"nombre": "sellado de juntas", "costo": 23.2, "descripcion": "una descripcion"})
       })
	*/
	public function crear()
	{
		// Si es una petición POST por ajax.
		$this->load->library('validation');
		$this->utiles->debugger(func_get_args());
		$datos = array('clase' => $this->input->post('clase'), 'datos' => json_decode($this->input->post('datos')));
		$data = array('clase' => $datos['clase']);
		// $this->validation->set_post();
		$this->validation->set_data($data);

		// $this->validation->required(array('clase'), 'Fields are required')
		$this->validation->required(array('clase'), 'Fields are required')
				->regexp('clase', '(TipoFalla|TipoMaterial|TipoReparacion)');
		if ($this->validation->is_valid())
		{
			$this->utiles->debugger('datos validos');
		}
		else
		{
			$this->utiles->debugger('datos invalidos: '.$this->validation->get_error_field());
			echo json_encode(array('codigo' => 200, 'mensaje' => "datos invalidos", 'valor' => ''));
			return;
		}
		$class = $datos['clase'];
		// Validando datos. Se puede mejorar con form_validation.
		if (!$class::{"datosCrearValidos"}($datos)) {
			// Si los datos son invalidos
			echo json_encode(array('codigo' => 400, 'mensaje' => "datos invalidos", 'valor' => json_encode($this->input->post())));
			return;
		}
		$this->utiles->debugger('datos validos');
		// // Comienza la transaccion
		// $this->db->trans_begin();
		$object = call_user_func(array($class, 'crear'), json_decode($this->input->post('datos')));
		echo json_encode(array('codigo' => 200, 'mensaje' => "$class ha sido ingresada correctamente", 'valor' => $object));
		// Por ahora siempre deshacemos
		// $this->db->trans_rollback();
		if ($this->db->trans_status() === FALSE)
		{
			// TODO: Falta dar aviso del error
		    $CI->db->trans_rollback();
		}
		else
		{
		    $CI->db->trans_commit();
		}
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
			if(count($objectArray) != 0){
				$codigo = 200;
				$mensaje = "Elementos Cargados";

			}

			echo json_encode(array('codigo' => $codigo, 'mensaje' => $mensaje, 'valor' =>json_encode($objectArray)));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "$class no existe", 'valor' =>''));
			
		}
	}

}
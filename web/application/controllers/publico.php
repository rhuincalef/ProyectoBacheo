<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publico extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	public function _remap($method){
		$args = array_slice($this->uri->rsegment_array(),2);
		if (method_exists($this, $method)){
			return call_user_func_array(array(&$this,$method),$args);
		}

		if(!$this->ion_auth->logged_in()){
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
	


	public function index(){
		
		$data['logueado'] = $this->ion_auth->logged_in();
		if ($data['logueado']) {
			$data['usuario'] = $this->ion_auth->user()->row()->username;
			$data['admin'] = $this->ion_auth->is_admin(); 
		}

		$this->template->build_page("mapa",$data);
	}




	public function getFalla($id){
		$this->utiles->debugger($id);
		try {
			$falla = Falla::getInstancia($id);
			echo json_encode($falla);			
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}

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

	public function getTiposMaterial(){
		try {
			$tipos = TipoMaterial::getTiposMaterial();
			echo json_encode($tipos);
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function getMaterial($idMaterial){
		$this->utiles->debugger($idMaterial);
		try {
			$material = Material::getInstancia($idMaterial);
			echo json_encode($material);			
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function login_via_ajax() {
		$firephp = FirePHP::getInstance(True);
		$identity = $this->input->post('login_identity');
		$password = $this->input->post('login_password');
		// $remember = $this->input->post('remember_me');
		$firephp->log($identity);
	    $firephp->log($password);
	    # Usar si es necesario enviar mas info del usuario
	    // $user = $this->ion_auth->user()->row();
	    if ($this->ion_auth->logged_in())
		{
			// redirect('auth/login');
			echo json_encode(array('status' => 'OK','data' => array('logged_in' => 'Ya se encuentra logeado.')));
		}
		else
		{
			if($this->ion_auth->login($identity, $password))
				echo json_encode(array('status' => 'OK','data' => array('login_identity' => $identity, 'login_password' => $password)));
			else
				echo json_encode(array('status' => 'error_log(message)','data' => 'User invalid!'));
		}
	}

	public function logout()
	{
		$this->ion_auth->logout();
	}
	
}
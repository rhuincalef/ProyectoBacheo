<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publico extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	public function _remap($method){
		$args = array_slice($this->uri->rsegment_array(),2);
		

		if($method == "index"){
			return $this->index();
		}


		if(!$this->ion_auth->logged_in()){
			require_once(APPPATH."controllers/invitado.php");
		    $invitado = new Invitado();
			call_user_func_array(array(&$invitado,$method),$args);
			//$invitado->$method($params);
		}else{
			require_once(APPPATH."controllers/privado.php");
		    $privado = new Privado();
		    call_user_func_array(array(&$privado,$method),$args);
		    //$privado->$method($params);
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


}
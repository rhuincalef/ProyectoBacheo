<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publico extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	// --------------------------------------------------------------------
	
	public function index(){
		

		$data['logueado'] = $this->ion_auth->logged_in();
		if ($data['logueado']) {
			$data['usuario'] = $this->ion_auth->user()->row()->username;
			$data['admin'] = $this->ion_auth->is_admin(); 
		}

		$this->template->build_page("mapa",$data);

		//$this->template->build_page("bache");
		//$this->template->build_page("actividadSistema");
	}


	public function getNiveles(){
		// $this->load->model('Criticidad');
		// $this->Criticidad->get(1);
		//require_once("/home/pablo/Documentos/ProyectosWeb/ProyectoBacheo/web/application/models/criticidad_modelo.php");
		$criti = Criticidad::getCriticidades();
		$this->utiles->debugger($criti);
		echo json_encode($criti);
	}

	// --------------------------------------------------------------------
}
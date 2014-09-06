<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
	}	

	// --------------------------------------------------------------------
	
	public function index(){
		$this->load->library('ion_auth');
		$this->output->enable_profiler(FALSE);
		

		$data['logueado'] = $this->ion_auth->logged_in();
		if ($data['logueado']) {
			$data['usuario'] = $this->ion_auth->user()->row()->username;
		}

		$this->template->build_page("mapa",$data);

		//$this->template->build_page("bache");
		//$this->template->build_page("actividadSistema");
	}

	// --------------------------------------------------------------------
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
	}	

	// --------------------------------------------------------------------
	
	public function index(){
		$this->output->enable_profiler(FALSE);
		//$this->template->build_page("mapa");
		$this->template->build_page("bache");
		//$this->template->build_page("actividadSistema");
	}

	// --------------------------------------------------------------------
}
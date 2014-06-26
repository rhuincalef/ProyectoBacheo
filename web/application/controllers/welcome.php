<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
	}	

	// --------------------------------------------------------------------
	
	public function index(){
		$this->output->enable_profiler(FALSE);
		// $this->load->view('header');
		// $this->load->view('mapa');
		// $this->load->view('footer');
		$datos['content'] = 'mapa'; //llamada al content de este metodo
		$this->load->view('layout', $datos); //llamada a la vista general
	}

	// --------------------------------------------------------------------
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privado extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	// --------------------------------------------------------------------
	
	public function getNiveles(){
		if ($this->ion_auth->logged_in()){
			$criti = Criticidad::getCriticidades();
			echo json_encode((array_map(function($obj){ return $obj->toJsonFormal(); }, $criti)));		
		}		
	}

	// --------------------------------------------------------------------
}

 ?>
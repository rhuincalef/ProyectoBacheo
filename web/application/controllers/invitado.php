<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invitado extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	// --------------------------------------------------------------------
	
	public function getNiveles(){
		$criti = Criticidad::getCriticidades();
		echo json_encode((array_map(function($obj){ return $obj->toJsonInformal(); }, $criti)));	
		
	}

	public function getBache($id){
		$bache = Bache::getInstancia($id);
		// echo json_encode((array_map(function($obj){ return $obj->toJsonInformal(); }, $direcciones)));	
		$this->utiles->debugger($bache);
	}



	// --------------------------------------------------------------------
}

 ?>
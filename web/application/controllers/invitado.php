<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invitado extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	// --------------------------------------------------------------------
	
	public function getNiveles(){
		try{
			$criti = Criticidad::getCriticidades();
			echo json_encode((array_map(function($obj){ return $obj->toJsonInformal(); }, $criti)));	
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
		
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



	// --------------------------------------------------------------------
}

 ?>
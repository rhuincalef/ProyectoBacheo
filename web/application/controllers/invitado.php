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

	public function getFalla($id)
	{
		$get = $this->uri->uri_to_assoc();
		$falla = Falla::getInstancia($id);
		$bache = $falla->to_array();
		if (!isset($bache)) {
			redirect('/', 'refresh');
			return;
		}

		$this->output->enable_profiler(FALSE);
		$bache['logueado'] = FALSE;
		$this->template->build_page("bache",$bache);
	}

	public function asociarObservacion(){
		$this->utiles->debugger($this->input->post());
		$datos = new stdClass;
		$datos->comentario = $this->input->post("comentario");
		$datos->nombreObservador = $this->input->post("nombreObservador");
		$datos->emailObservador = $this->input->post("emailObservador");
		$datos->idFalla = $this->input->post("idBache");
		Falla::asociarObservacionAnonima($datos);
	}

	// --------------------------------------------------------------------
}
?>
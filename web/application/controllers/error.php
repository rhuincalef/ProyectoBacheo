<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	// --------------------------------------------------------------------
	
	public function error_404(){
			echo "La pagina solicitada no existe hweon!";
	}

	// --------------------------------------------------------------------
}

 ?>
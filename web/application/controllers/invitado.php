<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invitado extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	public function index()
	{
		$data['logueado'] = $this->ion_auth->logged_in();
		$this->template->template_name = "default";
		$this->template->build_page("mapa",$data);
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
		// AGREGADO RODRIGO
		$this->load->helper('url');

		$get = $this->uri->uri_to_assoc();
		$falla = Falla::getInstancia($id);
		$bache = $falla->to_array();
		$bache['estado'] = json_encode($falla->estado);
		$bache['tiposEstado'] = json_encode(TipoEstado::getAll());
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

	/*
	$.post('crearFallaAnonima', 
	{"clase": "Falla",
	"datos": JSON.stringify(
	  { "falla": {"latitud": -43.2517261, "longitud": -65.30606180000001},
	   "observacion": {"comentario": "comentario falla", "nombreObservador": "Pepe", "emailObservador": "pepe@pepe.com"},
       "tipoFalla": {"id": 1},
	   "multimedias": {},
	   "direccion": {"altura": 350,"callePrincipal": "Avenida Fontana", "calleSecundariaA": "calleSA", "calleSecundariaB": "calleSB"}
	  })
	})
	*/
	public function crearFallaAnonima()
	{
		$datos = new stdClass;
		$datos->clase = $this->input->post('clase');
		$datos->clase = 'Falla';
		$datos->datos = json_decode($this->input->post('datos'));
		$class = $datos->clase;
		$this->utiles->debugger($datos);
		if (!Falla::{"validarDatosFallaAnonima"}($datos))
		{
			// Si los datos no son validos
			$this->utiles->debugger("Datos Invalidos");
			echo json_encode(array('codigo' => 400, 'mensaje' => "datos invalidos", 'valor' => json_encode($this->input->post())));
			return;
		}
		$this->utiles->debugger("Datos Validos");
		$this->db->trans_begin();
		$falla = Falla::crearFallaAnonima($datos->datos);
		// Por ahora siempre deshacemos
		// $this->db->trans_rollback();
		if ($this->db->trans_status() === FALSE)
		{
			$this->utiles->debugger("Falla en DB");
			// TODO: Falta dar aviso del error
		    $this->db->trans_rollback();
		}
		else
		{
		    $this->db->trans_commit();
		}
		
		$this->utiles->debugger($falla);
		echo json_encode(array('codigo' => 200, 'mensaje' => "$class ha sido ingresada con exito!", 'valor' =>json_encode($falla)));
		return;
	}

}
?>
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

	public function creacionTipoFalla(){
		$this->template->build_page("gestorFallas");
	}

		/*
		$.post('crear/TipoFalla', 
	       {"clase": "TipoFalla", 
	        "datos": JSON.stringify({"general": {"nombre": "Bache", "influencia": 2},
	                  "material": {"nombre": "Adoquines"},
	                  "atributos": [{"nombre": "ancho", "unidadMedida": "cm"}],
	                                 "criticidades": [{"nombre": "alto", "descripcion": "una descripcion", "ponderacion": 1}],
	                  "reparaciones": [{"nombre": "sellado de juntas", "costo": 54.2, "descripcion": "una descripcion"}]
	                 })
	       })
	      $.post('crear/TipoMaterial', 
	       {"clase":"TipoMaterial",
	        "datos":JSON.stringify({"nombre":"Adoquines"})
	       });
	       $.post('crear/TipoReparacion', 
	       {"clase": "TipoReparacion", 
	        "datos": JSON.stringify({"nombre": "sellado de juntas", "costo": 23.2, "descripcion": "una descripcion"})
	       })
		*/
		public function crear()
		{
			$this->utiles->debugger('AAAAAAAAAAAAAAAAAAAAAAAAAA');
			$this->load->library('validation');
			// $this->utiles->debugger(func_get_args());
			$datos = array('clase' => $this->input->post('clase'), 'datos' => json_decode($this->input->post('datos')));
			$data = array('clase' => $datos['clase']);
			$this->validation->required(array('clase'), 'Fields are required')
					->regexp('clase', '(TipoFalla|TipoMaterial|TipoReparacion|Falla)');
			$class = $datos['clase'];
			$this->utiles->debugger($datos['datos']);
			// Validando datos.
			$valor = $class::{"datosCrearValidos"}($datos['datos']) ? 'true' : 'false';;
			$this->utiles->debugger($valor);
			if ($class::{"datosCrearValidos"}($datos['datos']))
			{
				// Si los datos no son validos
				echo json_encode(array('codigo' => 400, 'mensaje' => "datos invalidos", 'valor' => json_encode($this->input->post())));
				return;
			}
			// Comienza la transaccion
			$this->db->trans_begin();
			$object = call_user_func(array($class, 'crear'), json_decode($this->input->post('datos')));
			echo json_encode(array('codigo' => 200, 'mensaje' => "$class ha sido ingresada correctamente", 'valor' => $object));
			// Por ahora siempre deshacemos
			// $this->db->trans_rollback();
			if ($this->db->trans_status() === FALSE)
			{
				// TODO: Falta dar aviso del error
			    $this->db->trans_rollback();
			}
			else
			{
			    $this->db->trans_commit();
			}
		}
	// --------------------------------------------------------------------
}

 ?>
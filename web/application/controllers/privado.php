<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privado extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	// --------------------------------------------------------------------
	
	public function index($data){
		if ($this->ion_auth->logged_in()){
			$this->template->build_page("mapaRegistrado",$data);
		}		
	}


	public function getNiveles(){
		if ($this->ion_auth->logged_in()){
			$criti = Criticidad::getCriticidades();
			echo json_encode((array_map(function($obj){ return $obj->toJsonFormal(); }, $criti)));		
		}		
	}

	public function creacionTipoFalla()
	{
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
			// $this->utiles->debugger(func_get_args());
			$datos = new stdClass;
			$datos->clase = $this->input->post('clase');
			$datos->datos = json_decode($this->input->post('datos'));
			$class = $datos->clase;
			$this->utiles->debugger($datos);
			// $this->utiles->debugger(gettype($datos->datos->multimedia->coordenadas->x));
			// Validando datos
			if (!$class::{"validarDatos"}($datos))
			{
				// Si los datos no son validos
				$this->utiles->debugger("Datos Invalidos");
				echo json_encode(array('codigo' => 400, 'mensaje' => "datos invalidos", 'valor' => json_encode($datos)));
				return;
			}
			$this->utiles->debugger("Datos Validos");
			// Comienza la transaccion
			$this->db->trans_begin();
			$object = call_user_func(array($class, 'crear'), $datos->datos);
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
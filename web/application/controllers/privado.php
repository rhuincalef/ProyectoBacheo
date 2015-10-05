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
			$datos->clase = func_get_args()[0];
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

		/*
		Probar:
		$.post("publico/getTiposFallasPorIDs", {"idTipos":JSON.stringify([4,5])})
		*/
		public function getTiposFallasPorIDs()
		{
			$arregloIDsTiposFallas = json_decode($this->input->post('idTipos'));
			$this->utiles->debugger($arregloIDsTiposFallas);
			$tiposFalla = array();
			try {
				foreach ($arregloIDsTiposFallas as $key => $value) {
					array_push($tiposFalla, TipoFalla::gety($value));
				}
				echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>json_encode($tiposFalla)));
			} catch (MY_BdExcepcion $e) {
				echo json_encode(array('codigo' => 400, 'mensaje' => "No se pudo realizar la petición", 'valor' =>''));
			}
		}

		/*
		Probar:
		$.post("publico/getTiposReparacionPorIDs", {"arregloIDsTiposReparacion":JSON.stringify([4,5])})
		*/
		public function getTiposReparacionPorIDs()
		{
			$arregloIDsTiposReparacion = json_decode($this->input->post('arregloIDsTiposReparacion'));
			$this->utiles->debugger($arregloIDsTiposReparacion);
			$tiposReparacion = array();
			try {
				foreach ($arregloIDsTiposReparacion as $key => $value) {
					array_push($tiposReparacion, TipoReparacion::get($value));
				}
				echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>json_encode($tiposReparacion)));
			} catch (MY_BdExcepcion $e) {
				echo json_encode(array('codigo' => 400, 'mensaje' => "No se pudo realizar la petición o no se encuentran los todos valores", 'valor' =>''));
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
			// $bache['logueado'] = TRUE;
			$bache['logueado'] = $this->ion_auth->logged_in();
			$bache['usuario'] = $this->ion_auth->user()->row()->username;
			$bache['admin'] = $this->ion_auth->is_admin(); 
			$this->template->build_page("bache",$bache);
			
		}

		public function registrarUsuario()
		{
			$this->template->build_page("registrarUsuario");
		}

		public function create_user()
		{
			$firephp = FirePHP::getInstance(True);

			// Set validation rules.
			// The custom rules 'identity_available' and 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
			$validation_rules = array(
				array('field' => 'register_first_name', 'label' => 'First Name', 'rules' => 'required'),
				array('field' => 'register_last_name', 'label' => 'Last Name', 'rules' => 'required'),
				array('field' => 'register_phone_number', 'label' => 'Phone Number', 'rules' => 'xss_clean'),
				// array('field' => 'register_newsletter', 'label' => 'Newsletter', 'rules' => 'integer'),
				array('field' => 'register_email_address', 'label' => 'Email Address', 'rules' => 'required|valid_email|identity_available'),
				array('field' => 'register_username', 'label' => 'Username', 'rules' => 'required|min_length[4]|identity_available'),
				array('field' => 'register_password', 'label' => 'Password', 'rules' => 'required|validate_password'),
				array('field' => 'register_confirm_password', 'label' => 'Confirm Password', 'rules' => 'required|matches[register_password]')
			);
			$this->form_validation->set_rules($validation_rules);

			// Run the validation.
			if ($this->form_validation->run())
			{
				$firephp->log('Pasa la validacion.');
				// Get user login details from input.
				$username = $this->input->post('register_username');
				$password = $this->input->post('register_password');
				$email = $this->input->post('register_email_address');
				$additional_data = array(
										'first_name' => $this->input->post('register_first_name'),
										'last_name' => $this->input->post('register_last_name'),
										'phone' => $this->input->post('register_phone_number'),
										 'email' => $this->input->post('register_email_address')
										);
				$group = array('2'); // Sets user to public. No need for array('1', '2') as user is always set to member by default

				$firephp->log($username);
				$firephp->log($password);
				$firephp->log($email);
				$firephp->log($additional_data);
				$firephp->log($group);

				if ($this->ion_auth->register($username, $password, $email, $additional_data, $group))
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					// $this->data['message'] = $this->ion_auth->errors();
					echo json_encode(array('status' => 'OK', 'message' => 'Your account has successfully been created.'));
				}
				else{
					$firephp->log('No se pudo registrar el usuario.');
					$this->session->flashdata('message');
					// echo $this->ion_auth->errors();
					echo json_encode(array('status' => 'ERROR', 'message' => $this->ion_auth->errors()));
				}			
			}
			else
			{
				$firephp->log('No pasa la validacion.');
				// echo validation_errors();
				echo json_encode(array('status' => 'ERROR', 'message' => validation_errors()));
			}
		}

}

 ?>
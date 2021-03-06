<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Privado extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
		// Se quitan los delimitadores que devuelven los mensajes como <p/>
		$this->ion_auth->set_message_delimiters('', '');
		$this->ion_auth->set_error_delimiters('', '');
	}

	public function index()
	{
		$data['logueado'] = $this->ion_auth->logged_in();
		$data['usuario'] = $this->ion_auth->user()->row()->username;
		$data['admin'] = $this->ion_auth->is_admin();
		//$this->template->build_page("mapaRegistrado",$data);
		$this->template->template_name = "mapa";
		$this->template->build_page("mapaRegistrado",$data);
	}



	// Obtiene la coleccion de datos para la captura con la extension
	// EXT_CAPTURA_DEFAULT (.pcd) 
	public function obtenerDatosVisualizacion($idFalla){
		$CI = &get_instance();
		$this->load->helper('url');
		$dir_raiz = base_url();

		$dir_csv = $dir_raiz.$CI->config->item("pcd_dir").$idFalla."/".$CI->config->item('dir_csv');
		$CI->utiles->debugger('dir_csv');
		$CI->utiles->debugger($dir_csv);
		$valores= array();
		$dir_local = $_SERVER['DOCUMENT_ROOT'].$CI->config->item('path_web').$CI->config->item("pcd_dir").$idFalla."/".$CI->config->item('dir_csv');
		$CI->utiles->debugger('dir_local');
		$CI->utiles->debugger($dir_local);


		if (is_dir($dir_local)) {
			$img_default = $CI->config->item('img_default');
			$colCapturas = array();
			//foreach (glob($dir_local.EXT_CAPTURA_DEFAULT) as $nombre_fichero) {
			foreach (glob($dir_local."*".EXTENSION_CAPTURA) as $nombre_fichero) {
				$nombre = '';
			    $CI->utiles->debugger($nombre_fichero);
			    $array_nombre = explode('/', $nombre_fichero);
			    $nombre = $array_nombre[count($array_nombre)-1];
			    array_push($colCapturas,$nombre);
			}
			
			//BACKUP!
			// Ejemplo de salida -->
			//{"estado":200,"raiz_tmp":"http:\/\/localhost\/web\/_\/dataMultimedia\/1\/","csv_nube":"infoMitre_2.csv","imagen":"_\/img\/res\/img_default.png","info_csv":"infoMitre_2.csv"}
			/*$valores= array(
				'estado' => 200,
				'raiz_tmp' => $dir_csv,
				'csv_nube' => $nombre ,
				'imagen' => $img_default,
				'info_csv' => $nombre );
			 */
			$CI->utiles->debugger('capturas leidas -->');
			$CI->utiles->debugger($colCapturas);

			$valores= array(
				'estado' => 200,
				'dirRaizCapturas' => $dir_csv,
				'nombresCapturas' => $colCapturas
				);
		}else{
			$valores=array(
				'estado' =>400,
				'error' => 'No existen capturas asociadas a la falla para visualizar'
				);
		}
			echo json_encode($valores);
		}


	// --------------------------------------------------------------------
	public function creacionTipoFalla()
	{
		$data['logueado'] = $this->ion_auth->logged_in();
		if ($data['logueado']){
			$data['usuario'] = $this->ion_auth->user()->row()->username;
			$data['admin'] = $this->ion_auth->is_admin();
			$this->template->template_name = "bache";
			$this->template->build_page("gestorFallas", $data);
		}else{
			// Redirecciona a index
			redirect('/', 'refresh');
			return;
		}
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
			echo json_encode(array('codigo' => 200, 'mensaje' => "$class ha sido ingresada correctamente", 'valor' => json_encode($object)));
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
			try {
				$falla = Falla::getInstancia($id);
				$bache = $falla->to_array();
				$bache['estado'] = json_encode($falla->estado);
				$bache['tiposEstado'] = json_encode(TipoEstado::getAll());
				if (!isset($bache)) {
					redirect('/', 'refresh');
					return;
				}
				$this->output->enable_profiler(FALSE);
				$bache['logueado'] = $this->ion_auth->logged_in();
				$bache['usuario'] = $this->ion_auth->user()->row()->username;
				$bache['admin'] = $this->ion_auth->is_admin();
				$this->template->template_name = "bache";
				$this->template->build_page("bacheRegistrado",$bache);
			} catch (Exception $e) {
				redirect(base_url().'errori/error_404', 'refresh');
			}
		}

		public function asociarObservacion(){
			$this->utiles->debugger($this->input->post());
			$datos = new stdClass;
			$datos->comentario = $this->input->post("comentario");
			$datos->nombreObservador = $this->ion_auth->user()->row()->username;
			$datos->emailObservador = $this->ion_auth->user()->row()->email;
			$datos->idFalla = $this->input->post("idBache");
			Falla::asociarObservacionAnonima($datos);
		}

		public function registrarUsuario()
		{
			$data['logueado'] = $this->ion_auth->logged_in();
			if ($data['logueado']){
				$data['usuario'] = $this->ion_auth->user()->row()->username;
				$data['admin'] = $this->ion_auth->is_admin();
				$this->template->template_name = "bache";
				$this->template->build_page("registrarUsuario", $data);
			}else{
				// Redirecciona a index
				redirect('/', 'refresh');
				return;
			}
		}

		public function create_user()
		{

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

				if ($this->ion_auth->register($username, $password, $email, $additional_data, $group))
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					// $this->data['message'] = $this->ion_auth->errors();
					echo json_encode(array('status' => 'OK', 'message' => $this->ion_auth->messages()));
				}
				else{
					$this->session->flashdata('message');
					// echo $this->ion_auth->errors();
					echo json_encode(array('status' => 'ERROR', 'message' => $this->ion_auth->errors()));
				}			
			}
			else
			{
				// echo validation_errors();
				echo json_encode(array('status' => 'ERROR', 'message' => validation_errors()));
			}
		}

		public $datosEstadoConfirmado = array(
		                                    array(
		                                            'field' => 'material',
		                                            'label' => 'Material',
		                                            'rules' => 'required'
		                                         ),
		                                    array(
		                                    		'field' => 'criticidad',
		                                    		'label' => 'Criticidad',
		                                    		'rules' => 'callback_criticidad_check'
		                                    	),
		);

		public function modificarEstado()
		{
			$datos = new stdClass;
			$datos->datos = json_decode($this->input->post('datos'));

			$user = $this->ion_auth->user()->row();
			$usuario = new stdClass();
			$usuario->id = $user->id;
			$usuario->nombre = $user->username;
			$usuario->email = $user->email;
			$this->utiles->debugger("datos");
			$this->utiles->debugger($datos->datos);
			$this->db->trans_begin();
			$falla = Falla::getInstancia($datos->datos->falla->id);
			$user = $this->ion_auth->user()->row();
			//sleep(5);
			if ($falla->estado->validarDatos($datos))
			{
			$this->utiles->debugger("Válido!!!");
				$falla = $falla->cambiarEstado($datos->datos, $usuario);
				if ($falla == null) {
					echo json_encode(array('codigo' => 500, 'mensaje' => "Error en cambiar de estado", 'valor' =>""));
					$this->db->trans_rollback();
				} else {
				//$this->db->trans_rollback();
				$this->db->trans_commit();
				echo json_encode(array('codigo' => 200, 'mensaje' => "Pasa validación....", 'valor' =>""));
				}
			}
			else
			{
				$this->db->trans_rollback();
			$this->utiles->debugger("No Valido");

			echo json_encode(array('codigo' => 400, 'mensaje' => "Falta completar implementacion....", 'valor' =>''));
			}
		}

		/*
		Probar:
		$.post("publico/getCriticidadesPorIDs", {"arregloIDsCriticidades":JSON.stringify([4,5])})
		*/
		public function getCriticidadesPorIDs()
		{
			$arregloIDsCriticidades = json_decode($this->input->post('arregloIDsCriticidades'));
			$criticidades = array();
			try {
				foreach ($arregloIDsCriticidades as $key => $value) {
					array_push($criticidades, Criticidad::getInstancia($value));
				}
				echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>json_encode($criticidades)));
			} catch (MY_BdExcepcion $e) {
				echo json_encode(array('codigo' => 400, 'mensaje' => "No se pudo realizar la petición o no se encuentran los todos valores", 'valor' =>''));
			}
		}

		public function getFallasPorCalle()
		{
			/*
			{
				"calle": nombre
				"tiposFalla": [tipoFalla1, id:tipoFalla2]
				"operacion": tipoOperacion - <, >, =
				"cantidad": valor - 0 -> todos los encontrados
				"estados": [estado1, estado2] - 0 todos los estados
			}
			*/
			// $arrayIdTiposFalla = {id:tipoFalla1, id:tipoFalla2}
			// $arrayFallas = array();
			/*
			foreach ($arrayFallas as $key => $value) {
				array_merge($arrayFallas, TipoFalla::getFallasPorTipoDeFalla($value));
			}
			*/
			// filtrar por calle
			/*
			foreach ($arrayFallas as $key => $value) {
				if ($value->comprobarCalle($calle)) {
					array_push($arrayFallasFilter, $value);
				}
			}
			*/
		}

}

?>
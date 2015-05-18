<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publico extends Frontend_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	

	public function _remap($method)
	{
		$args = array_slice($this->uri->rsegment_array(),2);
		$this->utiles->debugger($args);
		if (method_exists($this, $method))
		{
			return call_user_func_array(array(&$this,$method),$args);
		}

		if(!$this->ion_auth->logged_in())
		{
			require_once(APPPATH."controllers/invitado.php");
		    $invitado = new Invitado();
			call_user_func_array(array(&$invitado,$method),$args);
		}else{
			require_once(APPPATH."controllers/privado.php");
		    $privado = new Privado();
		    call_user_func_array(array(&$privado,$method),$args);
		}
	}

	// --------------------------------------------------------------------
	


	public function index()
	{
		
		$data['logueado'] = $this->ion_auth->logged_in();
		if ($data['logueado'])
		{
			$data['usuario'] = $this->ion_auth->user()->row()->username;
			$data['admin'] = $this->ion_auth->is_admin(); 
		}

		$this->template->build_page("mapa",$data);
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

	public function getTiposEstado(){
		try{
			$tipos = TipoEstado::getTiposEstado();
			echo json_encode($tipos);	
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function getEstados($idFalla){
		try {
			$estados = Estado::getAll($idFalla);
			echo json_encode($estados);
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function getEstado($idFalla){
		try {
			$estado = Estado::getEstadoActual($idFalla);
			echo json_encode($estado);
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function getTiposRotura(){
		try {
			$tipos = TipoRotura::getTiposRotura();
			echo json_encode($tipos);
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function getTiposMaterial(){
		try {
			$tipos = TipoMaterial::getTiposMaterial();
			echo json_encode($tipos);
		} catch (MY_BdExcepcion $e) {
			echo "Ha ocurrido un error";
		}
	}

	public function login_via_ajax()
	{
		$identity = $this->input->post('login_identity');
		$password = $this->input->post('login_password');
		// $remember = $this->input->post('remember_me');
		$remember = true;
	    # Usar si es necesario enviar mas info del usuario
	    // $user = $this->ion_auth->user()->row();
	    if ($this->ion_auth->logged_in())
		{
			echo json_encode(array('status' => 'OK','data' => array('logged_in' => 'Ya se encuentra logeado.')));
		}
		else
		{
			if($this->ion_auth->login($identity, $password, $remember))
				echo json_encode(array('status' => 'OK','data' => array('login_identity' => $identity, 'login_password' => $password)));
			else
				echo json_encode(array('status' => 'error_log(message)','data' => 'User invalid!'));
		}
	}

	public function logout()
	{
		$this->ion_auth->logout();
		$this->session->set_flashdata('message', $this->ion_auth->messages());
	}

	/*
	 * crearTipoMaterial
	 *
	 * @access	public
	 * @param	numeric
	 * @param	string
	 */
	public function crearTipoMaterial($nombre)
	{
		try {
			// Se Busca si el tipo de material existe.
			$tipoMaterial = TipoMaterial::getTipoDeMaterialPorNombre($nombre);
			echo "El tipo de Material ingresado ya se encuentra cargado";
		} catch (MY_BdExcepcion $e) {
			$tipoMaterial = new TipoMaterial();
			$tipoMaterial->nombre = $nombre;
			$tipoMaterial->save();
			echo "El tipo de Material ha sido ingresado correctamente";
		}

	}

	/*
	 * crearTipoMaterial
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	double
	 */
	public function crearTipoReparacion($nombre, $descripcion, $costo)
	{
		try {
			// Se Busca si el tipo de reparacion existe.
			$tipoReparacion = TipoReparacion::getTipoDeReparacionPorNombre($nombre);
			// $this->utiles->debugger(get_class_methods('TipoReparacion'));
			// $tipoReparacion = call_user_func(array('TipoReparacion', 'get'.'TipoDeReparacion'.'PorNombre'), $nombre);
			// $this->utiles->debugger($tipoReparacion);
			echo json_encode(array('codigo' => 400, 'mensaje' => "El tipo de reparacion ya se encontraba cargado", 'valor' => ''));
		} catch (Exception $e) {
			$tipoReparacion = new TipoReparacion();
			$tipoReparacion->nombre = $nombre;
			$tipoReparacion->descripcion = $descripcion;
			$tipoReparacion->costo = (float)$costo;
			$id= $tipoReparacion->save();
			echo json_encode(array('codigo' => 200, 'mensaje' => "El tipo de Reparacion ha sido ingresada correctamente", 'valor' => $id ));

		}
	}

	/*
	 * crearTipoMaterial
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	double
	 */
	public function crearCriticidad($nombre, $descripcion, $ponderacion)
	{
		try {
			// Se Busca si el tipo de criticidad existe.
			$criticidad = Criticidad::getCriticidadPorNombre($nombre);
			echo json_encode(array('codigo' => 400, 'mensaje' => "El tipo de Criticidad ingresado ya se encuentra cargado", 'valor' => ''));
		} catch (Exception $e) {
			$criticidad = new Criticidad();
			$criticidad->nombre = $nombre;
			$criticidad->descripcion = $descripcion;
			$criticidad->ponderacion = (float)$ponderacion;
			$id = $criticidad->save();
			$this->utiles->debugger(gettype($id));
			echo json_encode(array('codigo' => 200, 'mensaje' => "El tipo de Criticidad ha sido ingresada correctamente", 'valor' => $id));

		}
	}

	public function crearTipoAtributo($idFalla, $nombre, $unidadMedida)
	{
		$this->utiles->debugger($idFalla);
		// Buscar para evitar
		// ERROR: insert or update on table "TipoAtributoModelo" violates foreign key constraint "fk_id_falla" DETAIL: Key (idFalla)=(1) is not present in table "FallaModelo".
		$tipoAtributo = TipoAtributo::crearTipoAtributo($idFalla, $nombre, $unidadMedida);
		echo json_encode(array('codigo' => 200, 'mensaje' => "", 'valor' => json_encode($tipoAtributo)));
	}

	public function getCriticidades()
	{
		$criti = Criticidad::getCriticidades();
		echo json_encode((array_map(function($obj){ return $obj; }, $criti)));
	}

	public function crear()
	{
		// Si es una petición POST por ajax.
		if ($this->input->is_ajax_request())
		{
			$class = $this->input->post('clase');
			$datos = $this->input->post('datos');
		}
		else // Si es una petición GET.
		{
			$arguments = func_get_args();
			$class = $arguments[0];
			$datos = array_slice($arguments, 1);
		}
		try {
			// Se Busca si el tipo de criticidad existe.
			// $criticidad = Criticidad::getCriticidadPorNombre($nombre);
			$object = $class::{'get'.$class.'PorNombre'}($datos[0]);
			echo json_encode(array('codigo' => 400, 'mensaje' => "$class ingresado ya se encuentra cargado", 'valor' => ''));
		} catch (Exception $e) {
			$this->utiles->debugger('Exception');
			$object = new $class();
			// $criticidad = new Criticidad();
			// $criticidad->nombre = $nombre;
			// $criticidad->descripcion = $descripcion;
			// $criticidad->ponderacion = (float)$ponderacion;
			// $id = $criticidad->save();
			// $this->utiles->debugger(gettype($id));
			echo json_encode(array('codigo' => 200, 'mensaje' => "$class ha sido ingresada correctamente", 'valor' => $id));

		}
	}

	public function crear1($arguments)
	{
		$args = array_slice($this->uri->rsegment_array(),2);
		foreach ($args as $key => $value) {
			$this->utiles->debugger($value);
		}

		$algo = func_get_args();
		$this->utiles->debugger("Argumentos:");
		$this->utiles->debugger($algo);
		// Obtenemos los argumentos variables del objeto
		$arguments = array_slice($args, 1);
		$this->utiles->debugger($arguments);
		// Identificamos el tipo de objeto.
		$class = $args[0];
		$this->utiles->debugger($class);
		$object = new $class($arguments);
		$this->utiles->debugger(get_object_vars($object));
		$num = 0;
		$object->nombre = 'uno';
		// Inicializamos cada una de la propiedades del objeto.
		// foreach (get_object_vars($object) as $key => $value) {
		// 	if ($key != 'id') {
		// 		$this->utiles->debugger($object->{$key});
		// 		$object->{$key} = $arguments[$num];
		// 		$num = $num + 1;
		// 	}
		// }
		$this->utiles->debugger($object);
		// Guardamos.
		$id = $object->save();
		echo json_encode(array('codigo' => 200, 'mensaje' => "$class ha sido ingresada correctamente", 'valor' => $id));
	}

	/*
	* get
	* Devuelve un objeto dada la clase y el id.
	* @access	public
	* @param    string => clase del objeto a obtener
	* @param    numeric => id del objeto
	*/
	public function get()
	{
		// Si es una petición POST por ajax.
		if ($this->input->is_ajax_request())
		{
			$class = $this->input->post('clase');
			$id = $this->input->post('id');
		}
		else // Si es una petición GET.
		{
			$arguments = func_get_args();
			$class = $arguments[0];
			$id = $arguments[1];
		}
		try {
			// $object = call_user_func(array($class, 'get'), $id);
			$object = $class::{'getInstancia'}($id);
			echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>$object));	
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "$class no existe", 'valor' =>''));	
			
		}
	}

	/*
	* get
	* Devuelve un objeto dada la clase y el id.
	* @access	public
	* @param    string => clase del objeto a obtener
	* @param    numeric => id del objeto
	*/
	public function getAll()
	{
		// Si es una petición POST por ajax.
		if ($this->input->is_ajax_request())
		{
			$class = $this->input->post('clase');
		}
		else // Si es una petición GET.
		{
			$arguments = func_get_args();
			$class = $arguments[0];
		}
		try {
			// $object = call_user_func(array($class, 'get'), $id);
			$objectArray = $class::{'getAll'}();
			echo json_encode(array('codigo' => 200, 'mensaje' => '', 'valor' =>$objectArray));
		} catch (MY_BdExcepcion $e) {
			echo json_encode(array('codigo' => 400, 'mensaje' => "$class no existe", 'valor' =>''));
			
		}
	}

}
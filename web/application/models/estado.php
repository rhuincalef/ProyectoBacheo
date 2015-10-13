<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Estado
	{
		var $id;
		var $falla;
		var $usuario;
		var $tipoEstado;
		var $monto;
		var $fechaFinReparacionReal;
		var $fechaFinReparacionEstimada;
		
		function __construct()
		{
			
		}

		protected function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->falla = Falla::getInstancia($datos->idFalla);
			$this->tipoEstado = TipoEstado::getInstancia($datos->idTipoEstado);
			// $this->fechaFinReparacionReal = $datos->fechaFinReparacionReal;
			// $this->fechaFinReparacionEstimada = $datos->fechaFinReparacionEstimada;
		}

		static public function getInstancia($datos)
		{
			$estado = new Estado();
			$estado->inicializar($datos);
			return $estado;
		}

		static public function getAll($idFalla)
		{
			$CI = &get_instance();
			$estados = array();
			$datos = $CI->EstadoModelo->getEstados($idFalla);
			$estados = array_map(function($obj){ return Estado::getInstancia($obj); }, $datos);
			return $estados;
		}

		public function getEstadoActual($idFalla)
		{
			$CI = &get_instance();
			$datos = $CI->EstadoModelo->getUltimoEstado($idFalla);
			$CI->utiles->debugger($datos);
			$datosTipoEstado = $CI->TipoEstadoModelo->get($datos->idTipoEstado);
			$nombreTipoEstado = ucfirst($datosTipoEstado->nombre);
			$estado = $nombreTipoEstado::getInstancia($datos);
			// date('F jS, Y h:i:s', strtotime($date));
			$estado->fecha = date("F d Y h:i:s", strtotime($datos->fecha));
			// $estado->fecha = $datos->fecha;
			return $estado;
		}

		public function save()
		{
			$CI = &get_instance();
			return $CI->EstadoModelo->save($this);
		}

	}

	
	class Informado extends Estado
	{

		public function __construct()
		{
			parent::__construct();
			$this->tipoEstado = TipoEstado::getTipoEstado(get_class($this));
		}

		static public function getInstancia($datos)
		{
			$estado = new Informado();
			$estado->inicializar($datos);
			return $estado;
		}

		protected function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->falla = $datos->idFalla;
			// $this->falla = Falla::getInstancia($datos->idFalla);;
		}

		public function cambiar($falla)
		{
			$nuevoEstado = new Confirmado();
			$nuevoEstado->setUsuario();
			$nuevoEstado->falla = $falla;
			$nuevoEstado->id = $nuevoEstado->save();
			return $nuevoEstado;
		}

		public function to_array($falla)
		{
			$datos = array(
            "id" => $falla->id,
            "latitud" => $falla->latitud,
            "longitud" => $falla->longitud,
            "alturaCalle" => $falla->direccion->altura,
            "calle" => $falla->direccion->callePrincipal->nombre,
            "criticidad" => "No se especifica en Informado",
            // "imagenes"=> $this->obtenerImagenes($idBache)
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => $falla->tipoFalla->nombre,
            "estado" => json_encode($falla->estado),
            );
            return $datos;
		}

	}

	class Confirmado extends Estado
	{

		public function __construct()
		{
			parent::__construct();
			$this->tipoEstado = TipoEstado::getTipoEstado(get_class($this));
		}

		public function setUsuario()
		{
			// $this->usuario = $idUsuario;
			// Se obtiene el usuario a traves de la libreria ion_auth
			$CI = &get_instance();
			$this->usuario = $CI->ion_auth->user()->row()->id;
		}

		static public function getInstancia($datos)
		{
			$estado = new Confirmado();
			$estado->inicializar($datos);
			return $estado;
		}

		public function inicializar($datos)
		{
			// parent::inicializar($datos);
			$this->id = $datos->id;
			// $this->usuario = $datos->idUsuario;
		}

		public function to_array($falla)
		{
			$datos = array(
            "id" => $falla->id,
            "latitud" => $falla->latitud,
            "longitud" => $falla->longitud,
            "alturaCalle" => $falla->direccion->altura,
            "calle" => $falla->direccion->callePrincipal->nombre,
            "criticidad" => "Falta especificar",
            // "criticidad" => $falla->criticidad->nombre,
            // "imagenes"=> $this->obtenerImagenes($idBache)
            //"observaciones"=>$this->obtenerObservaciones($idBache)
            "titulo" => $falla->tipoFalla->nombre,
            "estado" => json_encode($falla->estado),
            );
            return $datos;
		}

	}

?>
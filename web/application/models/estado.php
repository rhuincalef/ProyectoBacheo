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

		private function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->falla = Falla::getInstancia($datos->idFalla);;
			$this->tipoEstado = TipoEstado::getInstancia($datos->idTipoEstado);
			// $this->usuario = $datos->idUsuario;
			// $this->monto = $datos->monto;
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

		static public function getEstadoActual($idFalla)
		{
			$CI = &get_instance();
			$CI->utiles->debugger("getEstadoActual");
			$datos = $CI->EstadoModelo->getUltimoEstado($idFalla);
			$CI->utiles->debugger($datos);
			$tipoEstado = TipoEstado::getInstancia($datos->idTipoEstado);
			$nombre = $tipoEstado->nombre;
			$CI->utiles->debugger("$nombre");
			$estado = $nombre::getInstancia($datos);
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

		private function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->falla = Falla::getInstancia($datos->idFalla);;
			$this->tipoEstado = TipoEstado::getInstancia($datos->idTipoEstado);
		}

		public function cambiar($falla)
		{
			$nuevoEstado = new Confirmado();
			$nuevoEstado->setUsuario();
			$nuevoEstado->falla = $falla;
			$nuevoEstado->id = $nuevoEstado->save();
			return $nuevoEstado;
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
			// Se obtiene el usuario a traves de la libreria ion_auth
			$CI = &get_instance();
			$this->usuario = $CI->ion_auth->user()->row()->id;
		}

	}

?>
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
			$this->usuario = $datos->idUsuario;
			$this->tipoEstado = TipoEstado::getInstancia($datos->idTipoEstado);
			$this->monto = $datos->monto;
			$this->fechaFinReparacionReal = $datos->fechaFinReparacionReal;
			$this->fechaFinReparacionEstimada = $datos->fechaFinReparacionEstimada;
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
			$datos = $CI->EstadoModelo->getUltimoEstado($idFalla);
			$estado = Estado::getInstancia($datos);
			return $estado;
		}

		public function save()
		{
			$CI = &get_instance();
			$CI->EstadoModelo->save($this);
		}

	}

	
	class Informado extends Estado
	{

		public function __construct()
		{
			parent::__construct();
			$this->tipoEstado = TipoEstado::getTipoEstado(get_class($this));
			$this->setUsuario();
		}

		public function setUsuario()
		{
			// Se obtiene el usuario a traves de la libreria ion_auth
			$CI = &get_instance();
			$this->usuario = $CI->ion_auth->user()->row()->id;
		}

		// public function cambiarEstado($falla)
		// {
		// 	$confirmado = Confirmado::crear($datos);
		// 	$falla->estado = $confirmado;
		// }
	}
	
?>
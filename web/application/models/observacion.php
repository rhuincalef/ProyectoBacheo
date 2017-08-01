<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Observacion
	{
		var $falla;
		var $fecha;
		var $comentario;
		var $nombreObservador;
		var $emailObservador;
		
		
		function __construct()
		{
			switch (count(func_get_args()))
			{
				case 1:
					return call_user_func_array(array($this,'inicializar'), func_get_args());
					break;
				case 2:
					return call_user_func(array($this,'nueva'), func_get_arg(0), func_get_arg(1));
					break;
				default:
					break;
			}
		}

		private function inicializar($datos)
		{
			// $this->falla = Falla::getInstacia($datos->idFalla);
			$this->comentario = $datos->comentario;
			$this->nombreObservador = $datos->nombreObservador;
			$this->emailObservador = $datos->emailObservador;
			$this->fecha = $datos->fecha;
		}

		private function nueva($datos, $fecha)
		{
			$this->comentario = $datos->comentario;
			$this->nombreObservador = $datos->nombreObservador;
			$this->emailObservador = $datos->emailObservador;
			$this->fecha = $fecha;
		}

		static public function getInstacia($datos)
		{
			$observacion = new Observacion();
			$observacion->inicializar($datos);
			return $observacion;
		}

		static public function getAll($idFalla)
		{
			$CI = &get_instance();
			$observaciones = array();
			try {
				$datos = $CI->ObservacionModelo->getAll($idFalla);
				$observaciones = array_map(function($obj){ return Observacion::getInstacia($obj); },$datos);
			} catch (Exception $e) {
				return $observaciones;
			}
			return $observaciones;
		}

		public function save()
		{
			$CI = &get_instance();
			return $CI->ObservacionModelo->save($this);
		}
	}
?>
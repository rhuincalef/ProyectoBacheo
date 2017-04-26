<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class TipoEstado
	{
		
		var $id;
		var $nombre;
		
		function __construct()
		{
			
		}

		private function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->nombre= ucfirst($datos->nombre);
		}

		static public function getInstancia($id)
		{
			$CI = &get_instance();
			$tipoEstado = new TipoEstado();
			$CI->utiles->debugger("$id");
			$datos = $CI->TipoEstadoModelo->get($id);
			$tipoEstado->inicializar($datos);
			return $tipoEstado;
		}

		static public function getTiposEstado()
		{
			$CI = &get_instance();
			$tiposEstado = array();
			$datos = $CI->TipoEstadoModelo->getTiposEstado();
			foreach ($datos as $row)
			{
				$tipoEstado = new TipoEstado();
				$tipoEstado->inicializar($row);
				array_push($tiposEstado, $tipoEstado);
			}
			
			return $tiposEstado;
		}

		static public function getTipoEstado($nombre)
		{
			$CI = &get_instance();
			$datos = $CI->TipoEstadoModelo->getTipoEstado($nombre);
			$tipoEstado = new TipoEstado();
			$tipoEstado->inicializar($datos);
			return $tipoEstado;
		}

		static public function getAll()
		{
			$CI = &get_instance();
			$tiposEstado = array();
			try {
				// $datos = $CI->CriticidadModelo->getCriticidades();
				$datos = $CI->TipoEstadoModelo->get_all();
    			foreach ($datos as $row)
    			{
    				$tipoEstado = new TipoEstado();
    				$tipoEstado->inicializar($row);
    				array_push($tiposEstado, $tipoEstado);
    			}
			}	
			catch (MY_BdExcepcion $e) {
				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
			}
			return $tiposEstado;
		}

		public function esTipoEstadoActual($tipoEstado)
		{
			//($this->id == $estado->tipoEstado->id) ||
			if (strcasecmp($this->nombre, $tipoEstado->nombre) == 0) {
				return (bool)1;
			}
			return (bool)0;
			//return (bool)$this->id == $tipoEstado->id;
			//return !strcasecmp($this->nombre, $tipoEstado->nombre) == 0;
		}

	}
?>
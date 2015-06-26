<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class TipoReparacion
	{
		
		var $id;
		var $nombre;
		var $descripcion;
		var $costo;
		
		function __construct()
		{
			
		}


		private function inicializar($datos)
		{
			$this->id = $datos->id;
			$this->nombre = $datos->nombre;
			$this->descripcion = $datos->descripcion;
			$this->costo = $datos->costo;

		}

		static public function getInstancia($id)
		{
			$CI = &get_instance();
			$tipoReparacion = new TipoReparacion();
			$datos = $CI->TipoReparacionModelo->get($id);
			$tipoReparacion->inicializar($datos);		
			return $tipoReparacion;

		}

		static public function getTipoDeReparacion($id)
		{
			$CI = &get_instance();
			$datos = $CI->TipoReparacionModelo->get($id);
			$tipoReparacion = new TipoReparacion();
			$tipoReparacion->inicializar($datos);
			return $tipoReparacion;
		}

		static public function getTipoReparacionPorNombre($nombre)
		{
			$CI = &get_instance();
			$CI->utiles->debugger($nombre);
			$datos = $CI->TipoReparacionModelo->getTipoDeReparacionPorNombre($nombre);
			$tipoReparacion = new TipoReparacion();
			$tipoReparacion->inicializar($datos);
			return $tipoReparacion;
		}

		static public function getAll()
		{
			$CI = &get_instance();
			$tiposReparacion = array();
			try {
				// $datos = $CI->CriticidadModelo->getCriticidades();
				$datos = $CI->TipoReparacionModelo->get_all();
    			foreach ($datos as $row)
    			{
    				$tipoReparacion = new TipoReparacion();
    				$tipoReparacion->inicializar($row);
    				array_push($tiposReparacion, $tipoReparacion);
    			}
			}	
			catch (MY_BdExcepcion $e) {
				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
			}
			return $tiposReparacion;
		}

		public function save()
		{
			$CI = &get_instance();
			return $CI->TipoReparacionModelo->save($this);

		}

		static public function crear($datos)
		{
			$CI = &get_instance();
			$CI->utiles->debugger($datos);
			$tipoReparacion = new TipoReparacion();
			$tipoReparacion->nombre = $datos->nombre;
			$tipoReparacion->costo = $datos->costo;
			$tipoReparacion->descripcion = $datos->descripcion;
			$tipoReparacion->id = $tipoReparacion->save();
			$CI->utiles->debugger($tipoReparacion);
			return $tipoReparacion;
		}

		public function asociar($idTipoFalla)
		{
			$CI = &get_instance();
			$CI->TipoReparacionModelo->asociar($this->id, $idTipoFalla);
		}

		static public function datosCrearValidos($datos)
		{
			$datos_validar_tipo_reparacion = array('nombre' => array('string', '\w'), 'costo' => array('double', '\w'), 'descripcion' => array('string', '\w'));
			foreach ($datos_validar_tipo_reparacion as $key => $value)
			{
				if (!property_exists($datos, $key) || !isset($datos->$key) || (gettype($datos->$key) != $value[0]) || (preg_match($value[1], var_export($datos->$key, 1))))
				{
					return FALSE;
				}
			}
			return TRUE;
		}
	}
 ?>
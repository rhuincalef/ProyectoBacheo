<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		class TipoFalla
		{
			
			var $id;
			var $nombre;
			var $influencia;
			// Agregadas
			var $material;
			var $atributos;
			var $criticidades;
			var $reparaciones;
			
			function __construct()
			{
				
			}


			private function inicializar($datos)
			{
				$this->id = $datos->id;		
				$this->nombre = $datos->nombre;
				
			}

			static public function getInstancia($id)
			{
				$CI = &get_instance();
				$tipoFalla = new TipoFalla();
				$datos = $CI->TipoFallaModelo->get($id);
				$tipoFalla->inicializar($datos);
				return $tipoFalla;
			}


			static public function getTiposFalla()
			{
				$CI = &get_instance();
				$tiposRotura= array();
				try {
					$datos = $CI->TipoFallaModelo->getTiposFalla();
	    			foreach ($datos as $row) {
	    				$tipoFalla = new TipoFalla();
	    				$tipoFalla->inicializar($row);
	    				array_push($tiposRotura, $tipoFalla);		
	    			}
				}	
				catch (MY_BdExcepcion $e) {
    				echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
    			}
    			return $tiposRotura;
			}

			public function save()
			{
				$CI = &get_instance();
				return $CI->TipoFallaModelo->save($this);
			}

			static public function crear($datos)
			{
				$CI = &get_instance();
				$CI->utiles->debugger($datos);
				$tipoFalla = new TipoFalla();
				$tipoFalla->nombre = $datos->general->nombre;
				$tipoFalla->influencia = $datos->general->influencia;
				$tipoFalla->id = $tipoFalla->save();
				$CI->utiles->debugger($tipoFalla);
				// $tipoFalla->material = $tipoFalla->cargar('TipoMaterial', $datos->material);
				if ($datos->material->id != "")
					$tipoFalla->material = TipoMaterial::getInstancia($datos->material->id);
				else
					$tipoFalla->material = TipoMaterial::crear($datos->material);
				$datos->atributos = array_map(function($atributo) use ($tipoFalla)
				{
					$atributo->falla = $tipoFalla->id;
					return $atributo;
				}, $datos->atributos);
				$CI->utiles->debugger($datos->atributos);
				$tipoFalla->atributos = $tipoFalla->cargar('TipoAtributo', $datos->atributos);
				$CI->utiles->debugger($tipoFalla->atributos);
				$tipoFalla->criticidades = $tipoFalla->cargar('Criticidad', $datos->criticidades);
				$tipoFalla->reparaciones = $tipoFalla->cargar('TipoReparacion', $datos->reparaciones);
				$tipoFalla->asociar();
				
				return $tipoFalla;
			}

			public function cargar($tipo, $datos)
			{
				return array_map(function($object) use ($tipo)
				{
					if (isset($object->id))
						$nuevo = call_user_func(array($tipo, 'getInstancia'), $object->id);
					else
						$nuevo = call_user_func(array($tipo, 'crear'), $object);
					return $nuevo;
				}, $datos);
			}

			public function asociar()
			{
				// $CI->TipoFallaModelo->asociar($this);
				$CI = &get_instance();
				$CI->utiles->debugger($this);
				$idTipoFalla = $this->id;
				// array_map(function($object) use (&$idTipoFalla)
				// {
				// 	$object->asociar($idTipoFalla);
				// }, $this->materiales);
				$this->material->asociar($idTipoFalla);
				array_map(function($criticidad) use (&$idTipoFalla)
				{
					$criticidad->asociar($idTipoFalla);
				}, $this->criticidades);
				array_map(function($tipoReparacion) use (&$idTipoFalla)
				{
					$tipoReparacion->asociar($idTipoFalla);
				}, $this->reparaciones);
			}

			public function getMaterial()
			{
				return $this->material;
			}

			static public function datosCrearValidos($datos)
			{
				$datos_validar_tipo_falla = array(
						'datos' => array('general' => array('nombre' => '', 'influencia' => ''),
										'material' => array('nombre' => ''),
										'atributos' => array('nombre' => '', 'unidadMedida' => ''),
										'criticidades' => array('nombre' => '', 'descripcion' => '', 'ponderacion' => ''),
										'reparaciones' => array('nombre' => '', 'costo' => '', 'descripcion' => '')
										)
						);
				$CI = &get_instance();
				return $CI->validarRequeridos($datos_validar_tipo_falla, $datos);
				// return $CI->compararValores($datos, $datos_validar_tipo_falla);
				// if (isset($datos['clase']) && isset($datos['datos'])) 
				// {
				// 	if (isset($datos['datos']->general) && isset($datos['datos']->materiales) && isset($datos['datos']->atributos) && isset($datos['datos']->criticidades) && isset($datos['datos']->reparaciones)) {
				// 		if (isset($datos['datos']->general->nombre) && isset($datos['datos']->general->influencia)) {
				// 			return TRUE;
				// 		}
				// 	}
				// }
				// return FALSE;
			}
		}
 ?>